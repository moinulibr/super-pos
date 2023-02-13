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

        <div class="modal-body">


            <div style="margin-top: -80px;">

               
                <div>
                    <div class="mb-2 text-right my-5">
                        <label>
                            <strong>Date : </strong>  <span style="font-size:14px;"> {{date('d-m-Y h:i:s a',strtotime($data->created_at))}}</span>
                        </label>
                    </div>
                </div>
                

                <div class="row">
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
                                <strong>Customer Name : </strong> 
                                <span style="font-size:14px;">
                                    @if ($data->sell_type == 1)
                                        {{$data->customer ? $data->customer->name  :NULL}}
                                        @elseif($data->sell_type == 2)
                                        {{ $data->quotation ? $data->quotation->customer_name : "N/L" }}
                                    @endif
                                </span>
                            </label>
                        </div>
                        <div class="mb-2">
                            <label>
                                <strong>Mobile : </strong>
                                @if ($data->sell_type == 1)
                                    {{$data->customer ? $data->customer->phone  :NULL}}
                                    @elseif($data->sell_type == 2)
                                    {{ $data->quotation ? $data->quotation->phone : "N/L" }}
                                @endif
                            </label>
                            <br/>
                            <label>
                                <strong>Address : </strong>
                                {{$data->customer ? $data->customer->address  :NULL}}
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

                <br/>
                <!-----Start of Products--->
                <div class="row">
                    <div class="col-md-12">
                        <h4>Products: </h4>
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>{{productCustomCodeLabel_hh()}}</th>
                                        <th style="width:30%;">Product</th>
                                        <th><small>Delivered qty</small></th>
                                        <th><small>Unit</small></th>
                                        <th><small>Sell Quantity</small></th>
                                        <th>Sell Price</th>
                                        <th style="text-align:left;">SubTotal</th>
                                        <th style="background-color:#c19696;color:#ffff;"><small>Return Qty</small></th>
                                        <th style="background-color:#c19696;color:#ffff;"><small>Return Amount</small></th>
                                        <th style="text-align:left;background-color:#7ab57a;color:#ffff;">Line Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data->sellProducts ? $data->sellProducts : NULL  as $item)
                                    <tr>
                                        @php
                                            $cats = json_decode($item->cart,true);
                                        @endphp
                                        <td> {{$item->custom_code}}</td>
                                        <td style="width:30%;">
                                            @if (array_key_exists('productName',$cats))
                                                {{$cats['productName']}}
                                                @else
                                                NULL
                                            @endif
                                        </td>
                                        <td>
                                            {{$item->delivered_qty}}
                                        </td>
                                        <td>
                                            @if (array_key_exists('unitName',$cats))
                                                <small>{{$cats['unitName']}}</small>
                                                @else
                                                NULL
                                            @endif
                                        </td>
                                        <td style="text-align: center">
                                            {{$item->total_sell_qty}}
                                        </td>
                                        <td style="text-align: center;">
                                            {{$item->sold_price}}
                                        </td>
                                        <td style="text-align: center;">
                                            {{ number_format(($item->sold_price * $item->total_sell_qty),2,'.', '')}} <!--like total_selling_amount-->
                                            {{-- {{ number_format(($item->sold_price * $item->total_quantity),2,'.', '')}} --}}
                                        </td>
                                        {{-- <td style="text-align: center;">
                                            {{$item->total_selling_amount}}   
                                        </td> --}}
                                        <td style="text-align: center;background-color:#c19696;color:#ffff;">
                                            {{$item->total_refunded_qty}} 
                                        </td>
                                        <td style="text-align: center;background-color:#c19696;color:#ffff;">
                                            {{$item->total_refunded_amount}} 
                                        </td>
                                        <td style="text-align: center;background-color:#7ab57a;color:#ffff;">
                                            {{$item->total_sold_amount}}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-----End of Products--->

                    <br/><br/>

                <!------Start of Payment Info --->
                <div class="row">
                    <div class="col-md-12"> <h4>Payment Info: </h4> </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th><small>Payment Invoice No</small></th>
                                        <th>Amount</th>
                                        <th>Credit/Debit</th>
                                        <th>Payment Method</th>
                                        <th>Payment Note</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data->invoicePayment ?? [] as $payment)
                                    <tr class="@if (getCdfLabelBySingleCdfId_hh($payment->cdf_type_id) == "Credit") text-info @else text-danger @endif">
                                        <td>{{date('d-m-Y',strtotime($payment->payment_date))}}</td>
                                        <td>{{$payment->payment_invoice_no}}</td>
                                        <td>{{number_format($payment->payment_amount,2,'.','')}}</td>
                                        <td>
                                            {{getCdfLabelBySingleCdfId_hh($payment->cdf_type_id)}}
                                        </td>
                                        <td>{{$payment->paymentMethods?$payment->paymentMethods->name:NULL}}</td>
                                        <td>
                                            <small style="font-size:11px;">
                                            {{ $payment->accountPaymentInvoice?$payment->accountPaymentInvoice->payment_note:"--" }}
                                            </small>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped table-hover">
                                <tbody>
                                    <tr>
                                        <td colspan="2">
                                            <strong>Sub Total</strong>
                                        </td>
                                        <td><small></small></td>
                                        <td style="text-align:right;">
                                            <span style="font-size:14px;"> {{$data->subtotal}}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <strong>({{ $data->vat_amount }}%) Vat</strong>
                                        </td>
                                        <td>(+)</td>
                                        <td style="text-align:right;">
                                            {{ $data->total_vat }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <strong>Shipping</strong>
                                        </td>
                                        <td></td>
                                        <td style="text-align:right;">
                                            <span style="font-size:14px;"> {{$data->shipping_cost}}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <strong>Other cost</strong>
                                        </td>
                                        <td></td>
                                        <td style="text-align:right;">
                                            <span style="font-size:14px;"> {{$data->others_cost}}</span>
                                        </td>
                                    </tr>
                                     <tr>
                                        <td colspan="2">
                                            <strong>Round off</strong>
                                        </td>
                                        <td>(+/-)</td>
                                        <td style="text-align:right;">
                                            <span style="font-size:14px;"> {{$data->round_amount}}</span>
                                        </td>
                                    </tr> 
                                    
                                    <tr>
                                        <td colspan="2">
                                            <strong>Total Payable  Amount<small> (Before Less)</small></strong>
                                        </td>
                                        <td><small style="color:rgb(113, 22, 22)"> (before return)</small></td>
                                        <td style="text-align:right;">
                                            {{$data->totalInvoicePayableAmountBeforeReturnWithoutDiscount()}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" >
                                            <strong>Less Amount</strong>
                                        </td>
                                        <td>(-)</td>
                                        <td style="text-align:right;">
                                            <span style="font-size:14px;">{{$data->total_discount}}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <strong>Total Payable Amount  (After Less)</small></strong>
                                        </td>
                                        <td><small style="color:rgb(113, 22, 22)"> (before return)</small></td>
                                        <td style="text-align:right;">
                                            {{$data->totalInvoicePayableAmountBeforeRefundAfterDiscount()}}
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td colspan="2"  style="background-color: #c19696;color:#ffff;">
                                            <strong>Return Amount</strong>
                                        </td>
                                        <td></td>
                                        <td style="text-align:right;background-color: #c19696;color:#ffff;">
                                            {{$data->total_refunded_amount}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="background-color:#7ab57a;color:#ffff;">
                                            <strong>Total Payable Amount</strong>
                                        </td>
                                        <td><small style="color:green">(after return)</small></td>
                                        <td style="text-align:right;right;background-color:#7ab57a;color:#ffff;">
                                            {{$data->totalInvoicePayableAmountAfterRefundAfterDiscount()}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <strong>Total Paid</strong>
                                        </td>
                                        <td></td>
                                        <td style="text-align:right;">
                                            {{$data->total_paid_amount}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <strong>Total Due</strong>
                                        </td>
                                        <td></td>
                                        <td style="text-align:right;">
                                            {{$data->total_due_amount}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <strong>Total Invoice Overall Less</strong>
                                        </td>
                                        <td>(Adjustment)</td>
                                        <td style="text-align:right;">
                                            {{$data->adjustment_amount}}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <!------Start of Payment Info --->

            </div>


        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-danger" data-dismiss="modal">Cancel</button>
            @if ($data->sell_type == 1)
            <a class="btn btn-primary print" target="_blank" href="{{route('admin.sell.regular.normal.print.from.sell.list',$data->id)}}" style="cursor: pointer">Print</a>
                @elseif($data->sell_type == 2)
                <a class="btn btn-primary print" target="_blank" href="{{route('admin.sell.regular.normal.print.from.sell.quotation.list',$data->id)}}" style="cursor: pointer">Print</a>
            @endif
        </div>
    </div>
</div>
