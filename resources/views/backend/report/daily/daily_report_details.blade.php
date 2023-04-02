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
            <h4 class="font-weight-bold py-3 mb-0">Reports  </h4>
            <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#"><i class="feather icon-home"></i></a>
                    </li>
                    <li class="breadcrumb-item">Reports</li>
                    <li class="breadcrumb-item active">Daily Report - Transactional Details</li>
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
                    <h3 style="text-align: center;">Daily Report - Module Wise Transaction Details</h3>
                    <h4 class="text-center">Date: {{date('d-m-Y')}}</h4>
            
                    {{-- <form class="d-flex justify-content-center">
                        <input type="date" id="date_search" value="2023-01-11" name="q" class="form-control margin-right-10 w-25" placeholder="Date" />
                        <button type="submit" class="btn ms-1 btn-primary pull-left"><i class="fa fa-search"></i> Search</button>
                        <a class="btn btn-secondary ms-1" href="https://amadersanitary.com/reports/daily-report">Today</a>
                    </form> --}}
                    <br/>
                    <hr/>
                </div>
                
                <br/><br/>
                <table class="table table-responsive table-bordered" style="margin-left:10%;margin-right:10%;">
                    <tbody>
                        <tr>
                            <th colspan="7" style="text-align:center;background-color:#3a743a;color:#ffff;"><h4>Sales</h4></th>
                        </tr>
                        <tr role="row" class="bg-whitesmoke">
                            <th>#</th>
                            <th>Date</th>
                            <th>Invoice No.</th>
                            <th>Bill Amount</th>
                            <th>Cash Amount</th>
                            <th>Due Amount</th>
                            <th>Payment Status</th>
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
                                <td>
                                    {{date('d-m-Y h:i:s A',strtotime($item->created_at))}}
                                </td>
                                <td>
                                    {{$item->invoice_no}} 
                                </td>
                                <td>
                                    {{$item->total_payable_amount}}
                                </td>
                                <td>
                                    {{$item->total_paid_amount}}
                                </td>
                                <td>
                                    {{$item->total_due_amount}}
                                </td>
                                <td>
                                    {{paymentStatus_hh($item->total_payable_amount,$item->total_paid_amount)}}
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
                            <td colspan="3" style="text-align:right">Total</td>
                            <th>{{number_format($totalSellPayableAmount,2,'.','')}}</th>
                            <th>{{number_format($totalSellPaidAmount,2,'.','')}}</th>
                            <th>{{number_format($totalSellDueAmount,2,'.','')}}</th>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                <br/>
                

                <br/>
                <table class="table table-responsive table-bordered" style="margin-left:10%;margin-right:10%;">
                    <tbody>
                        <tr>
                            <th colspan="5" style="text-align:center;background-color:rgb(194, 62, 62);color:#ffff;"><h4 style="text-align:center;">Sales Returns</h4></th>
                        </tr>
                        <tr role="row" class="bg-whitesmoke">
                            <th>Date</th>
                            <th>Invoice No</th>
                            <th>Customer Name</th>
                            {{-- <th>Payment Method</th>
                                <th>Account</th> --}}
                            <th>Receive Amount</th>
                            <th>Receive By</th>
                        </tr>
                        @php
                            $totalCustomerSellReturnAmount = 0;
                        @endphp
                        @foreach ($sellReturnAmount as $item)
                        <tr role="row">
                            <td>
                                {{date('d-m-Y h:i:s A',strtotime($item->created_at))}}
                            </td>
                            <td>
                               {{$item->main_module_invoice_no}}
                            </td>
                            <td>
                                {{$item->customers ? $item->customers->name : NULL}}
                            </td>
                            <td>
                                {{$item->payment_amount}}
                            </td>
                            <td>
                                {{$item->createdBY ? $item->createdBY->name : NULL}}
                            </td>
                        </tr>     
                        @php
                            $totalCustomerSellReturnAmount += $item->payment_amount;
                        @endphp 
                        @endforeach
                        <tr class="bg-whitesmoke h6">
                            <td colspan="3" style="text-align:right">Total</td>
                            <th>{{number_format($totalCustomerSellReturnAmount,2,'.','')}}</th>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                <br/>


                <br/>
                <table class="table table-responsive table-bordered" style="margin-left:10%;margin-right:10%;">
                    <tbody>
                        <tr>
                            <th colspan="6" style="text-align:center;background-color:#3a743a;color:#ffff;"><h4 style="text-align:center;">Purchases</h4></th>
                        </tr>
                        <tr role="row" class="bg-whitesmoke">
                            <th>Date</th>
                            <th>Invoice No.</th>
                            <th>Payable Amount</th>
                            <th>Paid Amount</th>
                            <th>Due Amount</th>
                            <th>Payment Status</th>
                        </tr>
                        @php
                            $totalPurchasePayableAmount = 0;
                            $totalPurchasePaidAmount = 0;
                            $totalPurchaseDueAmount = 0;
                        @endphp
                        @foreach ($purchaseInvoices as $item)
                        <tr role="row">
                            <td>
                                {{date('d-m-Y h:i:s A',strtotime($item->created_at))}}
                            </td>
                            <td> {{$item->invoice_no}}</td>
                            <td>{{$item->total_payable_amount}}</td>
                            <td>{{$item->total_paid_amount}}</td>
                            <td>{{$item->due_amount}}</td>
                            <td>{{paymentStatus_hh($item->total_payable_amount,$item->total_paid_amount)}}</td>
                        </tr>
                        @php
                            $totalPurchasePayableAmount += $item->total_payable_amount;
                            $totalPurchasePaidAmount += $item->total_paid_amount;
                            $totalPurchaseDueAmount += $item->due_amount;
                        @endphp
                        @endforeach
                        <tr class="bg-whitesmoke h6">
                            <td colspan="2" style="text-align:right">Total</td>
                            <th>{{number_format($totalPurchasePayableAmount,2,'.','')}}</th>
                            <th>{{number_format($totalPurchasePaidAmount,2,'.','')}}</th>
                            <th>{{number_format($totalPurchaseDueAmount,2,'.','')}}</th>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                <br/>

                {{-- <h3 class="text-center">Supplier Due Payments</h3>
                <table class="table table-responsive table-bordered">
                    <tbody>
                        <tr role="row" class="bg-whitesmoke">
                            <th>Date</th>
                            <th>Payment Ref No.</th>
                            <th>Invoice No./Ref. No.</th>
                            <th>Payment Method</th>
                            <th>Account</th>
                            <th>Paid Amount</th>
                        </tr>
                        <tr role="row">
                            <td>
                                11-01-2023
                            </td>
                            <td>
                                PE2023/006395
                            </td>
                            <td>
                                00690
                            </td>
            
                            <td>
                                <small style="font-size: 11px;">
                                    Cash<br />
                                    (Cash)
                                </small>
                            </td>
                            <td>
                                <small style="font-size: 13px;">
                                    Cash<br />
                                    ()
                                </small>
                            </td>
            
                            <td>
                                2335.00
                            </td>
                        </tr>
                        <tr role="row">
                            <td>
                                11-01-2023
                            </td>
                            <td>
                                PE2023/006396
                            </td>
                            <td>
                                00691
                            </td>
            
                            <td>
                                <small style="font-size: 11px;">
                                    Cash<br />
                                    (Cash)
                                </small>
                            </td>
                            <td>
                                <small style="font-size: 13px;">
                                    Cash<br />
                                    ()
                                </small>
                            </td>
            
                            <td>
                                78.45
                            </td>
                        </tr>
                        <tr class="bg-whitesmoke h6">
                            <td colspan="5"></td>
                            <td>2413.45</td>
                        </tr>
                    </tbody>
                </table> --}}

                <br/><br/>
                <table class="table table-responsive table-bordered" style="margin-left:10%;margin-right:10%;">
                    <tbody>
                        <tr>
                            <th colspan="5" style="text-align:center;background-color:#3a743a;color:#ffff;"><h4 style="text-align:center;">Sell Due Receives</h4></th>
                        </tr>
                        <tr role="row" class="bg-whitesmoke">
                            <th>Date</th>
                            <th>Invoice No</th>
                            <th>Customer Name</th>
                            {{-- <th>Payment Method</th>
                                <th>Account</th> --}}
                            <th>Receive Amount</th>
                            <th>Receive By</th>
                        </tr>
                        @php
                            $totalCustomerDueReceivedAmount = 0;
                        @endphp
                        @foreach ($customerSellDueReceives as $item)
                        <tr role="row">
                            <td>
                                {{date('d-m-Y h:i:s A',strtotime($item->created_at))}}
                            </td>
                            <td>
                               {{$item->main_module_invoice_no}}
                            </td>
                            <td>
                                {{$item->customers ? $item->customers->name : NULL}}
                            </td>
                            <td>
                                {{$item->payment_amount}}
                            </td>
                            <td>
                                {{$item->createdBY ? $item->createdBY->name : NULL}}
                            </td>
                        </tr>     
                        @php
                            $totalCustomerDueReceivedAmount += $item->payment_amount;
                        @endphp 
                        @endforeach
                        <tr class="bg-whitesmoke h6">
                            <td colspan="3" style="text-align:right">Total</td>
                            <th>{{number_format($totalCustomerDueReceivedAmount,2,'.','')}}</th>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                <br />

                <br/>
                <table class="table table-responsive table-bordered" style="margin-left:10%;margin-right:10%;">
                    <tbody>
                        <tr>
                            <th colspan="4" style="text-align:center;background-color:#3a743a;color:#ffff;"><h4 style="text-align:center;">Customer Previous Due Receives</h4></th>
                        </tr>

                        <tr role="row" class="bg-whitesmoke">
                            <th>Date</th>
                            <th>Customer Name</th>
                            {{-- <th>Payment Method</th>
                                <th>Account</th> --}}
                            <th>Receive Amount</th>
                            <th>Receive By</th>
                        </tr>
                        @php
                            $totalCustomerPreviousDueReceivedAmount = 0;
                        @endphp
                        @foreach ($customerPreviousDueReceives as $item)
                        <tr role="row">
                            <td>
                                {{date('d-m-Y h:i:s A',strtotime($item->created_at))}}
                            </td>
                            <td>
                                {{$item->customers ? $item->customers->name : NULL}}
                            </td>
                            <td>
                                {{$item->payment_amount}}
                            </td>
                            <td>
                                {{$item->createdBY ? $item->createdBY->name : NULL}}
                            </td>
                        </tr>     
                        @php
                            $totalCustomerPreviousDueReceivedAmount += $item->payment_amount;
                        @endphp 
                        @endforeach
                        <tr class="bg-whitesmoke h6">
                            <td colspan="2" style="text-align:right">Total</td>
                            <th>{{number_format($totalCustomerPreviousDueReceivedAmount,2,'.','')}}</th>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                <br />
                
                
                <br/>   
                <table class="table table-responsive table-bordered" style="margin-left:10%;margin-right:10%;">
                    <tbody>
                        <tr>
                            <th colspan="4" style="text-align:center;background-color:#3a743a;color:#ffff;"><h4 style="text-align:center;">Customer Add Loan</h4></th>
                        </tr>

                        <tr role="row" class="bg-whitesmoke">
                            <th>Date</th>
                            <th>Customer Name</th>
                            {{-- <th>Payment Method</th>
                                <th>Account</th> --}}
                            <th>Receive Amount</th>
                            <th>Receive By</th>
                        </tr>
                        @php
                            $totalCustomerAddLoanAmount = 0;
                        @endphp
                        @foreach ($customerAddLoans as $item)
                        <tr role="row">
                            <td>
                                {{date('d-m-Y h:i:s A',strtotime($item->created_at))}}
                            </td>
                            <td>
                                {{$item->customers ? $item->customers->name : NULL}}
                            </td>
                            <td>
                                {{$item->payment_amount}}
                            </td>
                            <td>
                                {{$item->createdBY ? $item->createdBY->name : NULL}}
                            </td>
                        </tr>     
                        @php
                            $totalCustomerAddLoanAmount += $item->payment_amount;
                        @endphp 
                        @endforeach
                        <tr class="bg-whitesmoke h6">
                            <td colspan="2" style="text-align:right">Total</td>
                            <th>{{number_format($totalCustomerAddLoanAmount,2,'.','')}}</th>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                <br />

                <br/>   
                <table class="table table-responsive table-bordered" style="margin-left:10%;margin-right:10%;">
                    <tbody>
                        <tr>
                            <th colspan="4" style="text-align:center;background-color:#3a743a;color:#ffff;"><h4 style="text-align:center;">Customer Add Advance</h4></th>
                        </tr>
                        <tr role="row" class="bg-whitesmoke">
                            <th>Date</th>
                            <th>Customer Name</th>
                            {{-- <th>Payment Method</th>
                                <th>Account</th> --}}
                            <th>Receive Amount</th>
                            <th>Receive By</th>
                        </tr>
                        @php
                            $totalCustomerReceivedAdvanceAmount = 0;
                        @endphp
                        @foreach ($customerAddAdvances as $item)
                        <tr role="row">
                            <td>
                                {{date('d-m-Y h:i:s A',strtotime($item->created_at))}}
                            </td>
                            <td>
                                {{$item->customers ? $item->customers->name : NULL}}
                            </td>
                            <td>
                                {{$item->payment_amount}}
                            </td>
                            <td>
                                {{$item->createdBY ? $item->createdBY->name : NULL}}
                            </td>
                        </tr>     
                        @php
                            $totalCustomerReceivedAdvanceAmount += $item->payment_amount;
                        @endphp 
                        @endforeach
                        <tr class="bg-whitesmoke h6">
                            <td colspan="2" style="text-align:right">Total</td>
                            <th>{{number_format($totalCustomerReceivedAdvanceAmount,2,'.','')}}</th>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                <br />

                {{-- <h3 class="text-center">Expenses</h3>
                <table class="table table-responsive table-bordered">
                    <tbody>
                        <tr role="row" class="bg-whitesmoke">
                            <th>Date</th>
                            <th>Payment Ref No.</th>
                            <th>Invoice No./Ref. No.</th>
                            <th>Payment Method</th>
                            <th>Account</th>
                            <th>Amount</th>
                        </tr>
                        <tr role="row">
                            <td>
                                11-01-2023
                            </td>
                            <td></td>
                            <td></td>
            
                            <td>
                                <small style="font-size: 11px;">
                                    Cash<br />
                                    (Cash)
                                </small>
                            </td>
                            <td>
                                <small style="font-size: 13px;">
                                    Cash<br />
                                    ()
                                </small>
                            </td>
                            <td>
                                40.00
                            </td>
                        </tr>
                        <tr class="bg-whitesmoke h6">
                            <td colspan="5"></td>
                            <td>40</td>
                        </tr>
                    </tbody>
                </table>
            
                <h3 class="text-center">Damages</h3>
                <table class="table table-responsive table-bordered">
                    <tbody>
                        <tr class="bg-whitesmoke">
                            <th>SN</th>
                            <th>Reference No</th>
                            <th>Supplier</th>
                            <th>Product</th>
                            <th>Amount</th>
                        </tr>
                        <tr class="bg-whitesmoke">
                            <td colspan="3"></td>
                            <td>Total Amount</td>
                            <td>0</td>
                        </tr>
                    </tbody>
                </table> --}}

                <br />
                <hr />
                <br />


                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped table-hover">
                        <tbody>
                            <tr>
                                <th colspan="4" style="text-align: center;">
                                    <h4>Calculation Summery</h4>
                                </th>
                            </tr>                                
                                <td rowspan="3" style="background-color:green;color:#ffff;text-align: center;vertical-align: middle;">
                                    Sell
                                </td>
                            </tr>
                            <tr style="background-color:green;color:#ffff;font-weight: 900;">
                                <td>Bill Amount</td>
                                <td>Received Amount</td>
                                <td>Due Amount</td>
                            </tr>
                            <tr style="background-color:green;color:#ffff;font-weight: 900;">
                                <td>{{number_format($totalSellPayableAmount,2,'.','')}}</td>
                                <td>{{number_format($totalSellPaidAmount,2,'.','')}} <br/>
                                    <small style="color:yellow;">During Selling. Cash Received Amount</small> <br/>
                                    {{$sellingTimeReceivedAmount}}
                                </td>
                                <td>{{number_format($totalSellDueAmount,2,'.','')}}</td>
                            </tr>
                            <tr>
                                <th colspan="3" style="text-align: right;">Sell Return</th>
                                <th  style="background-color:red;color:#ffff;font-weight: 900;">{{number_format($totalCustomerSellReturnAmount,2,'.','')}}</th>
                            </tr>
                            <tr style="background-color:#f1f9f1;color:black;font-weight: 900;">
                                <td rowspan="3" style="text-align: center;vertical-align: middle;">
                                    Purchase
                                </td>
                            </tr>
                            <tr style="background-color:#f1f9f1;color:black;font-weight: 900;">
                                <td>Bill Amount</td>
                                <td>Paid Amount</td>
                                <td>Due Amount</td>
                            </tr>
                            <tr style="background-color:#f1f9f1;color:black;font-weight: 900;">
                                <td>{{number_format($totalPurchasePayableAmount,2,'.','')}}</td>
                                <td  style="background-color:red;color:#ffff;font-weight: 900;">
                                    {{number_format($totalPurchasePaidAmount,2,'.','')}} <br/>
                                    <small style="color:yellow;">During Purchasing... Cash Paid Amount</small> <br/>
                                    {{$purchaseingTimePaidAmount}}
                                </td>
                                <td>{{number_format($totalPurchaseDueAmount,2,'.','')}}</td>
                            </tr>

                            <tr>
                                <th style="width: 25%;background-color:#5bcf5b;color:#ffff;">
                                    <strong> Customer Due Receives</strong>
                                </th>
                                <th style="width: 25%;background-color: #3a743a;color:#ffff;">
                                    {{number_format($totalCustomerDueReceivedAmount,2,'.','')}}
                                </th>
                                <th style="background-color:#65f565;color:black;width: 25%;text-align:right;">Customer Previous Due Receives</th>
                                <th style="background-color: #3a743a;color:#ffff;text-align:left;width: 25%;">
                                    <span style="font-size:14px;">{{number_format($totalCustomerPreviousDueReceivedAmount,2,'.','')}}</span>
                                </th>
                            </tr>

                            <tr>
                                <th  style="width: 25%;background-color: #2f302f;color:red;">
                                    <strong>Customer Add Loan</strong>
                                </th>
                                <th style="width: 25%;background-color:red;color:#ffff;">
                                    <span style="font-size:14px;">{{number_format($totalCustomerAddLoanAmount,2,'.','')}}</span>
                                </th>
                                <th style="background-color:#3a743a;color:#ffff;width: 25%;text-align:right;">Customer Add Advance</th>
                                <th style="background-color:#65f565;color:black;text-align:left;width: 25%;">
                                    <span style="font-size:14px;">{{number_format($totalCustomerReceivedAdvanceAmount,2,'.','')}}</span>
                                </th>
                            </tr>
                            <tr>
                                <th colspan="3" style="text-align: right;background-color:#65f565;color:black;">
                                    <div style="width:100%;display:flex;">
                                        <div style="width:90%;">
                                            <small>((Sell Cash Amount + Due Receive Amount + Previous Due Receive + Advance Receive) - (Purchase Paid Amount + Add Loan + Sell Return))</small> 
                                            <br/>

                                            <small>calculation with:</small> - 
                                            <small style="color:#b55353;">During Selling Cash Received Amount</small>
                                            
                                             <small style="color:#b55353;"> & Purchasing Cash Paid Amount</small>
                                             <small> Fields</small>
                                            
                                        </div>
                                        <div style="color: darkslateblue;width: 9%;padding-top: 1%;padding-right: 2px;padding-left: 2px;text-align: left;margin-left: 1%;border-left: 1px solid gray;">
                                            <strong>Total Cash </strong>
                                        </div>
                                    </div>
                                </th>
                                <th style="background-color: green;color:#ffff;padding-top: 1.9%;">
                                   {{number_format( ( ($sellingTimeReceivedAmount + $totalCustomerDueReceivedAmount + $totalCustomerPreviousDueReceivedAmount + $totalCustomerReceivedAdvanceAmount) - ($purchaseingTimePaidAmount + $totalCustomerAddLoanAmount + $totalCustomerSellReturnAmount) ) ,2,'.','')}}
                                </th>
                            </tr>

                            {{-- 
                                <tr>
                                    <th  style="width: 25%;">
                                        <strong>Other cost</strong>
                                    </th>
                                    <th style="width: 25%;">  
                                        <span style="font-size:14px;"> others_cost</span>
                                    </th>
                                    <th style="background-color: #c7d5c7;color:#000000;width: 25%;text-align:right;">Total Less Amount</th>
                                    <th style="background-color: #c7d5c7;color:#000000;text-align:right;width: 25%;">
                                        <span style="font-size:14px;"> total_discount</span>
                                    </th>
                                </tr>
                                <tr>
                                    <th  style="width: 25%;">
                                        <strong>Round off</strong>
                                    </th>
                                    <th style="width: 25%;">
                                        <span style="font-size:14px;"> round_amount</span>
                                    </th>
                                    <th style="width: 25%;text-align:right;background-color: #5bcf5b;color:#ffff;">Profit <small>From Product</small></th>
                                    <th style="text-align:right;width: 25%;background-color: #5bcf5b;color:#ffff;">
                                        <span style="font-size:14px;"> total_profit_from_product</span>
                                    </th>
                                </tr>
                                <tr>
                                    <th  style="width: 25%;">
                                        <strong>Overall Less</strong>
                                    </th>
                                    <th style="width: 25%;">
                                        <span style="font-size:14px;"> overall_discount_amount</span>
                                    </th>
                                    <th style="width: 25%;text-align:right;background-color: green;color:#ffff;">Net Profit/Loss</th>
                                    <th style="text-align:right;width: 25%;background-color: green;color:#ffff;">
                                        <span style="font-size:14px;"> totalInvoiceProfit()</span>
                                    </th>
                                </tr> 
                            --}}   

                        </tbody>
                    </table>
                </div>

                {{-- processd will later
                    <table class="table daily-summery table-bordered table-hover">
                        <thead>
                            <tr style="border-bottom: 1px solid lightgray;">
                                <th>Account</th>
                                <th style="width: 10%;">Debit</th>
                                <th style="width: 10%;">Credit</th>
                            </tr>
                        </thead>
                
                        <tbody>
                            <tr>
                                <td>Sales Total</td>
                                <td>90505</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Sales Receive</td>
                                <td></td>
                                <td>60975</td>
                            </tr>
                
                            <tr>
                                <td>Total Purchase</td>
                                <td></td>
                                <td>2413.45</td>
                            </tr>
                            <tr>
                                <td>Purchase Payments</td>
                                <td>2413.45</td>
                                <td></td>
                            </tr>
                
                            <tr>
                                <td>Loan</td>
                                <td>0</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Loan return</td>
                                <td></td>
                                <td>0</td>
                            </tr>
                
                            <tr>
                                <td>Advance</td>
                                <td></td>
                                <td>0</td>
                            </tr>
                
                            <tr>
                                <td>Total Expense</td>
                                <td>40</td>
                                <td></td>
                            </tr>
                
                            <tr class="line">
                                <td class="text-end"><b>Balance</b></td>
                                <td><b>92958.45</b></td>
                                <td><b>63388.45</b></td>
                            </tr>
                            <tr>
                                <td colspan="2">Total Damage</td>
                                <td>0</td>
                            </tr>
                        </tbody>
                    </table>
                --}}
            </div>
            


        
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
  
<!--=================js=================-->
@endpush
<!--=================js=================-->



<!--%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%-->
<!--%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%^^^^Content^^^^%%%%%%%%%%%%%%%%%%%%%%%%%%%%%-->
@endsection
<!--%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%^^^^Content^^^^%%%%%%%%%%%%%%%%%%%%%%%%%%%%%-->
<!--%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%-->





