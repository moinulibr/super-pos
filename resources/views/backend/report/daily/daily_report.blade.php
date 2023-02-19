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
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">Credit</th>
                                    <th class="text-center">Debit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                    <th>Sales Amount</th>
                                                    <th>Non Sales Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>Balance B/D</td>
                                                    <td></td>
                                                    <td>0</td>
                                                </tr>
                
                                                <tr>
                                                    <td>2</td>
                                                    <td>Sales Total</td>
                                                    <td>0</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>Sales Paid</td>
                                                    <td>0</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td>Sales Due</td>
                                                    <td></td>
                                                    <td>0</td>
                                                </tr>
                
                                                <tr>
                                                    <td>5</td>
                                                    <td>Sales Due Receive</td>
                                                    <td></td>
                                                    <td>0</td>
                                                </tr>
                
                                                <tr>
                                                    <td>6</td>
                                                    <td>Customer Advance</td>
                                                    <td></td>
                                                    <td>0</td>
                                                </tr>
                
                                                <tr>
                                                    <td>7</td>
                                                    <td>Loan Return</td>
                                                    <td></td>
                                                    <td>0</td>
                                                </tr>
                
                                                <tr>
                                                    <td>8</td>
                                                    <td>Purchase Returns</td>
                                                    <td></td>
                                                    <td>0</td>
                                                </tr>
                                                <tr>
                                                    <td>9</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>10</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>11</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>12</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>13</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>14</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>15</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>16</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                            <tfoot class="bg-ivory">
                                                <tr>
                                                    <td colspan="2">Total</td>
                                                    <td>0</td>
                                                    <td>0</td>
                                                </tr>
                                                <tr class="text-center">
                                                    <td>Balance C/D</td>
                                                    <td colspan="3"><b>-336580</b></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </td>
                                    <td>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                    <th>Return Amount</th>
                                                    <th>Non Return Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>Purchase</td>
                                                    <td>0</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>Purchase Paid</td>
                                                    <td>0</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>Purchase Due</td>
                                                    <td></td>
                                                    <td>0</td>
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td>Supplier Advance</td>
                                                    <td>0</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>5</td>
                                                    <td>Sales Returns</td>
                                                    <td>0</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>6</td>
                                                    <td>Plumber Advance</td>
                                                    <td>0</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>7</td>
                                                    <td>Plumber Commission</td>
                                                    <td></td>
                                                    <td>0</td>
                                                </tr>
                                                <tr>
                                                    <td>8</td>
                                                    <td>Customer Loan</td>
                                                    <td>0</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>9</td>
                                                    <td>Daily Expense</td>
                                                    <td></td>
                                                    <td>336580</td>
                                                </tr>
                                                <tr>
                                                    <td>10</td>
                                                    <td>Salery</td>
                                                    <td></td>
                                                    <td>0</td>
                                                </tr>
                                                <tr>
                                                    <td>11</td>
                                                    <td>House Rent</td>
                                                    <td></td>
                                                    <td>0</td>
                                                </tr>
                                                <tr>
                                                    <td>12</td>
                                                    <td>Utility bill</td>
                                                    <td></td>
                                                    <td>0</td>
                                                </tr>
                                                <tr>
                                                    <td>13</td>
                                                    <td>Water bill</td>
                                                    <td></td>
                                                    <td>0</td>
                                                </tr>
                                                <tr>
                                                    <td>14</td>
                                                    <td>Gas bill</td>
                                                    <td></td>
                                                    <td>0</td>
                                                </tr>
                                                <tr>
                                                    <td>15</td>
                                                    <td>Garbage bill</td>
                                                    <td></td>
                                                    <td>699763</td>
                                                </tr>
                                                <tr>
                                                    <td>16</td>
                                                    <td>Loan Paid</td>
                                                    <td></td>
                                                    <td>0</td>
                                                </tr>
                                            </tbody>
                                            <tfoot class="bg-ivory">
                                                <tr>
                                                    <td colspan="2">Total</td>
                                                    <td>0</td>
                                                    <td>1036343</td>
                                                </tr>
                                                <tr class="text-center">
                                                    <td>Grand Total</td>
                                                    <td colspan="3"><b>1036343</b></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
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





