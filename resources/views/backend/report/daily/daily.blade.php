@extends('layouts.backend.app')
@section('page_title') Home Page @endsection
@push('css')
<style>

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
            <h4 class="font-weight-bold py-3 mb-0">Products  </h4>
            <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#"><i class="feather icon-home"></i></a>
                    </li>
                    <li class="breadcrumb-item">Products</li>
                    <li class="breadcrumb-item active">All Products</li>
                </ol>
            </div>
            <div class="products">
                <a href="#">Add Product</a>
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
        

            <div class="col-md-12 text-center">
                <h3 style="text-align: center;">Daily Summary Report</h3>
                <h4 class="text-center">Date: 19-02-2023</h4>
            
                <form class="d-flex justify-content-center">
                    <input type="date" id="date_search" value="2023-02-19" name="q" class="form-control margin-right-10 w-25" placeholder="Date" />
                    <button type="submit" class="btn ms-1 btn-primary pull-left"><i class="fa fa-search"></i> Search</button>
                    <a class="btn btn-secondary ms-1" href="https://amadersanitary.com/reports/daily-summery-report">Today</a>
                </form>
                <br />
                <hr />
            
                <div class="row" style="background-color:#ffff;">
                    <div class="table-responsive table-responsive-index-page">
                        
                    </div>
                </div>
            </div>
            

            <div class="card-body" style="background-color: #fff;">
                <div class="col-md-12 text-center">
                    <h3 style="text-align: center;">Daily Summary Report</h3>
                    <h4 class="text-center">Date: 11-01-2023</h4>
            
                    <form class="d-flex justify-content-center">
                        <input type="date" id="date_search" value="2023-01-11" name="q" class="form-control margin-right-10 w-25" placeholder="Date" />
                        <button type="submit" class="btn ms-1 btn-primary pull-left"><i class="fa fa-search"></i> Search</button>
                        <a class="btn btn-secondary ms-1" href="https://amadersanitary.com/reports/daily-report">Today</a>
                    </form>
                    <br />
                    <hr />
                </div>
            
                <h3 class="text-center">Sales</h3>
                <table class="table table-responsive table-bordered">
                    <tbody>
                        <tr role="row" class="bg-whitesmoke">
                            <th>Date</th>
                            <th>Order No.</th>
                            <th>Total</th>
                            <th>Receive</th>
                            <th>Due</th>
                        </tr>
                        <tr role="row">
                            <td>
                                11-01-2023
                            </td>
                            <td>
                                003903
                            </td>
                            <td>
                                5040.00
                            </td>
                            <td>
                                0.00
                            </td>
                            <td>
                                5040
                            </td>
                        </tr>
                        <tr role="row">
                            <td>
                                11-01-2023
                            </td>
                            <td>
                                003904
                            </td>
                            <td>
                                8300.00
                            </td>
                            <td>
                                0.00
                            </td>
                            <td>
                                8300
                            </td>
                        </tr>
                        <tr role="row">
                            <td>
                                11-01-2023
                            </td>
                            <td>
                                003905
                            </td>
                            <td>
                                845.00
                            </td>
                            <td>
                                845.00
                            </td>
                            <td>
                                0
                            </td>
                        </tr>
                        <tr role="row">
                            <td>
                                11-01-2023
                            </td>
                            <td>
                                003906
                            </td>
                            <td>
                                250.00
                            </td>
                            <td>
                                250.00
                            </td>
                            <td>
                                0
                            </td>
                        </tr>
                        <tr role="row">
                            <td>
                                11-01-2023
                            </td>
                            <td>
                                003907
                            </td>
                            <td>
                                200.00
                            </td>
                            <td>
                                200.00
                            </td>
                            <td>
                                0
                            </td>
                        </tr>
                        <tr role="row">
                            <td>
                                11-01-2023
                            </td>
                            <td>
                                003908
                            </td>
                            <td>
                                70.00
                            </td>
                            <td>
                                70.00
                            </td>
                            <td>
                                0
                            </td>
                        </tr>
                        <tr role="row">
                            <td>
                                11-01-2023
                            </td>
                            <td>
                                003909
                            </td>
                            <td>
                                27380.00
                            </td>
                            <td>
                                27380.00
                            </td>
                            <td>
                                0
                            </td>
                        </tr>
                        <tr role="row">
                            <td>
                                11-01-2023
                            </td>
                            <td>
                                003910
                            </td>
                            <td>
                                1700.00
                            </td>
                            <td>
                                1700.00
                            </td>
                            <td>
                                0
                            </td>
                        </tr>
                        <tr role="row">
                            <td>
                                11-01-2023
                            </td>
                            <td>
                                003911
                            </td>
                            <td>
                                11790.00
                            </td>
                            <td>
                                0.00
                            </td>
                            <td>
                                11790
                            </td>
                        </tr>
                        <tr role="row">
                            <td>
                                11-01-2023
                            </td>
                            <td>
                                003912
                            </td>
                            <td>
                                3500.00
                            </td>
                            <td>
                                3500.00
                            </td>
                            <td>
                                0
                            </td>
                        </tr>
                        <tr role="row">
                            <td>
                                11-01-2023
                            </td>
                            <td>
                                003913
                            </td>
                            <td>
                                0.00
                            </td>
                            <td>
                                0.00
                            </td>
                            <td>
                                0
                            </td>
                        </tr>
                        <tr role="row">
                            <td>
                                11-01-2023
                            </td>
                            <td>
                                003914
                            </td>
                            <td>
                                3690.00
                            </td>
                            <td>
                                3690.00
                            </td>
                            <td>
                                0
                            </td>
                        </tr>
                        <tr role="row">
                            <td>
                                11-01-2023
                            </td>
                            <td>
                                003915
                            </td>
                            <td>
                                2600.00
                            </td>
                            <td>
                                0.00
                            </td>
                            <td>
                                2600
                            </td>
                        </tr>
                        <tr role="row">
                            <td>
                                11-01-2023
                            </td>
                            <td>
                                003916
                            </td>
                            <td>
                                0.00
                            </td>
                            <td>
                                0.00
                            </td>
                            <td>
                                0
                            </td>
                        </tr>
                        <tr role="row">
                            <td>
                                11-01-2023
                            </td>
                            <td>
                                003917
                            </td>
                            <td>
                                18200.00
                            </td>
                            <td>
                                18200.00
                            </td>
                            <td>
                                0
                            </td>
                        </tr>
                        <tr role="row">
                            <td>
                                11-01-2023
                            </td>
                            <td>
                                003918
                            </td>
                            <td>
                                10.00
                            </td>
                            <td>
                                10.00
                            </td>
                            <td>
                                0
                            </td>
                        </tr>
                        <tr role="row">
                            <td>
                                11-01-2023
                            </td>
                            <td>
                                003919
                            </td>
                            <td>
                                60.00
                            </td>
                            <td>
                                60.00
                            </td>
                            <td>
                                0
                            </td>
                        </tr>
                        <tr role="row">
                            <td>
                                11-01-2023
                            </td>
                            <td>
                                003920
                            </td>
                            <td>
                                1800.00
                            </td>
                            <td>
                                0.00
                            </td>
                            <td>
                                1800
                            </td>
                        </tr>
                        <tr role="row">
                            <td>
                                11-01-2023
                            </td>
                            <td>
                                003921
                            </td>
                            <td>
                                2820.00
                            </td>
                            <td>
                                2820.00
                            </td>
                            <td>
                                0
                            </td>
                        </tr>
                        <tr role="row">
                            <td>
                                11-01-2023
                            </td>
                            <td>
                                003922
                            </td>
                            <td>
                                2250.00
                            </td>
                            <td>
                                2250.00
                            </td>
                            <td>
                                0
                            </td>
                        </tr>
                        <tr class="bg-whitesmoke h6">
                            <td colspan="2">Balance</td>
                            <td>90505</td>
                            <td>60975</td>
                            <td>29530</td>
                        </tr>
                    </tbody>
                </table>
            
                <h3 class="text-center">Purchases</h3>
                <table class="table table-responsive table-bordered">
                    <tbody>
                        <tr role="row" class="bg-whitesmoke">
                            <th>Date</th>
                            <th>Invoice No.</th>
                            <th>Total</th>
                            <th>Paid</th>
                            <th>Due</th>
                        </tr>
                        <tr role="row">
                            <td>
                                11-01-2023
                            </td>
                            <td>00690</td>
                            <td>2335</td>
                            <td>2335.00</td>
                            <td>0</td>
                        </tr>
                        <tr role="row">
                            <td>
                                11-01-2023
                            </td>
                            <td>00691</td>
                            <td>78.45</td>
                            <td>78.45</td>
                            <td>-1.4210854715202E-14</td>
                        </tr>
                        <tr class="bg-whitesmoke h6">
                            <td colspan="2"></td>
                            <td>2413.45</td>
                            <td>2413.45</td>
                            <td>-1.4210854715202E-14</td>
                        </tr>
                    </tbody>
                </table>
            
                <h3 class="text-center">Supplier Due Payments</h3>
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
                </table>
            
                <h3 class="text-center">Customer Due Receives</h3>
                <table class="table table-responsive table-bordered">
                    <tbody>
                        <tr role="row" class="bg-whitesmoke">
                            <th>Date</th>
                            <th>Payment Ref No.</th>
                            <th>Invoice No./Ref. No.</th>
                            <th>Payment Method</th>
                            <th>Account</th>
                            <th>Receive Amount</th>
                        </tr>
                        <tr role="row">
                            <td>
                                11-01-2023
                            </td>
                            <td>
                                SI2023/006381
                            </td>
                            <td>
                                003906
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
                                250.00
                            </td>
                        </tr>
                        <tr role="row">
                            <td>
                                11-01-2023
                            </td>
                            <td>
                                SI2023/006382
                            </td>
                            <td>
                                003908
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
                                70.00
                            </td>
                        </tr>
                        <tr role="row">
                            <td>
                                11-01-2023
                            </td>
                            <td>
                                SI2023/006384
                            </td>
                            <td>
                                003912
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
                                3500.00
                            </td>
                        </tr>
                        <tr role="row">
                            <td>
                                11-01-2023
                            </td>
                            <td>
                                SI2023/006386
                            </td>
                            <td>
                                003918
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
                                10.00
                            </td>
                        </tr>
                        <tr role="row">
                            <td>
                                11-01-2023
                            </td>
                            <td>
                                SI2023/006387
                            </td>
                            <td>
                                003914
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
                                3690.00
                            </td>
                        </tr>
                        <tr role="row">
                            <td>
                                11-01-2023
                            </td>
                            <td>
                                SI2023/006388
                            </td>
                            <td>
                                003917
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
                                18200.00
                            </td>
                        </tr>
                        <tr role="row">
                            <td>
                                11-01-2023
                            </td>
                            <td>
                                SI2023/006389
                            </td>
                            <td>
                                003907
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
                                200.00
                            </td>
                        </tr>
                        <tr role="row">
                            <td>
                                11-01-2023
                            </td>
                            <td>
                                SI2023/006390
                            </td>
                            <td>
                                003910
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
                                1700.00
                            </td>
                        </tr>
                        <tr role="row">
                            <td>
                                11-01-2023
                            </td>
                            <td>
                                SI2023/006391
                            </td>
                            <td>
                                003905
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
                                845.00
                            </td>
                        </tr>
                        <tr role="row">
                            <td>
                                11-01-2023
                            </td>
                            <td>
                                SI2023/006392
                            </td>
                            <td>
                                003919
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
                                60.00
                            </td>
                        </tr>
                        <tr role="row">
                            <td>
                                11-01-2023
                            </td>
                            <td>
                                SI2023/006393
                            </td>
                            <td>
                                003921
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
                                2820.00
                            </td>
                        </tr>
                        <tr role="row">
                            <td>
                                11-01-2023
                            </td>
                            <td>
                                SI2023/006394
                            </td>
                            <td>
                                003922
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
                                2250.00
                            </td>
                        </tr>
                        <tr class="bg-whitesmoke h6">
                            <td colspan="5"></td>
                            <td>33595</td>
                        </tr>
                    </tbody>
                </table>
            
                <h3 class="text-center">Expenses</h3>
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
                </table>
                <br />
                <hr />
                <br />
                <h2 class="text-center">Daily Summery (Total)</h2>
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





