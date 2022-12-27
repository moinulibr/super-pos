<?php

namespace App\Http\Controllers\Backend\Stock;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Faker\Provider\vi_VN\Color;
use App\Models\Backend\Price\Price;
use App\Models\Backend\Stock\Stock;
use App\Http\Controllers\Controller;
use App\Models\Backend\Product\Product;
use App\Models\Backend\Supplier\Supplier;
use App\Models\Backend\Stock\ProductStock;
use App\Models\Backend\Stock\StockHistory;
use App\Models\Backend\ProductAttribute\Brand;
use App\Models\Backend\Supplier\SupplierGroup;
use App\Models\Backend\ProductAttribute\Category;

class StockController extends Controller
{

    public function index()
    {
        $data['page_no'] = 1;
        $data['categories'] = Category::latest()->get();
        $data['brands'] = Brand::latest()->get();
        $data['groups'] = SupplierGroup::latest()->get();
        $data['suppliers'] = Supplier::latest()->get();
        //$data['colors'] = Color::latest()->get();

        $data['datas']  = Product::latest()->paginate(50);
        $data['page_no'] = 1;
        $data['stocks'] = Stock::where('status',1)
                        ->where('branch_id',authBranch_hh())
                        ->whereNull('deleted_at')
                        ->select('id','name','label','branch_id','deleted_at')
                        ->orderBy('custom_serial','ASC')
                        ->get();
        return view('backend.stock.index',$data);
    }


    public function stockListByAjaxResponse(Request $request)
    {
        $data['categories'] = Category::latest()->get();
        $data['brands'] = Brand::latest()->get();
        $data['groups'] = SupplierGroup::latest()->get();
        $data['suppliers'] = Supplier::latest()->get();
        //$data['colors'] = Color::latest()->get();

        $status     = $request->status ?? NULL;
        $pagination = $request->pagination ?? 50;
        $search     = $request->search ?? NULL;
        $supplier_id = $request->supplier_id ?? NULL;
        $supplier_group_id = $request->supplier_group_id ?? NULL;
        $brand_id = $request->brand_id ?? NULL;
        $category_id = $request->category_id ?? NULL;
        $date_from = Carbon::parse($request->input('start_date'));
        $date_to = Carbon::parse($request->input('end_date') ?? date("Y-m-d h:i:s",strtotime(date("Y-m-d h:i:s")."-21 day")));
        
        $data['stocks'] = Stock::where('status',1)
                        ->where('branch_id',authBranch_hh())
                        ->whereNull('deleted_at')
                        ->select('id','name','label','branch_id','deleted_at')
                        ->orderBy('custom_serial','ASC')
                        ->get();
            
            $product  = Product::query();
            if($request->ajax())
            {
                if($request->search)
                {
                    $product->where('name','like','%'.$search.'%')
                            ->orWhere('sku','like','%'.$search.'%')
                            ->orWhere('bacode','like','%'.$search.'%')
                            ->orWhere('custom_code','like','%'.$search.'%')
                            ->orWhere('company_code','like','%'.$search.'%');
                }
                if($supplier_id)
                {
                    $product->where('supplier_id', $supplier_id);
                }
                if($supplier_group_id)
                {
                    $product->where('supplier_group_id', $supplier_group_id);
                }  
                if($brand_id)
                {
                    $product->where('brand_id', $brand_id);
                }
                if($category_id)
                {
                    $product->where('category_id', $category_id);
                }               
                $data['datas']  =  $product->orderBy('custom_code', 'desc')
                                            ->latest()
                                            ->paginate($pagination);
                $data['page_no'] = $request->page ?? 1;

            $html = view('backend.stock.ajax.list_ajax_response',$data)->render();
            return response()->json([
                'status' => true,
                'html' => $html
            ]);
        }
    }



    //add initial stock 
    public function addInitialStock()
    {
        $data['stocks'] = Stock::where('status',1)
        ->where('branch_id',authBranch_hh())
        ->whereNull('deleted_at')
        ->select('id','name','label','branch_id','deleted_at')
        ->orderBy('custom_serial','ASC')
        ->get();
        return view('backend.stock.initialStock.initial',$data);
    } 
    
    //render single product details
    public function renderSingleProductDetial(Request $request)
    {
        $data['stocks'] = Stock::where('status',1)
        ->where('branch_id',authBranch_hh())
        ->whereNull('deleted_at')
        ->select('id','name','label','branch_id','deleted_at')
        ->orderBy('custom_serial','ASC')
        ->get();
        
        $form = view('backend.stock.initialStock.stockForm',$data)->render();
        $search     = $request->search ?? NULL;
        if($request->ajax())
        {
            if($request->search)
            {
                $product  = Product::where('name','like','%'.$search.'%')
                        ->orWhere('sku','like','%'.$search.'%')
                        ->orWhere('bacode','like','%'.$search.'%')
                        ->orWhere('custom_code','like','%'.$search.'%')
                        ->orWhere('company_code','like','%'.$search.'%')
                        ->first();
                if($product)
                {
                    $data['product'] = $product;
                    $html = view('backend.stock.initialStock.addStock',$data)->render();
                    if($product->initial_stock > 0)
                    {
                        return response()->json([
                            'status' => false,
                            'message' => 'Already added  initial stock of this product',
                            'type' => 'success',
                            'html' => '',
                            'form' => $form,
                            'action' => false,
                        ]);
                    }else{
                        return response()->json([
                            'status' => true,
                            'message' => 'Product found',
                            'type' => 'success',
                            'html' => $html,
                            'form' => $form,
                            'action' => true,
                        ]);
                    }
                }else{
                    return response()->json([
                        'status' => false,
                        'message' => 'Product not found!',
                        'type' => 'error',
                        'html' => '',
                        'form' => $form,
                        'action' => false,
                    ]);
                }
            } 
        }
        return response()->json([
            'status' => false,
            'message' => 'Not Searching..',
            'type' => 'error',
            'html' => '',
            'form' => $form,
            'action' => false,
        ]);
    }

    //store initial stock
    public function storeInitialStock(Request $request)
    {
        $totalInititalStock = 0;
        $totalAlertStock = 0;
        foreach($request->stock_id as $stockId)
        {
            $totalInititalStock += $request->input('quantity_stock_id_'.$stockId) ?? 0;
            $totalAlertStock += $request->input('alert_stock_id_'.$stockId) ?? 0;
            //check product stock is exist or not,
                //if not exist, then add in the product stock table 
            $podctStock = ProductStock::where('stock_id',$stockId)   
                ->where('product_id',$request->product_id)
                ->where('branch_id',authBranch_hh()) 
                ->where('status',1)
                ->first();
            if(!$podctStock)
            {
                $nps = new ProductStock();
                $nps->product_id        = $request->product_id;
                $nps->branch_id         = authBranch_hh();
                $nps->stock_id          = $stockId;
                $nps->status            = 1;
                $nps->available_base_stock = $request->input('quantity_stock_id_'.$stockId) ?? 0;
                $nps->alert_quantity = $request->input('alert_stock_id_'.$stockId) ?? 0;
                $nps->used_stock        = 0;
                $nps->used_base_stock   = 0;
                $nps->save();
                $this->storeProductStockHistoryWhenInitialStockIsAdded($stockId,$nps->id,$request->product_id, $request->input('quantity_stock_id_'.$stockId) ?? 0);
            }else{
                $podctStock->available_base_stock = $request->input('quantity_stock_id_'.$stockId) ?? 0;
                $podctStock->alert_quantity = $request->input('alert_stock_id_'.$stockId) ?? 0;
                $podctStock->save();
                $this->storeProductStockHistoryWhenInitialStockIsAdded($stockId,$podctStock->id,$request->product_id,$request->input('quantity_stock_id_'.$stockId) ?? 0);
            }
        }//end foreach

        $product = Product::select('id','initial_stock','alert_stock','available_base_stock')->where('id',$request->product_id)->first();
        if($product)
        {
            $product->initial_stock = $totalInititalStock;
            $product->alert_stock = $totalAlertStock;
            $product->available_base_stock = $totalInititalStock;
            $product->save();
        }
        return response()->json([
            'status' => true,
            'type' => 'success',
            'message' => "Initial Stock Added successfully"
        ]);
    }


    /**
     * //its from initialStockTypeIncrement trait.....
     * add stock history
     * when changing stock (product_stocks), then store in as history
     */
    private function storeProductStockHistoryWhenInitialStockIsAdded($stockId,$productStockId,$productId, $quantity)
    {   
        $stock = new StockHistory();
        $stock->stock_id                = $stockId;
        $stock->product_stock_id        = $productStockId;
        $stock->product_id              = $productId;
        $stock->stock_changing_type_id  = 1;
        $stock->stock_changing_sign     = '+';
        $stock->stock_changing_history  = json_encode(['']);
        $stock->stock                   = $quantity;
        $stock->status                  = 1;
        $stock->branch_id               = authBranch_hh();
        $stock->created_by              = authId_hh();
        $stock->save();
        return $stock;
        /* $this->product_stock_id_FSCT;//for history
        $this->stock_changing_type_id_FSCT = 1;//for history
        $this->stock_changing_sign_FSCT    = '+';//for history
        $this->stock_changing_history_FSCT = [];//for history */
    }





}
