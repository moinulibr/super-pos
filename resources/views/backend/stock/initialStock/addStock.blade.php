<form action="{{route('admin.product.stock.store.initial.stock')}}" method="POST" class="storeInitialProductStock">
    @csrf
    <div class="card" style="margin-top:0px;margin-bottom:0px;padding: 10px;">
        <div class="container-fliud">
            <div class="wrapper row">
                <div class="preview col-md-6"> 
                    <div class="" style="margin-bottom:20px;">
                    <div class="tab-pane active" id="pic-1">
                            @if($product->photo)
                            <img src="{{ asset(productImageViewLocation_hh().$product->id.".".$product->photo) }}" width="100%" height="250;" style="padding:4px;border:1px solid #c7bbbb;background-color:#fbf8f8;border-radius:4px" />
                                @else
                                <img src="{{ asset(defaultProductImageUrl_hh()) }}" width="100%" height="250;" style="padding:4px;border:1px solid #c7bbbb;background-color:#fbf8f8;border-radius:4px" />
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
                    <h6 class="price"><span style="color:blue"> Barcode </span> : <span style="background-color:#e3e3f3;padding:2px;">{{$product->bacode}}</span></h6>
                    <h6 class="price"><span style="color:blue">Total Initial Stock </span> : <span style="background-color:#e3e3f3;padding:2px;">{{$product->initial_stock}}</span></h6>
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
            


            <div style="border-bottom:1px solid rgba(24,28,33,.06);padding:5px;margin-bottom:10px;"></div>
                
            <div class="form-group">
                <div class="col-md-12 processing" style="text-align:center;display:none;">
                    <span style="color:saddlebrown;">
                        <span class="spinner-border spinner-border-sm" role="status"></span>Processing...
                    </span>
                </div>
            </div>

            <div class="wrapper row">
                
                <div class="col-md-12">
                   <input type="hidden" name="product_id" value="{{$product->id}}">
                   <input type="hidden" name="unit_id" value="{{$product->unit_id}}">
                    @include('backend.stock.initialStock.stockForm')
                    
                </div>
            </div><!---wrapper row--->


        </div><!---container-fliud---->
        
    </div>

</form>