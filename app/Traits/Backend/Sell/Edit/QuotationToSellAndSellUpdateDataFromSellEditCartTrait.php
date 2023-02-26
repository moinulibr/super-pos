<?php
namespace App\Traits\Backend\Sell\Edit;
use App\Models\Backend\Sell\SellInvoice;
use App\Models\Backend\Sell\SellProduct;
use App\Models\Backend\Customer\Customer;
use App\Models\Backend\Sell\SellProductStock;
use App\Traits\Backend\Payment\PaymentProcessTrait;
use App\Models\Backend\CartSell\EditSellCartInvoice;
use App\Models\Backend\CartSell\EditSellCartProduct;
use App\Models\Backend\Product\Product;
use App\Models\Backend\ProductAttribute\Unit;
use App\Traits\Backend\Stock\Logical\StockChangingTrait;
use App\Traits\Backend\Payment\CustomerPaymentProcessTrait;
use App\Traits\Backend\Sell\Logical\UpdateSellSummaryCalculationTrait;
use App\Traits\Backend\Customer\Logical\ManagingCalculationOfCustomerSummaryTrait;
/**
 * pricing trait
 * 
 */
trait QuotationToSellAndSellUpdateDataFromSellEditCartTrait
{
    use UpdateSellSummaryCalculationTrait;

    use StockChangingTrait, PaymentProcessTrait;
    use CustomerPaymentProcessTrait, ManagingCalculationOfCustomerSummaryTrait;

    protected $quotationRequestFormData;

    protected $cartName;
    protected $product_id;

    protected $totalSellingQuantity;
    protected $otherProductStockQuantityPurchasePrice;
    protected $mainProductStockQuantityPurchasePrice;
    protected $totalPurchasePriceOfAllQuantityOfThisInvoice;

    //for update
    private $totalPreviousQuantity;
    private $totalPreviousSoldAmount;
    private $totalPreviousPurchaseAmount;
    private $totalPreviousProfit;
    private $totalPreviousDeliveredQuantity;
    private $totalPreviousRemainingDeliveryQuantity;
    private $totalPreviousReducedDeliveredQuantity;
    private $totalPreviousReduceableDeliveredQuantity;
    private $totalPreviousRemainingDeliveryUnreducedQuantity;

    
    /**
     * update sell related data for edit function
     *
     * @param integer $sellType
     * @param string $invoiceNo
     * @return boolean
     */
    protected function updateSellRelatedDataFromSellEditCart(int $sellType, string $invoiceNo):bool{
        $sellInvoiceId = session()->get('sell_invoice_id_for_edit');
        $this->updateSellProductAndProductStock($sellType,$invoiceNo);
        //$this->updateSellProductStock($sellType,$invoiceNo);

        $editSellInvoice = EditSellCartInvoice::where('sell_invoice_no',$invoiceNo)->first();
        if($editSellInvoice){
            //update sell invoice data
            $this->updateSellInvoice($sellType,$editSellInvoice->sell_invoice_id);

            //delete edit sell all carts data
            $editSellInvoice->editSellCartAllProducts()->delete();
            $editSellInvoice->editSellCartAllProductsStock()->delete();
            $editSellInvoice->delete();
        }
        return true;
        //last of all have to call sellCalculation trait 
    }

    /**
     * update sell product function
     *
     * @param integer $sellType
     * @param string $invoiceNo
     * @return boolean
     */
    private function updateSellProductAndProductStock(int $sellType, string $invoiceNo) : bool{

        $sellInvoiceId = session()->get('sell_invoice_id_for_edit');

        $editSellCartProducts = EditSellCartProduct::with('editSellCartProductAllStocks')->where('branch_id',authBranch_hh())->where('sell_invoice_no',$invoiceNo)->get();//->where('status',1)
        
        foreach($editSellCartProducts as $editSellProduct){

            if($editSellProduct->status == 1){
                //only not deleted sell product data
                $existingSellProduct = SellProduct::where('product_id',$editSellProduct->product_id)->where('branch_id',authBranch_hh())->where('sell_invoice_id',$editSellProduct->sell_invoice_id)->whereNull('deleted_at')->first();//->where('main_product_stock_id',$editSellProduct->main_product_stock_id)
                if($existingSellProduct){
                    //update sell product stock
                    $this->updateSellProductStock($sellType,$editSellProduct,$existingSellProduct);
                
                    //sell product table update by this method
                    $this->updateSingleSellProductCalculation($sellType,$existingSellProduct->id);
                }
                //if edit sell product is delete, then this product and product stock related data
                //have to delete 
                else{
                    //if this product is not exist, then insert this product first  
                    $newSellProduct = $this->addNewSellProductFromSellEditCart($sellType, $editSellProduct);
                                        
                    //update sell product stock
                    $this->updateSellProductStock($sellType,$editSellProduct,$newSellProduct);
    
                    //sell product table update by this method
                    $this->updateSingleSellProductCalculation($sellType,$newSellProduct->id);
                }
            }else{
                //only not deleted sell product data
                $sellProductExist = SellProduct::where('product_id',$editSellProduct->product_id)->where('branch_id',authBranch_hh())->where('sell_invoice_id',$editSellProduct->sell_invoice_id)->whereNull('deleted_at')->first();//->where('main_product_stock_id',$editSellProduct->main_product_stock_id)
                if($sellProductExist){
                    //delete sell product stock
                    $this->deleteSellProductWithProductStock($sellType,$sellProductExist);
                }else{
                    $editSellProduct->editSellCartProductAllStocks()->delete();
                    $editSellProduct->delete();
                }
            }
        }//end foreach
        return true;


            

        //not used.. used top section
        /* 
            $editSellCartProducts = EditSellCartProduct::with('editSellCartProductAllStocks')->where('branch_id',authBranch_hh())->where('sell_invoice_no',$invoiceNo)->get();//->where('status',1)
            
            foreach($editSellCartProducts as $editSellProduct){
                //only not deleted sell product data
                $existingSellProduct = SellProduct::where('product_id',$editSellProduct->product_id)->where('branch_id',authBranch_hh())->where('sell_invoice_id',$editSellProduct->sell_invoice_id)->whereNull('deleted_at')->first();//->where('main_product_stock_id',$editSellProduct->main_product_stock_id)
                //if this product is exist, then execute 
                if($existingSellProduct){
                    //if edit sell product is active
                    if($editSellProduct->status == 1){

                        //only not deleted sell product data
                        $existingSellProduct = SellProduct::where('product_id',$editSellProduct->product_id)->where('branch_id',authBranch_hh())->where('sell_invoice_id',$editSellProduct->sell_invoice_id)->whereNull('deleted_at')->first();//->where('main_product_stock_id',$editSellProduct->main_product_stock_id)
                
                        //update sell product stock
                        $this->updateSellProductStock($sellType,$editSellProduct,$existingSellProduct);
                    
                        //sell product table update by this method
                        $this->updateSingleSellProductCalculation($sellType,$existingSellProduct->id);
                    }
                    //if edit sell product is delete, then this product and product stock related data
                    //have to delete 
                    else{
                        //delete sell product stock
                        $this->deleteSellProductWithProductStock($sellType,$existingSellProduct);
                    }
                }else{
                    //though this edit sell product is newly added to the cart, and finally its not deleted in the cart..
                    if($editSellProduct->status == 1){
                        //if this product is not exist, then insert this product first  
                        $newSellProduct = $this->addNewSellProductFromSellEditCart($sellType, $editSellProduct);
                    
                        //update sell product stock
                        $this->updateSellProductStock($sellType,$editSellProduct,$newSellProduct);
        
                        //sell product table update by this method
                        $this->updateSingleSellProductCalculation($sellType,$newSellProduct->id);
                    }
                }
            }//end foreach
            return true; 
        */
    }


    /**
     * update sell product stock function
     *
     * @param integer $sellType
     * @param object $editSellProduct
     * @param object $sellProduct
     * @return boolean
     */
    private function updateSellProductStock(int $sellType, object $editSellProduct, object $sellProduct) : bool{
    
        foreach($editSellProduct->editSellCartProductAllStocks as $editSingleSellProductStock){
            //if edit sell product stock is active, not deleted, then execute if here
            if($editSingleSellProductStock->status == 1){
                
                $existingSellProductStock = SellProductStock::where('branch_id',authBranch_hh())->where('product_stock_id',$editSingleSellProductStock->product_stock_id)->whereNull('deleted_at')->first();
                if($existingSellProductStock){
                    //update here,
                    //update data in the SellProductStock table
                    $this->updateSellProductStockFromSellEditCart($sellType,$editSingleSellProductStock,$existingSellProductStock);
                }else{
                    //add here
                    $this->addNewSellProductStockFromSellEditCart($sellType,$editSingleSellProductStock,$sellProduct);
                }
            }
            //if edit sell product stock is deleted, then execute here else
            else{
                $existSellProductStock = SellProductStock::where('branch_id',authBranch_hh())->where('product_stock_id',$editSingleSellProductStock->product_stock_id)->whereNull('deleted_at')->first();
                if($existSellProductStock){
                    //delete sellproductstock
                    $this->deleteSellProductStockBasedOnSellEditCart($sellType,$existSellProductStock);
                    $existSellProductStock->deleted_at = date('Y-m-d');
                    $existSellProductStock->save();
                }else{
                    //delete edit sell cart product stock
                    $editSingleSellProductStock->delete();
                }
            }
        }
        return true;




        //not used.. used top section
        /* 
            foreach($editSellProduct->editSellCartProductAllStocks as $editSingleSellProductStock){
                
                $existingSellProductStock = SellProductStock::where('branch_id',authBranch_hh())
                    //->where('stock_id',$editSingleSellProductStock->stock_id)
                    ->where('product_stock_id',$editSingleSellProductStock->product_stock_id)->whereNull('deleted_at')->first();
                
                //if existing data found in the SellProductStock table
                //update all value which come from sell edit cart
                if($existingSellProductStock){
                    //if this data is not deleted in the cart :- status = 1
                    if($editSingleSellProductStock->status == 1){
                        //update data in the SellProductStock table
                        $this->updateSellProductStockFromSellEditCart($sellType,$editSingleSellProductStock,$existingSellProductStock);
                    }
                    //if this data is deleted in the cart :- status = 2
                    else{
                        //stock refunded process then deleted
                        $this->deleteSellProductStockBasedOnSellEditCart($sellType,$existingSellProductStock);
                        $existingSellProductStock->deleted_at = date('Y-m-d');
                        $existingSellProductStock->save();
                    }
                }
                //existing data not found
                //store new data in the SellProductStock table which come from sell edit cart
                else{
                    //though this item is newly added in the cart, and finally it's not deleted in the cart..
                    if($editSingleSellProductStock->status == 1){
                        $this->addNewSellProductStockFromSellEditCart($sellType,$editSingleSellProductStock,$sellProduct);
                    }
                }
            }
            return true; 
        */
    }

    /**
     * delete sell product with product stock function
     *
     * @param [type] $sellType
     * @param object $existingSellProduct
     * @return object
     */
    private function deleteSellProductWithProductStock($sellType,object $existingSellProduct) : object {

        //$existingSellProduct->sellProductStocksAllData()->update(['deleted_at'=>date('Y-m-d h:i:s')]);
        foreach($existingSellProduct->sellProductStocks as $sellProductStock){
            $this->deleteSellProductStockBasedOnSellEditCart($sellType,$sellProductStock);
        }
        
        $existingSellProduct->deleted_at = date('Y-m-d h:i:s');
        $existingSellProduct->save();
        return $existingSellProduct;
    }


    /**
     * update sell product stock from sell edit cart function
     *
     * @param integer $sellType
     * @param object $editSellCartProductStock
     * @param object $existingSellProductStock
     * @return object
     */
    private function updateSellProductStockFromSellEditCart(int $sellType = 1,object $editSellCartProductStock, object $existingSellProductStock) : object {

        $unitId = $editSellCartProductStock->editSellCartProductOnly ? $editSellCartProductStock->editSellCartProductOnly->unit_id : NULL; 
        
        $sellProductStock  =  $existingSellProductStock;
        $sellProductStock->branch_id = authBranch_hh();
        $sellProductStock->sell_invoice_id  = $editSellCartProductStock->sell_invoice_id;
        $sellProductStock->sell_product_id  = $editSellCartProductStock->sell_product_id;
        $sellProductStock->product_id  = $editSellCartProductStock->product_id;
        $sellProductStock->stock_id  = $editSellCartProductStock->stock_id;
        $sellProductStock->product_stock_id  = $editSellCartProductStock->product_stock_id;
        
        $totalQty = $editSellCartProductStock->total_quantity;
       
        //minus / return stock qty from sell product stock to main product stock
        $this->minusSellProductStockAndMainProductStockBasedOnPreviousSellProductStock($sellType, $existingSellProductStock);
        
        $sellProductStock->total_sell_qty  = $totalQty;
        $sellProductStock->mrp_price  = $editSellCartProductStock->mrp_price;
        $sellProductStock->regular_sell_price  = $editSellCartProductStock->regular_sell_price;
        $sellProductStock->sold_price  = $editSellCartProductStock->sold_price;
        $sellProductStock->purchase_price  = $editSellCartProductStock->purchase_price;

        $totalSellingAmount = $editSellCartProductStock->sold_price * $totalQty;
        $sellProductStock->total_selling_amount  = $totalSellingAmount;
        //$sellProductStock->total_refunded_amount  = 0;
        $sellProductStock->total_sold_amount  = $totalSellingAmount;
        
        $totalSellingPurchaseAmount = $editSellCartProductStock->purchase_price * $totalQty;
        $sellProductStock->total_selling_purchase_amount  =  $totalSellingPurchaseAmount;
        //$sellProductStock->total_refunding_purchase_amount  = 0;
        $sellProductStock->total_purchase_amount =  $totalSellingPurchaseAmount;
        $sellProductStock->total_quantity = $totalQty;
        //$sellProductStock->total_refunded_qty  = 0;

        $sellProductStock->total_selling_profit = $totalSellingAmount - $totalSellingPurchaseAmount;
        //$sellProductStock->refunded_reduced_profit  = 0;
        $sellProductStock->total_profit_from_product = $totalSellingAmount - $totalSellingPurchaseAmount;
        $sellProductStock->total_profit = $totalSellingAmount - $totalSellingPurchaseAmount;

        $sellProductStock->save();
    
        //$sellProductStock->reduced_base_stock_remaining_delivery = $sellProductStock->reduced_base_stock_remaining_delivery - $minusQtyFromReducedRemainingDeliveryAndIncrementToMainStock;
        //$sellProductStock->remaining_delivery_unreduced_qty = $sellProductStock->remaining_delivery_unreduced_qty - $directMinusQtyFromProcessLaterQty;
        //$sellProductStock->reduceable_delivered_qty = $sellProductStock->reduceable_delivered_qty - $minusQtyFromReducedRemainingDeliveryAndIncrementToMainStock;
        //$sellProductStock->remaining_delivery_unreduced_qty_date = $minusQtyFromReducedRemainingDeliveryAndIncrementToMainStock;
        //$decrementQtyFromMainStockAsRegularProcess = 0;

        //---------------------------------------------------------------
            $pStock = productStockByProductStockId_hh($sellProductStock->product_stock_id);
            $stockId = regularStockId_hh();
            if($pStock)
            {
                $availableBaseStock = $pStock->available_base_stock;
                $stockId = $pStock->stock_id;
            }else{
                $availableBaseStock = 0;
            }
            //stock id 
            $sellProductStock->stock_id = $stockId;

            $process_duration = 1;
            $stockProcessLaterQty  = 0;
            if($availableBaseStock > $totalQty)
            {
                //instantly processed all qty
                $instantlyProcessedQty = $totalQty;
                $stockProcessLaterDate = ""; 
                $stockProcessLaterQty  = 0;
            }
            else if($availableBaseStock == $totalQty)
            {
                //instantly processed all qty
                $instantlyProcessedQty = $totalQty;
                $stockProcessLaterDate = ""; 
                $stockProcessLaterQty  = 0;
            }
            else if($availableBaseStock < $totalQty)
            {
                //instantly processed all qty
                $overStock = $totalQty - $availableBaseStock;
                $instantlyProcessedQty = $totalQty - $overStock;
                $stockProcessLaterDate = date('Y-m-d',strtotime('+'.$process_duration.' day')); 
                $stockProcessLaterQty  = $overStock;
            }
            else 
            {   
                //instantly processed qty
                $overStock = $totalQty - $availableBaseStock;
                $instantlyProcessedQty = $totalQty - $overStock;
                $stockProcessLaterDate = date('Y-m-d',strtotime('+'.$process_duration.' day')); 
                $stockProcessLaterQty  = $overStock;
            }

            
            //if sell_type==1, then reduce stock from product stocks table 
            if($sellType  == 1 && $instantlyProcessedQty > 0){
                $this->stock_id_FSCT = $stockId;
                $this->product_id_FSCT = $sellProductStock->product_id;
                $this->stock_quantity_FSCT = $instantlyProcessedQty;
                $this->unit_id_FSCT = $unitId ;
                $this->stock_changing_history_process_FSCT = 2;//later
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
                $sellProductStock->total_delivered_qty = $totalDeliverdQty;
                $sellProductStock->remaining_delivery_qty = $totalQty - $totalDeliverdQty;

                //$productStock->reduceable_delivered_qty = 0;//new field
                $sellProductStock->reduced_base_stock_remaining_delivery = $instantlyProcessedQty;//new field
                $sellProductStock->remaining_delivery_unreduced_qty = $stockProcessLaterQty;//new
                $sellProductStock->remaining_delivery_unreduced_qty_date = $stockProcessLaterDate;//new
            }
        //---------------------------------------------------------------


        $sellProductStock->sell_cart  = $editSellCartProductStock->sell_cart;
        $sellProductStock->created_by = authId_hh();
        $sellProductStock->status = 1;
        $sellProductStock->delivery_status = 1;
        $sellProductStock->save();
        return $sellProductStock;

        /* 
            $previousTotalDeliveredQty = $existingSellProductStock->total_delivered_qty;
            $previousTotalRemaininDeliveryQty = $existingSellProductStock->remaining_delivery_qty;
            $previousTotalReduceableDeliveredQty = $existingSellProductStock->reduceable_delivered_qty;
            $previousTotalRemainingDeliveryQtyDate = $existingSellProductStock->remaining_delivery_unreduced_qty_date; */
            
            /* $previousMrp = $existingSellProductStock->mrp_price;
            $previousRegularSellPrice = $existingSellProductStock->regular_sell_price;
            $previousSoldPrice = $existingSellProductStock->sold_price;
            $previousPurchasePrice = $existingSellProductStock->purchase_price;
            $previousTotalSellingAmount = $existingSellProductStock->total_selling_amount;
            $previousTotalSoldAmount = $existingSellProductStock->total_sold_amount;
            $previousTotalSellingPurchaseAmount = $existingSellProductStock->total_selling_purchase_amount;
            $previousTotalPurchaseAmount = $existingSellProductStock->total_purchase_amount;
            $previousTotalProfitFromProduct = $existingSellProductStock->total_profit_from_product;
            $previousTotalProfit = $existingSellProductStock->total_profit; 
        */

        /* 
            $previousTotalQty = $existingSellProductStock->total_quantity;
            $previousTotalReducedBaseStockRemainingDeliveryQty = $existingSellProductStock->reduced_base_stock_remaining_delivery;
            $previousTotalRemainingDeliveryUnreducedQty = $existingSellProductStock->remaining_delivery_unreduced_qty;
            //compare total_quantity, if previous qty is more then current qty  
            $directMinusQtyFromProcessLaterQty = 0;
            $minusQtyFromReducedRemainingDeliveryAndIncrementToMainStock = 0;
            $decrementQtyFromMainStockAsRegularProcess = 0;

            if($sellType == 1){
                $stockProcessing =  $this->getQtyRelatedDataAfterComparePreviousAndCurrentQty(
                    $previousTotalQty,$totalQty,$previousTotalReducedBaseStockRemainingDeliveryQty,
                    $previousTotalRemainingDeliveryUnreducedQty
                );
                $directMinusQtyFromProcessLaterQty =  $stockProcessing['direct_minus_qty_from_process_later_qty'];
                $minusQtyFromReducedRemainingDeliveryAndIncrementToMainStock = $stockProcessing['minus_qty_from_reduced_remaining_delivery_and_increment_to_main_stock'];
                $decrementQtyFromMainStockAsRegularProcess =  $stockProcessing['decrement_from_main_stock_as_regular_process'];
            }
            
            $pStock = productStockByProductStockId_hh($sellProductStock->product_stock_id);
            $stockId = regularStockId_hh();
            $process_duration = 2;
            if($pStock)
            {
                //store for previous minus qty from stock
                $pStock->available_base_stock = (($pStock->available_base_stock) + ($minusQtyFromReducedRemainingDeliveryAndIncrementToMainStock));
                $pStock->reduced_base_stock_remaining_delivery = (($pStock->reduced_base_stock_remaining_delivery) - ($minusQtyFromReducedRemainingDeliveryAndIncrementToMainStock));
                $pStock->negative_sold_base_stock = (($pStock->negative_sold_base_stock) - ($directMinusQtyFromProcessLaterQty));//sold this stock, but not available then. so it's negative stock. when purchase product and received stock, then this stock have to minus, but not effect on main base stock - just minus from this stock - available_base_stock
                $pStock->save();
                
                //it's uses for next sept
                $availableBaseStock = $pStock->available_base_stock;
                $stockId = $pStock->stock_id;
            }else{
                $availableBaseStock = 0;
            }
            //stock id 
            $sellProductStock->stock_id = $stockId;

            $stockProcessLaterQty  = 0;
            $instantlyProcessedQty = 0;
            if($decrementQtyFromMainStockAsRegularProcess > 0  && $sellType  == 1){
                if($availableBaseStock > $decrementQtyFromMainStockAsRegularProcess)
                {
                    //instantly processed all qty
                    $instantlyProcessedQty = $decrementQtyFromMainStockAsRegularProcess;
                    $stockProcessLaterDate = ""; 
                    $stockProcessLaterQty  = 0;
                }
                else if($availableBaseStock == $decrementQtyFromMainStockAsRegularProcess)
                {
                    //instantly processed all qty
                    $instantlyProcessedQty = $decrementQtyFromMainStockAsRegularProcess;
                    $stockProcessLaterDate = ""; 
                    $stockProcessLaterQty  = 0;
                }
                else if($availableBaseStock < $decrementQtyFromMainStockAsRegularProcess)
                {
                    //instantly processed all qty
                    $overStock = $decrementQtyFromMainStockAsRegularProcess - $availableBaseStock;
                    $instantlyProcessedQty = $decrementQtyFromMainStockAsRegularProcess - $overStock;
                    $stockProcessLaterDate = date('Y-m-d',strtotime('+'.$process_duration.' day')); 
                    $stockProcessLaterQty  = $overStock;
                }
                else 
                {   
                    //instantly processed qty
                    $overStock = $decrementQtyFromMainStockAsRegularProcess - $availableBaseStock;
                    $instantlyProcessedQty = $decrementQtyFromMainStockAsRegularProcess - $overStock;
                    $stockProcessLaterDate = date('Y-m-d',strtotime('+'.$process_duration.' day')); 
                    $stockProcessLaterQty  = $overStock;
                }
            }
            //if sell_type==1, then reduce stock from product stocks table 
            if($sellType  == 1 && $instantlyProcessedQty > 0){
                $this->stock_id_FSCT = $stockId;
                $this->product_id_FSCT = $editSellCartProductStock->product_id;
                $this->stock_quantity_FSCT = $instantlyProcessedQty;
                $this->unit_id_FSCT = $unitId;
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
                $sellProductStock->total_delivered_qty = $totalDeliverdQty;
                $sellProductStock->remaining_delivery_qty = $totalQty - $totalDeliverdQty;
        
                //$productStock->reduceable_delivered_qty = 0;//new field
                $sellProductStock->reduced_base_stock_remaining_delivery = (($sellProductStock->reduced_base_stock_remaining_delivery) +  ($instantlyProcessedQty));//new field
                $sellProductStock->remaining_delivery_unreduced_qty = (($sellProductStock->remaining_delivery_unreduced_qty) + ($stockProcessLaterQty));//new
                $sellProductStock->remaining_delivery_unreduced_qty_date = date('Y-m-d',strtotime("+2 day"));//new
                $sellProductStock->delivered_total_qty  = 0;//$totalDeliverdQty;
            } 
        */
    }
    
    /**
     * get qty related data after compare previous and current qty function, 
     * It's under update sell product stock from sell edit cart 
     * (updateSellProductStockFromSellEditCart) method
     * 
     * @param integer $previousTotalQty
     * @param integer $currentQty
     * @param integer $previousTotalReducedBaseStockRemainingDeliveryQty
     * @param integer $previousStockProcessLaterQty
     * @return array
     */
    private function getQtyRelatedDataAfterComparePreviousAndCurrentQty(
        int $previousTotalQty, int $currentQty,
        int $previousTotalReducedBaseStockRemainingDeliveryQty,
        int $previousStockProcessLaterQty
        ) : array
    {

        $currentlyOverQtyMinusFromStockProcessLaterQty = 0;
        $currentlyOverQtyMinusFromReducedQtyRemainingDelivery = 0;
        $currentlyOverQtyWhichWillbeDecrementFromMainStock = 0;
        $currentlyReturnableQtyWhichWillbeIncrementWithMainStock = 0;

        // 3 < 5
        //current qty is less then previous qty
        if($currentQty < $previousTotalQty){
            //then minus qty from later quanity
            //focused on reduced based stock remaining delivery.. for keeping this qty first priority
            
            //curr 3 , previous reduced stock 5, later qty 0 , total previous qty = 5
            //curr 3 , previous reduced stock 4, later qty 1 , total previous qty = 5
            $overQtyMinusFromRemainingDelivery = 0;
            $overQtyMinusFromProcessLaterQty = 0;
            if($currentQty < $previousTotalReducedBaseStockRemainingDeliveryQty){
                //we are bound to minus from both field, if there remain available qty.
                $overQtyMinusFromRemainingDelivery = $previousTotalReducedBaseStockRemainingDeliveryQty - $currentQty;
                $overQtyMinusFromProcessLaterQty = ($previousTotalQty - ($overQtyMinusFromRemainingDelivery + $currentQty));
            }
            //current qty 4, previous qty processed reduced 0, later 7, total 7
            //current qty 4, previous qty processed reduced 1, later 6, total 7
            //current qty 4, previous qty processed reduced 2, later 5, total 7
            //current qty 4, previous qty processed reduced 3, later 4, total 7
            else if($currentQty > $previousTotalReducedBaseStockRemainingDeliveryQty){
                // 4-0 = 4, 7-4=3 thakbe 7-3=4
                // 4-1 = 3, 7-3=4 thakbe 7-4=3
                // 4-2 = 2, 7-2=5 thakbe 7-5=2
                // 4-3 = 1, 7-1=6 thakbe 7-6=1
                $keepableForLater = $currentQty - $previousTotalReducedBaseStockRemainingDeliveryQty;
                $overQtyMinusFromProcessLaterQty =  $previousStockProcessLaterQty - $keepableForLater;
                $overQtyMinusFromRemainingDelivery = 0;
            }
            //current qty 4, previous qty processed reduced 4, later 3, total 7
            //current qty 2, previous qty processed reduced 2, later 5, total 7
            else if($currentQty == $previousTotalReducedBaseStockRemainingDeliveryQty){
                $overQtyMinusFromRemainingDelivery = 0;
                $overQtyMinusFromProcessLaterQty = $previousTotalQty - $previousTotalReducedBaseStockRemainingDeliveryQty;
            }

            $currentlyOverQtyMinusFromStockProcessLaterQty = $overQtyMinusFromProcessLaterQty;
            $currentlyOverQtyMinusFromReducedQtyRemainingDelivery = $overQtyMinusFromRemainingDelivery;

            $currentlyOverQtyWhichWillbeDecrementFromMainStock = 0;
            $currentlyReturnableQtyWhichWillbeIncrementWithMainStock = 0;

        }

        // 7  >  5
        //current qty is more then previous qty
        else if($currentQty > $previousTotalQty){
    
            $currentlyOverQtyWhichWillbeDecrementFromMainStock = $currentQty - $previousTotalQty;
            $currentlyReturnableQtyWhichWillbeIncrementWithMainStock = 0;

            $currentlyOverQtyMinusFromStockProcessLaterQty = 0;
            $currentlyOverQtyMinusFromReducedQtyRemainingDelivery = 0;
        }

        // 5   =   5 //nothing change
        //current qty is equal to previous qty
        else if($currentQty == $previousTotalQty){
            $currentlyOverQtyWhichWillbeDecrementFromMainStock = 0;
            $currentlyReturnableQtyWhichWillbeIncrementWithMainStock = 0;

            $currentlyOverQtyMinusFromStockProcessLaterQty = 0;
            $currentlyOverQtyMinusFromReducedQtyRemainingDelivery = 0;
        }

        return [
            'direct_minus_qty_from_process_later_qty' => $currentlyOverQtyMinusFromStockProcessLaterQty,
            'minus_qty_from_reduced_remaining_delivery_and_increment_to_main_stock' => $currentlyOverQtyMinusFromReducedQtyRemainingDelivery,
            'decrement_from_main_stock_as_regular_process' => $currentlyOverQtyWhichWillbeDecrementFromMainStock,
            'returnable_increment_with_main_stock' => $currentlyReturnableQtyWhichWillbeIncrementWithMainStock,
        ];
    }

    
    /**
     * delete sell product stock from sell edit cart function
     *
     * @param integer $sellType
     * @param object $existingSellProductStock
     * @return boolean
     */
    private function minusSellProductStockAndMainProductStockBasedOnPreviousSellProductStock(int $sellType, object $existingSellProductStock):bool {
        
        $previousReducedBaseStockDecrementQty = $existingSellProductStock->reduced_base_stock_remaining_delivery;
        $previousRemainingDeliveryUnreducedQty = $existingSellProductStock->remaining_delivery_unreduced_qty;

        //delivery quantity
        if($sellType  == 1){
            $existingSellProductStock->total_delivered_qty = 0;
            $existingSellProductStock->remaining_delivery_qty = 0;
    
            $existingSellProductStock->reduceable_delivered_qty = 0;//new field
            $existingSellProductStock->reduced_base_stock_remaining_delivery = 0;//new field
            $existingSellProductStock->remaining_delivery_unreduced_qty = 0;//new
            $existingSellProductStock->remaining_delivery_unreduced_qty_date = NULL;//new
            $existingSellProductStock->delivered_total_qty = 0;
        }
        $existingSellProductStock->save();

        $pStock = productStockByProductStockId_hh($existingSellProductStock->product_stock_id);
        if($pStock && $sellType  == 1)
        {
            $pStock->available_base_stock = $pStock->available_base_stock + $previousReducedBaseStockDecrementQty;

            $reducedBaseStockSoldQtyRemainingDelivery = $pStock->reduced_base_stock_remaining_delivery;
            $reducedBaseStockNewQtyAfterMinus = 0;
            if($reducedBaseStockSoldQtyRemainingDelivery  == 0){
                $reducedBaseStockNewQtyAfterMinus = 0;
            } else if($reducedBaseStockSoldQtyRemainingDelivery  == $previousReducedBaseStockDecrementQty){
                $reducedBaseStockNewQtyAfterMinus = 0;
            }else if($reducedBaseStockSoldQtyRemainingDelivery  < $previousReducedBaseStockDecrementQty){
                $reducedBaseStockNewQtyAfterMinus = 0;
            }else if($reducedBaseStockSoldQtyRemainingDelivery > $previousReducedBaseStockDecrementQty){
                $reducedBaseStockNewQtyAfterMinus = $reducedBaseStockSoldQtyRemainingDelivery - $previousReducedBaseStockDecrementQty;
            }
            $pStock->reduced_base_stock_remaining_delivery = $reducedBaseStockNewQtyAfterMinus;
            

            $negativeSoldStock = $pStock->negative_sold_base_stock;
            $negativeNewQtyAfterMinus = 0;
            if($negativeSoldStock  == 0){
                $negativeNewQtyAfterMinus = 0;
            } else if($negativeSoldStock  == $previousRemainingDeliveryUnreducedQty){
                $negativeNewQtyAfterMinus = 0;
            }else if($negativeSoldStock  < $previousRemainingDeliveryUnreducedQty){
                $negativeNewQtyAfterMinus = 0;
            }else if($negativeSoldStock > $previousRemainingDeliveryUnreducedQty){
                $negativeNewQtyAfterMinus = $negativeSoldStock - $previousRemainingDeliveryUnreducedQty;
            }
            $pStock->negative_sold_base_stock = $negativeNewQtyAfterMinus;//sold this stock, but not available then. so it's negative stock. when purchase product and received stock, then this stock have to minus, but not effect on main base stock - just minus from this stock - available_base_stock
            $pStock->save();
        }

        return true;
        /* 
            $previousMrp = $existingSellProductStock->mrp_price;
            $previousRegularSellPrice = $existingSellProductStock->regular_sell_price;
            $previousSoldPrice = $existingSellProductStock->sold_price;
            $previousPurchasePrice = $existingSellProductStock->purchase_price;
            $previousTotalSellingAmount = $existingSellProductStock->total_selling_amount;
            $previousTotalSoldAmount = $existingSellProductStock->total_sold_amount;
            $previousTotalSellingPurchaseAmount = $existingSellProductStock->total_selling_purchase_amount;
            $previousTotalPurchaseAmount = $existingSellProductStock->total_purchase_amount;
            $previousTotalProfitFromProduct = $existingSellProductStock->total_profit_from_product;
            $previousTotalProfit = $existingSellProductStock->total_profit;
            $totalQty = $existingSellProductStock->total_quantity;
        */
    }




    /**
     * add new sell product from sell edit cart function
     *
     * @param integer $sellType
     * @param object $singleEditSellProduct
     * @return object
     */
    private function addNewSellProductFromSellEditCart(int $sellType, object $singleEditSellProduct) : object {
        
        $sellProduct = new SellProduct();
        $sellProduct->branch_id = authBranch_hh();
        $sellProduct->sell_invoice_id = $singleEditSellProduct->sell_invoice_id;
        $sellProduct->product_id = $singleEditSellProduct->product_id;
        $sellProduct->unit_id =$singleEditSellProduct->unit_id;
        $sellProduct->supplier_id = $singleEditSellProduct->supplier_id;
        $sellProduct->main_product_stock_id = $singleEditSellProduct->main_product_stock_id;
        $sellProduct->product_stock_type = $singleEditSellProduct->product_stock_type;
        $sellProduct->custom_code = $singleEditSellProduct->custom_code;

        $sellProduct->total_sell_qty = $singleEditSellProduct->total_quantity;
        $sellProduct->total_quantity = $singleEditSellProduct->total_quantity;

        $sellProduct->sold_price = $singleEditSellProduct->sold_price;
        $sellProduct->discount_amount = $singleEditSellProduct->discount_amount;
        $sellProduct->discount_type = $singleEditSellProduct->discount_type;
        $sellProduct->total_discount = $singleEditSellProduct->total_discount;
        $sellProduct->reference_commission = 0;//$cart[''];

        $sellProduct->total_selling_amount = $singleEditSellProduct->total_sold_amount;
        $sellProduct->total_sold_amount = $singleEditSellProduct->total_sold_amount;
        $sellProduct->total_selling_purchase_amount = $singleEditSellProduct->total_purchase_amount;
        $sellProduct->total_purchase_amount = $singleEditSellProduct->total_purchase_amount;

        $sellProduct->total_selling_profit = $singleEditSellProduct->total_profit;
        $sellProduct->total_profit_from_product = $singleEditSellProduct->total_profit;
        $sellProduct->total_profit = $singleEditSellProduct->total_profit;

        if($singleEditSellProduct->liability_type)
        {
            $sellProduct->liability_type = $singleEditSellProduct->liability_type;
        }
        $sellProduct->identity_number = $singleEditSellProduct->identity_number;
        $sellProduct->cart = $singleEditSellProduct->cart;
        /* json_encode([
            'productName' => $singleEditSellProduct->product_id,
            "productId" =>$singleEditSellProduct->product_id,
            'mrpPrice' => $singleEditSellProduct->product_id,
            'soldPrice' =>$singleEditSellProduct->product_id,
            'totalSellQuantity' =>$singleEditSellProduct->product_id,
            'totalMainProductStockQuantity' =>$singleEditSellProduct->product_id,
            'totalOtherProductStockQuantity' =>$singleEditSellProduct->product_id,
            'unitName' => $singleEditSellProduct->product_id,
            'unitId' =>$singleEditSellProduct->product_id,
            'customCode' =>$singleEditSellProduct->product_id,
            'warehouseId' =>$singleEditSellProduct->product_id,
            'warehouseRackId' => $singleEditSellProduct->product_id,
        ]); */

        $sellProduct->status =1;
        $sellProduct->delivery_status =1;
        $sellProduct->created_by = authId_hh();
        $sellProduct->save();
        return $sellProduct;
    }
    /**
     * add new SellProductStock data function, which is under updateSellProductStock function
     *
     * @param integer $sellType
     * @param object $editSellCartProductStock
     * @return boolean
     */
    private function addNewSellProductStockFromSellEditCart(int $sellType, object $editSellCartProductStock,
        object $sellProduct) : bool 
    {
        
        $unitId = $editSellCartProductStock->editSellCartProductOnly ? $editSellCartProductStock->editSellCartProductOnly->unit_id : NULL; 
        
        $sellProductStock  =  new SellProductStock();
        $sellProductStock->branch_id = authBranch_hh();
        $sellProductStock->sell_invoice_id  = $editSellCartProductStock->sell_invoice_id;
        $sellProductStock->sell_product_id  = $sellProduct->id;
        $sellProductStock->product_id  = $editSellCartProductStock->product_id;
        $sellProductStock->stock_id  = $editSellCartProductStock->stock_id;
        $sellProductStock->product_stock_id  = $editSellCartProductStock->product_stock_id;
            
        $totalQty = $editSellCartProductStock->total_quantity;
        $sellProductStock->total_sell_qty  = $totalQty;
        $sellProductStock->mrp_price  = $editSellCartProductStock->mrp_price;
        $sellProductStock->regular_sell_price  = $editSellCartProductStock->regular_sell_price;
        $sellProductStock->sold_price  = $editSellCartProductStock->sold_price;
        $sellProductStock->purchase_price  = $editSellCartProductStock->purchase_price;

        $totalSellingAmount = $editSellCartProductStock->sold_price * $totalQty;
        $sellProductStock->total_selling_amount  = $totalSellingAmount;
        //$sellProductStock->total_refunded_amount  = 0;
        $sellProductStock->total_sold_amount  = $totalSellingAmount;
        
        $totalSellingPurchaseAmount = $editSellCartProductStock->purchase_price * $totalQty;
        $sellProductStock->total_selling_purchase_amount  =  $totalSellingPurchaseAmount;
        //$sellProductStock->total_refunding_purchase_amount  = 0;
        $sellProductStock->total_purchase_amount =  $totalSellingPurchaseAmount;
        $sellProductStock->total_quantity = $totalQty;
        //$sellProductStock->total_refunded_qty  = 0;

        $productSellProfit = $totalSellingAmount - $totalSellingPurchaseAmount;
        $sellProductStock->total_selling_profit  = $productSellProfit;
        //$sellProductStock->refunded_reduced_profit  = 0;
        $sellProductStock->total_profit_from_product  = $productSellProfit;
        $sellProductStock->total_profit  = $productSellProfit;


        
        $pStock = productStockByProductStockId_hh($sellProductStock->product_stock_id);
        $stockId = regularStockId_hh();
        $process_duration = 2;
        if($pStock)
        {
            $availableBaseStock = $pStock->available_base_stock;
            $stockId = $pStock->stock_id;
        }else{
            $availableBaseStock = 0;
        }
        //stock id 
        $sellProductStock->stock_id = $stockId;

        $stockProcessLaterQty  = 0;
        if($availableBaseStock > $totalQty)
        {
            //instantly processed all qty
            $instantlyProcessedQty = $totalQty;
            $stockProcessLaterDate = ""; 
            $stockProcessLaterQty  = 0;
        }
        else if($availableBaseStock == $totalQty)
        {
            //instantly processed all qty
            $instantlyProcessedQty = $totalQty;
            $stockProcessLaterDate = ""; 
            $stockProcessLaterQty  = 0;
        }
        else if($availableBaseStock < $totalQty)
        {
            //instantly processed all qty
            $overStock = $totalQty - $availableBaseStock;
            $instantlyProcessedQty = $totalQty - $overStock;
            $stockProcessLaterDate = date('Y-m-d',strtotime('+'.$process_duration.' day')); 
            $stockProcessLaterQty  = $overStock;
        }
        else 
        {   
            //instantly processed qty
           $overStock = $totalQty - $availableBaseStock;
           $instantlyProcessedQty = $totalQty - $overStock;
           $stockProcessLaterDate = date('Y-m-d',strtotime('+'.$process_duration.' day')); 
           $stockProcessLaterQty  = $overStock;
        }

        //if sell_type==1, then reduce stock from product stocks table 
        if($sellType  == 1 && $instantlyProcessedQty > 0){
            $this->stock_id_FSCT = $stockId;
            $this->product_id_FSCT = $editSellCartProductStock->product_id;
            $this->stock_quantity_FSCT = $instantlyProcessedQty;
            $this->unit_id_FSCT = $unitId;//$cart['unit_id'];
            $this->stock_changing_history_process_FSCT = 2;//later
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
            $sellProductStock->total_delivered_qty = $totalDeliverdQty;
            $sellProductStock->remaining_delivery_qty = $totalQty - $totalDeliverdQty;
    
            //$productStock->reduceable_delivered_qty = 0;//new field
            $sellProductStock->reduced_base_stock_remaining_delivery = $instantlyProcessedQty;//new field
            $sellProductStock->remaining_delivery_unreduced_qty = $stockProcessLaterQty;//new
            $sellProductStock->remaining_delivery_unreduced_qty_date = $stockProcessLaterDate;//new
            $sellProductStock->delivered_total_qty  = $totalDeliverdQty;
        }

        $sellProductStock->sell_cart  = $editSellCartProductStock->sell_cart;
        $sellProductStock->created_by = authId_hh();
        $sellProductStock->status = 1;
        $sellProductStock->delivery_status = 1;
        $sellProductStock->save();
        return true;
    }

    /**
     * delete sell product stock from sell edit cart function
     *
     * @param integer $sellType
     * @param object $existingSellProductStock
     * @return boolean
     */
    private function deleteSellProductStockBasedOnSellEditCart(int $sellType, object $existingSellProductStock):bool {
        
        $previousReducedBaseStockDecrementQty = $existingSellProductStock->reduced_base_stock_remaining_delivery;
        $previousRemainingDeliveryUnreducedQty = $existingSellProductStock->remaining_delivery_unreduced_qty;

        //delivery quantity
        if($sellType  == 1){
            $existingSellProductStock->total_delivered_qty = 0;
            $existingSellProductStock->remaining_delivery_qty = 0;
    
            $existingSellProductStock->reduceable_delivered_qty = 0;//new field
            $existingSellProductStock->reduced_base_stock_remaining_delivery = 0;//new field
            $existingSellProductStock->remaining_delivery_unreduced_qty = 0;//new
            $existingSellProductStock->remaining_delivery_unreduced_qty_date = NULL;//new
            $existingSellProductStock->delivered_total_qty = 0;
        }
        $existingSellProductStock->deleted_at = date('Y-m-d h:i:s');
        $existingSellProductStock->save();

        $pStock = productStockByProductStockId_hh($existingSellProductStock->product_stock_id);
        if($pStock && $sellType  == 1)
        {
            $pStock->available_base_stock = $pStock->available_base_stock + $previousReducedBaseStockDecrementQty;

            $reducedBaseStockSoldQtyRemainingDelivery = $pStock->reduced_base_stock_remaining_delivery;
            $reducedBaseStockNewQtyAfterMinus = 0;
            if($reducedBaseStockSoldQtyRemainingDelivery  == 0){
                $reducedBaseStockNewQtyAfterMinus = 0;
            } else if($reducedBaseStockSoldQtyRemainingDelivery  == $previousReducedBaseStockDecrementQty){
                $reducedBaseStockNewQtyAfterMinus = 0;
            }else if($reducedBaseStockSoldQtyRemainingDelivery  < $previousReducedBaseStockDecrementQty){
                $reducedBaseStockNewQtyAfterMinus = 0;
            }else if($reducedBaseStockSoldQtyRemainingDelivery > $previousReducedBaseStockDecrementQty){
                $reducedBaseStockNewQtyAfterMinus = $reducedBaseStockSoldQtyRemainingDelivery - $previousReducedBaseStockDecrementQty;
            }
            $pStock->reduced_base_stock_remaining_delivery = $reducedBaseStockNewQtyAfterMinus;
            

            $negativeSoldStock = $pStock->negative_sold_base_stock;
            $negativeNewQtyAfterMinus = 0;
            if($negativeSoldStock  == 0){
                $negativeNewQtyAfterMinus = 0;
            } else if($negativeSoldStock  == $previousRemainingDeliveryUnreducedQty){
                $negativeNewQtyAfterMinus = 0;
            }else if($negativeSoldStock  < $previousRemainingDeliveryUnreducedQty){
                $negativeNewQtyAfterMinus = 0;
            }else if($negativeSoldStock > $previousRemainingDeliveryUnreducedQty){
                $negativeNewQtyAfterMinus = $negativeSoldStock - $previousRemainingDeliveryUnreducedQty;
            }
            $pStock->negative_sold_base_stock = $negativeNewQtyAfterMinus;//sold this stock, but not available then. so it's negative stock. when purchase product and received stock, then this stock have to minus, but not effect on main base stock - just minus from this stock - available_base_stock
            $pStock->save();
        }

        return true;
        /* 
            $previousMrp = $existingSellProductStock->mrp_price;
            $previousRegularSellPrice = $existingSellProductStock->regular_sell_price;
            $previousSoldPrice = $existingSellProductStock->sold_price;
            $previousPurchasePrice = $existingSellProductStock->purchase_price;
            $previousTotalSellingAmount = $existingSellProductStock->total_selling_amount;
            $previousTotalSoldAmount = $existingSellProductStock->total_sold_amount;
            $previousTotalSellingPurchaseAmount = $existingSellProductStock->total_selling_purchase_amount;
            $previousTotalPurchaseAmount = $existingSellProductStock->total_purchase_amount;
            $previousTotalProfitFromProduct = $existingSellProductStock->total_profit_from_product;
            $previousTotalProfit = $existingSellProductStock->total_profit;
            $totalQty = $existingSellProductStock->total_quantity;
        */
    }


    
    private function updateSingleSellProductCalculation(int $sellType, $primaryId){
        $this->updateSellProductCalculation($primaryId);
        return true;
    }
    private function updateSellInvoice(int $sellType, $primaryId){
        $this->updateSellInvoiceCalculation($primaryId);
        return true;
    }






    /*############################### sell from quotation ############################*/
    /*
    |-----------------------------------------------------------------------------------
    | this part is only for sell from quotation
    | Its a same process when sell create 
    |------------------------------------------------------------------------------------
    */
        protected function quotationToSellStoreDataFromSellEditCart(int $sellType, object $editSellCartInvoice,$requestData){
            //request valu assign here
            $this->quotationRequestFormData = $requestData;

            $invoiceNo = $editSellCartInvoice->sell_invoice_no;
            $sellInvoiceId = session()->get('sell_invoice_id_for_edit');
            
            $editSellInvoice = EditSellCartInvoice::where('sell_invoice_no',$invoiceNo)->first();
            $sellInvoice = $this->dataProcessingForQuotationToSell($sellType,$editSellInvoice,$requestData);
            
            if($editSellInvoice){
                //update sell invoice data
                $this->updateSellInvoiceCalculation($sellInvoice->id);
                //update sell invoice data
                
                $previousSellQuotation = SellInvoice::select('sold_type','id')->findOrFail($sellInvoiceId);
                if($previousSellQuotation){
                    $previousSellQuotation->sold_type = 3;
                    $previousSellQuotation->save();
                }

                //delete edit sell all carts data
                $editSellInvoice->editSellCartAllProducts()->delete();
                $editSellInvoice->editSellCartAllProductsStock()->delete();
                $editSellInvoice->delete();
            }
            return true;
            //last of all have to call sellCalculation trait 
        }

        /**
         * data processing for quotation to sell function
         * where from we can process whole insertable data
         * 
         * @param integer $sellType
         * @param object $editSellInvoice
         * @return object
         */
        private function dataProcessingForQuotationToSell(int $sellType, object $editSellInvoice) : object{

            $sellInvoice = $this->insertSellInvoiceDataFromQuotation($sellType, $editSellInvoice); 

            foreach($editSellInvoice->editSellCartProducts as $editSellProduct){
            $sellProductInstant = $this->insertSellProductDataFromQuotation($sellInvoice,$editSellProduct); 
                foreach($editSellProduct->editSellCartProductStocks as  $editSellProductStock){
                    $this->insertSellProductStockDataFromQuotation($sellType,$sellInvoice,$sellProductInstant,$editSellProductStock); 
                }
            }
            
            //general statement and payment process and customer calculation history
                //general statement- ledger 
                if(($this->quotationRequestFormData['invoice_total_paying_amount'] ?? 0) > 0)
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
                        'user_id' => $this->quotationRequestFormData['customer_id'],//client[customer,supplier,others staff]
                    ];
                    $this->paymentProcessingRequiredOfAllRequestOfModuleRelatedData = $moduleRelatedData;
                    $this->paymentProcessingRelatedOfAllRequestData = paymentDataProcessingWhenSellingSubmitFromPos_hh($this->quotationRequestFormData);// $paymentAllData;
                    $this->invoiceTotalPayingAmount = $this->quotationRequestFormData['invoice_total_paying_amount'] ?? 0 ;
                    $this->processingPayment();
                }
                //general statement- ledger 

                //customer transaction statement history
                $sellType = $this->quotationRequestFormData['sell_type'];
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
                $this->ctsCustomerId = $this->quotationRequestFormData['customer_id'];
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
                    $this->managingCustomerCalculation($this->quotationRequestFormData['customer_id'],$dbField = 33 ,$calType = 1,$sellInvoice->total_payable_amount);
                    //calculation in the customer table
                }//calculation in the customer table


                //$totalPaidAmount = ($this->quotationRequestFormData['cash_payment_value'] ?? 0) + ($this->quotationRequestFormData['advance_payment_value'] ?? 0) + ($this->quotationRequestFormData['banking_payment_value'] ?? 0);
                //calculation in the customer table
                if(($sellType == 1) && (($this->quotationRequestFormData['advance_payment_value'] ?? 0) > 0))//final sell
                {
                    //$sellAmount = $sellInvoice->total_payable_amount;
                    //$paidAmount = $sellInvoice->total_paid_amount;
                    //$dueAmount = $sellInvoice->due_amount;

                    //calculation in the customer table
                    //$dbField = 22;'current_paid_advance';
                    //$calType = 1='plus', 2='minus'
                    $this->managingCustomerCalculation($this->quotationRequestFormData['customer_id'],$dbField = 22 ,$calType = 1,$sellInvoice->total_payable_amount);
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
                    $this->managingCustomerCalculation($this->quotationRequestFormData['customer_id'],$dbField = 17 ,$calType = 1,$sellInvoice->due_amount);
                    //calculation in the customer table
                }//calculation in the customer table
            //general statement and payment process and customer calculation history                
            return $sellInvoice;
        }


        private function insertSellInvoiceDataFromQuotation(int $sellType, object $editSellInvoice){

            $sellInvoice = new SellInvoice();
            $sellInvoice->branch_id = authBranch_hh();
            $rand = rand(01,99);
            $makeInvoice = date("iHsymd").$rand;
            //$sellInvoice->invoice_no = $makeInvoice;
            $sellInvoice->sell_type = $sellType ;//$editSellInvoice->total_item;
            $sellInvoice->total_item = $editSellInvoice->total_sell_item;
            $sellInvoice->total_sell_item = $editSellInvoice->total_sell_item;
            $sellInvoice->sell_quantity = $editSellInvoice->total_quantity;
            $sellInvoice->total_quantity = $editSellInvoice->total_quantity;
            $sellInvoice->subtotal = $editSellInvoice->subtotal;
            $sellInvoice->total_selling_amount = $editSellInvoice->total_sold_amount;
            $sellInvoice->total_sold_amount = $editSellInvoice->total_sold_amount;
            $sellInvoice->discount_amount = $editSellInvoice->discount_amount;
            $sellInvoice->discount_type = $editSellInvoice->discount_type;
            $sellInvoice->total_discount = $editSellInvoice->total_discount;
            $sellInvoice->vat_amount = $editSellInvoice->vat_amount;
            $sellInvoice->total_vat = $editSellInvoice->total_vat;
            $sellInvoice->shipping_cost = $editSellInvoice->shipping_cost;
            $sellInvoice->others_cost = $editSellInvoice->others_cost;

            //total invoice amount == subtotal + shippping_cost + others_cost + vat +  
            $invoiceBillingAmountBeforeDiscount = $editSellInvoice->subtotal + $editSellInvoice->shippping_cost + $editSellInvoice->others_cost + $editSellInvoice->total_vat;
            $invoiceBillingAmountAfterDiscount = $invoiceBillingAmountBeforeDiscount - $editSellInvoice->total_discount;
            $totalInvoiceAmount = $invoiceBillingAmountBeforeDiscount;
            $totalPayableAmountBeforeRound = $invoiceBillingAmountAfterDiscount;
            
            //$totalInvoiceAmountWithRoundingWithoutDiscount = $editSellInvoice->subtotal + $editSellInvoice->shippping_cost + $editSellInvoice->others_cost + $editSellInvoice->total_vat;
            //$roundAmountForTotalInvoiceAmount =  (round($totalInvoiceAmount) - $totalInvoiceAmount);
            $totalPayableAmountAfterRound = round($totalPayableAmountBeforeRound);
            $roundAmount =  ($totalPayableAmountAfterRound - $totalPayableAmountBeforeRound);
            $sign = "";
            if($totalPayableAmountBeforeRound <= $totalPayableAmountAfterRound)
            {
                $sign = "+";
                $totalInvoicePayableAmount = $totalPayableAmountBeforeRound + $roundAmount;
            }
            else if($totalPayableAmountBeforeRound <= $totalPayableAmountAfterRound)
            {
                $sign = "-";
                $totalInvoicePayableAmount = $totalPayableAmountBeforeRound - $roundAmount;
            }else{
                $sign = "";
                $totalInvoicePayableAmount = $totalPayableAmountBeforeRound;
            }
            $sellInvoice->round_type = $sign;
            $sellInvoice->round_amount = $roundAmount;

            //total invoice amount with or without rounding amount
            $sellInvoice->total_invoice_amount = $totalInvoiceAmount;
            $sellInvoice->total_discount_amount = $editSellInvoice->total_discount;
            $sellInvoice->sold_type = 2; //1 = direct sold, 2 = sold from quotation, 3 = quotation - this quotation is sold, 4 = quotation
            $sellInvoice->reference_invoice_no = $editSellInvoice->sell_invoice_no;
            //new option created 19-02-2023
        
            //$lineAfterOtherCostShippingCostDiscountAndVatWithInvoiceSubTotal   = number_format((($this->requestAllCartData['subtotalFromSellCartList'] - $this->requestAllCartData['totalInvoiceDiscountAmount']) +  $this->requestAllCartData['totalVatAmountCalculation'] + $this->requestAllCartData['totalShippingCost'] + $this->requestAllCartData['invoiceOtherCostAmount']),2,'.', '');
            //$lineInvoicePayableAmountWithRounding = number_format(round($lineAfterOtherCostShippingCostDiscountAndVatWithInvoiceSubTotal),2,'.', '');
            $totalPayableAmount = $totalInvoicePayableAmount; //with rounding + shipping cost, others cost, vat - discount 
            $sellInvoice->total_payable_amount = $totalPayableAmount; //with rounding + shipping cost, others cost, vat - discount 
            
            $sellInvoice->sell_type = 1;
            
            //payment related section
            $totalPaidAmount = ($this->quotationRequestFormData['cash_payment_value'] ?? 0) + ($this->quotationRequestFormData['advance_payment_value'] ?? 0) + ($this->quotationRequestFormData['banking_payment_value'] ?? 0);
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
    
            //$customerId = $editSellInvoice['invoice_customer_id'];
            $customerId = $this->quotationRequestFormData['customer_id'];
            /* if(count($shippingCart) > 0)
            {
                $sellInvoice->customer_id = $shippingCart['customer_id'];
                $customerId = $shippingCart['customer_id'];
                $sellInvoice->reference_id = $this->quotationRequestFormData['reference_id'];
                $sellInvoice->shipping_id = $shippingCart['customer_shipping_address_id'];
                $sellInvoice->shipping_note = $shippingCart['shipping_note'];
                $sellInvoice->sell_note = $shippingCart['sell_note'];
                $sellInvoice->receiver_details = $shippingCart['receiver_details'];
            }else{
                $sellInvoice->customer_id = $this->quotationRequestFormData['customer_id'];
                $sellInvoice->reference_id = $this->quotationRequestFormData['reference_id'];
            } */
            $sellInvoice->customer_id = $this->quotationRequestFormData['customer_id'];
            $sellInvoice->reference_id = $this->quotationRequestFormData['reference_id'];
            
            $customer = Customer::select('customer_type_id','phone')->where('id',$customerId)->first();
            if($customer)
            {
                $sellInvoice->customer_type_id = $customer->customer_type_id;  
                $sellInvoice->customer_phone = $customer->phone;  
            }else{
                $sellInvoice->customer_type_id = 2;  //temporary
            }
            if( $this->quotationRequestFormData['sell_type'] == 1) 
            {
                $sellInvoice->sell_date = date('Y-m-d h:i:s');
            }
            $sellInvoice->status = 1;
            $sellInvoice->delivery_status = 1;
            $sellInvoice->created_by = authId_hh();
    
            $sellInvoice->save();
            $sellInvoice->invoice_no = sprintf("%'.08d", $sellInvoice->id);
            $sellInvoice->save();
            return $sellInvoice;
        }

        /**
         * insert sell product data from quotation function
         *
         * @param object $sellInvoice
         * @param object $editSellProduct
         * @return object
         */
        private function insertSellProductDataFromQuotation(object $sellInvoice, object $editSellProduct):object{
            
            $productProduct = new SellProduct();
            $productProduct->branch_id = authBranch_hh();
            $productProduct->sell_invoice_id = $sellInvoice->id;
            $productProduct->product_id = $editSellProduct->product_id;
            $productProduct->unit_id = $editSellProduct->unit_id;
            $productProduct->supplier_id = $editSellProduct->supplier_id;
            $productProduct->main_product_stock_id = $editSellProduct->main_product_stock_id;
            $productProduct->product_stock_type = $editSellProduct->product_stock_type;
            $productProduct->custom_code = $editSellProduct->custom_code;

            $productProduct->total_sell_qty = $editSellProduct->total_quantity;
            $productProduct->total_quantity = $editSellProduct->total_quantity;

            $productProduct->sold_price = $editSellProduct->sold_price;
            $productProduct->discount_amount = $editSellProduct->discount_amount;
            $productProduct->discount_type = $editSellProduct->discount_type;
            $productProduct->total_discount = $editSellProduct->total_discount;
            $productProduct->reference_commission = 0;

            $productProduct->total_selling_amount = $editSellProduct->total_sold_amount;
            $productProduct->total_sold_amount = $editSellProduct->total_sold_amount;
            $productProduct->total_selling_purchase_amount = $editSellProduct->total_purchase_amount;
            $productProduct->total_purchase_amount = $editSellProduct->total_purchase_amount;

            $productProduct->total_selling_profit = $editSellProduct->total_profit;
            $productProduct->total_profit_from_product = $editSellProduct->total_profit;
            
            $productProduct->total_profit = $editSellProduct->total_profit;
            
            //$this->totalPurchasePriceOfAllQuantityOfThisInvoice += $editSellProduct->totalPurchasePriceOfAllQuantityOfThisInvoice;

            $productProduct->liability_type = $editSellProduct->liability_type;
            $productProduct->identity_number = $editSellProduct->identity_number;

            //new setup            
            $product = Product::select('name','id','custom_code','warehouse_id','warehouse_rack_id')->findOrFail($editSellProduct->product_id);
            $unit = Unit::select('id','short_name')->findOrFail($editSellProduct->unit_id);
            $productProduct->cart = json_encode([
                'productName' => $product->name,
                "productId" => $product->id,
                'mrpPrice' => $product->name,
                'soldPrice' => $editSellProduct->sold_price,
                'totalSellQuantity' => $editSellProduct->total_quantity,
                'totalMainProductStockQuantity' => $editSellProduct->total_quantity,
                'totalOtherProductStockQuantity' => $editSellProduct->total_quantity,
                'unitName' => $unit->name,
                'unitId' =>$unit->id,
                'customCode' => $product->custom_code,
                'warehouseId' =>$product->warehouse_id,
                'warehouseRackId' => $product->warehouse_rack_id,
            ]);

            $productProduct->status =1;
            $productProduct->delivery_status =1;
            $productProduct->created_by = authId_hh();
            $productProduct->save();
            return $productProduct;
        }

        /**
         * insert sell product stock data from quotation function
         *
         * @param integer $sellType
         * @param [type] $sellInvoice
         * @param object $sellProduct
         * @param object $editSellProductStock
         * @return object
         */
        private function insertSellProductStockDataFromQuotation(int $sellType,$sellInvoice, object $sellProduct,object $editSellProductStock) :object{
            
            $productStock = new SellProductStock();
            $productStock->branch_id = authBranch_hh();
            $productStock->sell_invoice_id = $sellInvoice->id;
            $productStock->sell_product_id = $sellProduct->id;
            $productStock->product_stock_id = $editSellProductStock->product_stock_id;

            $productStock->product_id = $editSellProductStock->product_id;
            $qty = $editSellProductStock->total_quantity;
            $productStock->total_sell_qty = $qty;
            $productStock->total_quantity = $qty;

            $totalPurchasePrice = $editSellProductStock->purchase_price * $qty ;//$cart['purchase_price'] * $qty;
            $totalSoldPrice = $editSellProductStock->final_sell_price * $qty;
            $productStock->mrp_price = $editSellProductStock->mrp_price;
            $productStock->regular_sell_price = $editSellProductStock->regular_sell_price;
            $productStock->sold_price = $editSellProductStock->sold_price;

            $productStock->total_selling_amount = $totalSoldPrice;//$cart['selling_final_amount'];
            $productStock->total_sold_amount = $totalSoldPrice;//$cart['selling_final_amount'];
            $productStock->purchase_price = $editSellProductStock->purchase_price;//$cart['purchase_price'];
            $productStock->total_purchase_amount = $totalPurchasePrice;//$cart['total_purchase_price_of_all_quantity'];
            $productStock->total_selling_purchase_amount = $totalPurchasePrice;//$cart['total_purchase_price_of_all_quantity'];
            
            $productStock->total_selling_profit = $totalSoldPrice - $totalPurchasePrice;
            $productStock->total_profit_from_product = $totalSoldPrice - $totalPurchasePrice;
            $productStock->total_profit = $totalSoldPrice - $totalPurchasePrice;

            $process_duration = 2;
            $pStock = productStockByProductStockId_hh($editSellProductStock->product_stock_id);
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

            
            //if sell_type==1, then reduce stock from product stocks table 
            if($sellType  == 1 && $instantlyProcessedQty > 0){
                $this->stock_id_FSCT = $stockId;
                $this->product_id_FSCT = $editSellProductStock->product_id;
                $this->stock_quantity_FSCT = $instantlyProcessedQty;
                $this->unit_id_FSCT = $sellProduct->unit_id;
                $this->stock_changing_history_process_FSCT = 2;//later
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
                'product_id' => $sellProduct->id,
                'product_stock_id' => $editSellProductStock->product_stock_id,
                'total_sell_qty' => $qty,
                "total_quantity" => $qty,
                'mrp_price' =>$editSellProductStock->mrp_price , //$cart['mrp_price'] ,
                'regular_sell_price' =>$editSellProductStock->regular_sell_price , // $cart['sell_price'],
                'sold_price' =>$editSellProductStock->sold_price , // $cart['final_sell_price'],
                'total_selling_amount' => $totalSoldPrice,
                'total_sold_amount' => $totalSoldPrice,
                'purchase_price' =>$editSellProductStock->purchase_price , // $purchase_price , //$cart['purchase_price'],         
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
    /*
    |-----------------------------------------------------------------------------------
    | this part is only for sell from quotation
    | Its a same process when sell create 
    |------------------------------------------------------------------------------------
    */
    /*############################### sell from quotation ############################*/
    



    /*
    |-----------------------------------------------------------------------------------
    | this part is only for reduceing stock from all kinds of sells
    | and increment stock to the particular stocks    
    |------------------------------------------------------------------------------------
    */
        /*
        |--------------------------------------------------------------------------------------------------------
        | this section is managing for reducing stock when return/refund qty
        | note that:- refunding time -> we make a vartual field name totalReduceableQty
        | It's make by two column:-  totalReduceableQty = (reduceable_delivered_qty + reduced_base_stock_remaining_delivery)
        |--------------------------------------------------------------------------------------------------------
        */
            /* //total reduceable delivered qty
            $totalReducableDeliveredQty = $sellProductStockDetails->reduceable_delivered_qty; //2

            //total reduced base stock qty remaining delivery :- Its related product_stocks table
            $totalReducedBaseStockQtyRemaininingDelvierd = $sellProductStockDetails->reduced_base_stock_remaining_delivery;
            
            //total reduceable delivered qty = total reduceable delivered qty + total reduced base stock qty remaining delivery
            $totalReducealbeDeliveredQty = $totalReducableDeliveredQty + $totalReducedBaseStockQtyRemaininingDelvierd;
            
            $baseStockIncrementQuantity = 0; //base stock increment qty, which qty increment with main stock - in product_stocks table
            $reducedBaseStockDecrementQuantity = 0; //reduced base stock decrement qty, which qty is decrement/minus from - reduced_base_stock_remaining_delivery in the sell_product_stocks table
            $reduceableDeliveredDecrementQuantity = 0; //reduceable delivered decrement qty, which qty is decrement/minus from -  reduceable_delivered_qty in the sell_product_stocks table

            //if return qty == total reduceable delivered qty and total reduceable delivered qty > 0
            if($totalReducealbeDeliveredQty == $returningQty && $totalReducealbeDeliveredQty > 0){
                $baseStockIncrementQuantity = $returningQty; //base stock increment value is same.

                $reducedBaseStockDecrementQuantity = 0; //zero
                $reduceableDeliveredDecrementQuantity = 0; //zero
            }
            //if total reduceable delivered qty is more then returning qty and total reduceable delivered qty > 0
            else if($totalReducealbeDeliveredQty > $returningQty && $totalReducealbeDeliveredQty > 0){

                $baseStockIncrementQuantity = $returningQty;//base stock increment value is same.
                
                if($totalReducedBaseStockQtyRemaininingDelvierd == $returningQty){
                    $reducedBaseStockDecrementQuantity = 0;
                    $reduceableDeliveredDecrementQuantity = $totalReducableDeliveredQty ;
                }
                else if($totalReducedBaseStockQtyRemaininingDelvierd > $returningQty){
                    $reducedBaseStockDecrementQuantity = $totalReducedBaseStockQtyRemaininingDelvierd - $returningQty;
                    $reduceableDeliveredDecrementQuantity = $totalReducableDeliveredQty ;
                }
                else if($totalReducedBaseStockQtyRemaininingDelvierd < $returningQty){
                    $moreQtyOfReducedBaseStockFromReturningQty = $returningQty - $totalReducedBaseStockQtyRemaininingDelvierd;
                    $reducedBaseStockDecrementQuantity = 0;
                    if($moreQtyOfReducedBaseStockFromReturningQty > 0){
                        $reduceableDeliveredDecrementQuantity = $totalReducableDeliveredQty - $moreQtyOfReducedBaseStockFromReturningQty;
                    }else{
                        $reduceableDeliveredDecrementQuantity = 0;
                    }
                }
            }
            else if($totalReducealbeDeliveredQty < $returningQty && $totalReducealbeDeliveredQty > 0){
                $baseStockIncrementQuantity = $totalReducealbeDeliveredQty;

                $reducedBaseStockDecrementQuantity = 0;
                $reduceableDeliveredDecrementQuantity = 0;
            }
            else if($totalReducealbeDeliveredQty == 0){
                $baseStockIncrementQuantity = 0;
            }
            //$reducedBaseStockDecrementQuantity , $reduceableDeliveredDecrementQuantity
            $sellProductStockDetails->reduced_base_stock_remaining_delivery = $reducedBaseStockDecrementQuantity;
            $sellProductStockDetails->reduceable_delivered_qty = $reduceableDeliveredDecrementQuantity;
            $sellProductStockDetails->save(); */

        /*
        |--------------------------------------------------------------------------------------------------------
        | this section is managing for reducing stock when return/refund qty
        | note that:- refunding time -> we make a vartual field name totalReduceableQty
        | It's make by two column:-  totalReduceableQty = (reduceable_delivered_qty + reduced_base_stock_remaining_delivery)
        |--------------------------------------------------------------------------------------------------------
        */
        /* $productStock = productStockByProductStockId_hh($sellProductStockDetails->product_stock_id);
        if($productStock &&  $baseStockIncrementQuantity){
            $productStock->reduced_base_stock_remaining_delivery = $reducedBaseStockDecrementQuantity;
            $productStock->save();
        }
    
        //increment stock quantity to the particular's stock  from product stock
        if($invoiceData->sell_type == 1 && $returningQty > 0  && $baseStockIncrementQuantity > 0){
            $this->stock_id_FSCT = $sellProductStockDetails->stock_id;
            $this->product_id_FSCT = $sellProductStockDetails->product_id;
            $this->stock_quantity_FSCT = $baseStockIncrementQuantity;
            $this->unit_id_FSCT = $sellProduct ? $sellProduct->unit_id:0;
            $this->sellingReturnStockTypeIncrement();
        } */
        //increment stock quantity to the particular's stock  from product stock
    /*
    |-----------------------------------------------------------------------------------
    | this part is only for reduceing stock from all kinds of sells
    | and increment stock to the particular stocks    
    |------------------------------------------------------------------------------------
    */



}   