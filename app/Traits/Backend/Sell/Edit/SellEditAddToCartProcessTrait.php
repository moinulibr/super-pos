<?php
namespace App\Traits\Backend\Sell\Edit;

use App\Models\Backend\CartSell\EditSellCartInvoice;
use App\Models\Backend\CartSell\EditSellCartProduct;
use App\Models\Backend\CartSell\EditSellCartProductStock;
use App\Traits\Backend\Customer\Shipping\ShippingAddressTrait;

/**
 *  trait
 * 
 */
trait SellEditAddToCartProcessTrait
{
    use ShippingAddressTrait;

    protected $requestAllCartData;
    protected $cartName;
    protected $product_id;
    protected $product_name;
    protected $custom_code;

    protected $changeType;
    protected $discountType;
    protected $discountValue;
    protected $discountAmount;
    protected $totalSellingQuantity;
    protected $mainProductStockQuantity;
    protected $otherProductStockQuantityPurchasePrice;
    protected $mainProductStockQuantityPurchasePrice;
    protected $totalPurchasePriceOfAllQuantity;
    protected $changingQuantity;


    protected $saleDetails;
    protected $singleCartId;
    protected $available_status;
    protected $saleUnitPrice;
    protected $sale_unit_price;
    protected $sale_quantity;
    protected $sale_return_quantity;

    protected $identityNumber;
    protected $sale_from_stock_id;
    protected $sale_type_id;
    protected $sale_unit_id;
    protected $purchase_price;
    protected $sub_total;
    protected $selling_unit_name;
    protected $price_cat_id;

   

    //adding to sell cart [session:SellCreateAddToCart]
    protected function insetingDataInTheEditSellCartWhenSellEdit()
    {
        //return $this->requestAllCartData;
        $sell_invoice_id = $this->requestAllCartData['sell_invoice_id'];
        $product_id = $this->requestAllCartData['product_id'];
        
        $otherProductStockQuantity  = 0;
        $otherProductStockQuantityPurchasePrice  = 0;
        $mainProductStockQuantity = 0;
        $othersProductStocks = [];
        if($this->requestAllCartData['more_quantity_from_others_product_stock'] == 1)
        {
            if(count($this->requestAllCartData['product_stock_id']) > 0)
            {
                foreach($this->requestAllCartData['product_stock_id'] as $productStockId)
                {
                    $othersProductStocks[$product_id]['others_product_stock_ids'][]               = $productStockId;  
                    $othersProductStocks[$product_id]['others_product_stock_qtys'][]              = $this->requestAllCartData['product_stock_quantity_'.$productStockId] ;  
                    $othersProductStocks[$product_id]['others_product_stock_purchase_prices'][]   = $this->requestAllCartData['product_stock_quantity_purchase_price_'.$productStockId] ;  
                    $othersProductStocks[$product_id]['over_stock_quantity_process_duration'][]   = $this->requestAllCartData['over_stock_quantity_process_duration_'.$productStockId] ;  
                    
                    if($productStockId != $this->requestAllCartData['selling_main_product_stock_id'])
                    {
                        $otherProductStockQuantity   += $this->requestAllCartData['product_stock_quantity_'.$productStockId];
                        $otherProductStockQuantityPurchasePrice   += ($this->requestAllCartData['product_stock_quantity_purchase_price_'.$productStockId] * $this->requestAllCartData['product_stock_quantity_'.$productStockId]);
                    }else{
                        $mainProductStockQuantity  += $this->requestAllCartData['product_stock_quantity_'.$productStockId];
                    }
                }
            }
        }else{
            $mainProductStockQuantity   = $this->requestAllCartData['final_sell_quantity'];
        }
        //{"36":{"others_product_stock_ids":["137","138","139","140"],"others_product_stock_qtys":["10","2","1","2"],"others_product_stock_purchase_prices":["10.00","9.00","11.00","9.00"]}}
        $mainProductStockQuantityPurchasePrice  = $mainProductStockQuantity * $this->requestAllCartData['purchase_price'];
        $totalPurchasePriceOfAllQuantity  = $mainProductStockQuantityPurchasePrice + $otherProductStockQuantityPurchasePrice;

        $sell_invoice_id = session()->get('sell_invoice_id');
        $edit_sell_cart_invoice_id = session()->get('edit_sell_cart_invoice_id');

        $editSellCartInvoice = EditSellCartInvoice::where('sell_invoice_id',$sell_invoice_id)->first();
        $editSellCartProduct = EditSellCartProduct::where('sell_invoice_id',$sell_invoice_id)->where('branch_id',authBranch_hh())->where('product_id',$product_id)->where('status',1)->first();
        //if product is exist, then update quantity and others
        if($editSellCartProduct){
            $this->insertOrUpdateDataInTheEditSellCartProductStockTable($editSellCartProduct);
        }
        //if product is not exist, then insert the product and others
        else{
             //good working...
            $this->addNewDataOfEditSellCartProductAndProductStock($editSellCartInvoice,$sell_invoice_id,$otherProductStockQuantity,
                $totalPurchasePriceOfAllQuantity,$mainProductStockQuantity
            );  
        }//end else
        return true;
    }

    //-----------------------------------------------------------------------------------------------------  
        //good working...
        private function addNewDataOfEditSellCartProductAndProductStock($editSellCartInvoice,$sell_invoice_id,$otherProductStockQuantity,
            $totalPurchasePriceOfAllQuantity,$mainProductStockQuantity
        ){
            $product_name = $this->requestAllCartData['product_name'];
            $custom_code = $this->requestAllCartData['custom_code'];
            $product_id = $this->requestAllCartData['product_id'];
            $newEditSellCartProduct = new EditSellCartProduct();
            $newEditSellCartProduct->branch_id = authBranch_hh();
            $newEditSellCartProduct->edit_sell_cart_invoice_id = $editSellCartInvoice->id;
            $newEditSellCartProduct->sell_invoice_id = $sell_invoice_id;
            $newEditSellCartProduct->sell_invoice_no = $editSellCartInvoice->sell_invoice_no;
            $newEditSellCartProduct->product_id = $product_id;
            $newEditSellCartProduct->unit_id = $this->requestAllCartData['unit_id'];
            $newEditSellCartProduct->supplier_id = $this->requestAllCartData['supplier_id'];
            $newEditSellCartProduct->main_product_stock_id = $this->requestAllCartData['selling_main_product_stock_id'];
            $newEditSellCartProduct->product_added_type = 2;//edit, 2=add
            $newEditSellCartProduct->product_stock_type  = $otherProductStockQuantity == 0 ? 1 : 2;
            $newEditSellCartProduct->custom_code = $custom_code;
            $newEditSellCartProduct->sold_price = $this->requestAllCartData['final_sell_price'];//$this->requestAllCartData['sell_price'];
            $newEditSellCartProduct->discount_amount = $this->requestAllCartData['discount_amount'];
            $newEditSellCartProduct->discount_type = $this->requestAllCartData['discount_type'];
            $newEditSellCartProduct->total_discount = $this->requestAllCartData['total_discount_amount'];
            $newEditSellCartProduct->reference_commission = 0;
            $newEditSellCartProduct->total_sold_amount = $this->requestAllCartData['selling_final_amount'];
            $newEditSellCartProduct->total_purchase_amount = $totalPurchasePriceOfAllQuantity;
            $newEditSellCartProduct->total_profit = $this->requestAllCartData['selling_final_amount'] - $totalPurchasePriceOfAllQuantity;
            $newEditSellCartProduct->total_quantity = $this->requestAllCartData['final_sell_quantity'];
            $newEditSellCartProduct->status = 1;
            //$newEditSellCartProduct->total_delivered_qty  = 0;
            if($this->requestAllCartData['w_g_type'])
            {
                $newEditSellCartProduct->liability_type = json_encode(["w_g_type" => $this->requestAllCartData['w_g_type'], "w_g_type_day" => $this->requestAllCartData['w_g_type_day']]);
            }
            $newEditSellCartProduct->identity_number = $this->requestAllCartData['identityNumber'];
        
            $newEditSellCartProduct->cart = json_encode([
                'productName' => $product_name,
                "productId" => $product_id,
                'mrpPrice' => $this->requestAllCartData['mrp_price'] ,
                'soldPrice' =>$this->requestAllCartData['final_sell_price'] ,
                'totalSellQuantity' =>$this->requestAllCartData['final_sell_quantity'] ,
                'totalMainProductStockQuantity' => $mainProductStockQuantity ,
                'totalOtherProductStockQuantity' => $otherProductStockQuantity ,
                'unitName' => $this->requestAllCartData['unit_name'],
                'unitId' =>$this->requestAllCartData['unit_id'],
                'customCode' =>$custom_code,
                'warehouseId' =>$this->requestAllCartData['warehouse_id'],
                'warehouseRackId' =>$this->requestAllCartData['warehouse_rack_id'],
            ]);
            $newEditSellCartProduct->save();
            //if more quantity from others product stock equal to 1
            if($this->requestAllCartData['more_quantity_from_others_product_stock'] == 1)
            {
                if(count($this->requestAllCartData['product_stock_id']) > 0)
                {
                    foreach($this->requestAllCartData['product_stock_id'] as $productStockId)
                    {
                        $qtyOfCurrentStock = $this->requestAllCartData['product_stock_quantity_'.$productStockId] ;  
                        $currentPurchasePrice = $this->requestAllCartData['product_stock_quantity_purchase_price_'.$productStockId] ;  
                        $process_duration = $this->requestAllCartData['over_stock_quantity_process_duration_'.$productStockId] ;  
                        $this->insertNewDataInTheEditSellCartProductStockTable($this->requestAllCartData,$newEditSellCartProduct,$productStockId,
                            $qtyOfCurrentStock,$currentPurchasePrice
                        );
                    }
                }
            }else{
                //$mainProductStockQuantity  = $this->requestAllCartData['final_sell_quantity'];
                $this->insertNewDataInTheEditSellCartProductStockTable($this->requestAllCartData,$newEditSellCartProduct,
                    $this->requestAllCartData['selling_main_product_stock_id'],
                    $this->requestAllCartData['final_sell_quantity'],$this->requestAllCartData['purchase_price']
                );
            }
            return $newEditSellCartProduct;
        }


        /**
         * insert new data in the edit sell cart product stock function
         * under addNewDataOfEditSellCartProductAndProductStock method
         * 
         * @param [type] $cart
         * @param object $newEditSellCartProduct
         * @param [type] $product_stock_id
         * @param [type] $qty
         * @param [type] $purchase_price
         * @return object
         */
        private function insertNewDataInTheEditSellCartProductStockTable($cart,object $newEditSellCartProduct,
            $product_stock_id,$qty,$purchase_price) : object{
            $editSellCartProductStock = new EditSellCartProductStock();
            $editSellCartProductStock->branch_id = authBranch_hh();
            $editSellCartProductStock->edit_sell_cart_invoice_id  = $newEditSellCartProduct->edit_sell_cart_invoice_id;
            $editSellCartProductStock->edit_sell_cart_product_id  = $newEditSellCartProduct->id;
            $editSellCartProductStock->sell_invoice_id  = $newEditSellCartProduct->sell_invoice_id;
            $editSellCartProductStock->sell_invoice_no  = $newEditSellCartProduct->sell_invoice_no;

            $editSellCartProductStock->sell_product_id  = NULL;
            $editSellCartProductStock->product_id  = $newEditSellCartProduct->product_id;

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
            $editSellCartProductStock->stock_id = $stockId;
            $editSellCartProductStock->product_stock_id  = $product_stock_id;

            $totalSoldPrice = $cart['final_sell_price'] * $qty;
            $totalPurchasePrice = $purchase_price * $qty ;
            $editSellCartProductStock->mrp_price  = $cart['mrp_price'];
            $editSellCartProductStock->regular_sell_price  = $cart['sell_price'];
            $editSellCartProductStock->sold_price  = $cart['final_sell_price'];
            $editSellCartProductStock->purchase_price  = $purchase_price ;

            $editSellCartProductStock->total_quantity  = $qty;
            
            $editSellCartProductStock->total_profit  = $totalSoldPrice - $totalPurchasePrice;;
            $editSellCartProductStock->total_delivered_qty  = 0;

                //when insert in the  SellProductStock table from cart to final,
            //$editSellCartProductStock->reduced_base_stock_remaining_delivery  = $sellProductStock->reduced_base_stock_remaining_delivery;
            //$editSellCartProductStock->reduceable_delivered_qty  = $sellProductStock->reduceable_delivered_qty;
            //$editSellCartProductStock->remaining_delivery_unreduced_qty  = $sellProductStock->remaining_delivery_unreduced_qty;
            //$editSellCartProductStock->remaining_delivery_unreduced_qty  = $sellProductStock->remaining_delivery_unreduced_qty;
            //$editSellCartProductStock->remaining_delivery_unreduced_qty_date  = $sellProductStock->remaining_delivery_unreduced_qty_date;

            $editSellCartProductStock->created_by = authId_hh();

            //when insert in the  SellProductStock table from cart to final,
            $editSellCartProductStock->sell_cart = json_encode([
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
                //when insert in the  SellProductStock table from cart to final,
                'total_delivered_qty' => 0,
                'remaining_delivery_qty' => 0,
                'reduced_base_stock_remaining_delivery' =>  0,
                'remaining_delivery_unreduced_qty' => 0,
                'remaining_delivery_unreduced_qty_date' =>  0,
            ]);
            $editSellCartProductStock->save();
            return $editSellCartProductStock;
        }
    //-----------------------------------------------------------------------------------------------------
    
    //good working..
    private function insertOrUpdateDataInTheEditSellCartProductStockTable($editSellCartProduct){
        
        //if more quantity from others product stock equal to 1
        if($this->requestAllCartData['more_quantity_from_others_product_stock'] == 1)
        {
            if(count($this->requestAllCartData['product_stock_id']) > 0)
            {
                foreach($this->requestAllCartData['product_stock_id'] as $productStockId)
                {
                    $qtyOfCurrentStock = $this->requestAllCartData['product_stock_quantity_'.$productStockId] ;  
                    $currentPurchasePrice = $this->requestAllCartData['product_stock_quantity_purchase_price_'.$productStockId] ;  
                    $process_duration = $this->requestAllCartData['over_stock_quantity_process_duration_'.$productStockId] ;  
                    $this->insertOrUpdateNewDataInTheEditSellCartProductStockTable($this->requestAllCartData,$editSellCartProduct,$productStockId,
                        $qtyOfCurrentStock,$currentPurchasePrice
                    );
                }
            }
        }else{
            //$mainProductStockQuantity  = $this->requestAllCartData['final_sell_quantity'];
            $this->insertOrUpdateNewDataInTheEditSellCartProductStockTable($this->requestAllCartData,$editSellCartProduct,
                $this->requestAllCartData['selling_main_product_stock_id'],
                $this->requestAllCartData['final_sell_quantity'],$this->requestAllCartData['purchase_price']
            );
        }
    }    
    private function insertOrUpdateNewDataInTheEditSellCartProductStockTable($cart,object $editSellCartProduct,
        $product_stock_id,$qty,$purchase_price
    ){

        $existingEditSellCartProductStock = EditSellCartProductStock::where('product_id',$editSellCartProduct->product_id)
        ->where('product_stock_id',$product_stock_id)->where('edit_sell_cart_product_id',$editSellCartProduct->id)->where('status',1)->first();
        //if existing product stock id == new product stock id, then update
        if($existingEditSellCartProductStock){
            //$editSellCartProductStock =  EditSellCartProductStock::where('');
            //$existingEditSellCartProductStock->branch_id = authBranch_hh();
            //$existingEditSellCartProductStock->edit_sell_cart_invoice_id  = $editSellCartProduct->edit_sell_cart_invoice_id;
            //$existingEditSellCartProductStock->edit_sell_cart_product_id  = $editSellCartProduct->id;
            //$existingEditSellCartProductStock->sell_invoice_id  = $editSellCartProduct->sell_invoice_id;
            //$existingEditSellCartProductStock->sell_invoice_no  = $editSellCartProduct->sell_invoice_no;

            //$existingEditSellCartProductStock->sell_product_id  = NULL;
            //$existingEditSellCartProductStock->product_id  = $editSellCartProduct->product_id;

            /* $pStock = productStockByProductStockId_hh($product_stock_id);
            $stockId = regularStockId_hh();
            if($pStock)
            {
                $availableBaseStock = $pStock->available_base_stock;
                $stockId = $pStock->stock_id;
            }else{
                $availableBaseStock = 0;
            } */
            //stock id 
            //$existingEditSellCartProductStock->stock_id = $stockId;
            //$existingEditSellCartProductStock->product_stock_id  = $product_stock_id;

            $totalSoldPrice = $cart['final_sell_price'] * $qty;
            $totalPurchasePrice = $purchase_price * $qty ;
            $existingEditSellCartProductStock->mrp_price  = $cart['mrp_price'];
            $existingEditSellCartProductStock->regular_sell_price  = $cart['sell_price'];
            $existingEditSellCartProductStock->sold_price  = $cart['final_sell_price'];
            $existingEditSellCartProductStock->purchase_price  = $purchase_price ;

            $existingEditSellCartProductStock->total_quantity  = $qty;
            
            $existingEditSellCartProductStock->total_profit  = $totalSoldPrice - $totalPurchasePrice;;
            $existingEditSellCartProductStock->total_delivered_qty  = 0;

                //when insert in the  SellProductStock table from cart to final,
            //$existingEditSellCartProductStock->reduced_base_stock_remaining_delivery  = $sellProductStock->reduced_base_stock_remaining_delivery;
            //$existingEditSellCartProductStock->reduceable_delivered_qty  = $sellProductStock->reduceable_delivered_qty;
            //$existingEditSellCartProductStock->remaining_delivery_unreduced_qty  = $sellProductStock->remaining_delivery_unreduced_qty;
            //$existingEditSellCartProductStock->remaining_delivery_unreduced_qty  = $sellProductStock->remaining_delivery_unreduced_qty;
            //$existingEditSellCartProductStock->remaining_delivery_unreduced_qty_date  = $sellProductStock->remaining_delivery_unreduced_qty_date;

            $existingEditSellCartProductStock->created_by = authId_hh();

            //when insert in the  SellProductStock table from cart to final,
            $existingEditSellCartProductStock->sell_cart = json_encode([
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
                //when insert in the  SellProductStock table from cart to final,
                'total_delivered_qty' => 0,
                'remaining_delivery_qty' => 0,
                'reduced_base_stock_remaining_delivery' =>  0,
                'remaining_delivery_unreduced_qty' => 0,
                'remaining_delivery_unreduced_qty_date' =>  0,
            ]);
            $existingEditSellCartProductStock->save();
            return $existingEditSellCartProductStock;
        }
        //if not match with existing product stock id, then add new
        else{
            $editSellCartProductStock = new EditSellCartProductStock();
            $editSellCartProductStock->branch_id = authBranch_hh();
            $editSellCartProductStock->edit_sell_cart_invoice_id  = $editSellCartProduct->edit_sell_cart_invoice_id;
            $editSellCartProductStock->edit_sell_cart_product_id  = $editSellCartProduct->id;
            $editSellCartProductStock->sell_invoice_id  = $editSellCartProduct->sell_invoice_id;
            $editSellCartProductStock->sell_invoice_no  = $editSellCartProduct->sell_invoice_no;

            $editSellCartProductStock->sell_product_id  = NULL;
            $editSellCartProductStock->product_id  = $editSellCartProduct->product_id;

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
            $editSellCartProductStock->stock_id = $stockId;
            $editSellCartProductStock->product_stock_id  = $product_stock_id;

            $totalSoldPrice = $cart['final_sell_price'] * $qty;
            $totalPurchasePrice = $purchase_price * $qty ;
            $editSellCartProductStock->mrp_price  = $cart['mrp_price'];
            $editSellCartProductStock->regular_sell_price  = $cart['sell_price'];
            $editSellCartProductStock->sold_price  = $cart['final_sell_price'];
            $editSellCartProductStock->purchase_price  = $purchase_price ;

            $editSellCartProductStock->total_quantity  = $qty;
            
            $editSellCartProductStock->total_profit  = $totalSoldPrice - $totalPurchasePrice;;
            //$editSellCartProductStock->total_delivered_qty  = 0;

                //when insert in the  SellProductStock table from cart to final,
            //$editSellCartProductStock->reduced_base_stock_remaining_delivery  = $sellProductStock->reduced_base_stock_remaining_delivery;
            //$editSellCartProductStock->reduceable_delivered_qty  = $sellProductStock->reduceable_delivered_qty;
            //$editSellCartProductStock->remaining_delivery_unreduced_qty  = $sellProductStock->remaining_delivery_unreduced_qty;
            //$editSellCartProductStock->remaining_delivery_unreduced_qty  = $sellProductStock->remaining_delivery_unreduced_qty;
            //$editSellCartProductStock->remaining_delivery_unreduced_qty_date  = $sellProductStock->remaining_delivery_unreduced_qty_date;

            $editSellCartProductStock->created_by = authId_hh();

            //when insert in the  SellProductStock table from cart to final,
            $editSellCartProductStock->sell_cart = json_encode([
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
                //when insert in the  SellProductStock table from cart to final,
                'total_delivered_qty' => 0,
                'remaining_delivery_qty' => 0,
                'reduced_base_stock_remaining_delivery' =>  0,
                'remaining_delivery_unreduced_qty' => 0,
                'remaining_delivery_unreduced_qty_date' =>  0,
            ]);
            $editSellCartProductStock->save();
            return $editSellCartProductStock;
        }
    }
    //-----------------------------------------------------------------------------------------------------


    
    /**
     * remove single item from editsellcartproduct and editsellcartproductstock function
     *
     * @return boolean
     */
    public function removeSingleItemFromSellEditCreateAddedToCartList() : bool {
        $this->requestAllCartData['remove_edit_sell_cart_product_stock_id'];
        $this->requestAllCartData['remove_edit_sell_cart_product_id'];
        //if edit sell cart product stock id is found
        if(isset($this->requestAllCartData['remove_edit_sell_cart_product_stock_id'])){
            $data = EditSellCartProductStock::find($this->requestAllCartData['remove_edit_sell_cart_product_stock_id']);
            if($data){
                $data->status = 2;
                $data->save();

                //when all edit sell cart product stock is delete
                $editSellCartSingleProduct = EditSellCartProduct::find($data->edit_sell_cart_product_id);
                if(count($editSellCartSingleProduct->editSellCartProductStocks) == 0){
                    if($editSellCartSingleProduct){
                        $editSellCartSingleProduct->status = 2;
                        $editSellCartSingleProduct->save();
                    }
                }
            }
        }
        //if edit sell cart product id is found
        if(isset($this->requestAllCartData['remove_edit_sell_cart_product_id'])){
            $data = EditSellCartProduct::find($this->requestAllCartData['remove_edit_sell_cart_product_id']);
            if($data){
                $data->editSellCartProductStocks()->update(['status'=>2]);
                $data->status = 2;
                $data->save();
            }
        }
        return true;
    }//*Remove Single item From  Cart Working Properly


    /**
     * remove all item from sell edit related table function
     * after all remove/delete, it will redirect to sell list
     *
     * @return boolean
     */
    public function removeAllItemFromSellEditCreateAddedToCartList() :bool
    {
        $sell_invoice_id = session()->get('sell_invoice_id');
        $edit_sell_cart_invoice_id = session()->get('edit_sell_cart_invoice_id');

        $editSellCartInvoice = EditSellCartInvoice::where('id',$edit_sell_cart_invoice_id)->first();
        $editSellCartInvoice->editSellCartAllProducts()->delete();
        $editSellCartInvoice->editSellCartAllProductsStock()->delete();
        $editSellCartInvoice->delete();
        session()->put('sell_invoice_id',NULL);
        session()->put('edit_sell_cart_invoice_id',NULL);
        session()->put('sell_type',NULL);
        return true;
    }/*Remove All item From Cart Working Properly*/


    /*When changing quantity*/
    public function whenChangingQuantityFromSellEditCartList()
    {   
        //never minus below 1,
        //add more , no problem, 
        //change total qty, and calculation

        $edit_sell_cart_product_stock_id  = $this->requestAllCartData['edit_sell_cart_product_stock_id'];
        $changeType = $this->requestAllCartData['change_type'];
        $changingQuantity = $this->requestAllCartData['quantity'];
        
        $existingEditSellCartProductStock = EditSellCartProductStock::findOrFail($edit_sell_cart_product_stock_id);
        $totalQty = 1;
        if($changeType == 'minus')
        {
            $newTotalQty = $existingEditSellCartProductStock->total_quantity - 1;
            if($newTotalQty <= 1){
                $totalQty = 1;
            }else{
                $totalQty = $newTotalQty;
            }
        }
        else if($changeType == 'plus')
        {
            $totalQty = $existingEditSellCartProductStock->total_quantity + 1;
        }

        $existingEditSellCartProductStock->total_quantity = $totalQty;

        $totalSoldPrice = $existingEditSellCartProductStock->sold_price * $totalQty;
        $totalPurchasePrice = $existingEditSellCartProductStock->purchase_price * $totalQty ;
        //$existingEditSellCartProductStock->mrp_price  = ;
        //$existingEditSellCartProductStock->regular_sell_price  = $cart['sell_price'];
        //$existingEditSellCartProductStock->sold_price  = $cart['final_sell_price'];
        //$existingEditSellCartProductStock->purchase_price  = $purchase_price ;
        
        $existingEditSellCartProductStock->total_profit  = $totalSoldPrice - $totalPurchasePrice;
        $existingEditSellCartProductStock->save();
        return $existingEditSellCartProductStock;
    } /*When changing quantity*/





    
    
    //====================================================================
    protected function shippingAddressStoreInSessionWhenSellEdit()
    {
        //return $this->requestAllCartData;
        $use_shipping_address = $this->requestAllCartData['use_shipping_address'];
        $customer_id = $this->requestAllCartData['customer_id'];
        $reference_id = $this->requestAllCartData['reference_id'];
        $customerShippingAddressId = NULL;
        if($use_shipping_address == '1_existing')
        {
            $customerShippingAddressId = $this->requestAllCartData['customer_shipping_address_id'];
           
        }else if($use_shipping_address  = '2_new')
        {
            $data['customer_id'] = $customer_id;
            $data['phone'] = $this->requestAllCartData['phone'];
            $data['new_shipping_address'] = $this->requestAllCartData['new_shipping_address'];
            $data['email'] = $this->requestAllCartData['email'];
            
            $this->customerFormData = $data;
            $customerShippingAddressId = $this->insertCustomerShippingAddressFromPosCreate();
        }

        $invoice_shipping_cost = $this->requestAllCartData['invoice_shipping_cost'];
        $shipping_note = $this->requestAllCartData['shipping_note'];
        $sell_note = $this->requestAllCartData['sell_note'];
        $receiver_details = $this->requestAllCartData['receiver_details'];

        $cartName           = [];
        $cartName           = session()->has($this->cartName) ? session()->get($this->cartName)  : [];
        $cartName = [
            'customer_id'=> $customer_id,
            'reference_id'=> $reference_id,
            'customer_shipping_address_id'=> $customerShippingAddressId,
            'invoice_shipping_cost'=> $invoice_shipping_cost,
            'shipping_note'=> $shipping_note,
            'sell_note'=> $sell_note,
            'receiver_details'=> $receiver_details,
           ];
        session([$this->cartName => $cartName]);
        return $this->cartName;
    }

    //====================================================================

 
}