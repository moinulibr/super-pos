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


    public function addInitialStock()
    {
        $data['stocks'] = Stock::where('status',1)
        ->where('branch_id',authBranch_hh())
        ->whereNull('deleted_at')
        ->select('id','name','label','branch_id','deleted_at')
        ->orderBy('custom_serial','ASC')
        ->get();
        $data['productId'] = 0;
        return view('backend.stock.initialStock.initial',$data);
    } 
    
    public function renderSingleProductDetial(Request $request)
    {
        $data['stocks'] = Stock::where('status',1)
        ->where('branch_id',authBranch_hh())
        ->whereNull('deleted_at')
        ->select('id','name','label','branch_id','deleted_at')
        ->orderBy('custom_serial','ASC')
        ->get();
        $data['productId'] = 0;
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
                    $data['productId'] = 1;
                    $html = view('backend.stock.initialStock.addStock',$data)->render();
                    return response()->json([
                        'status' => true,
                        'message' => 'product found',
                        'type' => 'success',
                        'html' => $html,
                        'form' => $form,
                    ]);
                }else{
                    return response()->json([
                        'status' => false,
                        'message' => 'Product not found!',
                        'type' => 'error',
                        'html' => '',
                        'form' => $form
                    ]);
                }
            } 
        }
        return response()->json([
            'status' => false,
            'message' => 'Not Searching..',
            'type' => 'error',
            'html' => '',
            'form' => $form
        ]);
    }
}
