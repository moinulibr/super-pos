<?php

namespace App\Http\Controllers\Backend\Product;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Models\Backend\Price\Price;

//use Illuminate\Support\Facades\Validator;

use App\Models\Backend\Stock\Stock;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Traits\Permission\Permission;
use App\Models\Backend\Product\Product;
use App\Models\Backend\Supplier\Supplier;
use App\Models\Backend\Price\ProductPrice;
use App\Models\Backend\Stock\ProductStock;
use App\Models\Backend\Warehouse\Warehouse;
use App\Models\Backend\ProductAttribute\Unit;
use App\Models\Backend\ProductAttribute\Brand;
use App\Models\Backend\ProductAttribute\Color;
use App\Models\Backend\Supplier\SupplierGroup;
use App\Models\Backend\ProductAttribute\Category;
use App\Models\Backend\ProductAttribute\SubCategory;
use App\Traits\Backend\Product\Logical\ProductTrait;
use App\Models\Backend\ProductAttribute\ProductGrade;
use App\Traits\Backend\Product\Request\ProductValidationTrait;

class ProductController extends Controller
{
    use ProductValidationTrait;
    use ProductTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $data['page_no'] = 1;
        $data['categories'] = Category::latest()->get();
        $data['brands'] = Brand::latest()->get();
        $data['groups'] = SupplierGroup::latest()->get();
        $data['suppliers'] = Supplier::latest()->get();
        $data['colors'] = Color::latest()->get();
        $data['datas']  = Product::latest()->paginate(50);
        $data['prices'] = Price::where('status',1)
                        ->where('branch_id',authBranch_hh())
                        ->whereNull('deleted_at')
                        ->orderBy('custom_serial','ASC')
                        ->get();
        return view('backend.product.product.index',$data);
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     */
    public function productListByAjaxResponse(Request $request)
    {
        $data['categories'] = Category::latest()->get();
        $data['brands'] = Brand::latest()->get();
        $data['groups'] = SupplierGroup::latest()->get();
        $data['suppliers'] = Supplier::latest()->get();
        $data['colors'] = Color::latest()->get();
        $data['prices'] = Price::where('status',1)
                        ->where('branch_id',authBranch_hh())
                        ->whereNull('deleted_at')
                        ->orderBy('custom_serial','ASC')
                        ->get();

        $status     = $request->status ?? NULL;
        $pagination = $request->pagination ?? 50;
        $search     = $request->search ?? NULL;
        $supplier_id = $request->supplier_id ?? NULL;
        $supplier_group_id = $request->supplier_group_id ?? NULL;
        $brand_id = $request->brand_id ?? NULL;
        $category_id = $request->category_id ?? NULL;
        $date_from = Carbon::parse($request->input('date_from'));
        $date_to = Carbon::parse($request->input('date_to') ?? date("Y-m-d h:i:s",strtotime(date("Y-m-d h:i:s")."-21 day")));
        
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
            $html = view('backend.product.product.ajax.list_ajax_response',$data)->render();
            return response()->json([
                'status' => true,
                'html' => $html
            ]);
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['categories']     = Category::latest()->get();
        $data['brands']         = Brand::latest()->get();
        $data['colors']         = Color::latest()->get();
        $data['suppliers']      = Supplier::latest()->get();
        $data['productGrades']  = ProductGrade::latest()->get();
        $data['supplierGroups'] = SupplierGroup::latest()->get();
        $data['units']          = Unit::latest()->get();

        $data['warehouses']     = Warehouse::latest()->get();

        $data['prices']         = Price::where('status',1)
                                ->where('branch_id',authBranch_hh())
                                ->whereNull('deleted_at')
                                ->orderBy('custom_serial','ASC')
                                ->get();

        return view('backend.product.product.create',$data);
        return view('backend.sell.pos.single_product',$data);
        //return view('backend.product.product.old_create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validators = $this->productValidationWhenStoreProduct($request->all());
        if($validators['status'] == true)
        {
            return response()->json([
                'status' => 'errors',
                'error'=> $validators['errors']->getMessageBag()->toArray()
            ]);
        }
        DB::beginTransaction();
        try {
            $this->productStore($request->all());
            DB::commit();
        } catch (\Exception  $e) {
            DB::rollback();
            throw $e;
            return response()->json([
                'status' => 'exception',
                'type' => 'warning',
                'message' => "Product added successfully",
                'message'=>  $e->getMessage()
            ]);
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
        return response()->json([
            'status' => true,
            'type' => 'success',
            'message' => "Product added successfully"
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Backend\Product\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product,Request $request)
    {
        $data['product'] = Product::findOrFail($request->id);
        return view('backend.product.product.show',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Backend\Product\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product,Request $request)
    {
        $data['categories']     = Category::latest()->get();
        $data['brands']         = Brand::latest()->get();
        $data['colors']         = Color::latest()->get();
        $data['suppliers']      = Supplier::latest()->get();
        $data['productGrades']  = ProductGrade::latest()->get();
        $data['supplierGroups'] = SupplierGroup::latest()->get();
        $data['units']          = Unit::latest()->get();
        $data['warehouses']     = Warehouse::latest()->get();
        $data['prices']         = Price::where('status',1)
                                ->where('branch_id',authBranch_hh())
                                ->whereNull('deleted_at')
                                ->orderBy('custom_serial','ASC')
                                ->get();
        $data['product'] = Product::findOrFail($request->id);
        return view('backend.product.product.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Backend\Product\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $validators = $this->productValidationWhenUpdateProduct($request->all(),$request->id);
        if($validators['status'] == true)
        {
            return response()->json([
                'status' => 'errors',
                'error'=> $validators['errors']->getMessageBag()->toArray()
            ]);
        }

        DB::beginTransaction();
        try {
            $this->productUpdate($request->all());
            DB::commit();
        } catch (\Exception  $e) {
            DB::rollback();
            throw $e;
            return response()->json([
                'status' => 'exception',
                'type' => 'warning',
                'message' => "Product added successfully",
                'message'=>  $e->getMessage()
            ]);
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
        return response()->json([
            'status' => true,
            'type' => 'success',
            'message' => "Product updated successfully"
        ]);
    }


    
    public function delete(Product $product, Request $request)
    {
        //for solf delete, photo not deleting
        //$item = Product::findOrFail($request->id)->delete();
        /* if($item->photo){
            $this->productDelete($request->id,$item->photo);
        }
        $item->delete(); */
        
        //$item = Product::findOrFail($request->id)->delete();
        return response()->json([
            'status' => true,
            'type' => 'success',
            'message' => "Product Deleted successfully"
        ]);
    } 
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Backend\Product\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
