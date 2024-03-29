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


            <div style="margin-top: -60px;">
                <div>
                    <div class="mb-2 text-right my-5">
                        <label>
                            <strong>Date : </strong>  <span style="font-size:14px;"> {{date('d-m-Y h:i:s a',strtotime($data->created_at))}}</span>
                        </label>
                    </div>
                </div>

                <div class="row" style="margin:-5px 150px 10px 150px;">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped table-hover">
                                <tbody>
                                    <tr>
                                        <th colspan="4" style="text-align: center;">
                                            Invoice profit / loss
                                        </th>
                                    </tr>
                                    <tr>
                                        <th  style="width: 25%;">
                                            <strong>({{ $data->vat_amount }}%) Vat</strong>
                                        </th>
                                        <th style="width: 25%;"> {{ $data->total_vat }}</th>
                                        <th style="background-color: #3a743a;color:#ffff;width: 25%;text-align:right;">Total Sell Amount</th>
                                        <th style="background-color: #3a743a;color:#ffff;text-align:right;width: 25%;">
                                            <span style="font-size:14px;"> {{$data->subtotal}}</span>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th  style="width: 25%;">
                                            <strong>Shipping</strong>
                                        </th>
                                        <th style="width: 25%;">
                                            <span style="font-size:14px;"> {{$data->shipping_cost}}</span>
                                        </th>
                                        <th style="background-color: #324632;color:#ffff;width: 25%;text-align:right;">Total Purchase Amount</th>
                                        <th style="background-color: #324632;color:#ffff;text-align:right;width: 25%;">
                                            <span style="font-size:14px;"> {{$data->total_purchase_amount}}</span>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th  style="width: 25%;">
                                             <strong>Other cost</strong>
                                        </th>
                                        <th style="width: 25%;">  
                                            <span style="font-size:14px;"> {{$data->others_cost}}</span>
                                        </th>
                                        <th style="background-color: #c7d5c7;color:#000000;width: 25%;text-align:right;">Total Less Amount</th>
                                        <th style="background-color: #c7d5c7;color:#000000;text-align:right;width: 25%;">
                                            <span style="font-size:14px;"> {{$data->total_discount}}</span>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th  style="width: 25%;">
                                             <strong>Round off</strong>
                                        </th>
                                        <th style="width: 25%;">
                                            <span style="font-size:14px;"> {{$data->round_amount}}</span>
                                        </th>
                                        <th style="width: 25%;text-align:right;background-color: #5bcf5b;color:#ffff;">Profit <small>From Product</small></th>
                                        <th style="text-align:right;width: 25%;background-color: #5bcf5b;color:#ffff;">
                                            <span style="font-size:14px;"> {{$data->total_profit_from_product}}</span>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th  style="width: 25%;">
                                             <strong>Overall Less</strong>
                                        </th>
                                        <th style="width: 25%;">
                                            <span style="font-size:14px;"> {{$data->overall_discount_amount}}</span>
                                        </th>
                                        <th style="width: 25%;text-align:right;background-color: green;color:#ffff;">Net Profit/Loss</th>
                                        <th style="text-align:right;width: 25%;background-color: green;color:#ffff;">
                                            <span style="font-size:14px;"> {{$data->totalInvoiceProfit()}}</span>
                                        </th>
                                    </tr>   

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <hr>
                <br/>


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
                                {{-- {{paymentStatus_hh($data->totalInvoicePayableAmountAfterRefundAfterDiscount(),$data->total_paid_amount)}} --}}
                                {{paymentStatus_hp($data->sell_type,$data->payment_status)}}
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
                                        <th style="width:40%;">Product</th>
                                        <th><small>Quantity</small></th>
                                        <th><small>Purchase Price</small></th>
                                        <th><small>Total Purchase Price</small></th>
                                        <th><small>Sell Price</small></th>
                                        <th><small><small>Total Sell Price</small></small></th>
                                        <th><small>Less Amount</small></th>
                                        <th>SubTotal</th>
                                        <th>Profit/Loss</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $totalQty = 0;
                                        $totalPurchasePrice = 0;
                                        $totalSellPrice = 0;
                                        $totalLessAmount = 0;
                                        $totalSoldWithoutLessAmount = 0;
                                        $totalLineProfit = 0;
                                    @endphp
                                    @foreach ($data->sellProducts ? $data->sellProducts : NULL  as $item)
                                    <tr>
                                        @php
                                            $cats = json_decode($item->cart,true);
                                        @endphp
                                        <td> {{$item->custom_code}}</td>
                                        <td>
                                            @if (array_key_exists('productName',$cats))
                                                {{$cats['productName']}}
                                                @else
                                                NULL
                                            @endif
                                        </td>
                                        <td style="text-align: center">
                                            {{$item->total_quantity}}
                                            @php
                                                $totalQty += $item->total_quantity;
                                            @endphp
                                            {{-- @if (array_key_exists('unitName',$cats))
                                            <small>{{$cats['unitName']}}</small>
                                            @else
                                            NULL
                                            @endif --}}
                                        </td>
                                        <td>
                                            {{  number_format(( $item->total_quantity > 0 ? ($item->total_purchase_amount / $item->total_quantity) : $item->total_purchase_price),2,'.', '') }}
                                        </td>
                                        <td>
                                            @php
                                                 $totalPurchasePrice += $item->total_purchase_amount ;
                                            @endphp
                                            {{ $item->total_purchase_amount }}
                                        </td>
                                        <td>
                                            {{$item->sold_price}}
                                        </td>
                                        <td>
                                            @php
                                                $totalSellPrice += number_format(($item->sold_price * $item->total_quantity),2,'.', '');
                                            @endphp
                                            {{ number_format(($item->sold_price * $item->total_quantity),2,'.', '')}}
                                        </td>
                                        <td>
                                            @php
                                                $totalLessAmount += $item->total_discount;
                                            @endphp
                                            {{ $item->total_discount}}
                                        </td>
                                        <td>
                                            @php
                                                $totalSoldWithoutLessAmount += $item->total_sold_amount;
                                            @endphp
                                            {{ $item->total_profit}}   
                                        </td>
                                        <td>
                                            @php
                                            $totalLineProfit += $item->total_profit;
                                            @endphp
                                            {{ $item->total_profit}}   
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <th colspan="2" style="text-align: right;">Total</th>
                                        <th>{{$data->total_quantity}}</th>
                                        <th></th>
                                        <th>
                                            {{ number_format($totalPurchasePrice,2,'.', '') }}
                                        </th>
                                        <th></th>
                                        <th>{{ number_format($totalSellPrice,2,'.', '') }}</th>
                                        <th>{{ number_format($totalLessAmount,2,'.', '') }}</th>
                                        <th>{{ number_format($totalSoldWithoutLessAmount,2,'.', '') }}</th>
                                        <th>{{ number_format($totalLineProfit,2,'.', '') }}</th>
                                    </tr>
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
                                    <tr  class=" @if (getCdfLabelBySingleCdfId_hh($payment->cdf_type_id) == "Credit") text-info @else text-danger @endif">
                                        <td>{{date('d-m-Y',strtotime($payment->payment_date))}}</td>
                                        <td>{{$payment->payment_invoice_no}}</td>
                                        <td>{{number_format($payment->payment_amount,2,'.','')}}</td>
                                        <td>
                                            {{getCdfLabelBySingleCdfId_hh($payment->cdf_type_id)}}
                                        </td>
                                        <td>{{ $payment->paymentMethods ? $payment->paymentMethods->name : NULL }}</td>
                                        <td>
                                            <small style="font-size:11px;">
                                            {{ $payment->accountPaymentInvoice ? $payment->accountPaymentInvoice->payment_note : "--" }}
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
                                        <td></td>
                                        <td style="text-align:right;">
                                            {{$data->overall_discount_amount}}
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
           {{--  <a class="btn btn-primary print" target="_blank" href="{{route('admin.sell.regular.normal.print.from.sell.list',$data->id)}}" style="cursor: pointer">Print</a> --}}
            <button type="button" class="btn btn-secondary btn-danger" data-dismiss="modal">Cancel</button>
        </div>
    </div>
</div>
