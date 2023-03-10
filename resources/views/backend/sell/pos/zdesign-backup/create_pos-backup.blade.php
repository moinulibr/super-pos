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
        <title> {{ config('app.name') }}  @yield('page_title')</title>
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

        <header class="pos-header bg-white">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-xl-4 col-lg-4 col-md-6">
                        <div class="greeting-text">
                            <h3 class="card-label mb-0 font-weight-bold text-primary">
                                <a href="{{route('home')}}" style="text-decoration: none;">WELCOME</a>
                            </h3>
                            <h3 class="card-label mb-0">
                                Smith Joones
                            </h3>
                        </div>
                    </div>
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
                    <div class="col-xl-4 col-lg-3 col-md-12 order-lg-last order-second">
                        <div class="topbar justify-content-end">
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

                            <div class="topbar-item folder-data">
                                <div class="btn btn-icon w-auto h-auto btn-clean d-flex align-items-center py-0 mr-3" data-toggle="modal" data-target="#folderpop">
                                    <span class="badge badge-pill badge-primary">5</span>
                                    <span class="symbol symbol-35 symbol-light-success">
                                        <span class="symbol-label bg-warning font-size-h5">
                                            <svg width="20px" height="20px" xmlns="http://www.w3.org/2000/svg" fill="#ffff" viewBox="0 0 16 16">
                                                <path
                                                    d="M9.828 3h3.982a2 2 0 0 1 1.992 2.181l-.637 7A2 2 0 0 1 13.174 14H2.826a2 2 0 0 1-1.991-1.819l-.637-7a1.99 1.99 0 0 1 .342-1.31L.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3zm-8.322.12C1.72 3.042 1.95 3 2.19 3h5.396l-.707-.707A1 1 0 0 0 6.172 2H2.5a1 1 0 0 0-1 .981l.006.139z"
                                                ></path>
                                            </svg>
                                        </span>
                                    </span>
                                </div>
                            </div>

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
                                    <a href="#" class="dropdown-item">
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
                                            </svg>
                                        </span>
                                        Logout
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="contentPOS h-90">
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
                                            <span class="badge badge-secondary white rounded-circle" data-toggle="modal" data-target="#choosecustomer">
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    class="svg-sm"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                    version="1.1"
                                                    id="Layer_122"
                                                    x="0px"
                                                    y="0px"
                                                    width="512px"
                                                    height="512px"
                                                    viewBox="0 0 512 512"
                                                    enable-background="new 0 0 512 512"
                                                    xml:space="preserve"
                                                >
                                                    <g>
                                                        <rect x="234.362" y="128" width="43.263" height="256"></rect>
                                                        <rect x="128" y="234.375" width="256" height="43.25"></rect>
                                                    </g>
                                                </svg>
                                            </span>
                                        </label>
                                        <select class="arabic-select" style="width: 100%;">
                                            <option value="1">walk in customer</option>
                                        </select>
                                    </div><!----------Customer---------->

                                    <!----------reference---------->
                                    <div class="d-flex flex-column selectmain" style="width: 45%;">
                                        <label class="text-dark d-flex">
                                            Reference / Shipping Address
                                            <span class="badge badge-secondary white rounded-circle" data-toggle="modal" data-target="#shippingpop">
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    class="svg-sm"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                    version="1.1"
                                                    id="Layer_21"
                                                    x="0px"
                                                    y="0px"
                                                    width="512px"
                                                    height="512px"
                                                    viewBox="0 0 512 512"
                                                    enable-background="new 0 0 512 512"
                                                    xml:space="preserve"
                                                >
                                                    <g>
                                                        <rect x="234.362" y="128" width="43.263" height="256"></rect>
                                                        <rect x="128" y="234.375" width="256" height="43.25"></rect>
                                                    </g>
                                                </svg>
                                            </span>
                                        </label>
                                        <select class="arabic-select" style="width: 100%;">
                                            <option value="1">Men's</option>
                                            <option value="2">Accessories</option>
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
                            <style>
                                .select-product th {
                                    border: 1px solid #ddd;
                                }
                                .sticky-head {
                                    position: sticky;
                                    top: 0;
                                    background: white;
                                    padding: 10px 0;
                                }
                            </style>
                            <!---------added to cart product list----------->
                            <div class="card-body h-100">
                                <div class="table-responsive table-datapos col-md-12" id="printableTable">
                                    <table id="orderTable" class="display" style="width: 100%; font-family: Open Sans, Roboto, -apple-system, BlinkMacSystemFont,
                                    Segoe UI, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, sans-serif;">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th class="sticky-head" style="width: 3%;background-color: #f7f7f7;">Sl</th>
                                                <th class="sticky-head" style="width: 35%;text-align:center;background-color: #f7f7f7;">Name</th>
                                                <th class="sticky-head" style="width: 15%;text-align:center;background-color: #f7f7f7;">Unit</th>
                                                <th class="sticky-head" style="width: 11%;text-align:center;background-color: #f7f7f7;">Unit <br/> Price</th>
                                                <th class="sticky-head" style="width: 11%;text-align:center;background-color: #f7f7f7;">Quantity</th>
                                                <th class="sticky-head" style="width: 11%;text-align:center;background-color: #f7f7f7;">Less <br/>Amount</th>
                                                <th class="sticky-head" style="width: 11%;text-align:center;background-color: #f7f7f7;">Subtotal</th>
                                                <th class="sticky-head" style="width: 3%;background-color: #f7f7f7;"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr style="border-bottom: 0.05px dashed #dddfe0;">
                                                <td style="text-align:center;padding-top:1%;padding-bottom:1%;background-color: #f5f5f5">20.</td>
                                                <td style="text-align:center;padding-top:1%;padding-bottom:1%;">Tiger Nixon Tiger Nixon Tiger Nixon Tiger Nixon Tiger Nixon </td>
                                                <td style="text-align:center;padding-top:1%;padding-bottom:1%;">Unit Name</td>
                                                <td style="text-align:center;padding-top:1%;padding-bottom:1%;">1000.00</td>
                                                <td style="text-align:center;background-color: #f5f5f5;padding-top:1%;padding-bottom:1%;">
                                                    <span class="quantityChange" data-change_type="minus" data-product_id="1" data-quantity="1" style="cursor:pointer">
                                                        <i class="fa fa-minus-circle"></i>
                                                    </span>
                                        
                                                    <span id="set-1">100</span>
                                        
                                                    <span class="quantityChange" data-change_type="plus" data-product_id="1" data-quantity="1" style="cursor:pointer">
                                                        <i class="fa fa-plus-circle"></i>
                                                    </span>
                                                    
                                                    <br>
                                                    <strong id="not_available_message_1" style="font-size:11px; color:red;"></strong>
                                                </td>
                                                <td style="text-align:center;padding-top:1%;padding-bottom:1%;">000</td>
                                                <td style="text-align:center;background-color: #f5f5f5;padding-top:1%;padding-bottom:1%;">000</td>
                                                <td style="padding-top:1%;padding-bottom:1%;">
                                                    <div class="card-toolbar text-right">
                                                        <a href="#" class="confirm-delete" title="Delete"><i class="fas fa-trash-alt"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr style="border-bottom: 0.05px dashed #dddfe0;">
                                                <td style="text-align:center;padding-top:1%;padding-bottom:1%;background-color: #f5f5f5">20.</td>
                                                <td style="text-align:center;padding-top:1%;padding-bottom:1%;">Tiger Nixon Tiger Nixon Tiger Nixon Tiger Nixon Tiger Nixon </td>
                                                <td style="text-align:center;padding-top:1%;padding-bottom:1%;">Unit Name</td>
                                                <td style="text-align:center;padding-top:1%;padding-bottom:1%;">1000.00</td>
                                                <td style="text-align:center;background-color: #f5f5f5;padding-top:1%;padding-bottom:1%;">
                                                    <span class="quantityChange" data-change_type="minus" data-product_id="1" data-quantity="1" style="cursor:pointer">
                                                        <i class="fa fa-minus-circle"></i>
                                                    </span>
                                        
                                                    <span id="set-1">100</span>
                                        
                                                    <span class="quantityChange" data-change_type="plus" data-product_id="1" data-quantity="1" style="cursor:pointer">
                                                        <i class="fa fa-plus-circle"></i>
                                                    </span>
                                                    
                                                    <br>
                                                    <strong id="not_available_message_1" style="font-size:11px; color:red;"></strong>
                                                </td>
                                                <td style="text-align:center;padding-top:1%;padding-bottom:1%;">000</td>
                                                <td style="text-align:center;background-color: #f5f5f5;padding-top:1%;padding-bottom:1%;">000</td>
                                                <td style="padding-top:1%;padding-bottom:1%;">
                                                    <div class="card-toolbar text-right">
                                                        <a href="#" class="confirm-delete" title="Delete"><i class="fas fa-trash-alt"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr style="border-bottom: 0.05px dashed #dddfe0;">
                                                <td style="text-align:center;padding-top:1%;padding-bottom:1%;background-color: #f5f5f5">20.</td>
                                                <td style="text-align:center;padding-top:1%;padding-bottom:1%;">Tiger Nixon Tiger Nixon Tiger Nixon Tiger Nixon Tiger Nixon </td>
                                                <td style="text-align:center;padding-top:1%;padding-bottom:1%;">Unit Name</td>
                                                <td style="text-align:center;padding-top:1%;padding-bottom:1%;">1000.00</td>
                                                <td style="text-align:center;background-color: #f5f5f5;padding-top:1%;padding-bottom:1%;">
                                                    <span class="quantityChange" data-change_type="minus" data-product_id="1" data-quantity="1" style="cursor:pointer">
                                                        <i class="fa fa-minus-circle"></i>
                                                    </span>
                                        
                                                    <span id="set-1">100</span>
                                        
                                                    <span class="quantityChange" data-change_type="plus" data-product_id="1" data-quantity="1" style="cursor:pointer">
                                                        <i class="fa fa-plus-circle"></i>
                                                    </span>
                                                    
                                                    <br>
                                                    <strong id="not_available_message_1" style="font-size:11px; color:red;"></strong>
                                                </td>
                                                <td style="text-align:center;padding-top:1%;padding-bottom:1%;">000</td>
                                                <td style="text-align:center;background-color: #f5f5f5;padding-top:1%;padding-bottom:1%;">000</td>
                                                <td style="padding-top:1%;padding-bottom:1%;">
                                                    <div class="card-toolbar text-right">
                                                        <a href="#" class="confirm-delete" title="Delete"><i class="fas fa-trash-alt"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr style="border-bottom: 0.05px dashed #dddfe0;">
                                                <td style="text-align:center;padding-top:1%;padding-bottom:1%;background-color: #f5f5f5">20.</td>
                                                <td style="text-align:center;padding-top:1%;padding-bottom:1%;">Tiger Nixon Tiger Nixon Tiger Nixon Tiger Nixon Tiger Nixon </td>
                                                <td style="text-align:center;padding-top:1%;padding-bottom:1%;">Unit Name</td>
                                                <td style="text-align:center;padding-top:1%;padding-bottom:1%;">1000.00</td>
                                                <td style="text-align:center;background-color: #f5f5f5;padding-top:1%;padding-bottom:1%;">
                                                    <span class="quantityChange" data-change_type="minus" data-product_id="1" data-quantity="1" style="cursor:pointer">
                                                        <i class="fa fa-minus-circle"></i>
                                                    </span>
                                        
                                                    <span id="set-1">100</span>
                                        
                                                    <span class="quantityChange" data-change_type="plus" data-product_id="1" data-quantity="1" style="cursor:pointer">
                                                        <i class="fa fa-plus-circle"></i>
                                                    </span>
                                                    
                                                    <br>
                                                    <strong id="not_available_message_1" style="font-size:11px; color:red;"></strong>
                                                </td>
                                                <td style="text-align:center;padding-top:1%;padding-bottom:1%;">000</td>
                                                <td style="text-align:center;background-color: #f5f5f5;padding-top:1%;padding-bottom:1%;">000</td>
                                                <td style="padding-top:1%;padding-bottom:1%;">
                                                    <div class="card-toolbar text-right">
                                                        <a href="#" class="confirm-delete" title="Delete"><i class="fas fa-trash-alt"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr style="border-bottom: 0.05px dashed #dddfe0;">
                                                <td style="text-align:center;padding-top:1%;padding-bottom:1%;background-color: #f5f5f5">20.</td>
                                                <td style="text-align:center;padding-top:1%;padding-bottom:1%;">Tiger Nixon Tiger Nixon Tiger Nixon Tiger Nixon Tiger Nixon </td>
                                                <td style="text-align:center;padding-top:1%;padding-bottom:1%;">Unit Name</td>
                                                <td style="text-align:center;padding-top:1%;padding-bottom:1%;">1000.00</td>
                                                <td style="text-align:center;background-color: #f5f5f5;padding-top:1%;padding-bottom:1%;">
                                                    <span class="quantityChange" data-change_type="minus" data-product_id="1" data-quantity="1" style="cursor:pointer">
                                                        <i class="fa fa-minus-circle"></i>
                                                    </span>
                                        
                                                    <span id="set-1">100</span>
                                        
                                                    <span class="quantityChange" data-change_type="plus" data-product_id="1" data-quantity="1" style="cursor:pointer">
                                                        <i class="fa fa-plus-circle"></i>
                                                    </span>
                                                    
                                                    <br>
                                                    <strong id="not_available_message_1" style="font-size:11px; color:red;"></strong>
                                                </td>
                                                <td style="text-align:center;padding-top:1%;padding-bottom:1%;">000</td>
                                                <td style="text-align:center;background-color: #f5f5f5;padding-top:1%;padding-bottom:1%;">000</td>
                                                <td style="padding-top:1%;padding-bottom:1%;">
                                                    <div class="card-toolbar text-right">
                                                        <a href="#" class="confirm-delete" title="Delete"><i class="fas fa-trash-alt"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr style="border-bottom: 0.05px dashed #dddfe0;">
                                                <td style="text-align:center;padding-top:1%;padding-bottom:1%;background-color: #f5f5f5">20.</td>
                                                <td style="text-align:center;padding-top:1%;padding-bottom:1%;">Tiger Nixon Tiger Nixon Tiger Nixon Tiger Nixon Tiger Nixon </td>
                                                <td style="text-align:center;padding-top:1%;padding-bottom:1%;">Unit Name</td>
                                                <td style="text-align:center;padding-top:1%;padding-bottom:1%;">1000.00</td>
                                                <td style="text-align:center;background-color: #f5f5f5;padding-top:1%;padding-bottom:1%;">
                                                    <span class="quantityChange" data-change_type="minus" data-product_id="1" data-quantity="1" style="cursor:pointer">
                                                        <i class="fa fa-minus-circle"></i>
                                                    </span>
                                        
                                                    <span id="set-1">100</span>
                                        
                                                    <span class="quantityChange" data-change_type="plus" data-product_id="1" data-quantity="1" style="cursor:pointer">
                                                        <i class="fa fa-plus-circle"></i>
                                                    </span>
                                                    
                                                    <br>
                                                    <strong id="not_available_message_1" style="font-size:11px; color:red;"></strong>
                                                </td>
                                                <td style="text-align:center;padding-top:1%;padding-bottom:1%;">000</td>
                                                <td style="text-align:center;background-color: #f5f5f5;padding-top:1%;padding-bottom:1%;">000</td>
                                                <td style="padding-top:1%;padding-bottom:1%;">
                                                    <div class="card-toolbar text-right">
                                                        <a href="#" class="confirm-delete" title="Delete"><i class="fas fa-trash-alt"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr style="border-bottom: 0.05px dashed #dddfe0;">
                                                <td style="text-align:center;padding-top:1%;padding-bottom:1%;background-color: #f5f5f5">20.</td>
                                                <td style="text-align:center;padding-top:1%;padding-bottom:1%;">Tiger Nixon Tiger Nixon Tiger Nixon Tiger Nixon Tiger Nixon </td>
                                                <td style="text-align:center;padding-top:1%;padding-bottom:1%;">Unit Name</td>
                                                <td style="text-align:center;padding-top:1%;padding-bottom:1%;">1000.00</td>
                                                <td style="text-align:center;background-color: #f5f5f5;padding-top:1%;padding-bottom:1%;">
                                                    <span class="quantityChange" data-change_type="minus" data-product_id="1" data-quantity="1" style="cursor:pointer">
                                                        <i class="fa fa-minus-circle"></i>
                                                    </span>
                                        
                                                    <span id="set-1">100</span>
                                        
                                                    <span class="quantityChange" data-change_type="plus" data-product_id="1" data-quantity="1" style="cursor:pointer">
                                                        <i class="fa fa-plus-circle"></i>
                                                    </span>
                                                    
                                                    <br>
                                                    <strong id="not_available_message_1" style="font-size:11px; color:red;"></strong>
                                                </td>
                                                <td style="text-align:center;padding-top:1%;padding-bottom:1%;">000</td>
                                                <td style="text-align:center;background-color: #f5f5f5;padding-top:1%;padding-bottom:1%;">000</td>
                                                <td style="padding-top:1%;padding-bottom:1%;">
                                                    <div class="card-toolbar text-right">
                                                        <a href="#" class="confirm-delete" title="Delete"><i class="fas fa-trash-alt"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr style="border-bottom: 0.05px dashed #dddfe0;">
                                                <td style="text-align:center;padding-top:1%;padding-bottom:1%;background-color: #f5f5f5">20.</td>
                                                <td style="text-align:center;padding-top:1%;padding-bottom:1%;">Tiger Nixon Tiger Nixon Tiger Nixon Tiger Nixon Tiger Nixon </td>
                                                <td style="text-align:center;padding-top:1%;padding-bottom:1%;">Unit Name</td>
                                                <td style="text-align:center;padding-top:1%;padding-bottom:1%;">1000.00</td>
                                                <td style="text-align:center;background-color: #f5f5f5;padding-top:1%;padding-bottom:1%;">
                                                    <span class="quantityChange" data-change_type="minus" data-product_id="1" data-quantity="1" style="cursor:pointer">
                                                        <i class="fa fa-minus-circle"></i>
                                                    </span>
                                        
                                                    <span id="set-1">100</span>
                                        
                                                    <span class="quantityChange" data-change_type="plus" data-product_id="1" data-quantity="1" style="cursor:pointer">
                                                        <i class="fa fa-plus-circle"></i>
                                                    </span>
                                                    
                                                    <br>
                                                    <strong id="not_available_message_1" style="font-size:11px; color:red;"></strong>
                                                </td>
                                                <td style="text-align:center;padding-top:1%;padding-bottom:1%;">000</td>
                                                <td style="text-align:center;background-color: #f5f5f5;padding-top:1%;padding-bottom:1%;">000</td>
                                                <td style="padding-top:1%;padding-bottom:1%;">
                                                    <div class="card-toolbar text-right">
                                                        <a href="#" class="confirm-delete" title="Delete"><i class="fas fa-trash-alt"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr style="border-bottom: 0.05px dashed #dddfe0;">
                                                <td style="text-align:center;padding-top:1%;padding-bottom:1%;background-color: #f5f5f5">20.</td>
                                                <td style="text-align:center;padding-top:1%;padding-bottom:1%;">Tiger Nixon Tiger Nixon Tiger Nixon Tiger Nixon Tiger Nixon </td>
                                                <td style="text-align:center;padding-top:1%;padding-bottom:1%;">Unit Name</td>
                                                <td style="text-align:center;padding-top:1%;padding-bottom:1%;">1000.00</td>
                                                <td style="text-align:center;background-color: #f5f5f5;padding-top:1%;padding-bottom:1%;">
                                                    <span class="quantityChange" data-change_type="minus" data-product_id="1" data-quantity="1" style="cursor:pointer">
                                                        <i class="fa fa-minus-circle"></i>
                                                    </span>
                                        
                                                    <span id="set-1">100</span>
                                        
                                                    <span class="quantityChange" data-change_type="plus" data-product_id="1" data-quantity="1" style="cursor:pointer">
                                                        <i class="fa fa-plus-circle"></i>
                                                    </span>
                                                    
                                                    <br>
                                                    <strong id="not_available_message_1" style="font-size:11px; color:red;"></strong>
                                                </td>
                                                <td style="text-align:center;padding-top:1%;padding-bottom:1%;">000</td>
                                                <td style="text-align:center;background-color: #f5f5f5;padding-top:1%;padding-bottom:1%;">000</td>
                                                <td style="padding-top:1%;padding-bottom:1%;">
                                                    <div class="card-toolbar text-right">
                                                        <a href="#" class="confirm-delete" title="Delete"><i class="fas fa-trash-alt"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr style="border-bottom: 0.05px dashed #dddfe0;">
                                                <td style="text-align:center;padding-top:1%;padding-bottom:1%;background-color: #f5f5f5">20.</td>
                                                <td style="text-align:center;padding-top:1%;padding-bottom:1%;">Tiger Nixon Tiger Nixon Tiger Nixon Tiger Nixon Tiger Nixon </td>
                                                <td style="text-align:center;padding-top:1%;padding-bottom:1%;">Unit Name</td>
                                                <td style="text-align:center;padding-top:1%;padding-bottom:1%;">1000.00</td>
                                                <td style="text-align:center;background-color: #f5f5f5;padding-top:1%;padding-bottom:1%;">
                                                    <span class="quantityChange" data-change_type="minus" data-product_id="1" data-quantity="1" style="cursor:pointer">
                                                        <i class="fa fa-minus-circle"></i>
                                                    </span>
                                        
                                                    <span id="set-1">100</span>
                                        
                                                    <span class="quantityChange" data-change_type="plus" data-product_id="1" data-quantity="1" style="cursor:pointer">
                                                        <i class="fa fa-plus-circle"></i>
                                                    </span>
                                                    
                                                    <br>
                                                    <strong id="not_available_message_1" style="font-size:11px; color:red;"></strong>
                                                </td>
                                                <td style="text-align:center;padding-top:1%;padding-bottom:1%;">000</td>
                                                <td style="text-align:center;background-color: #f5f5f5;padding-top:1%;padding-bottom:1%;">000</td>
                                                <td style="padding-top:1%;padding-bottom:1%;">
                                                    <div class="card-toolbar text-right">
                                                        <a href="#" class="confirm-delete" title="Delete"><i class="fas fa-trash-alt"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr style="border-bottom: 0.05px dashed #dddfe0;">
                                                <td style="text-align:center;padding-top:1%;padding-bottom:1%;background-color: #f5f5f5">20.</td>
                                                <td style="text-align:center;padding-top:1%;padding-bottom:1%;">Tiger Nixon Tiger Nixon Tiger Nixon Tiger Nixon Tiger Nixon </td>
                                                <td style="text-align:center;padding-top:1%;padding-bottom:1%;">Unit Name</td>
                                                <td style="text-align:center;padding-top:1%;padding-bottom:1%;">1000.00</td>
                                                <td style="text-align:center;background-color: #f5f5f5;padding-top:1%;padding-bottom:1%;">
                                                    <span class="quantityChange" data-change_type="minus" data-product_id="1" data-quantity="1" style="cursor:pointer">
                                                        <i class="fa fa-minus-circle"></i>
                                                    </span>
                                        
                                                    <span id="set-1">100</span>
                                        
                                                    <span class="quantityChange" data-change_type="plus" data-product_id="1" data-quantity="1" style="cursor:pointer">
                                                        <i class="fa fa-plus-circle"></i>
                                                    </span>
                                                    
                                                    <br>
                                                    <strong id="not_available_message_1" style="font-size:11px; color:red;"></strong>
                                                </td>
                                                <td style="text-align:center;padding-top:1%;padding-bottom:1%;">000</td>
                                                <td style="text-align:center;background-color: #f5f5f5;padding-top:1%;padding-bottom:1%;">000</td>
                                                <td style="padding-top:1%;padding-bottom:1%;">
                                                    <div class="card-toolbar text-right">
                                                        <a href="#" class="confirm-delete" title="Delete"><i class="fas fa-trash-alt"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            
                                        </tbody>
                                    </table>
                                </div>
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
                                                width: 100%;padding: 2%;                                            }
                                        </style>
                                        <div class="col-3" style="border-right: 1px solid #e9ecef;">
                                            <a href="#" class="btn btn-danger btnFullWidth white" style="margin-top: 1%;" data-toggle="modal" data-target="#payment-popup">
                                                Cancel
                                            </a>
                                            <a href="#" class="btn btn-dark btnFullWidth white" style="margin-top: 1%;" data-toggle="modal" data-target="#payment-popup">
                                                Quotation
                                            </a>
                                            <a href="#" class="btn btn-success btnFullWidth white" style="margin-top: 1%;" data-toggle="modal" data-target="#payment-popup">
                                                Payment
                                            </a>

                                            <a href="#" class="btn btn-info btnFullWidth white" style="margin-top: 1%;" data-toggle="modal" data-target="#payment-popup">
                                                Print
                                            </a>
                                            <a href="#" class="btn btn-primary btnFullWidth white" style="margin-top: 1%;" data-toggle="modal" data-target="#payment-popup">
                                                POS Print
                                            </a>
                                        </div>
                                        <!-- <div class="col-3" style="border-right: 1px solid #e9ecef;">
                                            <a href="#" class="btn btn-danger white" style="margin-top: 1%;" data-toggle="modal" data-target="#payment-popup">
                                                Cancel
                                            </a> 
                                            <br/>
                                            <a href="#" class="btn btn-info white" style="margin-top: 1%;" data-toggle="modal" data-target="#payment-popup">
                                                Quotation
                                            </a> 
                                            <br/>
                                            <a href="#" class="btn btn-primary white" style="margin-top: 1%;" data-toggle="modal" data-target="#payment-popup">
                                                Payment
                                            </a> 

                                        </div> -->

                                        <div class="col-8">
                                            <table class="table right-table">
                                                <tbody>
                                                    <tr class="d-flex align-items-center justify-content-between">
                                                        <th class="border-0 font-size-h5 mb-0 font-size-bold text-dark"style="background-color:#f5f5f5;width:25%">
                                                            <strong style="color:#8428e7">Total Items</strong>
                                                        </th>
                                                        <td class="border-0 justify-content-end d-flex text-dark font-size-base" >
                                                            <strong style="color:#8428e7">6</strong>
                                                        </td> 
                                                        <th class="border-0 font-size-h5 mb-0 font-size-bold text-dark">
                                                            <strong style="color:#9e53ee">Subtotal</strong>
                                                        </th>
                                                        <td class="border-0 justify-content-end d-flex text-dark font-size-base">
                                                            <strong style="color:#9e53ee">45655</strong>
                                                        </td>
                                                    </tr>
                                                    <tr class="d-flex align-items-center justify-content-between">
                                                        <th class="border-0" style="background-color:#f5f5f5;width:25%">
                                                            <div class="d-flex align-items-center font-size-h5 mb-0 font-size-bold text-dark">
                                                                Shipping Cost
                                                                <span class="badge badge-secondary white rounded-circle ml-2" data-toggle="modal" data-target="#shippingcost">
                                                                    <svg
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        class="svg-sm"
                                                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                        version="1.1"
                                                                        id="Layer_11"
                                                                        x="0px"
                                                                        y="0px"
                                                                        width="512px"
                                                                        height="512px"
                                                                        viewBox="0 0 512 512"
                                                                        enable-background="new 0 0 512 512"
                                                                        xml:space="preserve"
                                                                    >
                                                                        <g>
                                                                            <rect x="234.362" y="128" width="43.263" height="256"></rect>
                                                                            <rect x="128" y="234.375" width="256" height="43.25"></rect>
                                                                        </g>
                                                                    </svg>
                                                                </span>
                                                            </div>
                                                        </th>
                                                        <td class="border-0 " style="width: 25%;text-align: center !important;">
                                                            00
                                                        </td>
                                                        <th class="border-0">
                                                            <div class="d-flex align-items-center font-size-h5 mb-0 font-size-bold text-dark">
                                                                Less Amount (65%)
                                                                <span class="badge badge-secondary white rounded-circle ml-2" data-toggle="modal" data-target="#discountpop">
                                                                    <svg
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        class="svg-sm"
                                                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                        version="1.1"
                                                                        id="Layer_31"
                                                                        x="0px"
                                                                        y="0px"
                                                                        width="512px"
                                                                        height="512px"
                                                                        viewBox="0 0 512 512"
                                                                        enable-background="new 0 0 512 512"
                                                                        xml:space="preserve"
                                                                    >
                                                                        <g>
                                                                            <rect x="234.362" y="128" width="43.263" height="256"></rect>
                                                                            <rect x="128" y="234.375" width="256" height="43.25"></rect>
                                                                        </g>
                                                                    </svg>
                                                                </span>
                                                            </div>
                                                        </th>
                                                        <td class="border-0  d-flex text-dark font-size-base" >100</td>
                                                    </tr>

                                                    <tr class="d-flex align-items-center justify-content-between">
                                                        <th class="border-0" style="background-color:#f5f5f5;width:25%">
                                                            <div class="d-flex align-items-center font-size-h5 mb-0 font-size-bold text-dark">
                                                                TAX (5%)
                                                                <span class="badge badge-secondary white rounded-circle ml-2" data-toggle="modal" data-target="#discountpop">
                                                                    <svg
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        class="svg-sm"
                                                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                        version="1.1"
                                                                        id="Layer_31"
                                                                        x="0px"
                                                                        y="0px"
                                                                        width="512px"
                                                                        height="512px"
                                                                        viewBox="0 0 512 512"
                                                                        enable-background="new 0 0 512 512"
                                                                        xml:space="preserve"
                                                                    >
                                                                        <g>
                                                                            <rect x="234.362" y="128" width="43.263" height="256"></rect>
                                                                            <rect x="128" y="234.375" width="256" height="43.25"></rect>
                                                                        </g>
                                                                    </svg>
                                                                </span>

                                                            </div>
                                                        </th>
                                                        <td class="border-0  d-flex text-dark font-size-base" style="text-align: right;">10</td>
                                                        
                                                        <th class="border-0">
                                                            <div class="d-flex align-items-center font-size-h5 mb-0 font-size-bold text-dark">
                                                                Vat (5%)
                                                                <span class="badge badge-secondary white rounded-circle ml-2" data-toggle="modal" data-target="#discountpop">
                                                                    <svg
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        class="svg-sm"
                                                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                        version="1.1"
                                                                        id="Layer_31"
                                                                        x="0px"
                                                                        y="0px"
                                                                        width="512px"
                                                                        height="512px"
                                                                        viewBox="0 0 512 512"
                                                                        enable-background="new 0 0 512 512"
                                                                        xml:space="preserve"
                                                                    >
                                                                        <g>
                                                                            <rect x="234.362" y="128" width="43.263" height="256"></rect>
                                                                            <rect x="128" y="234.375" width="256" height="43.25"></rect>
                                                                        </g>
                                                                    </svg>
                                                                </span>
                                                            </div>
                                                        </th>
                                                        <td class="border-0 justify-content-end d-flex text-dark font-size-base">50</td>
                                                    </tr>
                                                  
                                                  
                                                    <tr class="d-flex align-items-center justify-content-between item-price" style="background-color:#f5f5f5;">
                                                        <th class="border-0 font-size-h5 mb-0 font-size-bold text-primary">
                                                            
                                                        </th>
                                                        <td class="border-0 justify-content-end d-flex text-primary font-size-base"></td>
                                                        <th class="border-0 font-size-h5 mb-0 font-size-bold text-primary" style="color:#6010b3">
                                                            <strong style="color:#6010b3">Payable Amount </strong>
                                                        </th>
                                                        <td class="border-0 justify-content-end d-flex text-primary font-size-base" >
                                                            <strong style="color:#6010b3">6000</strong>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    
                                </div>

                                <div style="display: none;" class="d-flex .justify-content-bottom align-items-center flex-column">
                                    <div style="display: none;">
                                        <button type="submit" class="btn btn-outline-secondary mr-2" title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                        <button type="submit" class="btn btn-danger mr-2 confirm-delete" title="Save">
                                            <i class="fas fa-save"></i>
                                        </button>
                                        <button type="submit" class="btn btn-secondary white">
                                            <i class="fas fa-folder"></i>
                                            <!-- <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-folder-fill svg-sm mr-2" viewBox="0 0 16 16">
                                                <path
                                                    d="M9.828 3h3.982a2 2 0 0 1 1.992 2.181l-.637 7A2 2 0 0 1 13.174 14H2.826a2 2 0 0 1-1.991-1.819l-.637-7a1.99 1.99 0 0 1 .342-1.31L.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3zm-8.322.12C1.72 3.042 1.95 3 2.19 3h5.396l-.707-.707A1 1 0 0 0 6.172 2H2.5a1 1 0 0 0-1 .981l.006.139z"
                                                />
                                            </svg> -->
                                        </button>
                                        <a href="#" class="btn btn-primary white" data-toggle="modal" data-target="#payment-popup">
                                            POS Print
                                        </a> 
                                        <a href="#" class="btn btn-info white" data-toggle="modal" data-target="#payment-popup">
                                            Print
                                        </a>
                                        <!-- <a href="#" class="btn btn-outline-secondary">
                                            Pay With Card
                                        </a> -->
                                    </div>
                                </div>
                                <!-- 
                                    <div class="form-group row mb-0">
                                        <div class="col-md-12 btn-submit d-flex justify-content-center">
                                            <button type="submit" class="btn btn-outline-secondary mr-2" title="Delete">
                                                <i class="fas fa-trash-alt mr-2"></i>
                                            </button>
                                            <button type="submit" class="btn btn-danger mr-2 confirm-delete" title="Save">
                                                <i class="fas fa-save mr-2"></i>
                                            </button>
                                            <button type="submit" class="btn btn-secondary white">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-folder-fill svg-sm mr-2" viewBox="0 0 16 16">
                                                    <path
                                                        d="M9.828 3h3.982a2 2 0 0 1 1.992 2.181l-.637 7A2 2 0 0 1 13.174 14H2.826a2 2 0 0 1-1.991-1.819l-.637-7a1.99 1.99 0 0 1 .342-1.31L.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3zm-8.322.12C1.72 3.042 1.95 3 2.19 3h5.396l-.707-.707A1 1 0 0 0 6.172 2H2.5a1 1 0 0 0-1 .981l.006.139z"
                                                    />
                                                </svg>
                                            </button>
                                        </div>
                                    </div> 
                                -->
                            </div>
                            <!---------summery of added to cart product list----------->
                        </div>
                        <!-- <div class="card card-custom gutter-b bg-white border-0">
                            <div class="card-body">
                                
                            </div>
                        </div> -->
                    </div><!-----col-8------>

                    <!-----col-4------>
                    <div class="col-xl-4 col-lg-4 col-md-12 h-100">
                        <div class="card-custom gutter-b bg-white border-0">
                            <div class="card-body mb-4">
                                <div class="row" style="margin-top: 10px;">
                                    <div class="col-md-12">
                                        <div class="selectmain">
                                            <select class="arabic-select select2 bag-primary" style="width:100%">
                                                <option value="1">All Categories</option>
                                                <option value="2">Accessories</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                               <!--  <div class="selectmain mt-2">
                                    <input type="text" placeholder="Search.." style="width: 100%;border: 1px solid #e9ecef;padding: 1%;" />
                                </div> -->
                                <div class="form-group row mt-3 mb-0">
                                    <div class="col-md-12" style="padding-bottom:5px;">
                                        <fieldset class="form-group mb-0 d-flex barcodeselection">
                                            <input type="text" class="form-control border-dark" id="basicInput1" autofocus placeholder="product name / ascode / company code / sku"/>
                                        </fieldset>
                                    </div>
                                    <!-- <div class="col-md-12"> -->
                                        <!-- <label>Select Product</label> -->
                                        <!-- <fieldset class="form-group mb-0 d-flex barcodeselection">
                                            <select class="form-control" id="exampleFormControlSelect1" style="width: 35%;">
                                                <option>Name</option>
                                                <option>SKU</option>
                                                <option>ASCode</option>
                                            </select>
                                            <input type="text" class="form-control border-dark" id="basicInput1" placeholder="" />
                                        </fieldset>
                                    </div> -->
                                    <!-- <div class="col-md-1">
                                        <span class="badge badge-secondary white rounded-circle" data-toggle="modal" data-target="#choosecustomer"></span>
                                    </div> -->
                                </div> 
                                
                            </div>
                            <style>
                                .hovereffect {
                                    width: 100%;
                                    height: 100%;
                                    float: left;
                                    overflow: hidden;
                                    position: relative;
                                    text-align: center;
                                    cursor: pointer;
                                }
                                .hovereffect .overlay {
                                    width: 100%;
                                    position: absolute;
                                    overflow: hidden;
                                    left: 0;
                                    top: 70px;
                                    bottom: 0;
                                    padding: 5px;
                                    height: 4.75em;
                                    background: #79fac4;
                                    color: #3c4a50;
                                    -webkit-transition: -webkit-transform 0.35s;
                                    transition: transform 0.35s;
                                    -webkit-transform: translate3d(0, 100%, 0);
                                    transform: translate3d(0, 100%, 0);
                                    visibility: hidden;
                                }
                                .hovereffect h4 {
                                    color: #fff;
                                    text-align: center;
                                    position: relative;
                                    font-size: 10px;
                                    padding: 5px;
                                    background: rgba(0, 0, 0, 0.6);
                                    margin: 0px;
                                    display: inline-block;
                                }
                                .hovereffect h4,
                                .hovereffect p.icon-links a {
                                    -webkit-transition: -webkit-transform 0.35s;
                                    transition: transform 0.35s;
                                    -webkit-transform: translate3d(0, 200%, 0);
                                    transform: translate3d(0, 200%, 0);
                                    visibility: visible;
                                }
                                .hovereffect:hover .overlay,
                                .hovereffect:hover h4,
                                .hovereffect:hover p.icon-links a {
                                    -webkit-transform: translate3d(0, 0, 0);
                                    transform: translate3d(0, 0, 0);
                                }

                                .hovereffect:hover h4 {
                                    -webkit-transition-delay: 0.05s;
                                    transition-delay: 0.05s;
                                }
                            </style>
                            <div class="card-body product-items" style="background-color: #efefef;">
                                {{-- <div style="width:100%;background-color:red;height:100%;margin-left:-10px;margin-right:-30px;margin-top:20px;">

                                </div> --}}
                                <div class="row" style="margin-top:20px;">
                                    @foreach ($products as $item)    
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-6" style="border-bottom:5px solid #ffffff;border-right:2px solid #ffffff;border-left:2px solid #ffffff;border-top:5px solid #ffffff;margin-bottom: 10px;padding-top: 10px;">
                                            <div class="productDetails productCard hovereffect"  data-id="{{$item->id}}"> {{--data-toggle="modal" data-target="#product-details"--}}
                                                <div class="productThumb" style="border:5px solid #6e6d6d;">
                                                    @if($item->photo)
                                                        <img  src="{{ asset(productImageViewLocation_hh().$item->id.".".$item->photo) }}" alt=""class="img-fluid"  style="padding:2px;border:1px solid #c7bbbb;background-color:#fbf8f8;border-radius:4px">
                                                        @else
                                                        <img  src="{{ asset(defaultProductImageUrl_hh()) }}" alt="" class="img-fluid"  style="padding:2px;border:1px solid #c7bbbb;background-color:#fbf8f8;border-radius:4px">
                                                    @endif
                                                    {{-- <img class="img-fluid" src="assets/images/carousel/element-banner2-right.jpg" alt="ix" /> --}}
                                                    <div class="overlay">
                                                        <h4>
                                                            @foreach ($item->onlyRegularProductPricesWithPriceWhereStatusIsActive as $prices)
                                                                
                                                            Price: Tk {{ $prices->price }} <br />
                                                            @endforeach
                                                            Stock: {{ $item->available_base_stock ?? 0 }}
                                                        </h4>
                                                    </div>
                                                </div>
                                                <div class="productContent" style="margin-top:0px;">
                                                    <a href="#" class="productDetails"  data-id="{{$item->id}}">
                                                        @php
                                                            $product = $item->name;
                                                            if(strlen($item->name) > 30)
                                                            {
                                                                $len = substr($item->name,0,30);
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
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="old-product-details">
                                <div class="modal fade text-left" id="product-details" tabindex="-1" role="dialog" aria-labelledby="myModalLabel13" style="display: none;" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h3 class="modal-title" id="myModalLabel13">Men Polo Shirt (M) -MPS[2545-P]</h3>
                                                <button type="button" class="close rounded-pill btn btn-sm btn-icon btn-light btn-hover-primary m-0" data-dismiss="modal" aria-label="Close">
                                                    <svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-x" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            fill-rule="evenodd"
                                                            d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"
                                                        ></path>
                                                    </svg>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form>
                                                    <table class="table table-bordered">
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <label class="text-body">Price Category</label>
                                                                    <fieldset class="form-group mb-3">
                                                                        <select class="js-example-basic-single js-states form-control bg-transparent p-0" name="state">
                                                                            <option value="AL">Regular price</option>
                                                                        </select>
                                                                    </fieldset>
                                                                </td>
                                                                <td>
                                                                    <label class="text-body">Sale Unit</label>
                                                                    <fieldset class="form-group mb-3">
                                                                        <select class="js-example-basic-single js-states form-control bg-transparent p-0" name="state">
                                                                            <option value="AL">Fit</option>
                                                                        </select>
                                                                    </fieldset>
                                                                </td>
                                                                <td>
                                                                    <label class="text-body">Price</label>
                                                                    <fieldset class="form-group mb-3">
                                                                        <input type="number" name="number" class="form-control" placeholder="00.00" />
                                                                    </fieldset>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <label class="text-body">Sale From Stock</label>
                                                                    <fieldset class="form-group mb-3">
                                                                        <select class="js-example-basic-single js-states form-control bg-transparent p-0" name="state">
                                                                            <option value="AL">Showroom</option>
                                                                        </select>
                                                                    </fieldset>
                                                                </td>
                                                                <td>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked />
                                                                        <label class="form-check-label" for="exampleRadios1">
                                                                            Sale Price: Tk 70.00
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked />
                                                                        <label class="form-check-label" for="exampleRadios1">
                                                                            Whole Sale Price: Tk 65.00
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked />
                                                                        <label class="form-check-label" for="exampleRadios1">
                                                                            Purchase Price: Tk 70.00
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked />
                                                                        <label class="form-check-label" for="exampleRadios1">
                                                                            MRP Price: Tk 70.00
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <label class="text-body">Quantity Amount (Pcs)</label>
                                                                    <fieldset class="form-group mb-3">
                                                                        <input type="number" name="number" class="form-control" placeholder="0" />
                                                                    </fieldset>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <label class="text-body">Available Stock</label><br />
                                                                    <label class="text-body">Showroom: -10.67 Fit</label>
                                                                </td>
                                                                <td></td>
                                                                <td>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1" />
                                                                        <label class="form-check-label" for="inlineRadio1">Percentage(%)</label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2" />
                                                                        <label class="form-check-label" for="inlineRadio2">Fixed</label>
                                                                    </div>
                                                                    <fieldset class="form-group mb-3">
                                                                        <input type="number" name="number" class="form-control" placeholder="0" />
                                                                        (70.00) (0)
                                                                    </fieldset>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td>Total</td>
                                                                <td>1 Fit</td>
                                                                <td>70.00</td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                    <div class="form-group">
                                                        <label for="exampleFormControlTextarea1">IMEI/Serial/Chassis/Engine Number</label>
                                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                                    </div>
                                                    <div class="form-group row justify-content-end mb-0">
                                                        <div class="col-md-12 text-right">
                                                            <a href="#" class="btn btn-outline-secondary">Cancel</a>
                                                            <a href="#" class="btn btn-primary">Add To Cart</a>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-----col-4------>
					
                </div><!-----row------>
                
            </div>
        </div>

    <!-- Button trigger modal -->
    {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
        Launch demo modal
    </button>
  
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          ...
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div> --}}

        <div class="modal fade text-left" id="payment-popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel11" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="myModalLabel11">Payment</h3>
                        <button type="button" class="close rounded-pill btn btn-sm btn-icon btn-light btn-hover-primary m-0" data-dismiss="modal" aria-label="Close">
                            <svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-x" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    fill-rule="evenodd"
                                    d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"
                                ></path>
                            </svg>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table right-table">
                            <tbody>
                                <tr class="d-flex align-items-center justify-content-between">
                                    <th class="border-0 px-0 font-size-lg mb-0 font-size-bold text-primary">
                                        Total Amount to Pay :
                                    </th>
                                    <td class="border-0 justify-content-end d-flex text-primary font-size-lg font-size-bold px-0 font-size-lg mb-0 font-size-bold text-primary">
                                        $722
                                    </td>
                                </tr>
                                <tr class="d-flex align-items-center justify-content-between">
                                    <th class="border-0 px-0 font-size-lg mb-0 font-size-bold text-primary">
                                        Payment Mode :
                                    </th>
                                    <td class="border-0 justify-content-end d-flex text-primary font-size-lg font-size-bold px-0 font-size-lg mb-0 font-size-bold text-primary">
                                        Cash
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <form>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label class="text-body">Received Amount</label>
                                    <fieldset class="form-group mb-3">
                                        <input type="text" name="number" class="form-control" value="$1000" placeholder="Enter Amount " />
                                    </fieldset>
                                    <div class="p-3 bg-light-dark d-flex justify-content-between border-bottom">
                                        <h5 class="font-size-bold mb-0">Amount to Return :</h5>
                                        <h5 class="font-size-bold mb-0">-$20</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label class="text-body">Note (If any)</label>
                                    <fieldset class="form-label-group">
                                        <textarea class="form-control fixed-size" id="horizontalTextarea" rows="5" placeholder="Enter Note"></textarea>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="form-group row justify-content-end mb-0">
                                <div class="col-md-6 text-right">
                                    <a href="#" class="btn btn-primary">Submit</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade text-left" id="shippingpop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel12" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="myModalLabel12">Add Shipping Address</h3>
                        <button type="button" class="close rounded-pill btn btn-sm btn-icon btn-light btn-hover-primary m-0" data-dismiss="modal" aria-label="Close">
                            <svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-x" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    fill-rule="evenodd"
                                    d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"
                                ></path>
                            </svg>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label class="text-body">Country</label>
                                    <fieldset class="form-group mb-3">
                                        <select class="js-example-basic-single js-states form-control bg-transparent p-0 border-0" name="state">
                                            <option value="AL">USA</option>

                                            <option value="WY">UK</option>
                                        </select>
                                    </fieldset>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-body">State</label>
                                    <fieldset class="form-group mb-3">
                                        <input type="text" name="text" class="form-control" placeholder="Enter State " />
                                    </fieldset>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label class="text-body">City</label>
                                    <fieldset class="form-group mb-3">
                                        <select class="js-example-basic-single js-states form-control bg-transparent p-0 border-0" name="state">
                                            <option value="AL">Bahreen</option>

                                            <option value="WY">Dubai</option>
                                        </select>
                                    </fieldset>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-body">Postal Code</label>
                                    <fieldset class="form-group mb-3">
                                        <input type="number" name="text" class="form-control" placeholder="Enter Postal code" />
                                    </fieldset>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label class="text-body">Address</label>
                                    <fieldset class="form-group mb-3">
                                        <input type="text" name="text" class="form-control" placeholder="Enter Address" />
                                    </fieldset>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-body">Phone Number</label>
                                    <fieldset class="form-group mb-3">
                                        <input type="number" name="text" class="form-control" placeholder="Enter Phone Number" />
                                    </fieldset>
                                </div>
                            </div>
                            <div class="form-group row justify-content-end mb-0">
                                <div class="col-md-6 text-right">
                                    <a href="#" class="btn btn-primary">Add Address</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade text-left" id="choosecustomer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel13" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="myModalLabel13">Add Customer</h3>
                        <button type="button" class="close rounded-pill btn btn-sm btn-icon btn-light btn-hover-primary m-0" data-dismiss="modal" aria-label="Close">
                            <svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-x" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    fill-rule="evenodd"
                                    d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"
                                ></path>
                            </svg>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label class="text-body">Customer Group</label>
                                    <fieldset class="form-group mb-3">
                                        <select class="js-example-basic-single js-states form-control bg-transparent p-0 border-0" name="state">
                                            <option value="AL">General</option>

                                            <option value="WY">Partial</option>
                                        </select>
                                    </fieldset>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-body">Customer Name</label>
                                    <fieldset class="form-group mb-3">
                                        <input type="text" name="text" class="form-control" placeholder="Enter Customer Name" />
                                    </fieldset>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label class="text-body">Company Name</label>
                                    <fieldset class="form-group mb-3">
                                        <input type="text" name="text" class="form-control" placeholder="Enter Company Name" />
                                    </fieldset>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-body">Tax Number</label>
                                    <fieldset class="form-group mb-3">
                                        <input type="text" name="text" class="form-control" placeholder="Enter Tax" />
                                    </fieldset>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label class="text-body">Email</label>
                                    <fieldset class="form-group mb-3">
                                        <input type="email" name="text" class="form-control" placeholder="Enter Mail" />
                                    </fieldset>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-body">Phone Number</label>
                                    <fieldset class="form-group mb-3">
                                        <input type="email" name="text" class="form-control" placeholder="Enter Phone Number" />
                                    </fieldset>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label class="text-body">Country</label>
                                    <fieldset class="form-group mb-3">
                                        <select class="js-example-basic-single js-states form-control bg-transparent p-0 border-0" name="state">
                                            <option value="AL">USA</option>

                                            <option value="WY">UK</option>
                                        </select>
                                    </fieldset>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-body">State</label>
                                    <fieldset class="form-group mb-3">
                                        <input type="text" name="text" class="form-control" placeholder="Enter State" />
                                    </fieldset>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label class="text-body">City</label>
                                    <fieldset class="form-group mb-3">
                                        <select class="js-example-basic-single js-states form-control bg-transparent p-0 border-0" name="state">
                                            <option value="AL">Dubai</option>

                                            <option value="WY">Bahreen</option>
                                        </select>
                                    </fieldset>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-body">Postal Code</label>
                                    <fieldset class="form-group mb-3">
                                        <input type="text" name="text" class="form-control" placeholder="Enter Postal Code" />
                                    </fieldset>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label class="text-body">Address</label>
                                    <fieldset class="form-group mb-3">
                                        <input type="text" name="text" class="form-control" placeholder="Enter Address" />
                                    </fieldset>
                                </div>
                            </div>
                            <div class="form-group row justify-content-end mb-0">
                                <div class="col-md-6 text-right">
                                    <a href="#" class="btn btn-primary">Add Customer</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade text-left" id="folderpop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel14" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="myModalLabel14">Draft Orders</h3>
                        <button type="button" class="close rounded-pill btn btn-sm btn-icon btn-light btn-hover-primary m-0" data-dismiss="modal" aria-label="Close">
                            <svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-x" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    fill-rule="evenodd"
                                    d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"
                                ></path>
                            </svg>
                        </button>
                    </div>
                    <div class="modal-body pos-ordermain">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="pos-order">
                                    <h3 class="pos-order-title">Order 1</h3>
                                    <div class="orderdetail-pos">
                                        <p>
                                            <strong>Customer Name</strong>
                                            Sophia Hale
                                        </p>
                                        <p>
                                            <strong>Address</strong>
                                            9825 Johnsaon Dr.Columbo,MD21044
                                        </p>
                                        <p>
                                            <strong>Payment Status</strong>
                                            Pending
                                        </p>
                                        <p>
                                            <strong>Total Items</strong>
                                            10
                                        </p>
                                        <p>
                                            <strong>Amount to Pay</strong>
                                            $722
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <a href="#" class="confirm-delete ml-3" title="Delete"><i class="fas fa-edit"></i></a>
                                        <a href="#" class="confirm-delete ml-3" title="Delete"><i class="fas fa-trash-alt"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="pos-order">
                                    <h3 class="pos-order-title">Order 1</h3>
                                    <div class="orderdetail-pos">
                                        <p>
                                            <strong>Customer Name</strong>
                                            Sophia Hale
                                        </p>
                                        <p>
                                            <strong>Address</strong>
                                            9825 Johnsaon Dr.Columbo,MD21044
                                        </p>
                                        <p>
                                            <strong>Payment Status</strong>
                                            Pending
                                        </p>
                                        <p>
                                            <strong>Total Items</strong>
                                            10
                                        </p>
                                        <p>
                                            <strong>Amount to Pay</strong>
                                            $722
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <a href="#" class="confirm-delete ml-3" title="Delete"><i class="fas fa-edit"></i></a>
                                        <a href="#" class="confirm-delete ml-3" title="Delete"><i class="fas fa-trash-alt"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="pos-order">
                                    <h3 class="pos-order-title">Order 1</h3>
                                    <div class="orderdetail-pos">
                                        <p>
                                            <strong>Customer Name</strong>
                                            Sophia Hale
                                        </p>
                                        <p>
                                            <strong>Address</strong>
                                            9825 Johnsaon Dr.Columbo,MD21044
                                        </p>
                                        <p>
                                            <strong>Payment Status</strong>
                                            Pending
                                        </p>
                                        <p>
                                            <strong>Total Items</strong>
                                            10
                                        </p>
                                        <p>
                                            <strong>Amount to Pay</strong>
                                            $722
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <a href="#" class="confirm-delete ml-3" title="Delete"><i class="fas fa-edit"></i></a>
                                        <a href="#" class="confirm-delete ml-3" title="Delete"><i class="fas fa-trash-alt"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="pos-order">
                                    <h3 class="pos-order-title">Order 1</h3>
                                    <div class="orderdetail-pos">
                                        <p>
                                            <strong>Customer Name</strong>
                                            Sophia Hale
                                        </p>
                                        <p>
                                            <strong>Address</strong>
                                            9825 Johnsaon Dr.Columbo,MD21044
                                        </p>
                                        <p>
                                            <strong>Payment Status</strong>
                                            Pending
                                        </p>
                                        <p>
                                            <strong>Total Items</strong>
                                            10
                                        </p>
                                        <p>
                                            <strong>Amount to Pay</strong>
                                            $722
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <a href="#" class="confirm-delete ml-3" title="Delete"><i class="fas fa-edit"></i></a>
                                        <a href="#" class="confirm-delete ml-3" title="Delete"><i class="fas fa-trash-alt"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="pos-order">
                                    <h3 class="pos-order-title">Order 1</h3>
                                    <div class="orderdetail-pos">
                                        <p>
                                            <strong>Customer Name</strong>
                                            Sophia Hale
                                        </p>
                                        <p>
                                            <strong>Address</strong>
                                            9825 Johnsaon Dr.Columbo,MD21044
                                        </p>
                                        <p>
                                            <strong>Payment Status</strong>
                                            Pending
                                        </p>
                                        <p>
                                            <strong>Total Items</strong>
                                            10
                                        </p>
                                        <p>
                                            <strong>Amount to Pay</strong>
                                            $722
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <a href="#" class="confirm-delete ml-3" title="Delete"><i class="fas fa-edit"></i></a>
                                        <a href="#" class="confirm-delete ml-3" title="Delete"><i class="fas fa-trash-alt"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="pos-order">
                                    <h3 class="pos-order-title">Order 1</h3>
                                    <div class="orderdetail-pos">
                                        <p>
                                            <strong>Customer Name</strong>
                                            Sophia Hale
                                        </p>
                                        <p>
                                            <strong>Address</strong>
                                            9825 Johnsaon Dr.Columbo,MD21044
                                        </p>
                                        <p>
                                            <strong>Payment Status</strong>
                                            Pending
                                        </p>
                                        <p>
                                            <strong>Total Items</strong>
                                            10
                                        </p>
                                        <p>
                                            <strong>Amount to Pay</strong>
                                            $722
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <a href="#" class="confirm-delete ml-3" title="Delete"><i class="fas fa-edit"></i></a>
                                        <a href="#" class="confirm-delete ml-3" title="Delete"><i class="fas fa-trash-alt"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="pos-order">
                                    <h3 class="pos-order-title">Order 1</h3>
                                    <div class="orderdetail-pos">
                                        <p>
                                            <strong>Customer Name</strong>
                                            Sophia Hale
                                        </p>
                                        <p>
                                            <strong>Address</strong>
                                            9825 Johnsaon Dr.Columbo,MD21044
                                        </p>
                                        <p>
                                            <strong>Payment Status</strong>
                                            Pending
                                        </p>
                                        <p>
                                            <strong>Total Items</strong>
                                            10
                                        </p>
                                        <p>
                                            <strong>Amount to Pay</strong>
                                            $722
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <a href="#" class="confirm-delete ml-3" title="Delete"><i class="fas fa-edit"></i></a>
                                        <a href="#" class="confirm-delete ml-3" title="Delete"><i class="fas fa-trash-alt"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <div class="row">
                            <div class="col-12">
                                <a href="#" class="btn btn-primary">Submit</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade text-left" id="discountpop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel122" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="myModalLabel122">Add Discount</h3>
                        <button type="button" class="close rounded-pill btn btn-sm btn-icon btn-light btn-hover-primary m-0" data-dismiss="modal" aria-label="Close">
                            <svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-x" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    fill-rule="evenodd"
                                    d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"
                                ></path>
                            </svg>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <label class="text-body">Discount</label>
                                <fieldset class="form-group mb-3 d-flex">
                                    <input type="text" name="text" class="form-control bg-white" placeholder="Enter Discount" />
                                    <a href="javascript:void(0)" class="btn-secondary btn ml-2 white pt-1 pb-1 d-flex align-items-center justify-content-center">Apply</a>
                                </fieldset>
                                <div class="p-3 bg-light-dark d-flex justify-content-between border-bottom">
                                    <h5 class="font-size-bold mb-0">Discount Applied of:</h5>
                                    <h5 class="font-size-bold mb-0">$20</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       
        <div class="modal fade text-left" id="shippingcost" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1444" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="myModalLabel1444">Add Shipping Cost</h3>
                        <button type="button" class="close rounded-pill btn btn-sm btn-icon btn-light btn-hover-primary m-0" data-dismiss="modal" aria-label="Close">
                            <svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-x" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    fill-rule="evenodd"
                                    d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"
                                ></path>
                            </svg>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label class="text-body">Customer</label>
                                    <fieldset class="form-group mb-3">
                                        <input type="text" name="text" class="form-control" placeholder="Enter Customer " value="David Jones" disabled />
                                    </fieldset>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-body">Shipping Address</label>
                                    <fieldset class="form-group mb-3">
                                        <select class="js-example-basic-single js-states form-control bg-transparent p-0 border-0" name="state">
                                            <option value="AL">928 Johnsaon Dr Columbo,MD 21044</option>

                                            <option value="WY">933 Johnsaon Dr Columbo,MD 21044</option>
                                        </select>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label class="text-body">Shipping Charges</label>
                                    <fieldset class="form-group mb-3">
                                        <input type="number" name="text" class="form-control" placeholder="Enter Shipping Charges" />
                                    </fieldset>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-body">Shipping Status</label>
                                    <fieldset class="form-group mb-3">
                                        <select class="js-example-basic-single js-states form-control bg-transparent p-0 border-0" name="state">
                                            <option value="AL">Packed</option>

                                            <option value="WY">Open</option>
                                        </select>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label class="text-body">Shipping Charges</label>
                                    <fieldset class="form-label-group">
                                        <textarea class="form-control fixed-size" rows="5" placeholder="Textarea"></textarea>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="form-group row justify-content-end mb-0">
                                <div class="col-md-6 text-right">
                                    <a href="#" class="btn btn-primary">Update Order</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
  

    <!-------add Product Grade Modal------> 
    <div class="modal fade" id="showProductDetailModal"  aria-modal="true"></div>
    <input type="hidden" class="showProductDetailsModalRoute" value="{{ route('admin.sell.regular.pos.show.single.product.details') }}">
    <!-------add Product Grade Modal------> 


        <script src="{{asset('backend/pos')}}/assets/js/plugin.bundle.min.js"></script>
        <script src="{{asset('backend/pos')}}/assets/js/bootstrap.bundle.min.js"></script>
        <script src="{{asset('backend/pos')}}/assets/js/jquery.dataTables.min.js"></script>
        <script src="{{asset('backend/pos')}}/assets/js/multiple-select.min.js"></script>
        <script src="{{asset('backend/pos')}}/assets/js/sweetalert.js"></script>
        <script src="{{asset('backend/pos')}}/assets/js/sweetalert1.js"></script>
        <script src="{{asset('backend/pos')}}/assets/js/script.bundle.js"></script>
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

                    
        
        

        <!-- AJAX Js-->
        <script>
                jQuery.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });
        </script>
        
        @stack('pos-js')
        <script>
            //-----------------------------------------------------------------------
                //    
                jQuery(document).on('click','.productDetails',function(e){
                    e.preventDefault();
                    var url = jQuery('.showProductDetailsModalRoute').val();
                    var id = jQuery(this).data('id');
                    jQuery.ajax({
                        url:url,
                        data:{id:id},
                        success:function(response){
                            jQuery('#showProductDetailModal').html(response.html).modal('show');
                        }
                    });
                });
            //-----------------------------------------------------------------------
        </script>


    </body>
    <!--end::Body-->
</html>
