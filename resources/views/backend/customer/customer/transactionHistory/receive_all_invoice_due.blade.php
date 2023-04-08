
            <div class="modal-dialog modal-xl">
                <form action="{{route('admin.customer.store.receiving.all.invoice.dues')}}" method="POST" class="storeReceieAllInvoiceDueData modal-content">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">
                            Customer 
                            <span class="font-weight-light">Invoice Due Receive</span>
                            <br />
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                    </div>

                                        
                    <div class="submit_loader" style="display:none;">
                        <img src="{{asset('loading-img/loading1.gif')}}" style="position:absolute;margin:auto;top:0;left:0;right:0;bottom:0;height:60px;background-color:#ffff;border-radius:50%;display:block;" alt="">
                    </div>


                    <div class="modal-body" style="margin-left:30px;margin-right:30px;">
                        <input type="hidden" name="customer_id" value="{{$customer->id}}">
                        
                        <div class="table-responsive" style="margin-bottom:2%;">
                            <table id="example1" class="table table-bordered table-hover">
                                <tr>
                                    <th colspan="3" style="width:50%;">
                                        <strong style="margin-right:5px;">Customer Name</strong>
                                        <strong style="margin-right:5px;">:</strong>
                                        {{$customer->name}}
                                    </th>
                                    <th colspan="3" style="text-align: right;width:30%;">
                                        Mobile No
                                    </th>
                                    <th colspan="2"  style="width:20%;">
                                        {{$customer->phone}}
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="8">
                                        Address
                                        <strong style="margin-left:4px;margin-right:4px;">:</strong>
                                        {{$customer->address}}
                                    </th>
                                </tr>
                            </table>
                        </div>
                        
                        <div class="table-responsive" style="margin-bottom:2%;">
                            <table id="example1" class="table table-bordered table-hover">
                                <tr>
                                    <th colspan="3" style="color:red;">
                                        <strong style="margin-right:5px;">Total Due Amount</strong>
                                        <strong style="margin-right:5px;">:</strong>
                                        {{$sellInvoices->sum('total_due_amount')}}
                                    </th>
                                    <th colspan="3" style="text-align: right;">
                                        <div style="display:flex;width:100%;">
                                            <div style="float:left;width:30%;text-align:right">
                                               <label for="">Overall Less</label>
                                            </div>
                                            <div style="float:left;width:20%;">
                                                <input type="checkbox" name="" class="form-control" style="box-shadow:none;">
                                            </div>

                                            <div style="float:left;width:50%;">
                                                <input type="text" name="totalCustomerGivenAmount" class="form-control totalCustomerGivenAmount inputFieldValidatedOnlyNumeric" style="background-color:#f5e4e4;font-weight:bold;">
                                            </div>
                                        </div>
                                    </th>
                                    <th colspan="1" style="text-align: right;">
                                        Total Paying Amount
                                    </th>
                                    <th colspan="1">
                                        <input type="text" name="totalCustomerGivenAmount" class="form-control totalCustomerGivenAmount inputFieldValidatedOnlyNumeric" style="background-color:#f1f1f1;font-weight:bold;">
                                    </th>
                                </tr>
                            </table>
                        </div>
                        
                        <div class="form-group row">
                            <div class="col-md-12 processing" style="text-align: center;display: none;">
                                <span style="color:saddlebrown;">
                                    <span class="spinner-border spinner-border-sm" role="status"></span>Processing
                                </span>
                            </div>
                        </div>
                        
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-hover">
                                <thead style="background-color:#f1f1f1;">
                                    <tr>
                                        <th style="width:3%;">Sl.</th>
                                        <th style="width:10%;">Invoice No</th>
                                        <th style="width:5%;"><small>Invoice Profit</small></th>
                                        <th style="width:10%;">Sell Date</th>
                                        <th style="width:10%;">Bill Amount</th>
                                        <th style="width:10%;">Paid Amount</th>
                                        <th style="width:10%;">Due Amount</th>
                                        <th style="width:15%;">Paying Amount</th>
                                        <th style="width:7%;">
                                            <input class="checkAllReceiveIvoiceDue form-control" type="checkbox" value="all" name="check_all" style="box-shadow:none;">
                                        </th>
                                        <th style="width:10%;"><small>Overall Lsee</small></th>
                                        <th style="width:5%;">
                                            <input class="checkAllReceiveIvoiceDue form-control" type="checkbox" value="all" name="check_all" style="box-shadow:none;">
                                        </th>
                                        <th style="width:5%;"><small>Current Due</small></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sellInvoices as  $index => $item)
                                        <tr>
                                            <th style="width:3%;text-align:center;">{{$index + (1)}}</th>
                                            <th style="width:10%;text-align:center;">{{$item->invoice_no}}</th>
                                            <th style="width:5%;text-align:center;">{{$item->total_profit}}</th>
                                            <th style="width:10%;text-align:center;">{{date('d-m-Y',strtotime($item->sell_date))}}</th>
                                            <th style="width:10%;text-align:center;">{{$item->total_payable_amount}}</th>
                                            <th style="width:10%;text-align:center;color:green;">{{$item->total_paid_amount}}</th>
                                            <th style="width:10%;text-align:center;color:red;">
                                                @if ($item->total_due_amount > 0)
                                                <span style="color:red;">{{$item->total_due_amount}}</span>
                                                @else 
                                                <span style="color:green;">{{$item->total_due_amount}}</span>
                                                @endif
                                            </th>
                                            <!---paying amount-->
                                            <th style="width:15%;text-align:center;">
                                                @if ($item->total_due_amount > 0)
                                                <input type="text" name="single_invoice_paying_amount_{{$item->id}}" class="form-control inputFieldValidatedOnlyNumeric singleAndCustomReceivingAmount_{{$item->id}} singleAndCustomReceivingAmount" data-id="{{$item->id}}" style="background-color:#ffff;">
                                                @else
                                                <input type="text" disabled class="form-control" style="background-color:green;">
                                                @endif
                                            </th>
                                            <!---paying amount end-->
                                            
                                            <!---paying check-->
                                            <th style="width:7%;text-align:center;">
                                                <input type="hidden" name="single_invoice_due_amount_{{$item->id}}" class="singleInvoiceDueAmount singleInvoiceDueAmount_{{$item->id}}" value="{{$item->total_due_amount}}" data-id="{{$item->id}}">
                                                @if ($item->total_due_amount > 0)
                                                <input type="hidden" value="{{$item->id}}" name="sell_invoice_id">
                                                <input class="checkSingleReceiveIvoiceDue form-control checkSingleReceiveIvoiceDue_{{$item->id}}" type="checkbox"  name="checked_id[]" value="{{ $item->id }}" id="{{$item->id}}" style="box-shadow:none;">
                                                    @else
                                                    <input class="form-control" type="checkbox" disabled style="box-shadow:none;" >
                                                @endif
                                            </th>

                                            <!---overall Less amount-->
                                            <th style="width:10%;">
                                                <input type="text" name="overall_less_amount_{{$item->id}}" class="form-control inputFieldValidatedOnlyNumeric overallSingleInvoiceLessAmount_{{$item->id}} overallSingleInvoiceLessAmount" data-id="{{$item->id}}" style="background-color:#ffff;">
                                            </th>
                                            
                                            <!---overall check-->
                                            <th style="width:5%;text-align:center;">
                                                <input type="hidden" name="single_invoice_due_amount_{{$item->id}}" class="singleInvoiceDueAmount singleInvoiceDueAmount_{{$item->id}}" value="{{$item->total_due_amount}}" data-id="{{$item->id}}">
                                                @if ($item->total_due_amount > 0)
                                                <input type="hidden" value="{{$item->id}}" name="sell_invoice_id">
                                                <input class="checkSingleReceiveIvoiceDue form-control checkSingleReceiveIvoiceDue_{{$item->id}}" type="checkbox"  name="checked_id[]" value="{{ $item->id }}" id="{{$item->id}}" style="box-shadow:none;">
                                                    @else
                                                    <input class="form-control" type="checkbox" disabled style="box-shadow:none;" >
                                                @endif
                                            </th>

                                            <!---Current Due-->
                                            <th style="width:5%;text-align:center;color:red;">
                                                <span class="currentDueAmount currentDueAmount_{{$item->id}}">0</span>
                                            </th>
                                            <!---Current Due end-->
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot style="background-color:#f1f1f1;">
                                    <tr>
                                        <th colspan="2" style="text-align:right">Total</th>
                                        <th style="text-align:center;">00</th>
                                        <th style="text-align:center;">00</th>
                                        <th style="text-align:center;">00</th>
                                        <th style="text-align:center;">00</th>
                                        <th style="text-align:center;">00</th>
                                        <th style="text-align:center;">00</th>
                                        <th style="text-align:center;"></th>
                                        <th style="text-align:center;">0</th>
                                        <th style="text-align:center;"></th>
                                        <th style="text-align:center;">0</th>
                                    </tr>          
                                </tfoot>
                            </table>
                        </div>
                        
                       
                    <div class="modal-footer" style="padding-right: 0px;">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-info submitButton" disabled>
                            Receive Payment
                            <img class="submit_processing_gif" src="{{asset('loading-img/loading1.gif')}}" alt="" style="margin-left:auto;margin-right:auto;height:20px;display:none;background-color:#ffff;border-radius: 50%;">
                        </button>
                    </div>
                </form>
            </div>





