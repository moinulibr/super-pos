<!DOCTYPE html>
<html lang="en" class="default-style layout-fixed layout-navbar-fixed">

<!-- Mirrored from html.phoenixcoded.net/empire/bootstrap/default/pages_authentication_email-confirm.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 21 Jun 2020 10:58:57 GMT -->
<head>
    <title> {{ config('app.name') }} | Sell Edit</title>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="Empire is one of the unique admin template built on top of Bootstrap 4 framework. It is easy to customize, flexible code styles, well tested, modern & responsive are the topmost key factors of Empire Dashboard Template" />
    <meta name="keywords" content="bootstrap admin template, dashboard template, backend panel, bootstrap 4, backend template, dashboard template, saas admin, CRM dashboard, eCommerce dashboard">
    <meta name="author" content="Codedthemes" />
    <link rel="icon" type="image/x-icon" href="{{asset('backend/links/assets')}}/img/favicon.ico">

    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('backend/links/assets')}}/fonts/fontawesome.css">
    <link rel="stylesheet" href="{{asset('backend/links/assets')}}/fonts/ionicons.css">
    <link rel="stylesheet" href="{{asset('backend/links/assets')}}/fonts/linearicons.css">
    <link rel="stylesheet" href="{{asset('backend/links/assets')}}/fonts/open-iconic.css">
    <link rel="stylesheet" href="{{asset('backend/links/assets')}}/fonts/pe-icon-7-stroke.css">
    <link rel="stylesheet" href="{{asset('backend/links/assets')}}/fonts/feather.css">

    <link rel="stylesheet" href="{{asset('backend/links/assets')}}/css/bootstrap-material.css">
    <link rel="stylesheet" href="{{asset('backend/links/assets')}}/css/shreerang-material.css">
    <link rel="stylesheet" href="{{asset('backend/links/assets')}}/css/uikit.css">

    <link rel="stylesheet" href="{{asset('backend/links/assets')}}/libs/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="{{asset('backend/links/assets')}}/libs/flot/flot.css">
    <link rel="stylesheet" href="{{asset('backend/links/assets')}}/libs/flot/flot.css">

   {{--  <!--toster js-->
    <link rel="stylesheet" href="{{asset('backend/links/assets')}}/libs/toastr/toastr.css"> --}}

    <link rel="stylesheet" href="{{asset('custom_css/backend/for-all-file')}}/page-title-style.css">
    @stack('extra-css')
    @stack('custom-css')
    @stack('css')
</head>
<body>




    <div class="authentication-wrapper authentication-2 px-4">
        <div class="authentication-inner py-5">

            <div class="card">
                <div class="p-4 p-sm-5">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>Products:</h4>
                                    <div class="return_product_related_response_here">
                                        <div class="table-responsive">
                                            <table id="example1" class="table table-bordered table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th style="width:30%;">Product</th>
                                                        <th style="width:5%;"><small>Total Sell Qty</small></th>
                                                        <th style="width:60%;">
                                                            <div class="table-responsive" style="padding-bottom: 0px; margin-bottom: -7px !important;">
                                                                <table id="example1" class="table table-bordered table-striped table-hover" style="padding-bottom: 0px; margin-bottom: 0px;">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td style="width:16%;">Stock Name</td>
                                                                            <td style="width:15%;">Sell Unit</td>
                                                                            <td style="width:12%;"><small>Sell Price</small></td>
                                                                            <td style="width:10%;"><small>Sell Qty</small></td>
                                                                            <td style="width:20%;">
                                                                                <small>Editing Qty</small>
                                                                            </td>
                                                                            <td style="width:20%;"><small>Subtotal</small></td>
                                                                            <td style="width:7%; text-align: center;">
                                                                                <input class="check_all_class_for_return form-control" type="checkbox" value="all" name="check_all" style="box-shadow: none;" />
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </th>
                                                        <th style="width:5%;">#</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td  style="width:30%;">
                                                            1.25 Inchi Tee A1
                                                            <br/>
                                                            <b>KS Code : AS06820</b>
                                                        </td>
                                                        <td style="width:5%;text-align: center;">
                                                            <span style="color: green;">7.000 </span>
                                                            <br />
                                                            <del style="color: red;">0.000 </del>
                                                            <br />
                                                            7.000
                                                        </td>
                                                        <td  style="width:60%;">
                                                            <div class="table-responsive" style="padding-bottom: 0px; margin-bottom: -7px !important;">
                                                                <table id="example1" class="table table-bordered table-striped table-hover" style="padding-bottom: 0px; margin-bottom: 0px;">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td style="width:16%;">
                                                                                <small>
                                                                                    Regular Stock
                                                                                </small>
                                                                            </td>
                                                                            <td style="width:15%;">
                                                                                <small>Piece</small>
                                                                            </td>
                                                                            <td style="width:12%; text-align: center;">
                                                                                95.00
                                                                                <input type="hidden" class="sold_price_for_return sold_price_for_return_1" value="95.00" />
                                                                            </td>
                                                                            <td style="width:10%; text-align: center;">4.000</td>
                                                                            <td style="width:20%; text-align: center;">
                                                                                <input type="text" name="returning_qty_1" value="4.000" class="form-control returning_qty returning_qty_1 inputFieldValidatedOnlyNumeric" data-id="1" />
                                                                                <input type="hidden" value="4.000" class="total_quantity total_quantity_1" />
                                                                            </td>
                                                                            <td style="width:20%; text-align: center;">
                                                                                <input type="text" class="line_subtotal_for_return line_subtotal_for_return_1 form-control" disabled="" />
                                                                            </td>
                                                                            <td style="width: 7%; text-align: center;">
                                                                                <input type="hidden" value="1" name="sell_invoice_id" />
                                                                                <input class="check_single_class_for_return form-control check_single_class_for_return_1" type="checkbox" name="checked_id[]" value="" id="1" style="box-shadow: none;" />
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="width:16%;">
                                                                                <small>
                                                                                    Low Stock
                                                                                </small>
                                                                            </td>
                                                                            <td style="width:15%;">
                                                                                <small>Piece</small>
                                                                            </td>
                                                                            <td style="width:12%; text-align: center;">
                                                                                95.00
                                                                                <input type="hidden" class="sold_price_for_return sold_price_for_return_2" value="95.00" />
                                                                            </td>
                                                                            <td style="width:10%; text-align: center;">3.000</td>
                                                                            <td style="width:20%; text-align: center;">
                                                                                <input type="text" name="returning_qty_2" value="3.000" class="form-control returning_qty returning_qty_2 inputFieldValidatedOnlyNumeric" data-id="2" />
                                                                                <input type="hidden" value="3.000" class="total_quantity total_quantity_2" />
                                                                            </td>
                                                                            <td style="width:20%; text-align: center;">
                                                                                <input type="text" class="line_subtotal_for_return line_subtotal_for_return_2 form-control" disabled="" />
                                                                            </td>
                                                                            <td style="width:7%; text-align: center;">
                                                                                <input type="hidden" value="1" name="sell_invoice_id" />
                                                                                <input class="check_single_class_for_return form-control check_single_class_for_return_2" type="checkbox" name="checked_id[]" value="" id="2" style="box-shadow: none;" />
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </td>
                                                        <td style="width:5%;">
                                                            <i class="fa fa-trash" style="color:red;"></i>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>    
                        </div>
                        <div class="col-md-4"></div>
                    </div>          
                </div>
            </div>

        </div>
    </div>


    <!-- AJAX Js-->
    <script src="{{asset('backend/links/assets')}}/js/main.jquery-3.3.1.min.js"></script>

    <script src="{{asset('backend/links/assets')}}/js/pace.js"></script>
    {{-- <script src="{{asset('backend/links/assets')}}/js/jquery-3.3.1.min.js"></script> --}}
    <script src="{{asset('backend/links/assets')}}/libs/popper/popper.js"></script>
    <script src="{{asset('backend/links/assets')}}/js/bootstrap.js"></script>
    <script src="{{asset('backend/links/assets')}}/js/sidenav.js"></script>
    <script src="{{asset('backend/links/assets')}}/js/layout-helpers.js"></script>
    <script src="{{asset('backend/links/assets')}}/js/material-ripple.js"></script>

    <script src="{{asset('backend/links/assets')}}/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="{{asset('backend/links/assets')}}/libs/eve/eve.js"></script>
    <script src="{{asset('backend/links/assets')}}/libs/flot/flot.js"></script>
    <script src="{{asset('backend/links/assets')}}/libs/flot/curvedLines.js"></script>
    <script src="{{asset('backend/links/assets')}}/libs/chart-am4/core.js"></script>
    <script src="{{asset('backend/links/assets')}}/libs/chart-am4/charts.js"></script>
    <script src="{{asset('backend/links/assets')}}/libs/chart-am4/animated.js"></script>

    <script src="{{asset('backend/links/assets')}}/js/demo.js"></script>
    <script src="{{asset('backend/links/assets')}}/js/analytics.js"></script>

</body>

<!-- Mirrored from html.phoenixcoded.net/empire/bootstrap/default/pages_authentication_email-confirm.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 21 Jun 2020 10:58:57 GMT -->
</html>
