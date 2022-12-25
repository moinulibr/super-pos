@extends('layouts.backend.app')
@section('page_title') Product Stock @endsection
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
            <h4 class="font-weight-bold py-3 mb-0"> Product Stock  </h4>
            <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#"><i class="feather icon-home"></i></a>
                    </li>
                    <li class="breadcrumb-item"> Product Stock</li>
                    <li class="breadcrumb-item active">All  Product Stock</li>
                </ol>
            </div>
            <div class="products">
                <a href="#" class="addStockModal">Add  Product Stock</a>
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
                            <td style="width: 20%">
                                <label for="">Supplier</label>
                                <select name="supplier_id" id="supplier_filter_id" class="supplier_filter_id form-control">
                                    <option value="">Select Supllier</option>
                                    @foreach ($suppliers as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option> 
                                    @endforeach
                                </select>
                            </td>
                            <td style="width:1%"></td>
                            <td style="width:14%">
                                <label for="">Group</label>
                                <select name="ground" id="ground_filter_id" class="ground_filter_id form-control">
                                    <option value="">Select Group</option>
                                    @foreach ($groups as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option> 
                                    @endforeach
                                </select>
                            </td>
                            <td style="width:1%"></td>
                            <td style="width: 15%">
                                <label for="">Brand</label>
                                <select name="brand" id="brand_filter_id" class="brand_filter_id form-control">
                                    <option value="">Select Brand</option>
                                    @foreach ($brands as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option> 
                                    @endforeach
                                </select>
                            </td>
                            <td style="width:1%"></td>
                            <td style="width:19%">
                                <label for="">Category</label>
                                <select name="category" id="category_filter_id" class="category_filter_id form-control">
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option> 
                                    @endforeach
                                </select>
                            </td>
                            <td style="width:1%"></td>
                            <td style="width: 20%">
                                <label for="">Search</label>
                                <input type="text" class="search form-control" name="search" autofocus autocomplete="off">
                            </td>
                        </tr>
                    </table>
                </div>

                {{-- <div class="on_processing" style="text-align: center;padding-bottom:20px;display:none;">
                    <strong style="color:#0c0c0c;z-index:99999;background-color:#f9f9f9;padding:3px 5px;border-radious:3px solidg gray;">
                        Processing...
                    </strong>
                </div> --}}
            </div>
        </div>
        <br>
            
            <!-------responsive table------> 
            <div style="background-color:#ffff;width: 100%;">
                <div class="productStockListAjaxResponseResult" style="padding:2%;">

                    @include('backend.stock.partial.list')

                </div>
            </div>
            <!-------responsive table------> 

            

            
            <!-------show Product Modal------> 
            <div class="modal fade " id="showProductModal"  aria-modal="true"></div>
            <input type="hidden" class="showProductModalRoute" value="{{ route('admin.product.show') }}">
            <!-------show Product Modal------> 




        
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


    {{--product stock list url --}}
    <input type="hidden" class="productStockListUrl" value="{{route('admin.product.stock.list.ajaxresponse')}}">
    {{--product stock list url --}}

<!--=================js=================-->
@push('js')
<!--=================js=================-->
<script src="{{asset('custom_js/backend')}}/product-stock/index.js?v=1"></script>

    
<!--=================js=================-->
@endpush
<!--=================js=================-->



<!--%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%-->
<!--%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%^^^^Content^^^^%%%%%%%%%%%%%%%%%%%%%%%%%%%%%-->
@endsection
<!--%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%^^^^Content^^^^%%%%%%%%%%%%%%%%%%%%%%%%%%%%%-->
<!--%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%-->
