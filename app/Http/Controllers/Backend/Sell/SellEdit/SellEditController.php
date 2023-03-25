<?php

namespace App\Http\Controllers\Backend\Sell\SellEdit;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Backend\CartSell\EditSellCartInvoice;
use App\Models\Backend\CartSell\EditSellCartProduct;
use App\Models\Backend\CartSell\EditSellCartProductStock;
use App\Models\Backend\Product\Product;
use App\Models\Backend\Sell\SellInvoice;
use App\Models\Backend\Sell\SellProduct;
use App\Models\Backend\Customer\Customer;
use App\Models\Backend\Reference\Reference;
use App\Models\Backend\Sell\SellProductStock;
use App\Models\Backend\ProductAttribute\Category;
use App\Traits\Backend\Sell\Edit\QuotationToSellAndSellUpdateDataFromSellEditCartTrait;
use App\Traits\Backend\Sell\Edit\SellEditSummeryCalculationUpdateAfterSellEditAddedToCartTrait;

class SellEditController extends Controller
{
    use QuotationToSellAndSellUpdateDataFromSellEditCartTrait;
    use SellEditSummeryCalculationUpdateAfterSellEditAddedToCartTrait;

    private $invoiceTotalQuantity;
    private $invoiceTotalPayableAmount;
    private $invoiceSubtotal;
    private $invoiceTotalPurchaseAmount;
    private $invoiceTotalProfit;

    private $sellProductTotalQuantity;
    private $sellProductTotalSoldPrice;
    private $sellProductTotalPurchasePrice;
    private $sellProductTotalProfitPrice;



    /**
     * display product list function
     *
     * @param Request $request
     */
    public function displayProductList(Request $request)
    {
        $query = Product::query();
        if($request->product_id){
            $query->where('id',$request->product_id);
        }
        if($request->category_id){
            $query->where('category_id',$request->category_id);
        }
        if($request->custom_search){
            $query->where('name','like',"%".$request->custom_search."%");
            $query->orWhere('custom_code','like',"%".$request->custom_search."%");
            $query->orWhere('company_code','like',"%".$request->custom_search."%");
            $query->orWhere('sku','like',"%".$request->custom_search."%");
        }
        $data['products']  = $query->select('name','id','photo','available_base_stock')
                        ->latest()
                        ->paginate(21);
        $view = view('backend.sell.pos.ajax-response.landing.product-list.product_list',$data)->render();
        return response()->json([
            'status'    => true,
            'html'      => $view,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        //$this->updateSellRelatedDataForEditCart($sellType = 1,$invoiceNo);
        $id = NUll;
        if(isset($request->seid)){
            $id = \Crypt::decrypt($request->seid);
        }else{
            return redirect()->route('admin.sell.regular.sell.index')->with('error','Invalid data');
        }
       
        $sellInvoice = SellInvoice::findOrFail($id);
        if(!$sellInvoice){
            return redirect()->back()->with('error','Data Not Found!');
        }

        $data['customers'] = Customer::latest()->get();
        $data['references'] = Reference::latest()->get();
        $data['categories'] = Category::latest()->get();
        $data['allproducts'] = Product::select('name','id')->latest()->get();
        $data['products'] = Product::select('custom_code','company_code','name','id','photo','available_base_stock')->whereNull('deleted_at')->latest()->paginate(21);
    
        DB::beginTransaction();
        try {
            if($sellInvoice)
            {
                $this->deleteSellEditCartBySellInvoice($id);

                $editSellCartInvoice = $this->insertSellEditCart($sellInvoice);
                $data['sellEditCart'] = $editSellCartInvoice;
                //$editSellCartInvoice = EditSellCartInvoice::where('sell_invoice_id',$sellInvoice->id)->first();
                
                session()->put('sellInvoice_for_edit',$sellInvoice);
                session()->put('total_edit_count_for_edit',$sellInvoice->total_edit_count);
                session()->put('total_return_count_for_edit',$sellInvoice->total_return_count);
                session()->put('total_delivered_count_for_edit',$sellInvoice->total_delivered_count);

                session()->put('sell_invoice_id_for_edit',$sellInvoice->id);
                session()->put('sell_type_for_edit',$sellInvoice->sell_type);
                session()->put('edit_sell_cart_invoice_id_for_edit',$editSellCartInvoice->id);
                
                //update edit sell cart invoice table : all calculation
                $this->updateSellEditCartInvoiceCalculation($editSellCartInvoice->id);
                
                DB::commit();

                $data['editSellInvoice'] = $editSellCartInvoice;
                return view('backend.sell.edit.index',$data);
            }else{
                return redirect()->back()->with('error','Invalid Data!');
            }
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
            return redirect()->back()->with('error','Something went wrong!');
        }

        return view('backend.sell.edit.cart_product_list');
        $dkd = session()->get('sellInvoice_for_edit');
        return $dkd->invoice_no;
    }

    /**
     * insert sell edit cart invoice function
     *
     * @param object $sellInvoiceData
     * @return object
     */
    private function insertSellEditCart(object $sellInvoiceData) : object {

        //return $sellInvoiceData;
        $editSellCart = new EditSellCartInvoice();
        $editSellCart->branch_id = authBranch_hh();   
        $editSellCart->sell_type = $sellInvoiceData->sell_type;   
        $editSellCart->sell_invoice_id = $sellInvoiceData->id;   
        $editSellCart->sell_invoice_no = $sellInvoiceData->invoice_no;    
        $editSellCart->total_sell_item = $sellInvoiceData->total_item;   
        $editSellCart->subtotal = $sellInvoiceData->subtotal;   
        $editSellCart->discount_amount = $sellInvoiceData->discount_amount;   
        $editSellCart->discount_type = $sellInvoiceData->discount_type;   
        $editSellCart->total_discount = $sellInvoiceData->total_discount;   
        $editSellCart->vat_amount = $sellInvoiceData->vat_amount;   
        $editSellCart->total_vat = $sellInvoiceData->total_vat;   
        $editSellCart->shipping_cost = $sellInvoiceData->shipping_cost;   
        $editSellCart->others_cost = $sellInvoiceData->others_cost;   
        $editSellCart->round_amount = $sellInvoiceData->round_amount;   
        $editSellCart->round_type = $sellInvoiceData->round_type;   
        $editSellCart->total_payable_amount = $sellInvoiceData->total_payable_amount;
        $editSellCart->total_paid_amount = $sellInvoiceData->total_paid_amount;   
        $editSellCart->total_due_amount = $sellInvoiceData->total_due_amount;   
        $editSellCart->reference_amount = $sellInvoiceData->reference_amount;   
        $editSellCart->total_sold_amount = $sellInvoiceData->total_sold_amount;   
        $editSellCart->total_purchase_amount = $sellInvoiceData->total_purchase_amount;   
        $editSellCart->total_profit = $sellInvoiceData->total_profit;   
        $editSellCart->total_delivered_qty = $sellInvoiceData->total_delivered_qty;   
        $editSellCart->sell_date = $sellInvoiceData->sell_date;   
        $editSellCart->save();   

        $this->insertEditSellCartProduct($sellInvoiceData, $editSellCart);

        return $editSellCart;
    }

    private function insertEditSellCartProduct(object $data,object $editSellCart) : bool {
        
        foreach($data->sellProducts as $item){

            $editSellCartProduct  =  new EditSellCartProduct();
            $editSellCartProduct->branch_id	 = authBranch_hh();
            $editSellCartProduct->edit_sell_cart_invoice_id  = $editSellCart->id;
            $editSellCartProduct->sell_invoice_id  = $item->sell_invoice_id;
            $editSellCartProduct->sell_invoice_no  = $editSellCart->sell_invoice_no;
            $editSellCartProduct->product_id  = $item->product_id;
            $editSellCartProduct->unit_id  = $item->unit_id;
            $editSellCartProduct->supplier_id  = $item->supplier_id;
            $editSellCartProduct->main_product_stock_id  = $item->main_product_stock_id;
            $editSellCartProduct->product_added_type  = 1;//edit, 2=add
            $editSellCartProduct->product_stock_type  = $item->product_stock_type;
            $editSellCartProduct->custom_code  = $item->custom_code;
            //$editSellCartProduct->total_sell_qty_before_edit  = $item->total_quantity;
            //$editSellCartProduct->total_sell_qty_after_edit  = $item->total_quantity;
            $editSellCartProduct->sold_price  = $item->sold_price;
            $editSellCartProduct->discount_amount  = $item->discount_amount;
            $editSellCartProduct->discount_type  = $item->discount_type;
            $editSellCartProduct->total_discount  = $item->total_discount;
            $editSellCartProduct->reference_commission  = $item->reference_commission;
            //$editSellCartProduct->total_selling_amount_before_edit  = $item->total_sold_amount;
            //$editSellCartProduct->total_selling_amount_after_edit  = $item->total_sold_amount;
            $editSellCartProduct->total_sold_amount  = $item->total_sold_amount;
            //$editSellCartProduct->total_selling_purchase_amount_before_edit  = $item->total_purchase_amount;
            //$editSellCartProduct->total_selling_purchase_amount_after_edit  = $item->total_purchase_amount;
            $editSellCartProduct->total_purchase_amount  = $item->total_purchase_amount;
            //$editSellCartProduct->total_selling_profit_before_edit  = $item->total_profit;
            //$editSellCartProduct->total_selling_profit_after_edit  = $item->total_profit;
            $editSellCartProduct->total_profit  = $item->total_profit;
            //$editSellCartProduct->qty_change_type  = NULL;
            //$editSellCartProduct->total_update_qty  = $item->product_id;
            $editSellCartProduct->total_quantity  = $item->total_quantity;
            $editSellCartProduct->total_delivered_qty  = $item->delivered_qty;
            //$editSellCartProduct->remaining_delivery_qty_before_edit  = $item->total_quantity - $item->delivered_qty;
            //$editSellCartProduct->remaining_delivery_qty_after_edit  = $item->total_quantity - $item->delivered_qty;
            $editSellCartProduct->liability_type  = $item->liability_type;
            $editSellCartProduct->identity_number  = $item->identity_number;
            $editSellCartProduct->cart  = $item->cart;
            
            $editSellCartProduct->save();

            $this->insertEditSellCartProductStock($item, $editSellCartProduct);
        }

        return true;
    }

    private function insertEditSellCartProductStock(object $item, object $sellEditCartProduct) : bool {

        foreach($item->sellProductStocks as $sellProductStock){
            
            $editSellCartProductStock  =  new EditSellCartProductStock();
            $editSellCartProductStock->branch_id	 = authBranch_hh();
            $editSellCartProductStock->edit_sell_cart_invoice_id  = $sellEditCartProduct->edit_sell_cart_invoice_id;
            $editSellCartProductStock->edit_sell_cart_product_id  = $sellEditCartProduct->id;
            $editSellCartProductStock->sell_invoice_id  = $sellEditCartProduct->sell_invoice_id;
            $editSellCartProductStock->sell_invoice_no  = $sellEditCartProduct->sell_invoice_no;

            $editSellCartProductStock->sell_product_id  = $sellProductStock->sell_product_id;
            $editSellCartProductStock->product_id  = $sellProductStock->product_id;
            $editSellCartProductStock->stock_id  = $sellProductStock->stock_id;
            $editSellCartProductStock->product_stock_id  = $sellProductStock->product_stock_id;
            $editSellCartProductStock->mrp_price  = $sellProductStock->mrp_price;
            $editSellCartProductStock->regular_sell_price  = $sellProductStock->regular_sell_price;
            $editSellCartProductStock->sold_price  = $sellProductStock->sold_price;
            $editSellCartProductStock->total_sold_amount  = $sellProductStock->sold_price * $sellProductStock->total_quantity;
            $editSellCartProductStock->purchase_price  = $sellProductStock->purchase_price;
            $editSellCartProductStock->total_purchase_amount  = $sellProductStock->purchase_price * $sellProductStock->total_quantity;
            $editSellCartProductStock->total_quantity  = $sellProductStock->total_quantity;
            $editSellCartProductStock->total_delivered_qty  = $sellProductStock->total_delivered_qty;
            
            $editSellCartProductStock->reduced_base_stock_remaining_delivery  = $sellProductStock->reduced_base_stock_remaining_delivery;
            $editSellCartProductStock->reduceable_delivered_qty  = $sellProductStock->reduceable_delivered_qty;
            $editSellCartProductStock->remaining_delivery_unreduced_qty  = $sellProductStock->remaining_delivery_unreduced_qty;
            $editSellCartProductStock->remaining_delivery_unreduced_qty  = $sellProductStock->remaining_delivery_unreduced_qty;
            $editSellCartProductStock->remaining_delivery_unreduced_qty_date  = $sellProductStock->remaining_delivery_unreduced_qty_date;
            $editSellCartProductStock->sell_cart = $sellProductStock->sell_cart;
            $editSellCartProductStock->created_by = authId_hh();

            $editSellCartProductStock->save();

        }
        return true;
    }





    /**
     * delete Sell Edit Cart function, where from we delete sell edit cart
     *
     * @param int $id
     * @return boolean
     */
    private function deleteSellEditCartBySellInvoice (int $id) : bool {
        $editSellCart = EditSellCartInvoice::where('sell_invoice_id',$id)->where('branch_id',authBranch_hh())->first();
        if($editSellCart){
            EditSellCartProduct::where('sell_invoice_id',$id)->where('branch_id',authBranch_hh())->delete();
            EditSellCartProductStock::where('sell_invoice_id',$id)->where('branch_id',authBranch_hh())->delete();
            $editSellCart->delete();
        }
        return true;
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //test data
        DB::beginTransaction();
        try {
            if((isset($request->checked_id)) && (count($request->checked_id) > 0))
            {
                      
                DB::commit();
            }else{
                return response()->json([
                    'status'    => false,
                    'message'   => "Please, checked minimum quantity of a item for return",
                    'type'      => 'error'
                ]);
            }
           
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
            return response()->json([
                'status'    => false,
                'message'   => "Something went wrong fasedfdfa",
                'type'      => 'error'
            ]);
        }
    }


    //sell product stock table 
    private function sellProductStockChangesData($returnInvoice,$invoiceData,$sell_product_stock_id, $returningQty){
           
        $sellProductStockDetails = SellProductStock::select('id','reduceable_delivered_qty','reduced_base_stock_remaining_delivery','product_id','stock_id','sell_product_id','product_stock_id','sold_price','total_quantity','total_delivered_qty')->where('id',$sell_product_stock_id)->first();
        $sellProduct =  SellProduct::select('id','unit_id')->where('id',$sellProductStockDetails->sell_product_id)->first();
        
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
                //total reduceable delivered qty
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
                $sellProductStockDetails->save();

            /*
            |--------------------------------------------------------------------------------------------------------
            | this section is managing for reducing stock when return/refund qty
            | note that:- refunding time -> we make a vartual field name totalReduceableQty
            | It's make by two column:-  totalReduceableQty = (reduceable_delivered_qty + reduced_base_stock_remaining_delivery)
            |--------------------------------------------------------------------------------------------------------
            */
            $productStock = productStockByProductStockId_hh($sellProductStockDetails->product_stock_id);
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
            }
            //increment stock quantity to the particular's stock  from product stock
        /*
        |-----------------------------------------------------------------------------------
        | this part is only for reduceing stock from all kinds of sells
        | and increment stock to the particular stocks    
        |------------------------------------------------------------------------------------
        */


        //module = SellProductStock, moduleTypeId = 3
        $this->managingSellCalculationAfterRefunding($moduleTypeId = 3, $primaryId = $sell_product_stock_id,
            $calable = true,$dbField = 'total_refunded_qty', $calType = 1, $amountOrQty = $returningQty
        );
        
        //module = SellProduct, moduleTypeId = 2
        $this->managingSellCalculationAfterRefunding($moduleTypeId = 2, $primaryId = $sellProductStockDetails->sell_product_id,
            $calable = false, $dbField = NULL, $calType = 1, $amountOrQty = 0
        );
        
        return $this->sellReturnProductStore($returnInvoice,$invoiceData,$sellProductStockDetails,$returningQty);
    }


    //get Total Discount amount
    private function getTotalDiscountAmount($totalAmount,$discount_amount,$discount_type)
    {
        $discountAmount = 0;
        if($discount_amount == 'fixed')
        {
            $discountAmount = $discount_amount;
        }else{
            $discountAmount = (($totalAmount * $discount_amount) / 100);
        }
        return  $discountAmount;
    }

  


    
}
