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
                    <li class="breadcrumb-item active">Ledger </li>
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
                    <h3 style="text-align: center;">Daily buy and sells ledger</h3>
                    <h4 class="text-center">Date: {{date('d-m-Y')}}</h4>
            
                    {{-- <form class="d-flex justify-content-center">
                        <input type="date" id="date_search" value="2023-01-11" name="q" class="form-control margin-right-10 w-25" placeholder="Date" />
                        <button type="submit" class="btn ms-1 btn-primary pull-left"><i class="fa fa-search"></i> Search</button>
                        <a class="btn btn-secondary ms-1" href="https://amadersanitary.com/reports/daily-report">Today</a>
                    </form> --}}
                 
                    <hr/>
                </div>
                
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th colspan="16" style="text-align:right;">Opening Balance</th>
                                <th colspan="2">000</th>
                            </tr>
                            <tr>
                                <th>#</th>
                                <th>Invoice</th>
                                <th>Page No</th>
                                <th>Name</th>
                                <th>Sell Amount</th>
                                <th><small>New Due Amount</small></th>
                                <th><small>New Cash Amount</small></th>
                                <th><small>Previous Due Receive</small></th>
                                <th><small>Advance Receive</small></th>
                                <th style="border-right:.25px solid gray;"><small>Receive Bank/Personal Loan</small></th>
                                <th style="width:1%;border-right:.25px solid gray;"></th>

                                <th><small>Return Amount</small></th>
                                <th><small>Company Bill</small></th>
                                <th><small>Bank Deposit</small></th>
                                <th style="width:1%;border-right:.25px solid gray;"></th>
                                <th><small>Unreturnable Cost</small></th>
                                <th><small>Returnable Invesment</small></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td><small>-</small></td>
                                <td><small>-</small></td>
                                <td><small>-</small></td>
                                <td><small>-</small></td>
                                <td style="border-right:.25px solid gray;"><small>-</small></td>
                                <td style="width:1%;border-right:.25px solid gray;"></td>

                                <td><small>-</small></td>
                                <td><small>-</small></td>
                                <td><small>-</small></td>
                                <td style="width:1%;border-right:.25px solid gray;"></td>
                                <td><small>-</small></td>
                                <td><small>-</small></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td><small>-</small></td>
                                <td><small>-</small></td>
                                <td><small>-</small></td>
                                <td><small>-</small></td>
                                <td style="border-right:.25px solid gray;"><small>-</small></td>
                                <td style="width:1%;border-right:.25px solid gray;"></td>

                                <td><small>-</small></td>
                                <td><small>-</small></td>
                                <td><small>-</small></td>
                                <td style="width:1%;border-right:.25px solid gray;"></td>
                                <td><small>-</small></td>
                                <td><small>-</small></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td><small>-</small></td>
                                <td><small>-</small></td>
                                <td><small>-</small></td>
                                <td><small>-</small></td>
                                <td style="border-right:.25px solid gray;"><small>-</small></td>
                                <td style="width:1%;border-right:.25px solid gray;"></td>

                                <td><small>-</small></td>
                                <td><small>-</small></td>
                                <td><small>-</small></td>
                                <td style="width:1%;border-right:.25px solid gray;"></td>
                                <td><small>-</small></td>
                                <td><small>-</small></td>
                                <td></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="9" style="text-align:right;">Total Income</th>
                                <th  style="border-right:.25px solid gray;text-align:left">000</th>
                                <th style="width:1%;border-right:.25px solid gray;"></th>
                                
                                <th  style="text-align:right;">Expenditure</th>
                                <th style="text-align:left;" colspan="6">000</th>
                            </tr>
                            <tr>
                                <th colspan="16" style="text-align:right;">Closing Balance</th>
                                <th colspan="2">000</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <br/><br/>

                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped table-hover">
                        <tbody>
                            <tr>
                                <th colspan="4" style="text-align: center;">
                                    <h4>Ledger</h4>
                                </th>
                            </tr>
                            <tr>
                                <th style="width: 25%;background-color:#3a743a;color:#ffff;">
                                    <strong>Total Bill Amount</strong>
                                </th>
                                <th style="width: 25%;background-color: #3a743a;color:#ffff;">
                                    {{number_format(0,2,'.','')}}
                                </th>
                                <th style="background-color:#078354ba;color:black;width: 25%;text-align:right;">Total Cash Amount</th>
                                <th style="background-color: #3a743a;color:#ffff;text-align:left;width: 25%;">
                                    <span style="font-size:14px;">{{number_format(0,2,'.','')}}</span>
                                </th>
                            </tr>
                            <tr>
                                <th style="width: 25%;background-color:#f53e06;color:#ffff;">
                                    <strong>Total Due Amount</strong>
                                </th>
                                <th style="width: 25%;background-color: #f53e06;color:#ffff;">
                                    {{number_format(0,2,'.','')}}
                                </th>
                                <th style="background-color:#aa5339;color:#ffff;width: 25%;text-align:right;">Total Discount Amount</th>
                                <th style="background-color: #aa5339;color:#ffff;text-align:left;width: 25%;">
                                    <span style="font-size:14px;">{{number_format(0,2,'.','')}}</span>
                                </th>
                            </tr>
                            <tr>
                                <th style="width: 25%;background-color:#65f565;color:#2a0404;">
                                    <strong>Total Profit</strong>
                                </th>
                                <th style="width: 25%;background-color: #65f565;color:#2a0404;">
                                    {{number_format(0,2,'.','')}}
                                </th>
                                <th style="background-color:#059f9a;color:#ffff;width: 25%;text-align:right;">Total Profit <small>(From Product)</small></th>
                                <th style="background-color: #059f9a;color:#ffff;text-align:left;width: 25%;">
                                    <span style="font-size:14px;">{{number_format(0,2,'.','')}}</span>
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





