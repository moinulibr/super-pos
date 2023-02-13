<?php
namespace App\Traits\Backend\Sell\Edit;

use Illuminate\Support\Facades\Auth;
use App\Models\Backend\Sell\SellInvoice;

use App\Models\Backend\Sell\SellPackage;
use App\Models\Backend\Sell\SellProduct;
use App\Models\Backend\Customer\Customer;
use App\Models\Backend\Sell\SellQuotation;
use App\Models\Backend\Sell\SellProductStock;
use App\Traits\Backend\Payment\PaymentProcessTrait;
use App\Models\Backend\CartSell\EditSellCartInvoice;
use App\Models\Backend\CartSell\EditSellCartProduct;
use App\Traits\Backend\Stock\Logical\StockChangingTrait;
use App\Models\Backend\CartSell\EditSellCartProductStock;
use App\Traits\Backend\Payment\CustomerPaymentProcessTrait;
use App\Traits\Backend\Sell\Logical\UpdateSellSummaryCalculationTrait;
use App\Traits\Backend\Customer\Logical\ManagingCalculationOfCustomerSummaryTrait;
/**
 * pricing trait
 * 
 */
trait SellUpdateDataFromSellEditCartTrait
{
    use UpdateSellSummaryCalculationTrait;

    use StockChangingTrait, PaymentProcessTrait;
    use CustomerPaymentProcessTrait, ManagingCalculationOfCustomerSummaryTrait;

    protected $sellCreateFormData;

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

    //******************make sure that, when product delete, or qty change, then stock will be change, plus or minus)
    
    /**
     * update sell related data for edit function
     *
     * @param integer $sellType
     * @param string $invoiceNo
     * @return boolean
     */
    protected function updateSellRelatedDataFromSellEditCart(int $sellType, string $invoiceNo):bool{

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

        $editSellCartProducts = EditSellCartProduct::with('editSellCartProductAllStocks')->where('branch_id',authBranch_hh())->where('sell_invoice_no',$invoiceNo)->get();//->where('status',1)
        
        foreach($editSellCartProducts as $editSellProduct){
            //only not deleted sell product data
            $existingSellProduct = SellProduct::where('product_id',$editSellProduct->product_id)->where('branch_id',authBranch_hh())->where('sell_invoice_id',$editSellProduct->sell_invoice_id)->whereNull('deleted_at')->first();//->where('main_product_stock_id',$editSellProduct->main_product_stock_id)
            //if this product is exist, then execute 
            if($existingSellProduct){
                //if edit sell product is active
                if($editSellProduct->status == 1){

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