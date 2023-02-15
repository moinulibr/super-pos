<div class="table-responsive table-responsive-index-page">
    <table class="table table-bordered mb-0">
        <thead>
            <tr>
                <th  style="width:3%;">#</th>
                <th style="width:5%;">Action</th>
                <th style="width:;">Invoice No</th>
                <th style="width:;">Date(Time) </th>
                <th style="width:;">Customer </th>
                <th style="width:;">Total Amount </th>
                <th style="width:;">Paid Amount </th>
                <th style="width:;">Due Amount </th>
                <th style="width:;">Less Amount </th>
                <th style="width:;">Payment Status </th>
                <th style="width:;">Created By </th>
                <th style="width:;">Total Item </th>
                <th style="width:;">Reference By</th>
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
                                @if ($item->total_return_count == 0 && $item->total_delivered_count == 0 &&  $item->adjustment_amount == 0)
                                    <a class="dropdown-item" data-id="{{$item->id}}" href="{{route('admin.sell.edit.product.cart.list')}}?seid={{\Crypt::encrypt($item->id)}}" style="cursor: pointer">Edit Sell</a>
                                    @else
                                    <a class="dropdown-item" data-id="{{$item->id}}" href="#" style="cursor: not-allowed !important;">Edit Sell</a>
                                @endif
                        </div>
                    </td>
                    <td> <a  class="singleSellView" data-id="{{$item->id}}" style="cursor: pointer">{{$item->invoice_no}} </a> </td>
                    <td>
                        <a  class="singleSellView" data-id="{{$item->id}}" style="cursor: pointer">
                            {{date('d-m-Y h:i:s A',strtotime($item->created_at))}}
                        </a>
                    </td>
                    <td>{{$item->customer?$item->customer->name:NULL}}</td>
                    <td>{{$item->totalInvoicePayableAmountAfterRefundAfterDiscount()}}</td>
                    <td>{{$item->total_paid_amount}}</td>
                    <td>{{$item->total_due_amount}}</td>
                    <td>{{($item->total_discount + $item->adjustment_amount)}}</td>
                    <td>{{paymentStatus_hh($item->totalInvoicePayableAmountAfterRefundAfterDiscount(),$item->total_paid_amount)}}</td>
                    <td>{{$item->createdBy ? $item->createdBy->name : NULL}}</td>
                    <td>{{$item->totalSellItemAfterRefund()}}</td>
                    <td>{{$item->referenceBy?$item->referenceBy->name:NULL}}</td>
                    @php
                        $totalSellAmount += $item->totalInvoicePayableAmountAfterRefundAfterDiscount();
                        $totalPaidAmount += $item->total_paid_amount;
                        $totalDueAmount += $item->total_due_amount;
                        $totalLessAmount += ($item->total_discount + $item->adjustment_amount);
                        $totalItem += $item->totalSellItemAfterRefund();
                    @endphp
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5" style="text-align:right">Total</th>
                <th>{{number_format($totalSellAmount,2,'.','')}}</th>
                <th>{{number_format($totalPaidAmount,2,'.','')}}</th>
                <th>{{number_format($totalDueAmount,2,'.','')}}</th>
                <th>{{number_format($totalLessAmount,2,'.','')}}</th>
                <td></td>
                <td></td>
                <th>{{$totalItem}}</th>
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