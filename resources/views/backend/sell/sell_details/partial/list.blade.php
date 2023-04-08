<form action="{{route('admin.sell.regular.sell.list.pdf.download')}}" method="POST">
    @csrf
    <div class="row" style="margin-bottom:1% ">
        <div class="col-md-6">
            <button class="PrintPdfDownload btn btn-sm btn-success" style="display: none;"  name="action_type" value="pdf_download"> <i class="fa fa-download"></i> PDF Download</button>
            <button class="PrintPdfDownload btn btn-sm btn-info" style="display: none;" name="action_type" value="normal_print"> <i class="fa fa-print"></i> Print</button>
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
                    <th style="width:;text-align:center;">Date</th>
                    <th style="width:;text-align:center;">Invoice No</th>
                    <th style="width:;text-align:center;">Customer </th>
                    <th style="width:;text-align:center;">Type</th>
                    <th style="width:;text-align:center;">Total Item </th>
                    <th style="width:;text-align:center;">Bill Amount </th>
                    <th style="width:;text-align:center;">Less Amount </th>
                    <th style="width:;text-align:center;">Cash Amount </th>
                    <th style="width:;text-align:center;">Due Amount </th>
                    <th style="width:;text-align:center;">Total Amount</th>
                    <th style="width:;text-align:center;">Payment Status </th>
                    <th style="width:;text-align:center;">Created By </th>
                    <th style="width:;text-align:center;">Reference By</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalPayableAmount = 0;
                    $totalPaidAmount = 0;
                    $totalDueAmount = 0;
                    $totalLessAmount = 0;
                    $totalInvoiceAmount = 0;
                    $totalItem = 0;
                @endphp
                @foreach ($datas as $index => $item)
                    <tr style="@if($item->sell_type == 2) background-color:#f1efef;color:#120606; @endif">
                        <th style="padding-top: 2px;padding-bottom: 2px;">
                            <input class="check_single_class form-control" type="checkbox"  name="checked_id[]" value="{{ $item->id }}" class="check_single_class" id="{{$item->id}}" style="box-shadow:none;">
                        </th>
                        <th scope="row">
                            {{$index + 1}}
                        </th>
                        
                        <td style="width:3%;">
                            <div class="btn-group btnGroupForMoreAction">
                                <button type="button" class="btn btn-sm btn-info" data-toggle="dropdown" aria-expanded="true">
                                    <i class="fas fa-cog"></i>
                                </button>
                                <div class="dropdown-menu " x-placement="top-start" style="position: absolute; will-change: top, left; top: -183px; left: 0px;background-color:#f0f4f5">
                                    @if ($item->sell_type == 1)
                                        <a class="dropdown-item singleSellView" data-id="{{$item->id}}" style="cursor: pointer">View</a>
                                        <a class="dropdown-item print" target="_blank" data-id="{{$item->id}}" href="{{route('admin.sell.regular.normal.print.from.sell.list',$item->id)}}" style="cursor: pointer">Print</a>
                                        <a class="dropdown-item print" target="_blank" data-id="{{$item->id}}" href="{{route('admin.sell.regular.pos.print.from.sell.list',$item->id)}}" style="cursor: pointer">Print (POS)</a>
                                        <a class="dropdown-item singleSellInvoiceWiseDelivery" data-id="{{$item->id}}" style="cursor: pointer">Delivery Product</a>
                                        <a class="dropdown-item singleSellInvoiceProfitLossView" data-id="{{$item->id}}" style="cursor: pointer">View Profit/Loss</a>
                                        <a class="dropdown-item singleSellInvoiceReturnModalView" data-id="{{$item->id}}" style="cursor: pointer">Return Product</a>
                                        <a class="dropdown-item singleSellInvoiceReceivePaymentModalView" data-id="{{$item->id}}" style="cursor: pointer;">Make Payment</a> {{--singleSellInvoiceReceivePaymentModalView  cursor: not-allowed !important;--}}
                                        <a class="dropdown-item singleViewSellInvoiceWisePaymentDetailsModal" data-id="{{$item->id}}" style="cursor: pointer">View Payment</a>
                                        <a class="dropdown-item singleViewSellInvoiceOverallDiscountDetailsModal" data-id="{{$item->id}}" style="cursor: pointer">Make Overall Less</a>
                                        <a class="dropdown-item" style="cursor: pointer" href="{{route('admin.sell.regular.sell.update.sell.calculation',$item->id)}}">Update Invoice</a>
                                        {{-- @if ($item->total_return_count == 0 && $item->total_delivered_count == 0 &&  $item->overall_discount_amount == 0)
                                            <a class="dropdown-item" data-id="{{$item->id}}" href="{{route('admin.sell.edit.product.cart.list')}}?seid={{\Crypt::encrypt($item->id)}}" style="cursor: pointer">Edit Sell</a>
                                            @else
                                            <a class="dropdown-item" data-id="{{$item->id}}" href="#" style="cursor: not-allowed !important;">Edit Sell</a>
                                        @endif --}}
                                    @elseif ($item->sell_type == 2)
                                        <a class="dropdown-item singleSellView singleSellQuotationView" data-id="{{$item->id}}" style="cursor: pointer">View</a>
                                        <a class="dropdown-item print" target="_blank" href="{{route('admin.sell.regular.normal.print.from.sell.quotation.list',$item->id)}}" data-id="{{$item->id}}" style="cursor: pointer">Print</a>
                                        <a class="dropdown-item singleSellInvoiceProfitLossView singleSellQuotationInvoiceProfitLossView" data-id="{{$item->id}}" style="cursor: pointer">View Profit/Loss</a>
                                        <a class="dropdown-item" data-id="{{$item->id}}" href="{{route('admin.sell.edit.product.cart.list')}}?seid={{\Crypt::encrypt($item->id)}}" style="cursor: pointer">Edit / Sell</a>
                                    @endif
                            </div>
                        </td>
                        <td style="text-align:center;">
                            <a  class="singleSellView" data-id="{{$item->id}}" style="cursor: pointer">
                                {{date('d-m-Y',strtotime($item->created_at))}}
                            </a>
                        </td>
                        <td style="text-align:center;"> 
                            <a class="singleSellView" data-id="{{$item->id}}" style="cursor: pointer">
                               {{$item->invoice_no}}
                            </a> 
                        </td>
                        <td style="text-align:center;">
                            @if ($item->sell_type == 1)
                            <strong style="{{paymentStatusLabelColor_hp($item->total_payable_amount,$item->total_paid_amount)}}">
                                {{$item->customer?$item->customer->name:NULL}}
                                @elseif ($item->sell_type == 2)
                                <strong style="color:#387891">
                            {{$item->quotation ? $item->quotation->customer_name : NULL}}
                            @endif
                            </strong>
                        </td>
                        <td style="text-align:center;">
                            {{$item->sell_type == 1 ? 'Sell' : 'Quotation'}}
                        </td>
                        <td style="text-align:center;">{{$item->totalSellItemAfterRefund()}}</td>
                        <td style="text-align:center;">
                            {{$item->total_payable_amount}}
                        </td>
                        <td style="text-align:center;">
                            {{$item->total_discount_amount}}
                        </td> 
                        <td style="text-align:center;">{{$item->total_paid_amount}}</td>
                        <td style="text-align:center;">
                            {{$item->total_due_amount}}
                        </td>
                      
                        <td style="text-align:center;">
                            {{$item->total_invoice_amount}}
                        </td>
                        
                        <td style="text-align:center;">
                            {{paymentStatus_hh($item->total_payable_amount,$item->total_paid_amount)}}
                        </td>

                        <td style="text-align:center;">{{$item->createdBy ? $item->createdBy->name : NULL}}</td>
                        <td style="text-align:center;">{{$item->referenceBy?$item->referenceBy->name:NULL}}</td>
                        
                        @php
                            if($item->sell_type == 1){
                                $totalPayableAmount += $item->total_payable_amount;
                                $totalPaidAmount += $item->total_paid_amount;
                                $totalDueAmount += $item->total_due_amount;
                                $totalLessAmount += $item->total_discount_amount;
                                $totalInvoiceAmount += $item->total_invoice_amount;
                                $totalItem += $item->totalSellItemAfterRefund();
                            }
                        @endphp
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="7" style="text-align:right">Total</th>
                    <th style="text-align:center;">{{$totalItem}}</th>
                    <th style="text-align:center;">{{number_format($totalPayableAmount,2,'.','')}}</th>
                    <th style="text-align:center;">{{number_format($totalLessAmount,2,'.','')}}</th>
                    <th style="text-align:center;">{{number_format($totalPaidAmount,2,'.','')}}</th>
                    <th style="text-align:center;">{{number_format($totalDueAmount,2,'.','')}}</th>
                    <th style="text-align:center;">{{number_format($totalInvoiceAmount,2,'.','')}}</th>
                   
                    <td style="text-align:center;"></td>
                    <td></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
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