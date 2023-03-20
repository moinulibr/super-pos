@extends('layouts.backend.app')
@section('page_title') Report @endsection
@push('css')
<style>
    .table-bordered {
        border: none;
    }
</style>
@endpush



<!--%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%-->
<!--%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%^^^^Content^^^^%%%%%%%%%%%%%%%%%%%%%%%%%%%%%-->
@section('content')
<!--%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%^^^^Content^^^^%%%%%%%%%%%%%%%%%%%%%%%%%%%%%-->
<!--%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%-->


    <!--**************************************-->
    <!--*********^page title content^*********-->
    <!---page_title_of_content-->    
    @push('page_title_of_content')
        <div class="breadcrumbs layout-navbar-fixed">
            <h4 class="font-weight-bold py-3 mb-0">Reference  </h4>
            <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#"><i class="feather icon-home"></i></a>
                    </li>
                    <li class="breadcrumb-item">Reference History</li>
                    <li class="breadcrumb-item active">Sell History</li>
                </ol>
            </div>
            <div class="">
                <a href="#"></a>
            </div>
        </div>
    @endpush
    <!--*********^page title content^*********-->
    <!--**************************************-->



    <!--#################################################################################-->
    <!--######################^^total content space for this page^^######################-->    
    <div  class="content_space_for_page">
    <!--######################^^total content space for this page^^######################--> 
    <!--#################################################################################-->


        <!-------status message content space for this page------> 
        <div class="status_message_in_content_space">
            @include('layouts.backend.partial.success_error_status_message')
        </div>
        <!-------status message content space for this page------> 


        

        <!--@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@-->
        <!--@@@@@@@@@@@@@@@@@@@@@@@^^^real space in content^^^@@@@@@@@@@@@@@@@@@@@@@@--> 
        <div class="real_space_in_content">
        <!-------real space in content------> 
        <!--@@@@@@@@@@@@@@@@@@@@@@@^^^real space in content^^^@@@@@@@@@@@@@@@@@@@@@@@-->     
        <!--@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@-->   
        

            <div class="card-body" style="background-color: #fff;">
                <div class="col-md-12 text-center">
                    {{--<h3 style="text-align: center;">Daily Report - Module Wise Transaction Details</h3>
                    <h4 class="text-center">Date: {{date('d-m-Y')}}</h4>
            
                     <form class="d-flex justify-content-center">
                        <input type="date" id="date_search" value="2023-01-11" name="q" class="form-control margin-right-10 w-25" placeholder="Date" />
                        <button type="submit" class="btn ms-1 btn-primary pull-left"><i class="fa fa-search"></i> Search</button>
                        <a class="btn btn-secondary ms-1" href="https://amadersanitary.com/reports/daily-report">Today</a>
                    </form> --}}
                    <br/>
                   
                </div>
                
                
                
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped table-hover">
                        <tbody>
                            <tr>
                                <th colspan="4" style="text-align: center;">
                                    <h4>Sell Summery</h4>
                                </th>
                            </tr>
                            <tr>
                                <th style="width: 25%;background-color:#5bcf5b;color:#ffff;">
                                    <strong>Total Bill Amount</strong>
                                </th>
                                <th style="width: 25%;background-color: #3a743a;color:#ffff;">
                                    {{number_format($totalPayableAmount,2,'.','')}}
                                </th>
                                <th style="background-color:#65f565;color:black;width: 25%;text-align:right;">Total Cash Amount</th>
                                <th style="background-color: #3a743a;color:#ffff;text-align:left;width: 25%;">
                                    <span style="font-size:14px;">{{number_format($totalPaidAmount,2,'.','')}}</span>
                                </th>
                            </tr>
                            <tr>
                                <th style="width: 25%;background-color:#f53e06;color:#ffff;">
                                    <strong>Total Due Amount</strong>
                                </th>
                                <th style="width: 25%;background-color: #f53e06;color:#ffff;">
                                    {{number_format($totalDueAmount,2,'.','')}}
                                </th>
                                <th style="background-color:#aa5339;color:#ffff;width: 25%;text-align:right;">Total Discount Amount</th>
                                <th style="background-color: #aa5339;color:#ffff;text-align:left;width: 25%;">
                                    <span style="font-size:14px;">{{number_format($totalDiscountAmount,2,'.','')}}</span>
                                </th>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <br/><br/><br/>
            
                <table class="table table-responsive table-bordered" style="margin-left:1%;margin-right:1%;">
                    <tbody>
                        <tr>
                            <th colspan="9" style="text-align:center;background-color:#c7d0c7;color:#420505;">
                                All Sell List
                            </th>
                        </tr>
                        <tr role="row" class="bg-whitesmoke">
                            <th>#</th>
                            <th style="width:5%;">Action</th>
                            <th>Date</th>
                            <th>Invoice No.</th>
                            <th style="background-color:#5c5c95;color:#ffff;">Bill Amount</th>
                            <th style="background-color:#448d44;color:#ffff;">Cash Amount</th>
                            <th style="background-color:#bd3939;color:#ffff;">Due Amount</th>
                            <th>Payment Status</th>
                            <th>Customer Name</th>
                        </tr>
                        @php
                            $totalSellPayableAmount = 0;
                            $totalSellPaidAmount = 0;
                            $totalSellDueAmount = 0;
                            $totalLessAmount = 0;
                            $totalItem = 0;
                        @endphp
                        @foreach ($sellInvoices as $item)
                            <tr role="row">
                                <td>{{$loop->iteration}}</td>
                                <td style="width:3%;">
                                    <div class="btn-group btnGroupForMoreAction">
                                        <button type="button" class="btn btn-sm btn-info" data-toggle="dropdown" aria-expanded="true">
                                            <i class="fas fa-cog"></i>
                                        </button>
                                        <div class="dropdown-menu " x-placement="top-start" style="position: absolute; will-change: top, left; top: -183px; left: 0px;">
                                            @if ($item->sell_type == 1)
                                                <a class="dropdown-item singleSellView" data-id="{{$item->id}}" style="cursor: pointer">View</a>
                                                <a class="dropdown-item singleSellInvoiceProfitLossView" data-id="{{$item->id}}" style="cursor: pointer">View Profit/Loss</a>
                                                <a class="dropdown-item singleViewSellInvoiceWisePaymentDetailsModal" data-id="{{$item->id}}" style="cursor: pointer">View Payment</a>
                                                {{-- <a class="dropdown-item print" target="_blank" data-id="{{$item->id}}" href="{{route('admin.sell.regular.normal.print.from.sell.list',$item->id)}}" style="cursor: pointer">Print</a>
                                                <a class="dropdown-item print" target="_blank" data-id="{{$item->id}}" href="{{route('admin.sell.regular.pos.print.from.sell.list',$item->id)}}" style="cursor: pointer">Print (POS)</a>
                                                <a class="dropdown-item singleSellInvoiceWiseDelivery" data-id="{{$item->id}}" style="cursor: pointer">Delivery Product</a>
                                                <a class="dropdown-item singleSellInvoiceReturnModalView" data-id="{{$item->id}}" style="cursor: pointer">Return Product</a>
                                                <a class="dropdown-item singleSellInvoiceReceivePaymentModalView" data-id="{{$item->id}}" style="cursor: pointer;">Make Payment</a> <!--singleSellInvoiceReceivePaymentModalView  cursor: not-allowed !important;-->
                                                <a class="dropdown-item singleViewSellInvoiceOverallDiscountDetailsModal" data-id="{{$item->id}}" style="cursor: pointer">Make Overall Less</a>
                                                <a class="dropdown-item" style="cursor: pointer" href="{{route('admin.sell.regular.sell.update.sell.calculation',$item->id)}}">Update Invoice</a>
                                                 --}}
                                            @elseif ($item->sell_type == 2)
                                                {{-- <a class="dropdown-item singleSellView singleSellQuotationView" data-id="{{$item->id}}" style="cursor: pointer">View</a>
                                                <a class="dropdown-item print" target="_blank" href="{{route('admin.sell.regular.normal.print.from.sell.quotation.list',$item->id)}}" data-id="{{$item->id}}" style="cursor: pointer">Print</a>
                                                <a class="dropdown-item singleSellInvoiceProfitLossView singleSellQuotationInvoiceProfitLossView" data-id="{{$item->id}}" style="cursor: pointer">View Profit/Loss</a>
                                                <a class="dropdown-item" data-id="{{$item->id}}" href="{{route('admin.sell.edit.product.cart.list')}}?seid={{\Crypt::encrypt($item->id)}}" style="cursor: pointer">Edit / Sell</a> --}}
                                            @endif
                                    </div>
                                </td>
                                <td>
                                    <a class="singleSellView" data-id="{{$item->id}}" style="cursor: pointer">
                                    {{date('d-m-Y h:i:s A',strtotime($item->created_at))}}
                                    </a>
                                </td>
                                <td>
                                    <a class="singleSellView" data-id="{{$item->id}}" style="cursor: pointer">
                                    {{$item->invoice_no}} 
                                    </a>
                                </td>
                                <td style="background-color:#5c5c95;color:#ffff;">
                                    {{$item->total_payable_amount}}
                                </td>
                                <td style="background-color:#448d44;color:#ffff;">
                                    {{$item->total_paid_amount}}
                                </td>
                                <td style="background-color:#bd3939;color:#ffff;">
                                    {{$item->total_due_amount}}
                                </td>
                                <td>
                                    {{paymentStatus_hh($item->total_payable_amount,$item->total_paid_amount)}}
                                </td>
                                <td>
                                    @if ($item->sell_type == 1)
                                    {{$item->customer?$item->customer->name:NULL}}
                                    @elseif ($item->sell_type == 2)
                                    {{$item->quotation ? $item->quotation->customer_name : NULL}}
                                    @endif
                                </td>
                            </tr>
                            @php
                                $totalSellPayableAmount += $item->total_payable_amount;
                                $totalSellPaidAmount += $item->total_paid_amount;
                                $totalSellDueAmount += $item->total_due_amount;
                                //$totalLessAmount += $item->total_discount_amount;
                                //$totalItem += $item->totalSellItemAfterRefund();
                            @endphp
                        @endforeach
                        <tr class="bg-whitesmoke h6">
                            <td colspan="4" style="text-align:right">Total</td>
                            <th>{{number_format($totalSellPayableAmount,2,'.','')}}</th>
                            <th>{{number_format($totalSellPaidAmount,2,'.','')}}</th>
                            <th>{{number_format($totalSellDueAmount,2,'.','')}}</th>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                
                {{$sellInvoices->links()}}
        
                
            </div>
            


        

            <!-------single sell view Modal------> 
            <div class="modal fade" id="singleModalView"  aria-modal="true"></div>
            <input type="hidden" class="singleViewModalRoute" value="{{ route('admin.sell.regular.sell.single.view') }}">
            <!-------single sell view Modal------> 

            <!-------single sell invoice profit loss view Modal------> 
            <div class="modal fade" id="singleSellInvoiceProftLossModalView"  aria-modal="true"></div>
            <input type="hidden" class="singleSellInvoiceProftLossModalRoute" value="{{ route('admin.sell.regular.sell.view.single.invoice.profit.loss') }}">
            <!-------single sell invoice profit loss view Modal------> 

            <!------view Single Sell payment Modal------> 
            <div class="modal fade" id="viewSellSingleInvoiceReceivePaymentModal"  aria-modal="true"></div>
            <input type="hidden" class="viewSellSingleInvoiceReceivePaymentModalRoute" value="{{route('admin.sell.regular.sell.view.single.invoice.wise.payment.details.modal')}}">
            <!-------view Single Sell payment Modal------> 

        <!--@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@-->
        <!--@@@@@@@@@@@@@@@@@@@@@@@^^^real space in content^^^@@@@@@@@@@@@@@@@@@@@@@@-->     
        </div>
        <!--real space in content--> 
        <!--@@@@@@@@@@@@@@@@@@@@@@@^^^real space in content^^^@@@@@@@@@@@@@@@@@@@@@@@--> 
        <!--@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@-->

    


    <!--#################################################################################-->
    <!--######################^^total content space for this page^^######################-->  
    </div>
    <!--######################^^total content space for this page^^######################--> 
    <!--#################################################################################-->



<!--=================js=================-->
@push('js')
<!--=================js=================-->
  <script>
    //-----------------------------------------------------------------------
    $(document).on('click','.singleSellView',function(e){
        e.preventDefault();
        var url = $('.singleViewModalRoute').val();
        var id = $(this).data('id');
        $.ajax({
            url:url,
            data:{id:id},
            success:function(response){
                if(response.status == true)
                {
                    $('#singleModalView').html(response.html).modal('show');
                }
            }
        });
    });
    //-----------------------------------------------------------------------

    
    //-----------------------------------------------------------------------
    $(document).on('click','.singleSellInvoiceProfitLossView',function(e){
        e.preventDefault();
        var url = $('.singleSellInvoiceProftLossModalRoute').val();
        var id = $(this).data('id');
        $.ajax({
            url:url,
            data:{id:id},
            success:function(response){
                if(response.status == true)
                {
                    $('#singleSellInvoiceProftLossModalView').html(response.html).modal('show');
                }
            }
        });
    });
    //-----------------------------------------------------------------------


    //-----------------------------------------------------------------------
    $(document).on('click','.singleViewSellInvoiceWisePaymentDetailsModal',function(e){
        e.preventDefault();
        var url = $('.viewSellSingleInvoiceReceivePaymentModalRoute').val();
        var id = $(this).data('id');
        $.ajax({
            url:url,
            data:{id:id},
            success:function(response){
                if(response.status == true)
                {
                    $('#viewSellSingleInvoiceReceivePaymentModal').html(response.html).modal('show');
                }
            }
        });
    });
    //-----------------------------------------------------------------------

  </script>
<!--=================js=================-->
@endpush
<!--=================js=================-->



<!--%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%-->
<!--%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%^^^^Content^^^^%%%%%%%%%%%%%%%%%%%%%%%%%%%%%-->
@endsection
<!--%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%^^^^Content^^^^%%%%%%%%%%%%%%%%%%%%%%%%%%%%%-->
<!--%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%-->





