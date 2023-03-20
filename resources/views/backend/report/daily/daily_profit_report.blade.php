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
                    <li class="breadcrumb-item active">Profit</li>
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
                    <h3 style="text-align: center;">Daily Profit/Loss</h3>
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

                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped table-hover">
                        <tbody>
                            <tr>
                                <th colspan="4" style="text-align: center;">
                                    <h4>Sell Summery</h4>
                                </th>
                            </tr>
                            <tr>
                                <th style="width: 25%;background-color:#3a743a;color:#ffff;">
                                    <strong>Total Bill Amount</strong>
                                </th>
                                <th style="width: 25%;background-color: #3a743a;color:#ffff;">
                                    {{number_format($totalPayableAmount,2,'.','')}}
                                </th>
                                <th style="background-color:#078354ba;color:black;width: 25%;text-align:right;">Total Cash Amount</th>
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
                            <tr>
                                <th style="width: 25%;background-color:#65f565;color:#2a0404;">
                                    <strong>Total Profit</strong>
                                </th>
                                <th style="width: 25%;background-color: #65f565;color:#2a0404;">
                                    {{number_format($totalProfitAmount,2,'.','')}}
                                </th>
                                <th style="background-color:#059f9a;color:#ffff;width: 25%;text-align:right;">Total Profit <small>(From Product)</small></th>
                                <th style="background-color: #059f9a;color:#ffff;text-align:left;width: 25%;">
                                    <span style="font-size:14px;">{{number_format($totalProfitFromProductAmount,2,'.','')}}</span>
                                </th>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <br/>



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





