<?php
namespace App\Traits\Backend\Pos\Create;

use Illuminate\Support\Facades\Auth;
use App\Models\Backend\Sell\SellInvoice;
use App\Models\Backend\Sell\SellPackage;
use App\Models\Backend\Sell\SellProduct;
use App\Models\Backend\Customer\Customer;
use App\Models\Backend\Sell\SellQuotation;
use App\Models\Backend\Sell\SellProductStock;
use App\Traits\Backend\Stock\Logical\StockChangingTrait;
use App\Traits\Backend\Payment\PaymentProcessTrait;
use App\Traits\Backend\Payment\CustomerPaymentProcessTrait;
use App\Traits\Backend\Customer\Logical\ManagingCalculationOfCustomerSummaryTrait;
/**
 * pricing trait
 * 
 */
trait StoreDataFromSellCartTrait
{
    use StockChangingTrait, PaymentProcessTrait;
    use CustomerPaymentProcessTrait, ManagingCalculationOfCustomerSummaryTrait;

    protected $sellCreateFormData;

    protected $cartName;
    protected $product_id;

    protected $totalSellingQuantity;
    protected $otherProductStockQuantityPurchasePrice;
    protected $mainProductStockQuantityPurchasePrice;
    protected $totalPurchasePriceOfAllQuantityOfThisInvoice;



    protected function storeSessionDataFromSellCart()
    {   
        $sellCartName = sellCreateCartSessionName_hh();
        $sellCart   = [];
        $sellCart   = session()->has($sellCartName) ? session()->get($sellCartName)  : [];
        
        $sellInvoiceSummeryCartName = sellCreateCartInvoiceSummerySessionName_hh();
        $sellInvoiceSummeryCart = [];
        $sellInvoiceSummeryCart = session()->has($sellInvoiceSummeryCartName) ? session()->get($sellInvoiceSummeryCartName)  : [];
        
        $sellInvoice =  $this->insertDataInTheSellInvoiceTable($sellInvoiceSummeryCart);
       
        $this->totalSellingQuantity = 0;
        $this->otherProductStockQuantityPurchasePrice = 0;
        $this->mainProductStockQuantityPurchasePrice = 0;
        $this->totalPurchasePriceOfAllQuantityOfThisInvoice = 0;
        foreach($sellCart as $cart)
        {
           $sellProduct =  $this->insertDataInTheSellProduct($sellInvoice,$cart);

            if($cart['more_quantity_from_others_product_stock'] == 1)
            {
                foreach($cart['from_others_product_stocks'] as $ostock)
                {
                   foreach($ostock['others_product_stock_ids'] as $key => $stock)
                   {
                        //$ids[] = $stock;
                        $qty = $ostock['others_product_stock_qtys'][$key];
                        $purchase_price = $ostock['others_product_stock_purchase_prices'][$key];
                        $process_duration = $ostock['over_stock_quantity_process_duration'][$key];
                        $this->insertDataInTheSellProductStockTable($cart,$sellInvoice,$sellProduct,$stock,$qty,$purchase_price,$process_duration);
                   }//end foreach
                }//end foreach
            }else{
               $this->insertDataInTheSellProductStockTable($cart,$sellInvoice,$sellProduct,$cart['selling_main_product_stock_id'],$cart['total_qty_of_main_product_stock'],$cart['purchase_price'],1);
            }
        }//end foreach
        
        $sellInvoice->total_selling_purchase_amount = $this->totalPurchasePriceOfAllQuantityOfThisInvoice;
        $sellInvoice->total_purchase_amount = $this->totalPurchasePriceOfAllQuantityOfThisInvoice;
        
        $sellInvoice->total_selling_profit = (($sellInvoiceSummeryCart['lineInvoicePayableAmountWithRounding']) - ($this->totalPurchasePriceOfAllQuantityOfThisInvoice) - ($sellInvoiceSummeryCart['totalShippingCost'] + $sellInvoiceSummeryCart['invoiceOtherCostAmount'] ));
        $sellInvoice->total_profit_from_product = (($sellInvoiceSummeryCart['lineInvoicePayableAmountWithRounding']) - ($this->totalPurchasePriceOfAllQuantityOfThisInvoice) - ($sellInvoiceSummeryCart['totalShippingCost'] + $sellInvoiceSummeryCart['invoiceOtherCostAmount'] ));
        $sellInvoice->total_profit = (($sellInvoiceSummeryCart['lineInvoicePayableAmountWithRounding']) - ($this->totalPurchasePriceOfAllQuantityOfThisInvoice) - ($sellInvoiceSummeryCart['totalShippingCost'] + $sellInvoiceSummeryCart['invoiceOtherCostAmount'] ));
        
        $sellInvoice->invoice_no = sprintf("%'.08d", $sellInvoice->id);
        $sellInvoice->save();

        //general statement- ledger 
        if(($this->sellCreateFormData['invoice_total_paying_amount'] ?? 0) > 0)
        {
            //for payment processing 
            $this->mainPaymentModuleId = getModuleIdBySingleModuleLebel_hh('Sell');
            $this->paymentModuleId = getModuleIdBySingleModuleLebel_hh('Sell');
            $this->paymentCdfTypeId = getCdfIdBySingleCdfLebel_hh('Credit');
            $moduleRelatedData = [
                'main_module_invoice_no' => $sellInvoice->invoice_no,
                'main_module_invoice_id' => $sellInvoice->id,
                'module_invoice_no' => $sellInvoice->invoice_no,
                'module_invoice_id' => $sellInvoice->id,
                'user_id' => $this->sellCreateFormData['customer_id'],//client[customer,supplier,others staff]
            ];
            $this->paymentProcessingRequiredOfAllRequestOfModuleRelatedData = $moduleRelatedData;
            $this->paymentProcessingRelatedOfAllRequestData = paymentDataProcessingWhenSellingSubmitFromPos_hh($this->sellCreateFormData);// $paymentAllData;
            $this->invoiceTotalPayingAmount = $this->sellCreateFormData['invoice_total_paying_amount'] ?? 0 ;
            $this->processingPayment();
        }
        //general statement- ledger 

        //customer transaction statement history
        $sellType = $this->sellCreateFormData['sell_type'];
        $sellAmount = 0;
        $paidAmount = 0;
        $dueAmount = 0;
        $ctsTypeModule = '';
        $ctsCdfType = '';
        $note = "";
        if($sellType == 1)//final sell
        {
            $ctsTypeModule = 'Sell';
            $ctsCdfType = 'Due';
            $note = "Create sell";
            $sellAmount = $sellInvoice->total_payable_amount;
            $paidAmount = $sellInvoice->total_paid_amount;
            $dueAmount = $sellInvoice->due_amount;
        }else{ // quotation
            $ctsTypeModule = 'Quotation';
            $ctsCdfType = 'No Change';
            $note = "Create quotation";
            $sellAmount = 0;
            $paidAmount = 0;
            $dueAmount = 0;
        }
        $requestCTSData = [];
        $requestCTSData['amount'] = 0;
        $requestCTSData['ledger_page_no'] = NULL;
        $requestCTSData['next_payment_date'] = NULL;
        $requestCTSData['short_note'] =   $note;
        $requestCTSData['sell_amount'] = $sellAmount;//$sellInvoice->total_payable_amount;
        $requestCTSData['sell_paid'] = $paidAmount;
        $requestCTSData['sell_due'] = $dueAmount;
        $this->processingOfAllCustomerTransactionRequestData = customerTransactionRequestDataProcessing_hp($requestCTSData);
        $this->amount = $sellInvoice->total_payable_amount;
        
        $this->ctsTTModuleId = getCTSModuleIdBySingleModuleLebel_hp($ctsTypeModule);
        $this->ctsCustomerId = $this->sellCreateFormData['customer_id'];
        $ttModuleInvoics = [
            'invoice_no' => $sellInvoice->invoice_no,
            'invoice_id' => $sellInvoice->id
        ];
        $this->ttModuleInvoicsDataArrayFormated = $ttModuleInvoics;
        $this->ctsCdsTypeId = getCTSCdfIdBySingleCdfLebel_hp($ctsCdfType);
        $this->processingOfAllCustomerTransaction();
        //customer transaction statement history   


        //calculation in the customer table
        if($sellType == 1)//final sell
        {
            //calculation in the customer table
            //$dbField = 33;'current_total_sell_amount';
            //$calType = 1='plus', 2='minus'
            $this->managingCustomerCalculation($this->sellCreateFormData['customer_id'],$dbField = 33 ,$calType = 1,$sellInvoice->total_payable_amount);
            //calculation in the customer table
        }//calculation in the customer table


        //$totalPaidAmount = ($this->sellCreateFormData['cash_payment_value'] ?? 0) + ($this->sellCreateFormData['advance_payment_value'] ?? 0) + ($this->sellCreateFormData['banking_payment_value'] ?? 0);
        //calculation in the customer table
        if(($sellType == 1) && (($this->sellCreateFormData['advance_payment_value'] ?? 0) > 0))//final sell
        {
            //$sellAmount = $sellInvoice->total_payable_amount;
            //$paidAmount = $sellInvoice->total_paid_amount;
            //$dueAmount = $sellInvoice->due_amount;

            //calculation in the customer table
            //$dbField = 22;'current_paid_advance';
            //$calType = 1='plus', 2='minus'
            $this->managingCustomerCalculation($this->sellCreateFormData['customer_id'],$dbField = 22 ,$calType = 1,$sellInvoice->total_payable_amount);
            //calculation in the customer table
        }//calculation in the customer table

        //calculation in the customer table
        if(($sellType == 1))//final sell
        {
            //$sellAmount = $sellInvoice->total_payable_amount;
            //$paidAmount = $sellInvoice->total_paid_amount;
            //$dueAmount = $sellInvoice->due_amount;

            //calculation in the customer table
            //$dbField = 17;'current_due';
            //$calType = 1='plus', 2='minus'
            $this->managingCustomerCalculation($this->sellCreateFormData['customer_id'],$dbField = 17 ,$calType = 1,$sellInvoice->due_amount);
            //calculation in the customer table
        }//calculation in the customer table
        return $sellInvoice->id;
    }


    // sell product stock
    private function insertDataInTheSellProductStockTable($cart,$sellInvoice,$sellProduct,$product_stock_id,$qty,$purchase_price,$process_duration)
    {
        $productStock = new SellProductStock();
        $productStock->branch_id = authBranch_hh();
        $productStock->sell_invoice_id = $sellInvoice->id;
        $productStock->sell_product_id = $sellProduct->id;
        $productStock->product_stock_id = $product_stock_id;

        $productStock->product_id = $cart['product_id'];
        
        $productStock->total_sell_qty = $qty;
        $productStock->total_quantity = $qty;

        $totalPurchasePrice = $cart['purchase_price'] * $qty;
        $totalSoldPrice = $cart['final_sell_price'] * $qty;
        $productStock->mrp_price = $cart['mrp_price'];
        $productStock->regular_sell_price = $cart['sell_price'];
        $productStock->sold_price = $cart['final_sell_price'];

        $productStock->total_selling_amount = $totalSoldPrice;//$cart['selling_final_amount'];
        $productStock->total_sold_amount = $totalSoldPrice;//$cart['selling_final_amount'];
        $productStock->purchase_price = $cart['purchase_price'];
        $productStock->total_purchase_amount = $totalPurchasePrice;//$cart['total_purchase_price_of_all_quantity'];
        $productStock->total_selling_purchase_amount = $totalPurchasePrice;//$cart['total_purchase_price_of_all_quantity'];
        
        $productStock->total_selling_profit = $totalSoldPrice - $totalPurchasePrice;
        $productStock->total_profit_from_product = $totalSoldPrice - $totalPurchasePrice;
        $productStock->total_profit = $totalSoldPrice - $totalPurchasePrice;

        
        $pStock = productStockByProductStockId_hh($product_stock_id);
        $stockId = regularStockId_hh();
        if($pStock)
        {
            $availableBaseStock = $pStock->available_base_stock;
            $stockId = $pStock->stock_id;
        }else{
            $availableBaseStock = 0;
        }
        //stock id 
        $productStock->stock_id = $stockId;

        $stockProcessLaterQty  = 0;
        if($availableBaseStock > $qty)
        {
            //instantly processed all qty
            $instantlyProcessedQty = $qty;
            $stockProcessLaterDate = ""; 
            $stockProcessLaterQty  = 0;
        }
        else if($availableBaseStock == $qty)
        {
            //instantly processed all qty
            $instantlyProcessedQty = $qty;
            $stockProcessLaterDate = ""; 
            $stockProcessLaterQty  = 0;
        }
        else if($availableBaseStock < $qty)
        {
            //instantly processed all qty
            $overStock = $qty - $availableBaseStock;
            $instantlyProcessedQty = $qty - $overStock;
            $stockProcessLaterDate = date('Y-m-d',strtotime('+'.$process_duration.' day')); 
            $stockProcessLaterQty  = $overStock;
        }
        else 
        {   
            //instantly processed qty
           $overStock = $qty - $availableBaseStock;
           $instantlyProcessedQty = $qty - $overStock;
           $stockProcessLaterDate = date('Y-m-d',strtotime('+'.$process_duration.' day')); 
           $stockProcessLaterQty  = $overStock;
        }

        $sellType = $this->sellCreateFormData['sell_type'];
        //if sell_type==1, then reduce stock from product stocks table 
        if($sellType  == 1 && $instantlyProcessedQty > 0){
            $this->stock_id_FSCT = $stockId;
            $this->product_id_FSCT = $cart['product_id'];
            $this->stock_quantity_FSCT = $instantlyProcessedQty;
            $this->unit_id_FSCT = $cart['unit_id'];
            $this->sellingFromPossStockTypeDecrement();
        }
        if($pStock && $sellType  == 1)
        {
            //product_stocks table
            $pStock->reduced_base_stock_remaining_delivery = (($pStock->reduced_base_stock_remaining_delivery) + ($instantlyProcessedQty));
            $pStock->negative_sold_base_stock = (($pStock->negative_sold_base_stock) + ($stockProcessLaterQty));//sold this stock, but not available then. so it's negative stock. when purchase product and received stock, then this stock have to minus, but not effect on main base stock - just minus from this stock - available_base_stock
            $pStock->save();
        }

        //delivery quantity
        if($sellType  == 1){
            $totalDeliverdQty = 0;
            $productStock->total_delivered_qty = $totalDeliverdQty;
            $productStock->remaining_delivery_qty = $qty - $totalDeliverdQty;

            //$productStock->reduceable_delivered_qty = 0;//new field
            $productStock->reduced_base_stock_remaining_delivery = $instantlyProcessedQty;//new field
            $productStock->remaining_delivery_unreduced_qty = $stockProcessLaterQty;//new
            $productStock->remaining_delivery_unreduced_qty_date = $stockProcessLaterDate;//new
        }

        $productStock->status = 1;
        $productStock->delivery_status = 1;

        $totalDeliverdQty = 0;
        $productStock->sell_cart = json_encode([
            'product_id' => $cart['product_id'],
            'product_stock_id' => $product_stock_id,
            'total_sell_qty' => $qty,
            "total_quantity" => $qty,
            'mrp_price' =>$cart['mrp_price'] ,
            'regular_sell_price' => $cart['sell_price'],
            'sold_price' => $cart['final_sell_price'],
            'total_selling_amount' => $totalSoldPrice,
            'total_sold_amount' => $totalSoldPrice,
            'purchase_price' => $cart['purchase_price'],         
            'total_purchase_amount' => $totalPurchasePrice,
            'total_selling_purchase_amount' => $totalPurchasePrice,
            'total_selling_profit' => number_format($totalSoldPrice - $totalPurchasePrice,2,'.',''),
            'total_profit_from_product' => number_format($totalSoldPrice - $totalPurchasePrice,2,'.',''),
            'total_profit' =>  number_format($totalSoldPrice - $totalPurchasePrice,2,'.',''),
            'total_delivered_qty' => $totalDeliverdQty,
            'remaining_delivery_qty' => $qty - $totalDeliverdQty,
            'reduced_base_stock_remaining_delivery' =>  $instantlyProcessedQty,
            'remaining_delivery_unreduced_qty' => $stockProcessLaterQty,
            'remaining_delivery_unreduced_qty_date' =>  $stockProcessLaterDate,
        ]);

        $productStock->save();
        return $productStock;
    }

    //insert data in the sell products table
    private function insertDataInTheSellProduct($sellInvoice,$cart)
    {
        $productProduct = new SellProduct();
        $productProduct->branch_id = authBranch_hh();
        $productProduct->sell_invoice_id = $sellInvoice->id;
        $productProduct->product_id = $cart['product_id'];
        $productProduct->unit_id = $cart['unit_id'];
        $productProduct->supplier_id = $cart['supplier_id'];
        $productProduct->main_product_stock_id = $cart['selling_main_product_stock_id'];
        $productProduct->product_stock_type = $cart['total_qty_from_others_product_stock'] == 0 ? 1 : 2;
        $productProduct->custom_code = $cart['custom_code'];

        $productProduct->total_sell_qty = $cart['final_sell_quantity'];
        $productProduct->total_quantity = $cart['final_sell_quantity'];

        $productProduct->sold_price = $cart['final_sell_price'];
        $productProduct->discount_amount = $cart['discount_amount'];
        $productProduct->discount_type = $cart['discount_type'];
        $productProduct->total_discount = $cart['total_discount_amount'];
        $productProduct->reference_commission = 0;//$cart[''];

        $productProduct->total_selling_amount = $cart['selling_final_amount'];
        $productProduct->total_sold_amount = $cart['selling_final_amount'];
        $productProduct->total_selling_purchase_amount = $cart['total_purchase_price_of_all_quantity'];
        $productProduct->total_purchase_amount = $cart['total_purchase_price_of_all_quantity'];

        $productProduct->total_selling_profit = $cart['selling_final_amount'] - $cart['total_purchase_price_of_all_quantity'];
        $productProduct->total_profit_from_product = $cart['selling_final_amount'] - $cart['total_purchase_price_of_all_quantity'];
        $productProduct->total_profit = $cart['selling_final_amount'] - $cart['total_purchase_price_of_all_quantity'];
        
        $this->totalPurchasePriceOfAllQuantityOfThisInvoice += $cart['total_purchase_price_of_all_quantity'];

        if($cart['w_g_type'])
        {
            $productProduct->liability_type = json_encode(["w_g_type" => $cart['w_g_type'], "w_g_type_day" => $cart['w_g_type_day']]);
        }
        $productProduct->identity_number = $cart['identityNumber'];
        $productProduct->cart = json_encode([
            'productName' => $cart['product_name'],
            "productId" =>$cart['product_id'],
            'mrpPrice' =>$cart['mrp_price'] ,
            'soldPrice' =>$cart['final_sell_price'] ,
            'totalSellQuantity' =>$cart['final_sell_quantity'] ,
            'totalMainProductStockQuantity' =>$cart['total_qty_of_main_product_stock'] ,
            'totalOtherProductStockQuantity' =>$cart['total_qty_from_others_product_stock'] ,
            'unitName' => $cart['unit_name'],
            'unitId' =>$cart['unit_id'],
            'customCode' =>$cart['custom_code'],
            'warehouseId' =>$cart['warehouse_id'],
            'warehouseRackId' =>$cart['warehouse_rack_id'],
        ]);

        $productProduct->status =1;
        $productProduct->delivery_status =1;
        $productProduct->created_by = authId_hh();
        $productProduct->save();
        return $productProduct;
    }

    //insert data in the sell invoices table
    private function insertDataInTheSellInvoiceTable($sellInvoiceSummeryCart)
    {  
        $shippingCart = [];
        $shippingCart = session()->has(sellCreateCartShippingAddressSessionName_hh()) ? session()->get(sellCreateCartShippingAddressSessionName_hh())  : [];

        //return $sellInvoiceSummeryCart;
        $sellInvoice = new SellInvoice();
        $sellInvoice->branch_id = authBranch_hh();
        $rand = rand(01,99);
        $makeInvoice = date("iHsymd").$rand;
        //$sellInvoice->invoice_no = $makeInvoice;
        $sellInvoice->total_item = $sellInvoiceSummeryCart['totalItem'];
        $sellInvoice->total_sell_item = $sellInvoiceSummeryCart['totalItem'];
        $sellInvoice->sell_quantity = $sellInvoiceSummeryCart['totalQuantity'];
        $sellInvoice->total_quantity = $sellInvoiceSummeryCart['totalQuantity'];
        $sellInvoice->subtotal = $sellInvoiceSummeryCart['lineInvoiceSubTotal'];
        $sellInvoice->total_selling_amount = $sellInvoiceSummeryCart['lineInvoiceSubTotal'];
        $sellInvoice->total_sold_amount = $sellInvoiceSummeryCart['lineInvoiceSubTotal'];

        $sellInvoice->discount_amount = $sellInvoiceSummeryCart['invoiceDiscountAmount'];
        $sellInvoice->discount_type = $sellInvoiceSummeryCart['invoiceDiscountType'];
        $sellInvoice->total_discount = $sellInvoiceSummeryCart['totalInvoiceDiscountAmount'];
        $sellInvoice->vat_amount = $sellInvoiceSummeryCart['invoiceVatAmount'];
        $sellInvoice->total_vat = $sellInvoiceSummeryCart['totalVatAmountCalculation'];
        $sellInvoice->shipping_cost = $sellInvoiceSummeryCart['totalShippingCost'];
        $sellInvoice->others_cost = $sellInvoiceSummeryCart['invoiceOtherCostAmount'];
        $sellInvoice->round_amount = $sellInvoiceSummeryCart['lineInvoiceRoundingAmount'];
        $sign = "";
        if($sellInvoiceSummeryCart['lineInvoicePayableAmountWithRounding'] >=  $sellInvoiceSummeryCart['lineAfterOtherCostShippingCostDiscountAndVatWithInvoiceSubTotal'])
        {
            $sign = "+";
        }
        else if($sellInvoiceSummeryCart['lineInvoicePayableAmountWithRounding'] <  $sellInvoiceSummeryCart['lineAfterOtherCostShippingCostDiscountAndVatWithInvoiceSubTotal'])
        {
            $sign = "-";
        }else{
            $sign = "";
        }
        $sellInvoice->round_type = $sign;
        $totalPayableAmount = $sellInvoiceSummeryCart['lineInvoicePayableAmountWithRounding'];
        $sellInvoice->total_payable_amount = $totalPayableAmount; 
        
        $sellInvoice->sell_type = $this->sellCreateFormData['sell_type'];
        
        //payment related section
        $totalPaidAmount = ($this->sellCreateFormData['cash_payment_value'] ?? 0) + ($this->sellCreateFormData['advance_payment_value'] ?? 0) + ($this->sellCreateFormData['banking_payment_value'] ?? 0);
        $sellInvoice->paid_amount = $totalPaidAmount; //total before refunded
        $sellInvoice->total_paid_amount	 = $totalPaidAmount; // after refunded
        $sellInvoice->due_amount = $totalPayableAmount - $totalPaidAmount; //total before refunded
        $sellInvoice->total_due_amount = $totalPayableAmount - $totalPaidAmount; //total before refunded

        $paymentStatus = "";
        $payment_type = "";
        if($totalPayableAmount == $totalPaidAmount)
        {
            $paymentStatus = "Paid";
            $payment_type = "Full Payment";
        }
        else if($totalPayableAmount > $totalPaidAmount &&  $totalPaidAmount > 0){
            $paymentStatus = "Parital Payment";
            $payment_type = "Partial Payment";
        }
        else if($totalPayableAmount > $totalPaidAmount &&  $totalPaidAmount == 0){
            $paymentStatus = "Not Paid";
            $payment_type = "Not Paid";
        }
        $sellInvoice->payment_status = $paymentStatus;
        $sellInvoice->payment_type	 = $payment_type;
        //payment related section

        //$customerId = $sellInvoiceSummeryCart['invoice_customer_id'];
        $customerId = $this->sellCreateFormData['customer_id'];
        if(count($shippingCart) > 0)
        {
            $sellInvoice->customer_id = $shippingCart['customer_id'];
            $customerId = $shippingCart['customer_id'];
            $sellInvoice->reference_id = $this->sellCreateFormData['reference_id'];
            $sellInvoice->shipping_id = $shippingCart['customer_shipping_address_id'];
            $sellInvoice->shipping_note = $shippingCart['shipping_note'];
            $sellInvoice->sell_note = $shippingCart['sell_note'];
            $sellInvoice->receiver_details = $shippingCart['receiver_details'];
        }else{
            $sellInvoice->customer_id = $this->sellCreateFormData['customer_id'];
            $sellInvoice->reference_id = $this->sellCreateFormData['reference_id'];
        }

        $customer = Customer::select('customer_type_id','phone')->where('id',$customerId)->first();
        if($customer)
        {
            $sellInvoice->customer_type_id = $customer->customer_type_id;  
            $sellInvoice->customer_phone = $customer->phone;  
        }else{
            $sellInvoice->customer_type_id = 2;  //temporary
        }
        if( $this->sellCreateFormData['sell_type'] == 1) 
        {
            $sellInvoice->sell_date = date('Y-m-d h:i:s');
        }
        $sellInvoice->status = 1;
        $sellInvoice->delivery_status = 1;
        $sellInvoice->created_by = authId_hh();

        $sellInvoice->save();

        if( $this->sellCreateFormData['sell_type'] == 2) 
        {
            $quotation =  new SellQuotation();
            $quotation->sell_invoice_id  = $sellInvoice->id;
            $quotation->invoice_no       = $sellInvoice->invoice_no;
            $quotation->customer_name    = $this->sellCreateFormData['customer_name'];
            $quotation->phone            = $this->sellCreateFormData['phone'];
            $quotation->quotation_no     = $this->sellCreateFormData['quotation_no'];
            $quotation->validate_date    = $this->sellCreateFormData['validate_date'];
            $quotation->quotation_note   = $this->sellCreateFormData['quotation_note'];
            $quotation->sell_date        = $this->sellCreateFormData['sale_date'];
            $quotation->created_by       = authId_hh();
            $quotation->save(); 
        }

        return $sellInvoice;
        return $sellInvoiceSummeryCart;
    }





 
}