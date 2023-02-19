<form action="{{route('admin.sell.regular.sell.list.pdf.download')}}" method="POST">
    @csrf
    <div class="row" style="margin-bottom:1% ">
        <div class="col-md-6">
            <button class="pdfDownload btn btn-sm btn-success" style="display: none;"> <i class="fa fa-download"></i> PDF Download</button>
        </div>
        <div class="col-md-6"></div>
    </div>
    <div class="table-responsive table-responsive-index-page">
        <table class="table table-bordered mb-0">
            <thead>
                <tr>
                    <th style="width:3%;">
                        <input class="check_all_class " type="checkbox" value="all" name="check_all" style="box-shadow:none;">             
                    </th>
                    <th  style="width:3%;">#</th>
                    <th style="width:5%;">Action</th>
                    <th style="width:;text-align:center;">Payment Status </th>
                    <th style="width:;text-align:center;">Invoice No</th>
                    <th style="width:;text-align:center;">Date(Time) </th>
                    <th style="width:;text-align:center;">Customer </th>
                    <th style="width:;text-align:center;">Payable Amount </th>
                    <th style="width:;text-align:center;">Paid Amount </th>
                    <th style="width:;text-align:center;">Due Amount </th>
                    <th style="width:;text-align:center;">Less Amount </th>
                    <th style="width:;text-align:center;"><small>Total Invoice Amount</small></th>
                    <th style="width:;text-align:center;">Created By </th>
                    <th style="width:;text-align:center;">Total Item </th>
                    <th style="width:;text-align:center;">Reference By</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalSellAmount = 0;
                    $totalPaidAmount = 0;
                    $totalDueAmount = 0;
                    $totalLessAmount = 0;
                    $totalItem = 0;
                @endphp
                @foreach ($datas as $index => $item)
                    <tr>
                        <th>
                            <input class="check_single_class form-control" type="checkbox"  name="checked_id[]" value="{{ $item->id }}" class="check_single_class" id="{{$item->id}}" style="box-shadow:none;">
                        </th>
                        <th scope="row">
                            {{$index + 1}}
                        </th>
                        
                        <td style="width:3%;">
                            <div class="btn-group btnGroupForMoreAction">
                                <button type="button" class="btn btn-sm" data-toggle="dropdown" aria-expanded="true">
                                    <i class="fas fa-cog"></i>
                                </button>
                                <div class="dropdown-menu " x-placement="top-start" style="position: absolute; will-change: top, left; top: -183px; left: 0px;">
                                    <a class="dropdown-item singleSellView" data-id="{{$item->id}}" style="cursor: pointer">View</a>
                                    <a class="dropdown-item print" target="_blank" data-id="{{$item->id}}" href="{{route('admin.sell.regular.normal.print.from.sell.list',$item->id)}}" style="cursor: pointer">Print</a>
                                    <a class="dropdown-item print" target="_blank" data-id="{{$item->id}}" href="{{route('admin.sell.regular.pos.print.from.sell.list',$item->id)}}" style="cursor: pointer">Print (POS)</a>
                                    <a class="dropdown-item singleSellInvoiceWiseDelivery" data-id="{{$item->id}}" style="cursor: pointer">Delivery Product</a>
                                    <a class="dropdown-item singleSellInvoiceProfitLossView" data-id="{{$item->id}}" style="cursor: pointer">View Profit/Loss</a>
                                    <a class="dropdown-item singleSellInvoiceReturnModalView" data-id="{{$item->id}}" style="cursor: pointer">Return Product</a>
                                    <a class="dropdown-item singleSellInvoiceReceivePaymentModalView" data-id="{{$item->id}}" style="cursor: pointer;">Make Payment</a> {{--singleSellInvoiceReceivePaymentModalView  cursor: not-allowed !important;--}}
                                    <a class="dropdown-item singleViewSellInvoiceWisePaymentDetailsModal" data-id="{{$item->id}}" style="cursor: pointer">View Payment</a>
                                    <a class="dropdown-item singleViewSellInvoiceOverallAjdustmentDiscountDetailsModal" data-id="{{$item->id}}" style="cursor: pointer">Overall Less (Adjustment)</a>
                                    <a class="dropdown-item" style="cursor: pointer" href="{{route('admin.sell.regular.sell.update.sell.calculation',$item->id)}}">Update Invoice</a>
                                    {{-- @if ($item->total_return_count == 0 && $item->total_delivered_count == 0 &&  $item->overall_discount_amount == 0)
                                        <a class="dropdown-item" data-id="{{$item->id}}" href="{{route('admin.sell.edit.product.cart.list')}}?seid={{\Crypt::encrypt($item->id)}}" style="cursor: pointer">Edit Sell</a>
                                        @else
                                        <a class="dropdown-item" data-id="{{$item->id}}" href="#" style="cursor: not-allowed !important;">Edit Sell</a>
                                    @endif --}}
                            </div>
                        </td>
                        <td style="text-align:center;">
                            {{paymentStatus_hh($item->total_payable_amount,$item->total_paid_amount)}}
                            {{-- {{paymentStatus_hh($item->totalInvoicePayableAmountAfterRefundAfterDiscount(),$item->total_paid_amount)}} --}}
                        </td>
                        <td style="text-align:center;"> 
                            <a  class="singleSellView" data-id="{{$item->id}}" style="cursor: pointer">
                            {{$item->invoice_no}} 
                        </a> 
                        </td>
                        <td style="text-align:center;">
                            <a  class="singleSellView" data-id="{{$item->id}}" style="cursor: pointer">
                                {{date('d-m-Y h:i:s A',strtotime($item->created_at))}}
                            </a>
                        </td>
                        <td style="text-align:center;">{{$item->customer?$item->customer->name:NULL}}</td>
                        <td style="text-align:center;">
                            {{$item->total_payable_amount}}
                            {{-- {{$item->totalInvoicePayableAmountAfterRefundAfterDiscount()}} --}}
                        </td>
                        <td style="text-align:center;">{{$item->total_paid_amount}}</td>
                        <td style="text-align:center;">
                            {{$item->total_due_amount}}
                            {{-- {{$item->totalInvoicePayableAmountAfterRefundAfterDiscount() - $item->total_paid_amount}} --}}
                        </td>
                        <td style="text-align:center;">
                            {{$item->total_discount_amount}}
                            {{-- {{$item->totalInvoiceDiscountAmountWithAdjustment()}} --}}
                        </td> 
                        <td style="text-align:center;">
                            {{$item->total_invoice_amount}}
                        </td>
                        
                        <td style="text-align:center;">{{$item->createdBy ? $item->createdBy->name : NULL}}</td>
                        <td style="text-align:center;">{{$item->totalSellItemAfterRefund()}}</td>
                        <td style="text-align:center;">{{$item->referenceBy?$item->referenceBy->name:NULL}}</td>
                        @php
                            $totalSellAmount += $item->total_payable_amount;
                            /* $totalSellAmount += $item->totalInvoicePayableAmountAfterRefundAfterDiscount(); */
                            $totalPaidAmount += $item->total_paid_amount;
                            $totalDueAmount += $item->total_due_amount;
                            $totalLessAmount += $item->total_discount_amount;
                            /* $totalLessAmount += $item->totalInvoiceDiscountAmountWithAdjustment(); */
                            $totalItem += $item->totalSellItemAfterRefund();
                        @endphp
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="7" style="text-align:right">Total</th>
                    <th style="text-align:center;">{{number_format($totalSellAmount,2,'.','')}}</th>
                    <th style="text-align:center;">{{number_format($totalPaidAmount,2,'.','')}}</th>
                    <th style="text-align:center;">{{number_format($totalDueAmount,2,'.','')}}</th>
                    <th style="text-align:center;">{{number_format($totalLessAmount,2,'.','')}}</th>
                    <td style="text-align:center;"></td>
                    <td style="text-align:center;"></td>
                    <th style="text-align:center;">{{$totalItem}}</th>
                    <td></td>
                </tr>
            </tfoot>
        </table>
        {{-- {{$datas->links()}} --}}
    </div>
    <input type="hidden" class="page_no" name="page" value="{{$page_no}}">
                        
    <div class="row">
        <div class="col-md-3">
            Showing {{$datas->count()}} from {{ $datas->firstItem() ?? 0 }} to {{ $datas->lastItem() }} of {{ $datas->total() }}  entries 
        </div>
        <div class="col-md-9">
            <div style="float: right">
            {{ $datas->links() }}
            </div>
        </div>
    </div>
</form>