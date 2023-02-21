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
                            <td style="width:25%"></td>
                            <td style="width:50%">
                                <label for="">Search </label>
                                <input type="text" class="search form-control" name="search" autofocus autocomplete="off" placeholder="{{productCustomCodeLabel_hh()}} / company code / sku">
                            </td>
                            <td style="width:25%"></td>
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
                <div  style="padding:2%;">
                    <h4 style="text-align: center;">Search Result</h4>
                    <h6 style="text-align: center;color:red;">Product Not Match</h6>
                    <h6 style="text-align: center;">OR, Product Found! </h6>
                    @include('backend.stock.checkStockFromOtherBranch.search_result')
                </div>
            </div>
            <!-------responsive table------> 

            




        
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


    
    <input type="hidden" class="renderSingleProductDetialsUrl" value="{{route('admin.product.stock.render.single.product.details')}}">
    

<!--=================js=================-->
@push('js')
<!--=================js=================-->
{{-- <script src="{{asset('custom_js/backend')}}/product-stock/index.js?v=1"></script> --}}

    <script>
        jQuery(document).on('keyup keypress','.inputFieldValidatedOnlyNumeric',function(e){
            if (String.fromCharCode(e.keyCode).match(/[^0-9\.]/g)) return false;
        });
        
        jQuery(document).on('keyup keypress','.quantity',function(e){
            totalQutantity();
        });
        
        $(document).on('click','.cancelInsertStock',function(e){
            $('.search').val('');
            $('.search').focus();
            searchFunctional(e);
            totalQutantity();
        });
        //search 
        var ctrlDown = false,ctrlKey = 17,cmdKey = 91,vKey = 86,cKey = 67;xKey = 88;
        $(document).on('keypress keyup','.search',function(e){
            searchFunctional(e);
        });
       
        function searchFunctional(e)
        {
            $('.enableDisableActionOfSubmitButton').attr('disabled',true);
            $('.disabledAllInputField').attr('disabled',true);
            if (e.keyCode == ctrlKey || e.keyCode == cmdKey) ctrlDown = true;
            if (ctrlDown && (e.keyCode == vKey || e.keyCode == cKey || e.keyCode == xKey)) return false;
            var search = $('.search').val();
            var url = $('.renderSingleProductDetialsUrl').val();
            $.ajax({
                url: url,
                data:{
                   search:search
                },
                type: "GET",
                datatype:"HTML",
                success: function(response){
                    if(response.status == true)
                    {
                        //$.notify(response.message, response.type);
                        $('.renderHereSingleProductDetailsForAddingStock').html(response.html);
                    }else{
                        $.notify(response.message, response.type);
                        $('.renderHereSingleProductDetailsForAddingStock').html(response.form);
                    }
                    if(response.action == true)
                    {
                        //$('.enableDisableActionOfSubmitButton').removeAttr('disabled');
                        $('.disabledAllInputField').removeAttr('disabled');
                    }else{
                        //$('.enableDisableActionOfSubmitButton').attr('disabled',true);
                        $('.disabledAllInputField').attr('disabled',true);
                    }
                },
            });
        }
        //-----------------------------------------------------------------------
        
        $(document).on("submit",'.storeInitialProductStock',function(e){
            e.preventDefault();
            $('.enableDisableActionOfSubmitButton').attr('disabled',true);
            var form = $(this);
            $('.color-red').text('');
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                enctype: 'multipart/form-data',
                data: new FormData(this),
                processData: false,
                contentType: false,
                beforeSend:function(){
                    $('.processing').fadeIn();
                    $('.submit_button_processing_gif').fadeIn();
                },
                success: function(response){
                    if(response.status == 'errors')
                    {   
                        printErrorMsg(response.error);
                    }
                    else if(response.status == 'exception')
                    {
                        $.notify(response.message, response.type);
                    }
                    else if(response.status == true)
                    {
                        form[0].reset();
                        $.notify(response.message, response.type);
                        /* setTimeout(function(){
                            $('#addProductModal').modal('hide');//hide modal
                            productList();
                            //window.location = redirectUrl;
                        },200); */
                        $('.search').val('');
                        $('.search').focus();
                        searchFunctional(e);
                    }
                },
                complete:function(){
                    $('.processing').fadeOut();
                    $('.submit_button_processing_gif').fadeOut();
                },
            });
            //end ajax

            function printErrorMsg(msg) {
                $('.color-red').css({'color':'red'});
                $.each(msg, function(key, value ) {
                    $('.'+key+'_err').text(value);
                });
            }
        });
        //-----------------------------------------------------------------------
        function totalQutantity(){
            var total = 0;
            $(".quantity").each(function() {
                total += nanCheck($(this).val());
            });
            if(total > 0){
                $('.enableDisableActionOfSubmitButton').removeAttr('disabled');
            }else{
                $('.enableDisableActionOfSubmitButton').attr('disabled',true);
            }
        }

        
    function nanCheck(value)
    {
        if(isNaN(value))
        {
            return 0;
        }
        else{
            return value;
        }
    }


    </script>
<!--=================js=================-->
@endpush
<!--=================js=================-->



<!--%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%-->
<!--%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%^^^^Content^^^^%%%%%%%%%%%%%%%%%%%%%%%%%%%%%-->
@endsection
<!--%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%^^^^Content^^^^%%%%%%%%%%%%%%%%%%%%%%%%%%%%%-->
<!--%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%-->
