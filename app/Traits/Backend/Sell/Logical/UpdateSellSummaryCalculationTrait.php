<?php
namespace App\Traits\Backend\Sell\Logical;

use App\Models\Backend\Sell\SellInvoice;
use App\Models\Backend\Sell\SellProduct;
use App\Models\Backend\Sell\SellProductStock;

/**
 * Update Sell Related all calculate field/data in this trait
 * mainly sell return is perfectly...
 */
trait UpdateSellSummaryCalculationTrait
{

    /**
     * managingSellCalcuation function, from this function
     * we can update dynamically field with calculation-
     * if needed calculation, then calable == true, or false- 
     * if calable == false, then dbField, calType, amountOrQty, is optional-  
     * moduleTypeId => SellInvoice = 1, SellProduct = 2, SellProductStock=3 - 
     * mainly sell return is perfect-
     * 
     * @param integer $moduleTypeId
     * @param integer $primaryId
     * @param string $dbField
     * @param integer $calType
     * @param boolean $calable
     * @param integer $amountOrQty
     * @return boolean
     */
    protected function managingSellCalculationAfterRefunding(int $moduleTypeId,int $primaryId,bool $calable = false,string $dbField = NULL,int $calType = 1,int $amountOrQty = 0) : bool {
        //follow the all sequence
        $databaseField = $dbField; // $this->getDBFieldByInteger($dbField);

        if($calable && $dbField){

            $this->calculationAndUpdateSellDynamicField($moduleTypeId,$primaryId,$databaseField,$calType,$amountOrQty);
        }
        
        //follow this sequence
        $this->sellModuleWiseUpdateDbField($moduleTypeId,$primaryId);
        return true;
    }


    /**
     * Sell related all moudle wise update database field function
     * (like.SellInvoice,SellProduct,SellProductStock)
     *
     * @param integer $moduleTypeId
     * @param integer $primaryId
     * @return boolean
     */
    protected function sellModuleWiseUpdateDbField(int $moduleTypeId, int $primaryId) : bool {
        //follow this sequence
        //$moduleTypeId == 3 - SellProductStock
        if($moduleTypeId == 3){
            //3 sell product stock
            $this->updateSellProductStockCalculation($primaryId);
        } 
        //$moduleTypeId == 2 - SellProduct
        else if($moduleTypeId == 2){
            //2 sell product
            $this->updateSellProductCalculation($primaryId);
        }
        //$moduleTypeId == 1 - SellInvoice
        else if($moduleTypeId == 1){
            //1 sell invoice
            $this->updateSellInvoiceCalculation($primaryId);
        }
        return true;
    }


    

    /**
     * calculationAndUpdateSellDynamicField function
     * update only targeted field after calculation
     * 
     * @param integer $module
     * @param integer $primaryId
     * @param string $dbField
     * @param integer $calType
     * @param integer $amountOrQty
     * @return boolean
     */
    private function calculationAndUpdateSellDynamicField(int $module,int $primaryId,string $dbField,int $calType,int $amountOrQty) : bool {   
        //module 1=SellInvoice, 2=SellProduct, 3=SellProductStock
        //1='plus', 2='minus'
        $existingData = $this->getModuleObject($module,$dbField,$primaryId);//return $existingData = $this->getModuleObject(1,'total_quantity',1);

        $amountAfterCalculation = 0;
        if($calType == 1)
        {
            $amountAfterCalculation = $existingData->{$dbField} + $amountOrQty;
        }else{
            /* if($existingData->{$dbField} != 0){
                $amount = $existingData->{$dbField} - $amountOrQty;
            }else{
                $amount = $amountOrQty;
            } */
            $amountAfterCalculation = $existingData->{$dbField} - $amountOrQty;
            //$amountAfterCalculation = $amount;
        }
        $existingData->{$dbField} = $amountAfterCalculation;
        $existingData->save();
        return true;
    }

    /**
     * getModuleObject function
     * get dynamically one selected object amoung three model or table
     * 
     * @param integer $module
     * @param string $dbField
     * @param integer $primaryId
     * @return object
     */
    private function getModuleObject(int $module,string $dbField,int $primaryId) : object {
        //module 1=SellInvoice, 2=SellProduct, 3=SellProductStock
        if($module == 1){
            $existingData = SellInvoice::select('id',"$dbField")->where('id',$primaryId)->first();
        }
        else if($module == 2){
            $existingData = SellProduct::select('id',"$dbField")->where('id',$primaryId)->first();
        }
        else if($module == 3){
           $existingData = SellProductStock::select('id',"$dbField")->where('id',$primaryId)->first();
        }
        return  $existingData;
    }


 
    //sell invoice table
    private function updateSellInvoiceCalculation($primaryId) : bool {
        
        $existingData = SellInvoice::select('id','sell_quantity','total_selling_amount','total_refunded_amount','refundable_amount','total_sold_amount','total_selling_purchase_amount','total_refunding_purchase_amount',
        'total_selling_profit','total_refunded_reduced_profit','total_profit_from_product','total_profit','total_purchase_amount','total_quantity','total_refunded_qty',
        'subtotal','total_discount','total_vat','shipping_cost','others_cost','round_amount','total_payable_amount',
        'paid_amount','due_amount','adjustment_amount','refund_charge','reference_amount','total_paid_amount','total_due_amount','total_sell_item','total_refunded_item','total_item','payment_status','payment_type'
        )->where('id',$primaryId)->first();

        // $existingData->sellProducts->sum('total_quantity'); 

        //total sell and refunded quantity
        $totalSellQuantity = $existingData->sellProducts->sum('total_sell_qty');
        $existingData->sell_quantity =  $totalSellQuantity;

        $totalRefundedQuantity = $existingData->sellProducts->sum('total_refunded_qty');


        //total selling amount
        $totalSellingAmount =  $existingData->sellProducts->sum('total_selling_amount');
        //$existingData->subtotal =  $totalSellingAmount; //total_selling_amount
        $existingData->total_selling_amount =  $totalSellingAmount; //total_selling_amount

        //calculate and store - total refunded amount 
        $totalRefundedAmount = $existingData->sellProducts->sum('total_refunded_amount');
        $existingData->total_refunded_amount = $totalRefundedAmount;
        $existingData->refundable_amount = $totalRefundedAmount;

        //total sold amount
        $totalSoldAmount = $existingData->sellProducts->sum('total_sold_amount');
        $existingData->subtotal = $totalSoldAmount; 
        $existingData->total_sold_amount = $totalSoldAmount; 

        //total sold amount
        $totalSellingPurchaseAmount = $existingData->sellProducts->sum('total_selling_purchase_amount');
        $totalRefundingPurchaseAmount = $existingData->sellProducts->sum('total_refunding_purchase_amount');

        $existingData->total_selling_purchase_amount = $totalSellingPurchaseAmount;
        $existingData->total_refunding_purchase_amount = $totalRefundingPurchaseAmount;
        $existingData->total_purchase_amount = $existingData->sellProducts->sum('total_purchase_amount');

        //totoal quantity
        $totalQuantity = $existingData->sellProducts->sum('total_quantity');
        $existingData->total_quantity = $totalQuantity;
        $existingData->total_refunded_qty = $totalRefundedQuantity;

        //profit calculation and store
        $totalSellingProfit = $existingData->sellProducts->sum('total_selling_profit');
        $totalRefundedReducedProfit = $totalRefundedAmount - $totalRefundingPurchaseAmount;
        $existingData->total_selling_profit = $totalSellingProfit;
        $existingData->total_refunded_reduced_profit = $totalRefundedReducedProfit;
        $existingData->total_profit_from_product = $totalSellingProfit - $totalRefundedReducedProfit;
        //$existingData->total_profit = ($totalSellingProfit - $totalRefundedReducedProfit) - (0);//-(0)==others
        

        $totalSoldAmountAmountAfterRefunded = $totalSoldAmount - $totalRefundedAmount;
        //total_discount ,total_vat, shipping_cost,others_cost,round_amount//total_payable_amount,paid_amount,due_amount,adjustment_amount//refund_charge,reference_amount,total_paid_amount,total_due_amount, total_sell_item ,total_refunded_item ,total_item   
        //total payable amount calculation
        $invoicePlusableCharge = $existingData->total_vat + $existingData->shipping_cost + $existingData->others_cost + $existingData->refund_charge;
        $invoiceMinusableCost = $existingData->total_discount + $existingData->reference_amount;
        if($existingData->round_type ==	'+'){
            $invoicePlusableCharge = $invoicePlusableCharge + $existingData->round_amount;
        }else{
            $invoiceMinusableCost = $invoiceMinusableCost + $existingData->round_amount;
        }

        //$existingData->adjustment_amount
        $totalPayableAmount = (($totalSoldAmountAmountAfterRefunded + $invoicePlusableCharge) - ($invoiceMinusableCost));
        $existingData->total_payable_amount = $totalPayableAmount ;
        //total payable amount calculation


        $totalPaidAmount = $existingData->total_paid_amount;
        //$totalDueAmount = $existingData->total_due_amount;
        $overPaidAmount = 0;
        $newPaidAmount = 0;
        $nowNewDueAmount = 0; 
        if($totalPayableAmount < $totalPaidAmount){
            $overPaidAmount = $totalPaidAmount - $totalPayableAmount;
            $newPaidAmount = $totalPayableAmount; 
            $nowNewDueAmount = 0; 
        }
        else if($totalPayableAmount > $totalPaidAmount){
            $overPaidAmount = 0;
            $newPaidAmount = $totalPaidAmount; 
            $nowNewDueAmount = $totalPayableAmount - $totalPaidAmount; 
        } 
        else if($totalPayableAmount == $totalPaidAmount){
            $overPaidAmount = 0;
            $newPaidAmount =  $totalPaidAmount; 
            $nowNewDueAmount = 0; 
        }
        $existingData->total_paid_amount = $newPaidAmount;
        $existingData->total_due_amount = $nowNewDueAmount;
        //total due and paid section


    
        //total profit calculation
        $invoicePlusableChargeForInvoiceProfit = $existingData->refund_charge;
        $invoiceMinusableCostForInvoiceProfit  = $existingData->total_discount + $existingData->reference_amount + $existingData->adjustment_amount;
        if($existingData->round_type ==	'+'){
            $invoicePlusableChargeForInvoiceProfit = $invoicePlusableChargeForInvoiceProfit + $existingData->round_amount;
        }else{
            $invoiceMinusableCostForInvoiceProfit = $invoiceMinusableCostForInvoiceProfit + $existingData->round_amount;
        }

        $existingData->total_profit = number_format((($existingData->total_profit_from_product + $invoicePlusableChargeForInvoiceProfit) - ($invoiceMinusableCostForInvoiceProfit)),2,'.','');
        //total profit calculation
        

        //payment status and payment type
        $paymentStatus = "";
        $payment_type = "";
        if($totalPayableAmount == $newPaidAmount)
        {
            $paymentStatus = "Paid";
            $payment_type = "Full Payment";
        }
        else if($totalPayableAmount > $newPaidAmount &&  $newPaidAmount > 0){
            $paymentStatus = "Parital Payment";
            $payment_type = "Partial Payment";
        }
        else if($totalPayableAmount > $newPaidAmount &&  $newPaidAmount == 0){
            $paymentStatus = "Not Paid";
            $payment_type = "Not Paid";
        }
        $existingData->payment_status = $paymentStatus;
        $existingData->payment_type	 = $payment_type;
        //payment status and payment type

        $existingData->save();
        return true;
    }

    
    /**
     * sell product table function where from update 
     * all calculateable field by SellProduct primary id
     * 
     * @param integer $primaryId
     * @return boolean
     */
    private function updateSellProductCalculation(int $primaryId) : bool {

        $existingData = SellProduct::select('id','total_sell_qty','sold_price','total_selling_amount','total_refunded_amount','total_sold_amount','total_selling_purchase_amount','total_refunding_purchase_amount',
        'total_selling_profit','total_refunded_reduced_profit','total_profit_from_product','total_profit','total_purchase_amount','total_quantity','total_refunded_qty'
        )->where('id',$primaryId)->first(); //maybe have to delete this field- total_refunded_received_qty


        //total sell and refunded quantity
        $totalSellQuantity = $existingData->sellProductStocks->sum('total_sell_qty');
        $existingData->total_sell_qty =  $totalSellQuantity;

        $totalRefundedQuantity = $existingData->sellProductStocks->sum('total_refunded_qty');

        //total selling amount
        $totalSellingAmount =  $existingData->sellProductStocks->sum('total_selling_amount');
        $existingData->total_selling_amount =  $totalSellingAmount;

        //calculate and store - total refunded amount 
        $totalRefundedAmount = $existingData->sellProductStocks->sum('total_refunded_amount');
        $existingData->total_refunded_amount = $totalRefundedAmount;

        //total sold amount 
        $totalSoldAmount = $existingData->sellProductStocks->sum('total_sold_amount');
        $existingData->total_sold_amount = $totalSoldAmount; 

        //total sold amount
        $totalSellingPurchaseAmount = $existingData->sellProductStocks->sum('total_selling_purchase_amount');
        $totalRefundingPurchaseAmount = $existingData->sellProductStocks->sum('total_refunding_purchase_amount');

        $existingData->total_selling_purchase_amount = $totalSellingPurchaseAmount;
        $existingData->total_refunding_purchase_amount = $totalRefundingPurchaseAmount;
        $existingData->total_purchase_amount = $existingData->sellProductStocks->sum('total_purchase_amount');

        //totoal quantity
        $totalQuantity = $existingData->sellProductStocks->sum('total_quantity');
        $existingData->total_quantity = $totalQuantity;
        $existingData->total_refunded_qty = $totalRefundedQuantity;

        //profit calculation and store
        $totalSellingProfit = $existingData->sellProductStocks->sum('total_selling_profit');
        $totalRefundedReducedProfit = $totalRefundedAmount - $totalRefundingPurchaseAmount;
        $existingData->total_selling_profit = $totalSellingProfit;
        $existingData->total_refunded_reduced_profit = $totalRefundedReducedProfit;
        $existingData->total_profit_from_product = $totalSellingProfit - $totalRefundedReducedProfit;
        $existingData->total_profit = ($totalSellingProfit - $totalRefundedReducedProfit) - (0);//-(0)==others
        
        $existingData->delivered_qty = $existingData->sellProductStocks->sum('total_delivered_qty');

        $existingData->save();
        return true;
    }


    /**
     * update sell product stock calculation function
     * where from calculate all qty, amount, profit, and others
     * @param integer $primaryId
     * @return boolean
     */
    private function updateSellProductStockCalculation(int $primaryId) : bool {

        $existingData = SellProductStock::select('id','total_sell_qty','sold_price','purchase_price','total_selling_amount','total_refunded_amount','total_sold_amount','total_selling_purchase_amount','total_refunding_purchase_amount',
            'total_selling_profit','refunded_reduced_profit','total_profit_from_product','total_profit','remaining_delivery_qty','total_delivered_qty','total_purchase_amount','total_quantity','total_refunded_qty'
            )->where('id',$primaryId)->first(); //maybe have to delete this field- total_refunded_received_qty

        //total sell and refunded quantity
        $totalSellQuantity = $existingData->total_sell_qty;
        $totalRefundedQuantity = $existingData->total_refunded_qty;

        //total selling amount
        $totalSellingAmount =  $existingData->sold_price * $totalSellQuantity;
        $existingData->total_selling_amount =  $totalSellingAmount;

        //calculate and store - total refunded amount 
        $totalRefundedAmount =  $existingData->sold_price * $totalRefundedQuantity;
        $existingData->total_refunded_amount = $totalRefundedAmount;//total refunded amount

        //total sold amount
        $totalSoldAmount =  $totalSellingAmount - $totalRefundedAmount;
        $existingData->total_sold_amount = $totalSoldAmount;

        //total sold amount
        $totalSellingPurchaseAmount =  $existingData->purchase_price * $totalSellQuantity;
        $totalRefundingPurchaseAmount =  $existingData->purchase_price * $totalRefundedQuantity;

        $existingData->total_selling_purchase_amount = $totalSellingPurchaseAmount;
        $existingData->total_refunding_purchase_amount = $totalRefundingPurchaseAmount;
        $existingData->total_purchase_amount = $totalSellingPurchaseAmount - $totalRefundingPurchaseAmount;

        //totoal quantity
        $totalQuantity = $totalSellQuantity  - $totalRefundedQuantity ;
        $existingData->total_quantity = $totalQuantity;
        $existingData->total_refunded_qty = $totalRefundedQuantity;

        //profit calculation and store
        $totalSellingProfit = $totalSellingAmount - $totalSellingPurchaseAmount;
        $totalRefundedReducedProfit = $totalRefundedAmount - $totalRefundingPurchaseAmount;
        $existingData->total_selling_profit = $totalSellingProfit;
        $existingData->refunded_reduced_profit = $totalRefundedReducedProfit;
        $existingData->total_profit_from_product = $totalSellingProfit - $totalRefundedReducedProfit;
        $existingData->total_profit = ($totalSellingProfit - $totalRefundedReducedProfit) - (0);//-(0)==others

        
        $totalPreviousDeliveryedQty = $existingData->total_delivered_qty;
        $newlyTotalDeliveredQty = 0;
        if($totalQuantity > $totalPreviousDeliveryedQty){
            $newlyTotalDeliveredQty = $totalPreviousDeliveryedQty;
        }
        else if($totalQuantity < $totalPreviousDeliveryedQty){
            $newlyTotalDeliveredQty = $totalQuantity;
        }
        else if($totalQuantity == $totalPreviousDeliveryedQty){
            $newlyTotalDeliveredQty = $totalPreviousDeliveryedQty;
        }
        
        $existingData->total_delivered_qty = $newlyTotalDeliveredQty;
        $existingData->remaining_delivery_qty = $totalQuantity - $newlyTotalDeliveredQty;

        //when total delivered qty is equal to total quantity, then this data will be null
        if($existingData->total_delivered_qty == $newlyTotalDeliveredQty){
            $existingData->remaining_delivery_unreduced_qty_date = NULL;
        }//have to process :- remaining_delivery_unreduced_qty
        
        $existingData->save();
        return true;
    }


    
    /**
     * getDBFieldByInteger function
     * get db field by integer number
     * which integer is stored in the sellRelatedAllCalculateableDatabaseFiled array
     * 
     * @param integer $key
     * @return string
     */
    private function getDBFieldByInteger(int $key) : string {
        $arrayLabel = "";
        if(array_key_exists($key,$this->sellRelatedAllCalculateableDatabaseFiled()))
        {
            $arrayLabel = $this->sellRelatedAllCalculateableDatabaseFiled()[$key];
        }
        return $arrayLabel;
    }
    

    //it's not implemented yet now.. 11-01-2023
   //database all calculationable field
   private function sellRelatedAllCalculateableDatabaseFiled()
   {
       return [
           //sellinvoice fileds
            1 => 'sell_quantity' , 
            2 => 'total_selling_amount' , 
            3 => 'total_refunded_amount' , 
            4 => 'refundable_amount' , 
            5 => 'total_sold_amount' , 
            6 => 'total_selling_purchase_amount' , 
            7 => 'total_refunding_purchase_amount' , 
            8 => 'total_selling_profit' , 
            9 => 'total_refunded_reduced_profit' ,
           10 => 'total_profit_from_product' ,
           11 => 'total_profit' ,
           12 => 'total_purchase_amount' ,
           13 => 'total_quantity' ,
           14 => 'total_refunded_qty' ,
           15 => 'subtotal' ,
           16 => 'total_discount' ,
           17 => 'total_vat' ,
           18 => 'shipping_cost' ,
           19 => 'others_cost' ,
           20 => 'round_amount' ,
           21 => 'total_payable_amount' ,
           22 => 'paid_amount',
           23 => 'due_amount',
           24 => 'adjustment_amount' ,
           25 => 'refund_charge' ,
           26 => 'reference_amount' ,
           27 => 'total_paid_amount' ,

           //sellproduct fileds
           28 => 'quantity' ,
           29 => 'sold_price' ,
           30 => 'total_selling_amount' ,
           31 => 'total_refunded_amount' ,
           32 => 'total_sold_amount' ,
           33 => 'total_selling_purchase_amount' ,
           34 => 'total_refunding_purchase_amount' ,
           35 => 'total_selling_profit' ,
           36 => 'total_refunded_reduced_profit',
           36 => 'total_profit_from_product' ,
           37 => 'total_profit' ,
           38 => 'total_purchase_amount' ,
           39 => 'total_quantity' ,
           40 => 'total_refunded_qty' ,

           //sellproductstock fileds
           41 => 'total_sell_qty' ,
           42 => 'sold_price' ,
           43 => 'purchase_price' ,
           44 => 'total_selling_amount' ,
           45 => 'total_refunded_amount' ,
           46 => 'total_sold_amount' ,
           47 => 'total_selling_purchase_amount' ,
           48 => 'total_refunding_purchase_amount' ,
           49 => 'total_selling_profit',
           50 => 'refunded_reduced_profit' ,
           51 => 'total_profit_from_product' ,
           52 => 'total_profit' ,
           53 => 'remaining_delivery_qty' ,
           54 => 'total_delivered_qty' ,
           55 => 'total_purchase_amount' ,
           56 => 'total_quantity' ,
           57 => 'total_refunded_qty' ,
       ];
   }


}
