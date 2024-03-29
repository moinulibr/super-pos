{{-- <link rel="stylesheet" href="{{asset('custom_css/backend')}}/only_for_product_show_modal.css">--}}

<div class="modal-dialog modal-lg">
    <div  class=" modal-content">

        <div class="modal-header">
            <h5 class="modal-title">
                Product  
                <span class="font-weight-light">Information</span>
                <br />
                
                {{-- <small class="text-muted">Add New Reference</small> --}}
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
        </div>
        <div class="modal-body">

            

                <div class="card" style="margin-top:0px;margin-bottom:0px;padding: 10px;">
                    <div class="container-fliud">
                        <div class="wrapper row">
                            <div class="preview col-md-6"> 
                                <div class="" style="margin-bottom:20px;">
                                  <div class="tab-pane active" id="pic-1">
                                        {{-- @if(Storage::disk('public')->exists("storage/backend/product/product/{$item->id}.",$item->photo)) --}}
                                        @if($product->photo)
                                        <img src="{{ asset(productImageViewLocation_hh().$product->id.".".$product->photo) }}" width="100%" height="195;" style="padding:4px;border:1px solid #c7bbbb;background-color:#fbf8f8;border-radius:4px" />
                                            @else
                                            <img src="{{ asset(defaultProductImageUrl_hh()) }}" width="100%" height="195;" style="padding:4px;border:1px solid #c7bbbb;background-color:#fbf8f8;border-radius:4px" />
                                        @endif
                                    </div>
                                </div>
                            </div><!---col-6-->
                            <div class="details col-md-6">
                                <h5 class="product-title">{{$product->name}}</h5>
                                <div style="border-bottom:1px solid rgba(24,28,33,.06);padding:5px;margin-bottom:10px;"></div>
                                
                                <h6 class="price"><span style="color:orange">  {{productCustomCodeLabel_hh()}} </span> : <span style="background-color:#e3e3f3;padding:2px;">{{ $product->custom_code }}</span></h6>
                                <h6 class="price"><span style="color:blue"> Company Code </span> : <span style="background-color:#e3e3f3;padding:2px;">{{$product->company_code}}</span></h6>
                                <h6 class="price"><span style="color:green"> SKU </span> : <span style="background-color:#e3e3f3;padding:2px;">{{$product->sku}}</span></h6>
                                <h6 class="price"><span style="color:blue"> Stock </span> : <span style="background-color:#e3e3f3;padding:2px;">{{$product->total_product_stock}}</span></h6>
                                <h6 class="price"><span style="color:#286e2d"> Status </span> : 
                                    <span style="background-color:#e3e3f3;padding:2px;">
                                        @if (!$product->deleted_at)
                                            <span class="badge badge-success">Active</span>
                                            @else
                                            <span class="badge badge-danger">Inactive</span>
                                        @endif    
                                    </span>
                                </h6>
                            </div><!---col-6-->
                        </div><!---wrapper row--->
                        

                        <div class="wrapper row">
                            <div class="col-md-12">
                                <div>
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <input type="hidden" name="product_id" value="{{$product->id}}">
                                                <th  style="font-size:16px;background-color: darkgray;color: floralwhite;border-bottom-color:#f1e7e7;">
                                                    Stock
                                                </th>
                                                <th style="font-size:16px;background-color: #c1b8b8;color:yellow;border-bottom-color:#f1e7e7;">
                                                    Quantity
                                                </th>
                                                @foreach ($product->priceNORWhereStatusIsActive() as $ppric) 
                                                    <td style="font-size: 12px;">{{$ppric->label}}</td>
                                                    <input type="hidden" name="prices[]" value="{{$ppric->id}}">
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($product->productStockNORWhereStatusIsActive() as $productStock)    
                                                <tr>
                                                    <th style="font-size:16px;background-color: darkgray;color: floralwhite;border-bottom-color:#f1e7e7;">
                                                        {{$productStock->label}}
                                                    </th>
                                                    <th style="font-size:16px;background-color: #c1b8b8;color:yellow;border-bottom-color:#f1e7e7;">
                                                        {{$productStock->available_base_stock}}
                                                    </th>
                                                    @foreach ($productStock->productStockWiseProductPrices() as $pSPPrice) 
                                                        <td>
                                                            {{$pSPPrice->price}}
                                                        </td>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>  
                        </div><!---wrapper row--->



                        <div style="border-bottom:1px solid rgba(24,28,33,.06);padding:5px;margin-bottom:10px;"></div>
                            
                        <div class="wrapper row">
                            <div class="col-md-6">
                                <div>
                                    <table class="table" style="border:none;border-right:1px solid rgba(24,28,33,.06)">
                                        <thead>
                                            <tr>
                                                <th style="width:20%;border:none;">
                                                    {{productCustomCodeLabel_hh()}}
                                                </th>
                                                <td style="width:1%;border:none;">:</td>
                                                <th style="border:none;">
                                                    {{$product->custom_code }}
                                                </th>
                                            </tr>
                                            <tr>
                                                <th style="width:20%;border:none;">
                                                    Company Code
                                                </th>
                                                <td style="width:1%;border:none;">:</td>
                                                <th style="border:none;">
                                                    {{$product->company_code }}
                                                </th>
                                            </tr>
                                           
                                            <tr>
                                                <th style="width:20%;border:none;">
                                                    SKU
                                                </th>
                                                <td style="width:1%;border:none;">:</td>
                                                <th style="border:none;">
                                                    {{$product->sku }}
                                                </th>
                                            </tr>
                                            <tr>
                                                <th style="width:20%;border:none;">
                                                    Created By
                                                </th>
                                                <td style="width:1%;border:none;">:</td>
                                                <th style="border:none;">
                                                    {{$product->createdBy?$product->createdBy->name:NULL }}
                                                </th>
                                            </tr>
                                            <tr>
                                                <th style="width:20%;border:none;">
                                                    Status
                                                </th>
                                                <td style="width:1%;border:none;">:</td>
                                                <th style="border:none;">
                                                    @if (!$product->deleted_at)
                                                        <span class="badge badge-success">Active</span>
                                                        @else
                                                        <span class="badge badge-danger">Inactive</span>
                                                    @endif
                                                </th>
                                            </tr>
                                            <tr>
                                                <th style="width:20%;border:none;">
                                                    Initial Stock
                                                </th>
                                                <td style="width:1%;border:none;">:</td>
                                                <th style="border:none;">
                                                    {{$product->initial_stock }}
                                                </th>
                                            </tr> 
                                            <tr>
                                                <th style="width:20%;border:none;">
                                                    Alert Quantity
                                                </th>
                                                <td style="width:1%;border:none;">:</td>
                                                <th style="border:none;">
                                                    {{$product->alert_stock }}
                                                </th>
                                            </tr> 
                                            <tr>
                                                <th style="width:20%;border:none;">
                                                    Available Stock
                                                </th>
                                                <td style="width:1%;border:none;">:</td>
                                                <th style="border:none;">
                                                    {{ $product->total_product_stock }}
                                                    {{-- {{ unitView_hh($product->unit_id,$product->available_stock)  }} --}}
                                                </th>
                                            </tr>
                                            <tr>
                                                <th style="width:20%;border:none;">
                                                    <small>Stock Ready For Delivery</small>
                                                </th>
                                                <td style="width:1%;border:none;">:</td>
                                                <th style="border:none;">
                                                    {{ $product->total_product_stock_ready_for_delivery }}
                                                </th>
                                            </tr>
                                            
                                        </thead>
                                    </table>
                                </div> 
                            </div>
                            <div class="col-md-6">
                                <div>
                                    <table class="table" style="border:none;">
                                        <thead>
                                            <tr>
                                                <th style="width:20%;border:none;">
                                                    Supplier
                                                </th>
                                                <td style="width:1%;border:none;">:</td>
                                                <th style="border:none;">
                                                    {{$product->suppliers ? $product->suppliers->name : null }}
                                                </th>
                                            </tr>
                                            <tr>
                                                <th style="width:20%;border:none;">
                                                    Category
                                                </th>
                                                <td style="width:1%;border:none;">:</td>
                                                <th style="border:none;">
                                                    {{$product->categories ? $product->categories->name : null }}
                                                </th>
                                            </tr>
                                           
                                            <tr>
                                                <th style="width:20%;border:none;">
                                                    Sub-category
                                                </th>
                                                <td style="width:1%;border:none;">:</td>
                                                <th style="border:none;">
                                                    {{$product->subCategories ? $product->subCategories->name : 'None' }}
                                                </th>
                                            </tr>
                                           
                                           
                                            <tr>
                                                <th style="width:20%;border:none;">
                                                    Color
                                                </th>
                                                <td style="width:1%;border:none;">:</td>
                                                <th style="border:none;">
                                                    {{$product->colors ? $product->colors->name : 'None' }}
                                                </th>
                                            </tr>
                                            
                                            <tr>
                                                <th style="width:20%;border:none;">
                                                    Grade
                                                </th>
                                                <td style="width:1%;border:none;">:</td>
                                                <th style="border:none;">
                                                    {{$product->productGrades ? $product->productGrades->name : null }}
                                                </th>
                                            </tr>
                                            <tr>
                                                <th style="width:20%;border:none;">
                                                    Unit
                                                </th>
                                                <td style="width:1%;border:none;">:</td>
                                                <th style="border:none;">
                                                    {{$product->units ? $product->units->full_name : null }}
                                                </th>
                                            </tr>
                                            <tr>
                                                <th style="width:20%;border:none;">
                                                    Brand
                                                </th>
                                                <td style="width:1%;border:none;">:</td>
                                                <th style="border:none;">
                                                    {{$product->brands ? $product->brands->name : null }}
                                                </th>
                                            </tr>
                                            <tr>
                                                <th style="width:20%;border:none;">
                                                    Warehouse
                                                </th>
                                                <td style="width:1%;border:none;">:</td>
                                                <th style="border:none;">
                                                    {{$product->warehouses ? $product->warehouses->name : 'Default Warehouse' }}
                                                </th>
                                            </tr>
                                            <tr>
                                                <th style="width:20%;border:none;" colspan="3">
                                                    Rack/Sefl : {{$product->warehouseRacks ? $product->warehouseRacks->name : "Default Rack/Self" }}
                                                </th>
                                            </tr>
                                        </thead>
                                    </table>

                                </div>
                            </div>
                        </div><!---wrapper row--->


                        <div style="border-bottom:1px solid rgba(24,28,33,.06);padding:5px;margin-bottom:10px;"></div>
                            

                     
                        <div class="wrapper row" style="margin-bottom:20px;">
                            <div class="col-md-12">
                                <strong style="border-bottom:1px solid gray;padding-bottom:5px;">Description</strong><br/>
                                <p class="product-description" style="margin-top:5px;">
                                    {{$product->description}}
                                </p>
                            </div>
                        </div><!---wrapper row--->

                       
                        <div class="wrapper row">
                            <div class="col-md-12">
                                
                                <div>
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th colspan="7" style="text-align:center">Stock History</th>
                                            </tr>
                                            <tr>
                                                <th style="">
                                                    Stock
                                                </th>
                                                <th style="">
                                                    Quantity
                                                </th>
                                                <th>Module</th>                                            
                                                <th><small>Module Invoice</small></th>                                            
                                                <th>Created Time</th>                                            
                                                <th>Changing Time</th>                                            
                                                <th>Created By</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($stockHistories as $stockHistory)    
                                                <tr>
                                                    <th style="">
                                                        {{$stockHistory->stockLabel ? $stockHistory->stockLabel->label : NULL}}
                                                    </th>
                                                    <th style="">
                                                        {{$stockHistory->stock}}
                                                    </th>
                                                    <td> 
                                                        <strong style="{{$stockHistory->stock_changing_sign == '+' ? 'color:green' : 'color:red;'}}">
                                                            {{$stockHistory->stock_changing_sign}}
                                                        </strong>
                                                        @if (($stockHistory->stockChangingType ? $stockHistory->stockChangingType->id : 0) > 1)
                                                        {{$stockHistory->stockChangingType ? $stockHistory->stockChangingType->label_name : NULL}}
                                                        @else
                                                        <label style="color:red">
                                                            {{$stockHistory->stockChangingType ? $stockHistory->stockChangingType->label_name : NULL}}
                                                        </label>
                                                        @endif
                                                    </td>
                                                    <td>{{$stockHistory->main_module_invoice_no}}</td>
                                                    <td>
                                                        @if ($stockHistory->main_module_invoice_created_date) 
                                                        {{date('d-m-Y',strtotime($stockHistory->main_module_invoice_created_date))}}
                                                        @endif
                                                    </td>
                                                    <td>{{date('d-m-Y',strtotime($stockHistory->created_at))}}</td>
                                                    <td>{{$stockHistory->createdBY ? $stockHistory->createdBY->name : NULL}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>  
                        </div><!---wrapper row--->


                    </div><!---container-fliud---->
                </div>
                <!---card---->



        </div>
        
     
        
        
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>