<?php
namespace App\Traits\Backend\Sell\Edit;

use App\Models\Backend\CartSell\EditSellCartInvoice;
use App\Models\Backend\CartSell\EditSellCartProduct;


/**
 * pricing trait
 * 
 */
trait SellEditSummeryCalculationUpdateAfterSellEditAddedToCartTrait
{
    


 
   
    /**
     * update sell edit cart invoice function
     * from this method, calculate all invoice data
     * @param integer $primaryId
     * @return boolean
     */
    private function updateSellEditCartInvoiceCalculation(int $primaryId) : bool {
        
        $existingData = EditSellCartInvoice::select('id','total_sell_item','subtotal','discount_amount','discount_type','total_discount','vat_amount','total_vat',
        'shipping_cost','others_cost','round_amount','round_type','total_payable_amount','total_paid_amount','total_due_amount',
        'reference_amount','total_sold_amount','total_purchase_amount','total_profit','total_profit_from_product','total_quantity','total_delivered_qty'
        )->where('id',$primaryId)->first();

        //total sell and refunded quantity
        $existingData->total_sell_item =  $existingData->editSellCartProducts->count();
        $totalSellQuantity = $existingData->editSellCartProducts->sum('total_quantity');
        $existingData->total_quantity =  $totalSellQuantity;

        //total sold amount
        $totalSoldAmount = $existingData->editSellCartProducts->sum('total_sold_amount');
        $existingData->subtotal = $totalSoldAmount; 
        $existingData->total_payable_amount = $totalSoldAmount; 
        $existingData->total_sold_amount = $totalSoldAmount; 

        //total sold amount
        $totalPurchaseAmount = $existingData->editSellCartProducts->sum('total_purchase_amount');
        $existingData->total_purchase_amount = $totalPurchaseAmount;

        //profit calculation and store
        $totalProfitFromProductProfit = $existingData->editSellCartProducts->sum('total_profit_from_product');
        $existingData->total_profit_from_product = $totalProfitFromProductProfit;

        //total payable amount == subtotal or total_sold_amount + vatamount + shipping_cost + others_cost + 
        $invoicePlusableCharge = $existingData->total_vat + $existingData->shipping_cost + $existingData->others_cost;
        $reference = 0;//$existingData->reference_amount;
        $invoiceMinusableCost =  $existingData->total_discount + $reference;  

        if($existingData->round_type ==	'+'){
            $invoicePlusableCharge = $invoicePlusableCharge + $existingData->round_amount;
        }else{
            $invoiceMinusableCost = $invoiceMinusableCost + $existingData->round_amount;
        }

        $invoicePayableAmount = $totalSoldAmount + $invoicePlusableCharge - $invoiceMinusableCost;
        $existingData->total_payable_amount = $invoicePayableAmount; 

        $existingData->total_profit = ($totalProfitFromProductProfit - $invoiceMinusableCost) - (0);//-(0)==others
        
        //total due and paid section
        //total_discount ,total_vat, shipping_cost,others_cost,round_amount
        //total_payable_amount,paid_amount,due_amount,adjustment_amount
        //refund_charge,reference_amount,total_paid_amount,total_due_amount,
        $totalPayableAmount = $invoicePayableAmount;
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

        $existingData->save();
        return true;
    } //sell edit invoice table

    
    /**
     * sell product table function where from update 
     * all calculateable field by EditSellCartProduct primary id
     * 
     * @param integer $primaryId
     * @return boolean
     */
    private function updateSellEditCartProductCalculation(int $primaryId) : bool {

        $existingData = EditSellCartProduct::select('id','total_sold_amount','total_purchase_amount','total_profit','total_quantity','total_delivered_qty'
        )->where('id',$primaryId)->first(); 


        //total sold and purchase amount 
        $existingData->total_sold_amount = $existingData->editSellCartProductStocks->sum('total_sold_amount'); 
        $existingData->total_purchase_amount = $existingData->editSellCartProductStocks->sum('total_purchase_amount');

        //totoal quantity
        $totalQuantity = $existingData->editSellCartProductStocks->sum('total_quantity');
        $existingData->total_quantity = $totalQuantity;


        //profit calculation and store

        $existingData->total_profit = $existingData->editSellCartProductStocks->sum('total_profit');//-(0)==others
        
        //$existingData->total_delivered_qty = $existingData->editSellCartProductStocks->sum('total_delivered_qty');

        $existingData->save();
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