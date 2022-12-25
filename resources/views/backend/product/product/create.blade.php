
            <div class="modal-dialog modal-xl">
                <form action="{{route('admin.product.store')}}" method="POST" class="storeProductData modal-content" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header" style="background: #d3dbd3;">
                        <h5 class="modal-title">
                            Product 
                            <span class="font-weight-light">Information</span>
                            <br />
                            {{-- <small class="text-muted">Add New Product</small> --}}
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                    </div>


              


                    <div class="modal-body "><!--modal body-->
                        
                        <div class="form-group">
                            <div class="col-md-12 processing" style="text-align:center;display:none;">
                                <span style="color:saddlebrown;">
                                    <span class="spinner-border spinner-border-sm" role="status"></span>Processing...
                                </span>
                            </div>
                        </div>
                       

                        @include('backend.product.product.partial.create_form_data')

                        
                        

                    </div>
                    <!--modal body-->
                    <div class="modal-footer"  style="background: #d3dbd3;">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        {{-- <input type="submit" class="btn btn-primary" role="status" value="Save"> --}}
                    </div>
                </form>
            </div>





