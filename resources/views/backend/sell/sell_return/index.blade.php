<style>
    .modal-full {
            min-width: 90%;
            margin: 0;
            margin-left:5%;
        }

        .modal-full .modal-content {
            min-height: 100vh;
        }
</style>
  
<div class="submit_loader" style="display:none;">
    <!--<img src="https://ebaskat-admin.s3.eu-west-1.amazonaws.com/public/assets/images/xloading.gif" alt="">-->
</div>


<div class="modal-dialog modal-lg modal-full" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="exampleModalLabel">
                <strong style="mergin-right:20px;">Sell Details (Invoice No.: {{$data->invoice_no}})</strong>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </h4>
        </div>
        <form method="POST" action="{{route('admin.sell.product.return.invoice.wise.quantity.store')}}" class="storeReturnDataFromReturnOption">
            @csrf
            <div class="modal-body">

                <input type="hidden" name="customer_id" value="{{$data->customer_id}}">
                <div style="margin-top: -60px;">
                    <div>
                        <div class="mb-2 text-right my-5">
                            <label>
                                <strong>Date : </strong>  <span style="font-size:14px;"> {{date('d-m-Y h:i:s a',strtotime($data->created_at))}}</span>
                            </label>
                        </div>
                    </div>
                    <div class="row" style="border-bottom: 1px solid #cdc7c7;">
                        <div class="col-md-4">
                            <div class="mb-2">
                                <label>
                                    <strong>Invoice No: </strong> <span style="font-size:14px;"> {{$data->invoice_no}}</span>
                                </label>
                            </div>
                           
                            <div class="mb-2">
                                <label>
                                    <strong>Payment Status: </strong>
                                    {{paymentStatus_hh($data->totalInvoicePayableAmountAfterRefundAfterDiscount(),$data->total_paid_amount)}}
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-2">
                                <label>
                                    <strong>Customer Name : </strong> <span style="font-size:14px;"> {{$data->customer ? $data->customer->name  :NULL}}</span>
                                </label>
                            </div>
                            <div class="mb-2">
                                <label>
                                    <strong>Address : </strong>
                                    {{$data->customer ? $data->customer->address  :NULL}}
                                </label>
                                <br/>
                                <label>
                                    <strong>Mobile : </strong>
                                    {{$data->customer ? $data->customer->phone  :NULL}}
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-2">
                                <label>
                                    <strong>Shipping :</strong>
                                    {{ $data->shipping_id ? $data->shipping? $data->shipping->address : NUll : NULL }}
                                    {{ $data->shipping_id ? $data->shipping ? " (". $data->shipping->phone .")" : NUll : NULL }}
                                </label>
                            </div>
                            <div class="mb-2">
                                <label>
                                    <strong>Reference By: </strong>
                                    {{$data->referenceBy ? $data->referenceBy->name:NULL}}
                                    {{$data->referenceBy ? " (". $data->referenceBy->phone .")" :NULL}}
                                </label>
                            </div>
                            <div class="mb-2">
                                <label>
                                    <strong>Receiver Details: </strong>
                                    {{$data->receiver_details}}
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <div class="alert alert-success alert_success_message_div" role="alert" style="display:none;z-index:99999999;padding: 5px;"> 
                                <p class="success_message_text"  style="text-align: center"></p>
                            </div>
                            <div class="alert alert-danger alert_danger_message_div" role="alert" style="display:none;z-index:99999999;padding: 5px;"> 
                                <p class="danger_message_text" style="text-align: center"></p>
                            </div>
                        </div>
                        <div class="col-md-3"></div>
                    </div>
                    <br/>
                    <!-----Receive From and Received related information--->
                    <div class="row" style="margin-top:5px;padding-bottom:20px;">
                        <div class="col-md-12" style="padding-bottom:20px;">
                            <h3 style="text-align: center;">
                                <strong style="border-bottom: 1px solid gray;padding-bottom: 3px;">    
                                Sell Return 
                                </strong>
                            </h3>
                        </div>
                        <div class="col-md-6">
                            <label for="">Receive Note</label>
                            <textarea name="receive_note"  class="form-control" cols="10" rows="1"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="">Return Note</label>
                            <textarea name="return_note"  class="form-control" cols="10" rows="1"></textarea>
                        </div>
                    </div>
                    <!-----Receive From and Received related information--->
                    <!-----Start of Products--->
                    <div class="row">
                        <div class="col-md-12">
                            <h4>Products: </h4>
                            <div class="return_product_related_response_here">
                            
                            </div>
                        </div>
                    </div>
                    <!-----End of Products--->
                   
                    <div class="table-responsive">
                        <table id="example1" class="table">
                            <tr>
                                <td style="width: 86%;text-align:right;border: none;">Subtotal</td>
                                <th style="width: 10%;text-align: center;background-color:#f3f3f3;color:#666565;">
                                    <strong class="subtotal_before_discount_for_return">00.00</strong>
                                    <input type="hidden" name="return_invoice_subtotal_before_discount" class="subtotal_before_discount_for_return_val">
                                </th>
                                <td style="width:4%;border:none;background-color:#f3f3f3;color:#666565;"></td>
                            </tr>
                        </table>
                    </div>

                    <!---discount section-->
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="">Discount Type</label>
                                    <select class="form-control return_invoice_discount_type" name="return_invoice_discount_type">
                                        <option value="">None</option>
                                        <option value="percentage">Percentage</option>
                                        <option value="fixed">Fixed</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="">Discount Value</label>
                                    <input type="text" class="form-control return_invoice_discount_amount" name="return_invoice_discount_amount">
                                </div>
                                <div class="col-md-4">
                                    <label for="">Discount Amount</label>
                                    <input type="text" disabled class="form-control return_invoice_total_discount_amount">
                                    <input type="hidden" name="return_invoice_total_discount_amount" class="return_invoice_total_discount_amount_val">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="table-responsive">
                                <table id="example1" class="table">
                                    <tr>
                                        <td style="width:30%;text-align:right;border: none;">Total Amount</td>
                                        <th colspan="2" style="text-align: center;background-color:#f3f3f3;color:#666565;border: none;">
                                            <strong style="padding-left:40px;font-size:18px;" class="total_return_amount_after_discount">00.00</strong>
                                            <input type="hidden" name="return_invoice_total_amount_after_discount" class="total_return_amount_after_discount_val">
                                        </th>
                                    </tr>
                                    <tr>
                                        <td  colspan="3" style="text-align: right;border: none;">
                                            <small><i>(Total return amount after discount/less amount)</i></small>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!---discount section-->

                    <!---invoice payment, due, total amount--->
                    <div class="row">
                        <div class="col-md-5"></div>
                        <div class="col-md-7">
                            <div class="table">
                                <table class="table table-bordered table striped">
                                    <tr>
                                        <th colspan="3" style="text-align:center;background-color:#220909;color:#fff;">
                                            Invoice Payment
                                        </th>
                                    </tr>
                                    <tr style="text-align:center;background-color:#666565;color:#fff;">
                                        <th>Payable Amount : {{$data->total_payable_amount}}</th>
                                        <th style="text-align:center;background-color:#1b441b;color:#fff;">Paid Amount : {{$data->total_paid_amount}}</th>
                                        <th style="text-align:center;background-color:#7e2727;color:#fff;">Due Amount : {{$data->total_due_amount}}</th>
                                        
                                        <input type="hidden" class="total_invoice_payable_amount" name="" value="{{$data->total_payable_amount}}">
                                        <input type="hidden" class="total_invoice_paid_amount" name="" value="{{$data->total_paid_amount}}">
                                        <input type="hidden" class="total_invoice_due_amount" name="" value="{{$data->total_due_amount}}">
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!---invoice payment, due, total amount--->
                    
                    <br/>

                    <!------Start of Payment Info --->
                    <!--<div class="sell_return_payment_options_render"></div>-->
                    <div class="row">
                        <div class="col-md-8"></div>
                        <div class="col-md-4">
                            <!-----Invoice Payment--->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table">
                                        <table class="table table-bordered table striped">
                                            <tr>
                                                <th style="text-align:right;background-color:#524343;color:#fff;">Total Return Amount</th>
                                                <th style="text-align:left;background-color:#524343;color:#fff;">
                                                    <strong style="margin-right:5px;">:</strong>
                                                    <strong class="total_return_amount_for_customer_history">00</strong>
                                                    <input type="hidden" class="total_return_amount_for_customer_history_val" name="total_return_amount_for_customer_history_value">
                                                </th>
                                            </tr>
                                            <tr>
                                                <th style="text-align:right;background-color:#0e0808;color:#fff;">Paying Return Amount</th>
                                                <th  style="text-align:left;background-color:#100000;color:#fff;">
                                                    <strong style="margin-right:5px;">:</strong>
                                                    <strong class="total_sell_return_invoice_payable_amount" style="font-size:16px;">00</strong>
                                                    <input type="hidden" name="total_sell_return_invoice_payable_amount" class="total_sell_return_invoice_payable_amount_val">
                                                </th>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!------Start of Payment Info --->
                    <br/>
                    

                </div><!------margin-top: -60px; --->
               

            </div><!-----modal-body--->

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-danger" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success submitButton_for_sell_return" style="padding:7px 20px;">
                    <strong><b>Submit</b></strong> <img class="submit_processing_gif" src="{{asset('loading-img/loading1.gif')}}" alt="" style="margin-left:auto;margin-right:auto;height:20px;display:none;background-color:#ffff;border-radius: 50%;">
                </button>
            </div>
        </form>
    </div>
</div>
