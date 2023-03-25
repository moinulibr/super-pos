@extends('layouts.backend.app')
@section('page_title') Purchase @endsection
@push('css')
<style>
  .submit_loader {
            background: rgba(0, 0, 0, 0.5);
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 999;
            display: none;
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
            <h4 class="font-weight-bold py-3 mb-0">Purchase  </h4>
            <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#"><i class="feather icon-home"></i></a>
                    </li>
                    <li class="breadcrumb-item">Purchase</li>
                    <li class="breadcrumb-item active">All Purchase</li>
                </ol>
            </div>
            <div class="products">
                <a href="{{route('admin.purchase.regular.pos.create')}}" target="_blank" class="addPurchaseModal">Add Purchase</a>
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
                            <td style="width:6%">
                                <label for="">&nbsp;</label>
                                <select class="form-control paginate" id="paginate" name="paginate" style="font-size: 12px;width:100%;">
                                    <option value="5"selected>5</option>
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="30">30</option>
                                    <option value="40">40</option>
                                    <option value="50" >50</option>
                                    <option value="100">100</option>
                                    <option value="200">200</option>
                                    <option value="300">300</option>
                                    <option value="500">500</option>
                                    <option value="1000">1000</option>
                                    <option value="1500">1500</option>
                                    <option value="2000">2000</option>
                                </select>
                            </td>
                            <td style="width:1%"></td>
                            <td style="width:14%">
                                <label for="">Date From </label>
                                <input type="date" class="form-control date_from">
                            </td>
                            <td style="width:1%"></td>
                            <td style="width:14%">
                                <label for="">Date To</label>
                                <input type="date" class="form-control date_to">    
                            </td>
                            <td style="width:1%"></td>
                            <td style="width:20%">
                                <label for=""><strong>Search</strong></label>
                                <input type="text" class="search form-control" name="search" placeholder="Search (by invoice)" autofocus autocomplete="off">
                            </td>
                            <td style="width:1%"></td>
                            <td style="width:20%">
                                <label for=""><strong>Supplier</strong></label>
                                <input type="text" class="form-control supplier" name="supplier" placeholder="Supplier Name / Phone" autofocus autocomplete="off">
                            </td>
                            <td style="width:1%"></td>
                            <td style="width:20%">
                                <label for="">&nbsp;</label>
                                <div class="display:flex">
                                    {{-- <a href="{{route('admin.sell.regular.sell.index')}}" class="btn btn-success btn">Reload</a>
                                    <a href="{{route('home')}}" class="btn btn-info btn">Home</a> --}}
                                </div>
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
                <div class="purchaseListAjaxResponseResult" style="padding:2%;">

                    @include('backend.purchase.purchase_details.partial.list')

                </div>
            </div>
            <!-------responsive table------> 

            

            <!-------single purchase view Modal------> 
            <div class="modal fade " id="singleModalView"  aria-modal="true"></div>
            <input type="hidden" class="singleViewModalRoute" value="{{ route('admin.purchase.regular.purchase.single.view') }}">
            <!-------single purchase view Modal------> 
           
            

            <!-------purchase product receive Modal------> 
            <div class="modal fade " id="purchaseProductReceiveInvoiceWiseModal"  aria-modal="true"></div>
            <input type="hidden" class="purchaseProductReceiveInvoiceWiseModalRoute" value="{{route('admin.purchase.product.receive.invoice.wise.list.index')}}">
            <!-------purchase product receive Modal------> 


            <!-------purchase receive payment Modal------> 
            <div class="modal fade " id="purchaseViewSingleInvoiceMakePaymentModal"  aria-modal="true"></div>
            <input type="hidden" class="purchaseViewSingleInvoiceMakePaymentModalRoute" value="{{route('admin.purchase.regular.purchase.view.single.invoice.make.payment.modal')}}">
            <input type="hidden" class="paymentBankingOptionUrl" value="{{route('admin.payment.common.banking.option.data')}}">
            <!-------purchase receive payment Modal------> 

            <!-------purchase receive payment Modal------> 
            <div class="modal fade " id="purchaseViewSingleInvoiceWisePaymentModal"  aria-modal="true"></div>
            <input type="hidden" class="purchaseViewSingleInvoiceWisePaymentModalRoute" value="{{route('admin.purchase.regular.purchase.view.single.invoice.wise.payment.details.modal')}}">
            <!-------purchase receive payment Modal------> 

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


    <!--purchase list url -->
    <input type="hidden" class="purchaseListUrl" value="{{route('admin.purchase.regular.purchase.list.ajaxresponse')}}">
    <!--purchase list url -->
    


<!--=================js=================-->
@push('js')
<!--=================js=================-->
<script src="{{asset('custom_js/backend')}}/purchase/purchase_details/index.js?v=1"></script>
<script src="{{asset('custom_js/backend')}}/purchase/receive/index.js?v=1"></script>
<script src="{{asset('custom_js/backend')}}/purchase/purchase_payment/payment.js?v=1"></script>



    
<!--=================js=================-->
@endpush
<!--=================js=================-->



<!--%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%-->
<!--%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%^^^^Content^^^^%%%%%%%%%%%%%%%%%%%%%%%%%%%%%-->
@endsection
<!--%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%^^^^Content^^^^%%%%%%%%%%%%%%%%%%%%%%%%%%%%%-->
<!--%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%-->
