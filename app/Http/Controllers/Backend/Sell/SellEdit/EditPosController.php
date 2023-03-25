<?php

namespace App\Http\Controllers\Backend\Sell\SellEdit;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Backend\Product\Product;
use App\Models\Backend\Customer\Customer;
use App\Models\Backend\Stock\ProductStock;
use App\Models\Backend\ProductAttribute\Unit;
use App\Models\Backend\CartSell\EditSellCartInvoice;
use App\Traits\Backend\Sell\Edit\SellEditAddToCartProcessTrait;
use App\Traits\Backend\Sell\Edit\QuotationToSellAndSellUpdateDataFromSellEditCartTrait;
class EditPosController extends Controller
{
    use  QuotationToSellAndSellUpdateDataFromSellEditCartTrait;
    use SellEditAddToCartProcessTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
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
            //$query->orWhere('sku','like',"%".$request->custom_search."%");
        }
        $data['products']       = $query->select('custom_code','company_code','name','id','photo','available_base_stock')
                                ->latest()
                                ->whereNull('deleted_at')
                                ->paginate(21);
        $view = view('backend.sell.pos.ajax-response.landing.product-list.product_list',$data)->render();
        return response()->json([
            'status'    => true,
            'html'      => $view,
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function singleProductDetails(Request $request)
    {
        $data['product'] = Product::find($request->id);
        $unitBaseId  = Unit::find($data['product']->unit_id)->base_unit_id;
        $data['units'] = Unit::where('base_unit_id',$unitBaseId)->latest()->get();
        
        //default price id 
        $data['defaultPriceId'] = 1;
        //default stock 
        $defaultStock = 1 ;
        $dafault = ProductStock::select("product_stocks.id","stocks.id as sId")
                ->join("stocks","stocks.id","=","product_stocks.stock_id")
                ->where('product_stocks.product_id',$request->id)
                ->where('product_stocks.branch_id',authBranch_hh())
                ->where('stocks.id',defaultSelectedProductStockId_hh())//default stock id
                ->where('product_stocks.status',1)
                ->where('stocks.status',1)
                ->orderBy('stocks.custom_serial','ASC')
                ->where('stocks.branch_id',authBranch_hh())
                ->first(); 
        $data['defaultProductStockId'] = $dafault ? $dafault->id : 1;
        //default stock 

        //default product stocks price
        $product = $data['product'];
        $data['productStock'] = $product->productStockWithActivePriceByProductStockIdNORWhereStatusIsActiveWhenCreateSale($dafault->id);
        //default product stocks price

        //$data['sell_invoice_id'] = session()->get('sell_invoice_id_for_edit');
        //$data['edit_sell_cart_invoice_id'] = session()->get('edit_sell_cart_invoice_id_for_edit');
        
        $view = view('backend.sell.edit.ajax-response.single-product.single_product',$data)->render();
        $stock = view('backend.sell.edit.ajax-response.single-product.include.product_stock',$data)->render();
        return response()->json([
            'status'    => true,
            'html'      => $view,
            'stock'     => $stock,
        ]);
    }


    public function displaySinglePriceListByProductStockId(Request $request)
    {
        $product                = Product::find($request->product_id);
        $data['productStock']   = $product->productStockWithActivePriceByProductStockIdNORWhereStatusIsActiveWhenCreateSale($request->product_stock_id);

        $stock = view('backend.sell.edit.ajax-response.single-product.include.product_stock_price',$data)->render();
        return response()->json([
            'status'    => true,
            'stock'     => $stock,
        ]);
    }

    //display product stock and price, when sell create. more than stock, from others stock
    public function displayQuantityWiseSingleProductStockByProductId(Request $request)
    {
        $product                        = Product::find($request->product_id);
        $data['sellingQuantity']        = $request->sellingQuantity;
        $data['sellingPrice']           = $request->sellingPrice;
        $data['primarySellingStock']    = $request->primarySellingStock;
        $data['product'] = $product;
        $stock = view('backend.sell.edit.ajax-response.single-product.include.quantity_wise_product_stock',$data)->render();
        return response()->json([
            'status'    => true,
            'stock'     => $stock,
        ]);
    }
  
    

    //================================= start add to cart for sell edit ============================
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $edit_sell_cart_invoice_id = session()->get('edit_sell_cart_invoice_id_for_edit');

        $this->requestAllCartData = $request;
        $this->insetingDataInTheEditSellCartWhenSellEdit();
        $sellEditCart = EditSellCartInvoice::find($edit_sell_cart_invoice_id);
        $list = view('backend.sell.edit.ajax-response.landing.added-to-cart.list',compact('sellEditCart'))->render();
        return response()->json([
            'status'    => true,
            'list'      => $list,
            'message'   => "This item is added in the cart",
            'type'      => 'success'
        ]);
    }

    
    /**
     * display sell edited added to cart product list function
     * from this method, all added to carts product will be displayed
     *
     * @param Request $request
     * @return void
     */
    public function displaySellEditCreateAddedToCartProductList(Request $request)
    {
        $edit_sell_cart_invoice_id = session()->get('edit_sell_cart_invoice_id_for_edit');
        $sellEditCart = EditSellCartInvoice::find($edit_sell_cart_invoice_id);
        $list = view('backend.sell.edit.ajax-response.landing.added-to-cart.list',compact('sellEditCart'))->render();
        return response()->json([
            'status'    => true,
            'list'     => $list,
        ]);
    }//display sell created added to cart product list


    

    /**
     * Undocumented function
     * sell edit final invoice calculation summery [update in editsellcartinvoice table]
     * without shipping details, but shipping cost, other cost, discount is working...
     * @param Request $request
     * @return void
     */
    public function invoiceFinalSellEditCalculationSummery(Request $request){

        $sellEditInvoice = EditSellCartInvoice::findOrFail($request->sellEditInvoiceId);
        $sellEditInvoice->total_sell_item = $request->totalItem;
        $sellEditInvoice->subtotal = $request->subtotalFromSellCartList;
        $sellEditInvoice->total_quantity	 = $request->totalQuantity;
        $sellEditInvoice->discount_amount = $request->invoiceDiscountAmount;
        $sellEditInvoice->discount_type = $request->invoiceDiscountType;
        $sellEditInvoice->total_discount = $request->totalInvoiceDiscountAmount;
        $sellEditInvoice->vat_amount = $request->invoiceVatAmount;
        $sellEditInvoice->total_vat = $request->totalVatAmountCalculation;
        $sellEditInvoice->shipping_cost = $request->totalShippingCost;
        $sellEditInvoice->others_cost = $request->invoiceOtherCostAmount;
        $sellEditInvoice->total_payable_amount = $request->totalInvoicePayableAmount;
        //$sellEditInvoice-> = $request->customer_id;
        //$sellEditInvoice-> = $request->reference_id;
        $sellEditInvoice->save();
        return response()->json([
            'status'    => true,
        ]);
       
    }



    
    /**
     * remove single item from sell edit product and product stock function
     * from this method, a popup blade file will be appeared for confirmation
     * 
     * @param Request $request
     * @return void
     */
    public function removeConfirmationRequiredForSingleItemFromSellEditAddedToCartList(Request $request)
    {
        if(isset($request->edit_sell_product_id)){
            $data['edit_sell_product_id'] = $request->edit_sell_product_id;
            $html = view('backend.sell.edit.ajax-response.landing.remove-added-to-cart.remove_single_item',$data)->render();
        }
        if(isset($request->edit_sell_cart_product_stock_id)){
            $data['edit_sell_cart_product_stock_id'] = $request->edit_sell_cart_product_stock_id;
            $html = view('backend.sell.edit.ajax-response.landing.remove-added-to-cart.remove_single_sell_product_stock_item',$data)->render();
        }
        return response()->json([
            'status'    => true,
            'html'     => $html,
        ]);
    }//remove single item confirmation modal

    /**
     * remove single item from sell edit cart product and product stocks function
     *
     * @param Request $request
     * @return void
     */
    public function removeSingleItemFromSellEditAddedToCartList(Request $request)
    {
        $this->requestAllCartData = $request;
        $this->removeSingleItemFromSellEditCreateAddedToCartList();
        $edit_sell_cart_invoice_id = session()->get('edit_sell_cart_invoice_id_for_edit');
        $sellEditCart = EditSellCartInvoice::find($edit_sell_cart_invoice_id);
        $list = view('backend.sell.edit.ajax-response.landing.added-to-cart.list',compact('sellEditCart'))->render();
        return response()->json([
            'status'    => true,
            'list'     => $list,
            'message'   => "Delete this item from the cart",
            'type'      => 'success'
        ]);
    }

    
    /**
     * remove all item confirmation  function
     * from this method, a popup blade file will be appeared for confirmation
     * 
     * @return void
     */
    public function removeConfirmationRequiredForAllItemFromSellEditAddedToCartList()
    {
        $html = view('backend.sell.edit.ajax-response.landing.remove-added-to-cart.remove_all_item')->render();
        return response()->json([
            'status'    => true,
            'html'     => $html,
        ]);
    }//remove all itme confirmation modal

    /**
     * remove all item from sell edit related data function
     * and redirect to sell list
     * @return void
     */
    public function removeAllItemFromSellEditAddedToCartList()
    {
        $sellType = session()->get('sell_type_for_edit');
        $redirectUrl = NULL;
        if($sellType == 1){
            $redirectUrl = route('admin.sell.regular.sell.index');
        }else{
            $redirectUrl = route('admin.sell.regular.quotation.index');
        }
        $this->removeAllItemFromSellEditCreateAddedToCartList();
        return response()->json([
            'status'    => true,
            'list'     => '',
            'redirectUrl' => $redirectUrl,
            'message'   => "All item are deleted from the cart",
            'type'      => 'success'
        ]);
    }

    //change quantity
    public function changeQuantity(Request $request)
    {
        $this->requestAllCartData = $request;
        $this->whenChangingQuantityFromSellEditCartList();
        $edit_sell_cart_invoice_id = session()->get('edit_sell_cart_invoice_id_for_edit');
        $sellEditCart = EditSellCartInvoice::find($edit_sell_cart_invoice_id);
        $list = view('backend.sell.edit.ajax-response.landing.added-to-cart.list',compact('sellEditCart'))->render();
        return response()->json([
            'status'    => true,
            'list'     => $list,
            'message'   => "Quantity is updated for this item",
            'type'      => 'success'
        ]);
    }
    //================================= end add to cart for sell edit ============================




    
    //quotation mmodal open with customer information and invoice information
    public function quotationModalOpen(Request $request)
    {
        $sellQuotation = session()->get('sellInvoice_for_edit');
        $list = view('backend.sell.edit.ajax-response.payment_quotation.quotation_data',compact('sellQuotation'))->render();
        return response()->json([
            'status'    => true,
            'list'     => $list,
        ]);
    }
    
    //payment mmodal open with customer information and invoice information
    public function paymentModalOpen(Request $request)
    {
        $edit_sell_cart_invoice_id = session()->get('edit_sell_cart_invoice_id_for_edit');

        $sellEditCart = EditSellCartInvoice::find($edit_sell_cart_invoice_id);

        $data['totalPayableAmount'] = $sellEditCart->total_payable_amount;
        
        $data['customer'] = Customer::findOrFail($request->customer_id);
        $data['reference'] = $request->reference_id;

        $data['cashAccounts'] = cashAccounts_hh();
        $data['advanceAccounts'] = advanceAccounts_hh();
        
        if($data['totalPayableAmount'] > 0)
        {
            $list = view('backend.sell.edit.ajax-response.payment_quotation.payment_data',$data)->render();
            return response()->json([
                'status'    => true,
                'list'     => $list,
            ]);
        }else{
            return response()->json([
                'status'    => false,
            ]);
        }
    }




    /*======================================================= */
    //customer shipping address from sell cart (pos)
    public function customerShippingAddress(Request $request)
    {
        //return $request; 
        $this->requestAllCartData = $request;
        //$this->cartName = sellCreateCartShippingAddressSessionName_hh();
        //$this->shippingAddressStoreInSession();
        return response()->json([
            'status'    => true,
        ]);
    } //customer shipping address from sell cart (pos)
    /*======================================================= */

    // store sell and quotation data from sell cart (pos)
    public function storeDataFromSellEditCart(Request $request)
    {   
        DB::beginTransaction();
        try {
             
            $edit_sell_cart_invoice_id = session()->get('edit_sell_cart_invoice_id_for_edit');
            $sellEditCart = EditSellCartInvoice::find($edit_sell_cart_invoice_id);
            

            //$this->sellCreateFormData = $request;
            $currentSellingType = $request->sell_type;
            $beforeSellingType = session()->get('sell_type_for_edit');
            if($beforeSellingType == 2 && $currentSellingType == 1){
                //create new sell from quotation
                $sellType = 1;
                $this->quotationToSellStoreDataFromSellEditCart($sellType,$sellEditCart,$request);
            }
            else if($beforeSellingType == 2 && $currentSellingType == 2){
                //'quotation update';
                //$sellType = session()->get('sell_type_for_edit');
                $sellType = 2;
                $this->updateSellRelatedDataFromSellEditCart($sellType,$sellEditCart->sell_invoice_no);
            }
            else if($beforeSellingType == 1 && $currentSellingType == 1){
                //sell update
                //$this->updateSellRelatedDataFromSellEditCart($sellType,$sellEditCart->sell_invoice_no);
                return 'sell update';
            }
        
            //$sellNormalPrintUrl = route('admin.sell.edit.regular.normal.print.from.sell.edit.list',$sellLastId); 
            DB::commit();
            $redirectUrl = NULL;
            if($sellType == 1){
                $redirectUrl = route('admin.sell.regular.sell.index');
            }else{
                $redirectUrl = route('admin.sell.regular.quotation.index');
            }
            session()->put('sellInvoice_for_edit',NULL);
            session()->put('total_edit_count_for_edit',NULL);
            session()->put('total_return_count_for_edit',NULL);
            session()->put('total_delivered_count_for_edit',NULL);
    
            session()->put('sell_invoice_id_for_edit',NULL);
            session()->put('edit_sell_cart_invoice_id_for_edit',NULL);
            session()->put('sell_type_for_edit',NULL);
            
            $list = view('backend.sell.pos.ajax-response.landing.added-to-cart.list',compact('sellEditCart'))->render();
            return response()->json([
                'status'    => true,
                'list'      => $list,
                'redirectUrl'      => $redirectUrl,
                'normalPrintUrl'=> '',//$sellNormalPrintUrl,
                'message'   => "Action submited successfully!",
                'type'      => 'success'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
            return response()->json([
                'status'    => true,
                'message'   => "Something went wrong",
                'type'      => 'error'
            ]);
        } /* catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        } */
    }
    /*======================================================= */
    
}
