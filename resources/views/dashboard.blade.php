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
            <h4 class="font-weight-bold py-3 mb-0">Home Page  </h4>
            <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#"><i class="feather icon-home"></i></a>
                    </li>
                    <li class="breadcrumb-item">Home Page</li>
                    <li class="breadcrumb-item active">Home Page</li>
                </ol>
            </div>
            <div class="products">
                <a href="{{route('admin.sell.regular.sell.index')}}">Sell List</a>
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
        
            <style>
                .container_parent {
                    display: flex;
                    width: 100%;
                }
                .container_child {
                    width:100%;
                    height: 100px;
                    margin: 5px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    color: #ffff;"
                }
            </style>
            <div class="modal fade" id="afterSellCompleteModal"  aria-modal="true" style="display:block;overflow-y: auto;">
               
                <div class="modal-dialog modal-xl" style="pointer-events: all;background-color:#ffff;border: 1px solid #d9d6d6">
                    
                    <div class="modal-body">
                        
                        <div style="margin-top:20%;margin-bottom:20%;margin-right:30%;margin-left:30%;">
                            <div class="container_parent">
                                <div class="container_child" style="background-color:#4c4cad;">
                                    <a href="{{route('admin.sell.regular.sell.index')}}" style="font-size:20px;font-weight:bold;cursor: pointer;color:#ffff;"><i class="fa fa-shopping-cart" aria-hidden="true"></i></i> Sell List</strong>
                                </div>
                                <div class="container_child" style="background-color:#1b1b4e;">
                                    <a href="{{route('home')}}" style="font-size:20px;font-weight:bold;cursor: pointer;color:#ffff;"><i class="fa fa-home" aria-hidden="true"></i> Dashboard</a>
                                </div>
                            </div>
                            <div class="container_parent">
                                <div class="container_child" style="background-color:#337e33;">
                                    <a blank="_target" style="font-size:20px;font-weight:bold;cursor: pointer;"><i class="fa fa-print" aria-hidden="true"></i> Print</a>
                                </div>
                                <div class="container_child" style="background-color: #f35a5a;">
                                    <strong style="font-size:20px;font-weight:bold;cursor: pointer;" class="closeModal"><i class="fa fa-times" aria-hidden="true"></i> Close</strong>
                                </div>
                            </div>
                        </div>                        
                        
                    </div>
                    <!--modal body-->
                    <div class="modal-footer" ></div>
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
    
    <script>
        /* $(document).ready(function(){
            $("#afterSellCompleteModal").attr('class','modal fade-in');
        });
        $(document).on('click','.closeModal',function(){
            $("#afterSellCompleteModal").attr('class','modal fade');
        }); */
    </script>
    
<!--=================js=================-->
@endpush
<!--=================js=================-->



<!--%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%-->
<!--%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%^^^^Content^^^^%%%%%%%%%%%%%%%%%%%%%%%%%%%%%-->
@endsection
<!--%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%^^^^Content^^^^%%%%%%%%%%%%%%%%%%%%%%%%%%%%%-->
<!--%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%-->


