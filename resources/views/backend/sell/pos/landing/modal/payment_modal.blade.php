<div class="modal fade text-left" id="payment-popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel11" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document" >
        <div class="modal-content" style="overflow-y: auto !important">
            <form action="{{route('admin.sell.regular.pos.store.data.from.sell.cart')}}" method="POST"  class="storeDataFromSellCart">
                @csrf
                <div class="modal-header">
                    <h3 class="modal-title" id="myModalLabel11">Payment</h3>
                    <button type="button" class="close rounded-pill btn btn-sm btn-icon btn-light btn-hover-primary m-0" data-dismiss="modal" aria-label="Close">
                        <svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-x" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path
                                fill-rule="evenodd"
                                d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"
                            ></path>
                        </svg>
                    </button>
                </div>

                <div class="submit_loader" style="display:none;">
                    <img src="{{asset('loading-img/loading1.gif')}}" style="position:absolute;margin:auto;top:0;left:0;right:0;bottom:0;height:60px;background-color:#ffff;border-radius:50%;display:block;" alt="">
                </div>

                <div class="modal-body">

                    <div class="payment_data_response"></div>
                    
                    
                    

                    <input type="hidden" name="sell_type" value="1">
                    <div class="form-group row justify-content-end mb-0">
                        <div class="col-md-6 text-right">
                            <button type="button" class="btn btn-danger" data-dismiss="modal" style="padding:7px 20px;">
                                <i class="fa fa-times" aria-hidden="true"></i>
                                Close
                            </button>

                            <button type="submit" class="btn btn-primary submitButton" style="padding:7px 20px;">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                                <strong><b>Submit</b></strong> <img class="submit_processing_gif" src="{{asset('loading-img/loading1.gif')}}" alt="" style="margin-left:auto;margin-right:auto;height:20px;display:none;background-color:#ffff;border-radius: 50%;">
                            </button>
                            
                        </div>
                    </div>
                   
                </div>
            </form>
        </div>
    </div>
</div>
