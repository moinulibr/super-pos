@extends('layouts.backend.app')
@section('page_title') | Sell List @endsection
@push('css')
<style>

</style>
<!---for date picker-->
{{-- <link rel="stylesheet" href="{{asset('backend/links/assets')}}/libs/bootstrap-datepicker/bootstrap-datepicker.css">
<link rel="stylesheet" href="{{asset('backend/links/assets')}}/libs/bootstrap-material-datetimepicker/bootstrap-material-datetimepicker.css">
 --}}
<!---for date picker-->
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
            <h4 class="font-weight-bold py-3 mb-0">Sell  </h4>
            <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#"><i class="feather icon-home"></i></a>
                    </li>
                    <li class="breadcrumb-item">Sell</li>
                    <li class="breadcrumb-item active">All Sells</li>
                </ol>
            </div>
            <div class="products">
                <a href="{{route('admin.sell.regular.pos.create')}}" target="_blank" class="addSellModal">Add Sell</a>
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
        

            <div class="row" style="margin-bottom: 5px;background-color:#ffff;padding:5px 0px 10px 0px;">
                <div class="col-12">
                    <div>
                        <table  style="width: 100%;">
                            <tr>
                                <td style="width:7%">
                                    <label for="">&nbsp;</label>
                                    <select class="form-control paginate" id="paginate" name="paginate" style="font-size: 12px;width:100%;">
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="30">30</option>
                                        <option value="40">40</option>
                                        <option value="50" selected>50</option>
                                        <option value="100">100</option>
                                        <option value="200">200</option>
                                        <option value="300">300</option>
                                        <option value="500">500</option>
                                        <option value="1000">1000</option>
                                    </select>
                                </td>
                                <td style="width:1%"></td>
                                {{-- <td style="width: 20%">
                                    <label for="">Supplier</label>
                                    <select name="supplier_id" id="supplier_filter_id" class="supplier_filter_id form-control">
                                        <option value="">Select Supllier</option>
                                    </select>
                                </td>
                                <td style="width:1%"></td>
                                <td style="width:14%">
                                    <label for="">Group</label>
                                    <select name="ground" id="ground_filter_id" class="ground_filter_id form-control">
                                        <option value="">Select Group</option>
                                    </select>
                                </td>
                                <td style="width:1%"></td> --}}
                                <td style="width: 15%">
                                    <label for="">Date From </label>
                                    <input type="date" class="form-control date_from">
                                </td>
                                <td style="width:1%"></td>
                                <td style="width:19%">
                                    <label for="">Date To</label>
                                    <input type="date" class="form-control date_to">    
                                </td>
                                <td style="width:1%"></td>
                                <td style="width: 20%">
                                    <label for="">Search</label>
                                    <input type="text" class="search form-control" name="search" placeholder="Search" autofocus autocomplete="off">
                                </td>
                            </tr>
                        </table>
                    </div>

                    {{-- 
                        <div class="on_processing" style="text-align: center;padding-bottom:20px;display:none;">
                            <strong style="color:#0c0c0c;z-index:99999;background-color:#f9f9f9;padding:3px 5px;border-radious:3px solidg gray;">
                                Processing...
                            </strong>
                        </div> 
                    --}}
                </div>
            </div>
            <br/>
            <!-------responsive table------> 
            <div style="background-color:#ffff;width: 100%;">
                <div class="sellListAjaxResponseResult" style="padding:2%;">

                    @include('backend.sell.sell_details.partial.list')

                </div>
            </div>
            <!-------responsive table------> 

            

            <!-------single sell view Modal------> 
            <div class="modal fade" id="singleModalView"  aria-modal="true"></div>
            <input type="hidden" class="singleViewModalRoute" value="{{ route('admin.sell.regular.sell.single.view') }}">
            <!-------single sell view Modal------> 
            
             <!-------single sell invoice profit loss view Modal------> 
            <div class="modal fade" id="singleSellInvoiceProftLossModalView"  aria-modal="true"></div>
            <input type="hidden" class="singleSellInvoiceProftLossModalRoute" value="{{ route('admin.sell.regular.sell.view.single.invoice.profit.loss') }}">
            <!-------single sell invoice profit loss view Modal------> 
            

            <!-------Sell product delivery Modal------> 
            <div class="modal fade" id="sellProductDeliveryModal"  aria-modal="true"></div>
            <input type="hidden" class="sellProductDeliveryInvoiceWiseModalRoute" value="{{route('admin.sell.product.delivery.invoice.wise.list.index')}}">
            <!-------Sell product delivery Modal------> 

            <!-------Sell product delivery Modal------> 
            <div class="modal fade" id="sellProductReturnModal"  aria-modal="true"></div>
            <input type="hidden" class="sellProductReturnInvoiceWiseModalRoute" value="{{route('admin.sell.product.return.invoice.wise.list.index')}}">
            <!-------Sell product delivery Modal------> 

            <!------Single Sell receive payment Modal------> 
            <div class="modal fade" id="sellViewSingleInvoiceReceivePaymentModal"  aria-modal="true"></div>
            <input type="hidden" class="sellViewSingleInvoiceReceivePaymentModalRoute" value="{{route('admin.sell.regular.sell.view.single.invoice.receive.payment.modal')}}">
            <input type="hidden" class="paymentBankingOptionUrl" value="{{route('admin.payment.common.banking.option.data')}}">
            <!-------Single Sell receive payment Modal------> 

            <!------Single Sell overall adjustment discount Modal------> 
            <div class="modal fade" id="sellViewSingleInvoiceOverallAdjustmentDiscountModal"  aria-modal="true"></div>
            <input type="hidden" class="sellViewSingleInvoiceOverallAdjustmentDiscountModalRoute" value="{{route('admin.sell.regular.sell.view.single.invoice.for.overall.adjustment.discount')}}">
            <input type="hidden" class="sellViewSingleInvoiceOverallAdjustmentDiscountReceivingRouteUrl" value="{{route('admin.sell.regular.sell.view.single.invoice.for.overall.adjustment.discount.receiving')}}">
            <!-------Single Sell overall adjustment discount Modal------> 

             <!------view Single Sell payment Modal------> 
             <div class="modal fade" id="viewSellSingleInvoiceReceivePaymentModal"  aria-modal="true"></div>
             <input type="hidden" class="viewSellSingleInvoiceReceivePaymentModalRoute" value="{{route('admin.sell.regular.sell.view.single.invoice.wise.payment.details.modal')}}">
             <!-------view Single Sell payment Modal------> 


           {{--  <!-------delete Customer Modal------> 
            @include('backend.customer.customer.partial.delete_modal')
            <input type="hidden" class="deleteCustomerModalRoute" value="{{ route('admin.customer.delete') }}">
            <!-------delete Customer Modal------> --}} 
            



        
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


    {{--sell list url --}}
    <input type="hidden" class="sellListUrl" value="{{route('admin.sell.regular.sell.list.ajaxresponse')}}">
    {{--sell list url --}}
    


<!--=================js=================-->
@push('js')
<!--=================js=================-->
<script src="{{asset('custom_js/backend')}}/sell/sell_details/index.js?v=1"></script>
<script src="{{asset('custom_js/backend')}}/sell/delivery/index.js?v=1"></script>
<script src="{{asset('custom_js/backend')}}/sell/sell_return/index.js?v=1"></script>
<script src="{{asset('custom_js/backend')}}/sell/sell_payment/payment.js?v=1"></script>
<script src="{{asset('custom_js/backend')}}/sell/sell_return_payment/return_payment.js?v=2"></script>

<!---for date picker-->
{{-- <script src="{{asset('backend/links/assets')}}/libs/bootstrap-material-datetimepicker/bootstrap-material-datetimepicker.js"></script>
<script src="{{asset('backend/links/assets')}}/js/pages/forms_pickers.js"></script>
 --}}<!---for date picker-->   

<!--=================js=================-->
@endpush
<!--=================js=================-->



<!--%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%-->
<!--%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%^^^^Content^^^^%%%%%%%%%%%%%%%%%%%%%%%%%%%%%-->
@endsection
<!--%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%^^^^Content^^^^%%%%%%%%%%%%%%%%%%%%%%%%%%%%%-->
<!--%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%-->
