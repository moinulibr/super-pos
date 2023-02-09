<!DOCTYPE html>
<!--
Template Name: Kundol Admin - Bootstrap 4 HTML Admin Dashboard Theme
Author: Themescoder
Website: http://www.themescoder.net/
Contact: support@themescoder.net
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<html lang="en">
    <!--begin::Head-->

    <head>
        <meta charset="utf-8" />
        <title> {{ config('app.name') }}  @yield('page_title') | Sell Edit</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="Updates and statistics" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <!--begin::Fonts-->
        <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" /> -->
        <!--end::Fonts-->

        <!--begin::Global Theme Styles(used by all pages)-->
        <link href="{{asset('backend/pos')}}/assets/css/stylec619.css?v=1.0" rel="stylesheet" type="text/css" />
        <!--end::Global Theme Styles-->

        <link href="{{asset('backend/pos')}}/assets/api/pace/pace-theme-flat-top.css" rel="stylesheet" type="text/css" />
        <link href="{{asset('backend/pos')}}/assets/api/mcustomscrollbar/jquery.mCustomScrollbar.css" rel="stylesheet" type="text/css" />

        <link href="{{asset('backend/pos')}}/assets/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
        <link href="{{asset('backend/pos')}}/assets/css/multiple-select.min.css" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="{{asset('backend/pos')}}/assets/css/daterangepicker.css" />



        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>



        <link rel="shortcut icon" href="{{asset('backend/pos/')}}/assets/media/logos/favicon.html" />
        <style>
            .h-90{
                height: 90% !important;
            }
            @media screen and (min-width: 760px) {
                .table-contentpos .table-datapos {
                    height: 180px !important;
                }
            }
            @media screen and (min-width: 820px) {
                .table-contentpos .table-datapos {
                    height: 200px !important;
                }
            }
            @media screen and (min-width: 1120px) {
                .table-contentpos .table-datapos {
                    height: 210px !important;
                }
            }
            @media screen and (min-width: 1800px) {
                .table-contentpos .table-datapos {
                    height: 360px !important;
                }
            }
            .contentPOS{
                padding-top: 20px !important;
                padding-bottom: 0px !important;
            }
            .card-custom.gutter-b {
                height: calc(100% - 20px) !important;
            }
        </style>
    </head>
    <!--end::Head-->
    <!--begin::Body-->

    <body id="tc_body" class="header-fixed header-mobile-fixed subheader-enabled aside-enabled aside-fixed">
        <!-- Paste this code after body tag -->
        {{-- <div class="se-pre-con">
            <div class="pre-loader">
                <img class="img-fluid" src="{{asset('backend/pos')}}/assets/images/loadergif.gif" alt="loading" />
            </div>
        </div> --}}
        <!-- pos header -->
        @php
            $sellInvoice = session()->get('sellInvoice_for_edit');
        @endphp
        <header class="pos-header bg-white">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <!--welcome-->
                    <div class="col-xl-4 col-lg-4 col-md-6">
                        <div class="greeting-text">
                            <h3 class="card-label mb-0 font-weight-bold text-primary">
                                <a href="{{route('admin.sell.regular.sell.index')}}"  title="go to sell list" style="text-decoration: none;">Sell Edit</a>
                            </h3>
                            <h3 class="card-label mb-0">
                                <a href="{{route('admin.sell.regular.sell.index')}}"  title="go to sell list" style="text-decoration: none;">
                                    Invoice No : {{$sellInvoice->invoice_no}}
                                </a>
                            </h3>
                        </div>
                    </div>
                    <!--welcome-->

                    <!--clock, hour , minute, second-->
                    <div class="col-xl-4 col-lg-5 col-md-6 clock-main">
                        <div class="clock">
                            <div class="datetime-content">
                                <ul>
                                    <li id="hours"></li>
                                    <li id="point1">:</li>
                                    <li id="min"></li>
                                    <li id="point">:</li>
                                    <li id="sec"></li>
                                </ul>
                            </div>
                            <div class="datetime-content">
                                <div id="Date" class=""></div>
                            </div>
                        </div>
                    </div>
                    <!--clock, hour , minute, second-->

                    <div class="col-xl-4 col-lg-3 col-md-12 order-lg-last order-second">
                        <div class="topbar justify-content-end">
                            <!--calculator-->
                            <div class="dropdown mega-dropdown">
                                <div id="id2" class="topbar-item" data-toggle="dropdown" data-display="static">
                                    <div class="btn btn-icon w-auto h-auto btn-clean d-flex align-items-center py-0 mr-3">
                                        <span class="symbol symbol-35 symbol-light-success">
                                            <span class="symbol-label bg-primary font-size-h5">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" fill="#fff" class="bi bi-calculator-fill" viewBox="0 0 16 16">
                                                    <path
                                                        d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2zm2 .5v2a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5v-2a.5.5 0 0 0-.5-.5h-7a.5.5 0 0 0-.5.5zm0 4v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5zM4.5 9a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zM4 12.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5zM7.5 6a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zM7 9.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5zm.5 2.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zM10 6.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5zm.5 2.5a.5.5 0 0 0-.5.5v4a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-4a.5.5 0 0 0-.5-.5h-1z"
                                                    />
                                                </svg>
                                            </span>
                                        </span>
                                    </div>
                                </div>
                                <div class="dropdown-menu dropdown-menu-right calu" style="min-width: 248px;">
                                    <div class="calculator">
                                        <div class="input" id="input"></div>
                                        <div class="buttons">
                                            <div class="operators">
                                                <div>+</div>
                                                <div>-</div>
                                                <div>&times;</div>
                                                <div>&divide;</div>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <div class="leftPanel">
                                                    <div class="numbers">
                                                        <div>7</div>
                                                        <div>8</div>
                                                        <div>9</div>
                                                    </div>
                                                    <div class="numbers">
                                                        <div>4</div>
                                                        <div>5</div>
                                                        <div>6</div>
                                                    </div>
                                                    <div class="numbers">
                                                        <div>1</div>
                                                        <div>2</div>
                                                        <div>3</div>
                                                    </div>
                                                    <div class="numbers">
                                                        <div>0</div>
                                                        <div>.</div>
                                                        <div id="clear">C</div>
                                                    </div>
                                                </div>
                                                <div class="equal" id="result">=</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--calculator-->
                            
                            <!--Last Sell List-->
                            <div class="topbar-item">
                                <div class="btn btn-icon w-auto h-auto btn-clean d-flex align-items-center py-0 mr-3" data-toggle="modal" data-target="#LastsellList">
                                    <a href="{{route('home')}}" title="go to home">
                                    <span class="symbol symbol-35 symbol-light-success">
                                        <span class="symbol-label bg-success font-size-h5">
                                            <svg width="20px" height="20px" xmlns="http://www.w3.org/2000/svg" fill="#ffff" viewBox="0 0 16 16">
                                                <path
                                                    d="M9.828 3h3.982a2 2 0 0 1 1.992 2.181l-.637 7A2 2 0 0 1 13.174 14H2.826a2 2 0 0 1-1.991-1.819l-.637-7a1.99 1.99 0 0 1 .342-1.31L.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3zm-8.322.12C1.72 3.042 1.95 3 2.19 3h5.396l-.707-.707A1 1 0 0 0 6.172 2H2.5a1 1 0 0 0-1 .981l.006.139z"
                                                ></path>
                                            </svg>
                                        </span>
                                    </span>
                                </a>
                                </div>
                            </div>
                            <!--Last Sell List-->

                            <!--logout-->
                            <div class="dropdown">
                                <div class="topbar-item" data-toggle="dropdown" data-display="static">
                                    <div class="btn btn-icon w-auto h-auto btn-clean d-flex align-items-center py-0">
                                        <span class="symbol symbol-35 symbol-light-success">
                                            <span class="symbol-label font-size-h5">
                                                <svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-person-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"></path>
                                                </svg>
                                            </span>
                                        </span>
                                    </div>
                                </div>
                                <div class="dropdown-menu dropdown-menu-right" style="min-width: 150px;">
                                    <a  class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                        <span class="svg-icon svg-icon-xl svg-icon-primary mr-2">
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                width="20px"
                                                height="20px"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                class="feather feather-power"
                                            >
                                                <path d="M18.36 6.64a9 9 0 1 1-12.73 0"></path>
                                                <line x1="12" y1="2" x2="12" y2="12"></line>
                                            </svg> Logout
                                        </span>
                                       {{--  <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                        <i class="feather icon-power text-danger"></i>
                                        &nbsp; Log Out
                                    </a> --}}
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                    </a>
                                </div>
                            </div>
                            <!--logout-->
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="contentPOS h-90" style="background-color:#0b3b5e !important">
            <div class="container-fluid h-100">
                <!-----row------>
                <div class="row h-100">
                    <!-----col-8------>
					<div class="col-xl-8 col-lg-8 col-md-12 h-100">
                        <div class="card card-custom gutter-b bg-white border-0 table-contentpos">
                            <div class="card-body h-25">
                                <div class="d-flex justify-content-between colorfull-select">
                                    <!----------Customer---------->
                                    <div class="selectmain" style="width: 45%;">
                                        <label class="text-dark d-flex">
                                            Choose a Customer
                                            {{-- <span class="badge badge-secondary white rounded-circle" data-toggle="modal" data-target="#choosecustomer" style="cursor: pointer">
                                                <i class="fa fa-plus"></i>
                                            </span> --}} 
                                            <span class="addCustomerModal badge badge-secondary white rounded-circle" data-create_from_value="customer" data-class_name="addedNewCustomer" style="cursor: pointer">
                                                <i class="fa fa-plus"></i>
                                            </span>

                                            {{-- <span style="padding-left:2%;">
                                                <span class="badge badge-secondary white rounded-circle ml-2" data-toggle="modal" data-target="#shippingpop" style="cursor: pointer">
                                                    <i class="fa fa-plus"></i>
                                                </span>
                                            </span>
                                            <span style="padding-left:1px;">Shipping Address</span> --}}
                                        </label>
                                        <select class="addedNewCustomer customer_id arabic-select" style="width: 100%;"> <!--arabic-select--->
                                            <option value="">Select a customer</option>
                                            @foreach ($customers as $item)
                                            <option {{$sellInvoice->customer_id == $item->id ? 'selected' : ''}} value="{{$item->id}}">{{$item->name}} ({{$item->phone}})</option>
                                            @endforeach
                                        </select>
                                    </div><!----------Customer---------->

                                    <!----------reference---------->
                                    <div class="d-flex flex-column selectmain" style="width: 45%;">
                                        <label class="text-dark d-flex">
                                            Reference
                                            {{-- <span class="badge badge-secondary white rounded-circle" data-toggle="modal" data-target="#shippingpop" style="cursor: pointer">
                                                <i class="fa fa-plus"></i>
                                            </span> --}} 
                                            <span class="addReferenceModal badge badge-secondary white rounded-circle"  data-create_from_value="customer" data-class_name="addedNewReference" style="cursor: pointer">
                                                <i class="fa fa-plus"></i>
                                            </span>
                                        </label>
                                        <select class="addedNewReference reference_id arabic-select" style="width: 100%;"><!--arabic-select--->
                                            <option value="">Select Reference</option>
                                            @foreach ($references as $item)
                                            <option {{$sellInvoice->reference_id == $item->id ? 'selected' : ''}} value="{{$item->id}}">{{$item->name}} ({{$item->phone}})</option>
                                            @endforeach
                                        </select>
                                    </div><!----------reference---------->
                                </div>

                                <!-- search product
                                    <div class="form-group row mt-3 mb-0">
                                        <div class="col-md-12">
                                            <label>Select Product</label>
                                            <fieldset class="form-group mb-0 d-flex barcodeselection">
                                                <select class="form-control w-25" id="exampleFormControlSelect1">
                                                    <option>Name</option>
                                                    <option>SKU</option>
                                                </select>
                                                <input type="text" class="form-control border-dark" id="basicInput1" placeholder="" />
                                            </fieldset>
                                        </div>
                                    </div> 
                                -->
                                <!-- search product--->
                            </div>
                            
                            <!---------added to cart product list----------->
                            <div class="display_sell_edit_added_to_cart_product_list">
                                @include('backend.sell.edit.ajax-response.landing.added-to-cart.list')
                            </div>
                            <!---------added to cart product list----------->

                            <div style="padding: 4px 0px;background: #e6e6e6;"></div>

                            <!---------summery of added to cart product list----------->
                            <div class="card-body h-75">
                                <!-- 
                                    <div class="shop-profile">
                                        <div class="media">
                                            <div class="bg-primary w-100px h-100px d-flex justify-content-center align-items-center">
                                                <h2 class="mb-0 white">K</h2>
                                            </div>
                                            <div class="media-body ml-3">
                                                <h3 class="title font-weight-bold">The Kundol Shop</h3>
                                                <p class="phoonenumber">
                                                    02199+(070)234-4569
                                                </p>
                                                <p class="adddress">
                                                    Russel st 50,Bostron,MA
                                                </p>
                                                <p class="countryname">USA</p>
                                            </div>
                                        </div>
                                    </div> 
                                -->
                                
                                <div class="resulttable-pos">
                                    <div class="row">
                                        <style>
                                            .btnFullWidth{
                                                width: 100%;padding: 2%;                                            
                                            }
                                        </style>
                                        <div class="col-3" style="border-right: 1px solid #e9ecef;">
                                            <a href="#" class="btn btn-danger btnFullWidth white removeOrEmptyAllItemFromCreateSellCartList" style="margin-top: 1%;">
                                                Cancel
                                            </a>
                                            @if ($sellInvoice->sell_type == 2)    
                                            <a href="#" class="quotationModalOpen btn btn-dark btnFullWidth white" style="margin-top: 1%; cursor: pointer;">
                                                Quotation <img class="quotation_processing_gif" src="{{asset('loading-img/loading1.gif')}}" alt="" style="margin-left:auto;margin-right:auto;height:20px;display:none;">
                                            </a>
                                            @else
                                            <a href="#" class="btn btn-dark btnFullWidth white" style="margin-top: 1%; cursor: pointer;cursor:not-allowed !important;">
                                                Quotation 
                                            </a>
                                            @endif

                                            <a href="#" class="paymentModalOpen  btn btn-success btnFullWidth white" style="margin-top: 1%; cursor: pointer;">{{--paymentQuotationButtonWhenCartItemMoreThenZero data-toggle="modal" data-target="#payment-popup"--}}
                                                Payment <img class="payment_processing_gif" src="{{asset('loading-img/loading1.gif')}}" alt="" style="margin-left:auto;margin-right:auto;height:20px;display:none;background-color:#ffff;border-radius: 50%;">
                                            </a>
                                            <input type="hidden" class="paymentModalOpenUrl" value="{{route('admin.sell.edit.regular.pos.sell.edit.payment.modal.open')}}">
                                            <input type="hidden" class="paymentBankingOptionUrl" value="{{route('admin.payment.common.banking.option.data')}}">
                                            <input type="hidden" class="quotationModalOpenUrl" value="{{route('admin.sell.edit.regular.pos.sell.edit.quotation.modal.open')}}">

                                            <a href="" class="print normal_print_direct_from_sell_cart btn btn-info btnFullWidth white" data-href="#" style="margin-top: 1%;" target="_blank">
                                                POS Print
                                            </a>
                                            <a class="normalPriceFromSellList pos_print_direct_from_sell_cart btn btn-primary btnFullWidth white" target="_blank" style="cursor:not-allowed !important;margin-top:1%;color:#d1cdcd;">
                                                Print
                                            </a>
                                            {{-- data-href="{{ route('admin.sell.regular.pos.normal.print.from.direct.sell.cart') }}"--}}
                                        </div>

                                        <div class="col-8">
                                            @include('backend.sell.edit.landing.include.invoice_final_calculation_summery')
                                        </div>
                                    </div>                                    
                                </div>
                            </div>
                            <!---------summery of added to cart product list----------->
                        </div>
                        
                    </div><!-----col-8------>

                    <!-----col-4------>
                    <div class="col-xl-4 col-lg-4 col-md-12 h-100">
                        <div class="card-custom gutter-b bg-white border-0">
                            <div class="card-body mb-4">
                                <div class="row">
                                    <div class="col-md-5"></div>
                                    <div class="col-md-2">
                                        <img class="product_rendering_processing_gif" src="{{asset('loading-img/loading1.gif')}}" alt="" style="margin-left:auto;margin-right:auto;height:40px;display:none;background-color:#FFFCFD;border-radius: 50%;">
                                    </div>
                                    <div class="col-md-5"></div>
                                </div>
                                <div class="row" style="margin-top: 10px;">
                                    <div class="col-md-12">
                                        <div class="selectmain">
                                            <select  name="category_id"  class="category_id arabic-select select2 bag-primary" style="width:100%">
                                                <option value="">All Categories</option>
                                                @foreach ($categories as $item)
                                                <option value="{{$item->id}}">{{$item->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 10px;">
                                    <div class="col-md-12">
                                        <div class="selectmain">
                                            <select  name="product_id" class="product_id arabic-select select2 bag-primary" style="width:100%">
                                                <option value="">All Product</option>
                                                @foreach ($allproducts as $item)
                                                <option value="{{$item->id}}">
                                                    @php
                                                        $product = $item->name;
                                                        if(strlen($item->name) > 70)
                                                        {
                                                            $len = substr($item->name,0,70);
                                                            if(str_word_count($len) > 1)
                                                            {
                                                                $product = implode(" ",(explode(' ',$len,-1)));
                                                            }else{
                                                                $product = $len;
                                                            }
                                                            $product = $product ."...";
                                                        }
                                                    @endphp
                                                    {{$product}}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                               <!--  <div class="selectmain mt-2">
                                    <input type="text" placeholder="Search.." style="width: 100%;border: 1px solid #e9ecef;padding: 1%;" />
                                </div> -->
                                <div class="form-group row mt-3 mb-0" style="padding-bottom: 15px;">
                                    <div class="col-md-12" style="padding-bottom:5px;">
                                        <fieldset class="form-group mb-0 d-flex barcodeselection">
                                            <input name="custom_search" type="text" class="custom_search form-control border-dark" id="basicInput1" autofocus placeholder="product name / {{ strtolower( productCustomCodeLabel_hh() ) }} / company code / sku"/>
                                        </fieldset>
                                    </div>
                                </div> 
                                
                            </div>

                            
                            <div class="card-body product-items" style="background-color: #efefef;">
                                <!----display all product list--->
                                <div class="display-all-product-list">
                                    @include('backend.sell.edit.product_list')
                                </div>
                                <!----display all product list--->
                            </div>

                        </div>
                    </div><!-----col-4------>
                </div><!-----row------>
            </div>
        </div>

    <!-- Button trigger modal -->

        @include('backend.sell.edit.landing.modal.payment_modal')
        @include('backend.sell.edit.landing.modal.quotation_modal')
        @include('backend.sell.edit.landing.modal.shipping_modal')
        @include('backend.sell.edit.landing.modal.shipping_cost_modal')
        @include('backend.sell.edit.landing.modal.choose_customer_modal')
        @include('backend.sell.edit.landing.modal.folder_modal')

       

  

        <!-------show single Product details  Modal------> 
        <div class="modal fade" id="showProductDetailModal"  aria-modal="true"></div>
        <input type="hidden" class="showProductDetailsModalRoute" value="{{ route('admin.sell.edit.regular.pos.show.single.product.details') }}">
        <!-------show single Product details  Modal------> 

        <!-------show Product quantity Modal------> 
        <div class="modal fade" id="showQuantityWiseProductStockModal"  aria-modal="true"></div>
        <!-------show Product quantity Modal------> 

        <!-------display product list------> 
        <input type="hidden" class="displayProductListUrl" value="{{ route('admin.sell.edit.regular.pos.display.product.list') }}">
        <!-------display product list------> 
        
        <!-------display added to product list------> 
        <input type="hidden" class="displaySellCreateAddedToCartProductListUrl" value="{{ route('admin.sell.edit.regular.pos.display.sell.edit.created.added.to.cart.product.list') }}">
        <!-------display added to product list------> 
        
        <!------- invoice final calculation summery------> 
        <input type="hidden" class="invoiceFinalSellCalculationSummeryUrl" value="{{ route('admin.sell.edit.regular.pos.sell.edit.final.invoice.calculation.summery') }}">
        <!------- invoice final calculation summery------> 

        <!-------remove single item from added to sell cart list------> 
        <div class="modal fade" id="removeSingleItemFromSellAddedToCartModal"  aria-modal="true"></div>
        <input type="hidden" class="removeConfirmationRequiredSingleItemFromSellAddedToCartListUrl" value="{{ route('admin.sell.edit.regular.pos.remove.confirmation.required.single.item.from.sell.edit.added.to.cart.list') }}">
        <input type="hidden" class="removeSingleItemFromSellAddedToCartListUrl" value="{{ route('admin.sell.edit.regular.pos.remove.single.item.from.sell.edit.added.to.cart.list') }}">
        <!-------remove single item from added to sell cart list------> 

        <!-------remove all item from added to sell cart list------> 
        <div class="modal fade" id="removeAllItemFromSellAddedToCartModal"  aria-modal="true"></div>
        <input type="hidden" class="removeConfirmationRequiredAllItemFromSellAddedToCartListUrl" value="{{ route('admin.sell.edit.regular.pos.remove.confirmation.required.all.item.from.sell.edit.added.to.cart.list') }}">
        <input type="hidden" class="removeAllItemFromSellAddedToCartListUrl" value="{{ route('admin.sell.edit.regular.pos.remove.all.item.from.sell.edit.added.to.cart.list') }}">
        <!-------remove all item from added to sell cart list------> 

        <!-------change quantity from added to sell cart list------> 
        <input type="hidden" class="changeQuantityFromSellAddedToCartListUrl" value="{{ route('admin.sell.edit.regular.pos.change.quantity.from.sell.edit.added.to.cart.list') }}">
        <!-------change quantity from added to sell cart list------> 


        <script src="{{asset('backend/pos')}}/assets/js/plugin.bundle.min.js"></script>
        <script src="{{asset('backend/pos')}}/assets/js/bootstrap.bundle.min.js"></script>
        <script src="{{asset('backend/pos')}}/assets/js/jquery.dataTables.min.js"></script>
        <script src="{{asset('backend/pos')}}/assets/js/multiple-select.min.js"></script>
        <script src="{{asset('backend/pos')}}/assets/js/sweetalert.js"></script>
        <script src="{{asset('backend/pos')}}/assets/js/sweetalert1.js"></script>

        <!--notify js-->
        <script src="{{asset('backend/links/assets')}}/js/notify.js"></script>

        <!--not using this script.bundle.js file js-->
        {{-- <script src="{{asset('backend/pos')}}/assets/js/script.bundle.js"></script> --}}
        <!--not using this script.bundle.js file js-->
        <script src="{{asset('backend/pos')}}/assets/js/time-calculator.js"></script>

        <script>
            jQuery(function () {
                jQuery(".arabic-select").multipleSelect({
                    filter: true,
                    filterAcceptOnEnter: true,
                });
            });
            jQuery(function () {
                jQuery(".js-example-basic-single").multipleSelect({
                    filter: true,
                    filterAcceptOnEnter: true,
                });
            });
            jQuery(document).ready(function () {
                jQuery("#orderTable").DataTable({
                    info: false,
                    paging: false,
                    searching: false,

                    columnDefs: [
                        {
                            targets: "no-sort",
                            orderable: false,
                        },
                    ],
                });
            });
        </script>

                        
            {{-- <div style="display: none;" class="processing">
                <img src="{{asset('loading-img/loading.gif')}}" alt="" style="display: block;margin-left: auto;margin-right: auto;width: 5%;height: 40px;">
            </div> --}}
            

        <!-- AJAX Js-->
        <script>
                jQuery.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });
        </script>
        
        @stack('pos-js')

        <script src="{{asset('custom_js/backend')}}/sell/sell_edit_pos/landing/product-list.js"></script>
        <script src="{{asset('custom_js/backend')}}/sell/sell_edit_pos/single-product/stock-with-price.js"></script>
        <script src="{{asset('custom_js/backend')}}/sell/sell_edit_pos/add-to-cart/add_to_cart.js"></script>
        
        <script src="{{asset('custom_js/backend')}}/sell/session/setting.js"></script>

        
        <!---customer related js file--->
        <!--<span class="addCustomerModal badge badge-secondary white rounded-circle" data-create_from_value="customer" data-class_name="addedNewCustomer" style="cursor: pointer"><i class="fa fa-plus"></i>-->
        <!-------add Customer Modal------> 
        <div class="modal fade " id="addCustomerModal"  aria-modal="true"></div>
        <input type="hidden" class="addCustomerModalRoute" value="{{ route('admin.customer.create') }}">
        <!-------add Customer Modal------> 
        <script src="{{asset('custom_js/backend')}}/customer/customer/create.js?v=2"></script>
        <!---customer related js file--->
 
        <!---Reference related js file--->
         <!-------add Reference Modal------> 
         <div class="modal fade " id="addReferenceModal"  aria-modal="true"></div>
         <input type="hidden" class="addReferenceModalRoute" value="{{ route('admin.reference.create') }}">
         <!-------add Reference Modal------> 
         <script src="{{asset('custom_js/backend')}}/reference/reference/create.js?v=2"></script>
        <!---Reference related js file--->

    </body>
    <!--end::Body-->
</html>

