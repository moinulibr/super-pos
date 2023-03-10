<!DOCTYPE html>
<html>
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="keywords" content="{{ config('app.name') }} ">
        <meta name="author" content="GeniusOcean">

        <title> {{ config('app.name') }} </title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
 {{--    <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{asset('backend/print/bootstrap/dist/css/bootstrap.min.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('backend/print/font-awesome/css/font-awesome.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{asset('backend/print/Ionicons/css/ionicons.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('backend/print/css/style.css')}}">
  <link href="{{asset('backend/print/css/print.css')}}" rel="stylesheet"> --}}
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  {{-- <link rel="icon" type="image/png" href="{{asset('backend/images/favicon.ipg')}}"> 
  <style type="text/css">
    @page { size: auto;  margin: 0mm; }
    @page {
    size: A4;
    margin: 0;
    }
    @media print {
    html, body {
        width: 210mm;
        height: 287mm;
    }

    html {

    }
    ::-webkit-scrollbar {
        width: 0px;  /* remove scrollbar space */
        background: transparent;  /* optional: just make scrollbar invisible */
    }
  </style> --}}
    <style>
        body {
        width: 300px;
        margin: 0 auto;
        background: rgb(216, 216, 216);
        }
        .mini-invoice {
            background: white;
            padding: 10px;
            margin-top: 10px;
        }
        h1{
        font-size: 1.5em;
        color: #000;
        }
        h1.brand {
            margin-bottom: 3px;
        }
        h2{font-size: 0.8em;}
        h3{
        font-size: 1em;
        font-weight: 600;
        }
        p{
        font-size: 1em;
        color: #000;
        line-height: 1.2em;
        }
        p.serve {
            margin-bottom: 10px !important;
        }
        #top{
            min-height: 100px;
            text-align: center;
        }

        #bot{ min-height: 50px;}

        #top .logo{
            height: 60px;
            width: 60px;
            no-repeat;
            background-size: 60px 60px;
        }
        .clientlogo{
        float: left;
            height: 60px;
            width: 60px;
            background-size: 60px 60px;
        border-radius: 50px;
        }
        .info{
        display: block;
        margin-left: 0;
        }
        .info p{
            margin: 0;
            padding: 0 2px;
        }
        #mid { font-size:.7em;}
        .title{
        float: right;
        }
        .title p{text-align: right;}
        table{
        width: 100%;
        border-collapse: collapse;
        }
        .tabletitle{
        font-size: 1em;
        /* font-weight: 600; */
        font-weight: 100;
        }
        .items-table-label{
        /* border-top: dashed 1px gray;
        border-bottom:dashed 1px gray; */
        vertical-align: middle;
        }
        .subtotal{
            /* border-top: dashed 1px gray; */
            font-size: 1em;
            }
        .subtotal .right-side-td{
            text-align: right;
            }
        .item{width: 40mm;}
        .itemtext{
            font-size: .8em;
            margin-bottom:0;
            display: inline-block;
        }
        .option-item{
            font-size: 1.5em;
            font-style: italic;
            display: block;
            color: #000;
        }
        #legalcopy{
        margin-top: 10mm;
        text-align:center;
        }
        ul.payment-methods {
        font-size: 1.5em;
        list-style: none;
        margin-left: -40px;
    }
    td.tableitem.item-qty {
        text-align: center;
    }
    </style>
</head>
<body onload="window.print();">
        
    <div class="mini-invoice">
        <div id="top" style="margin-top: -10px">
            <h2 class="brand" style="margin-bottom:2px;font-size: 1.2em">
                {{ companyNameInInvoice_hh() }}
            </h2>
            <div class="info" style="font-size: 0.9em;">
                <p>{{ companyFullAddressInInvoice_hh() }} </p>
                <p>Call: {{ companyPhone_hh() }} {{ companyPhoneOne_hh() ? ','.companyPhoneOne_hh() : NULL }}</p>
                <b>Invoice No. #{{$data->invoice_no}}</b>
                <p>Date: {{date('d/m/Y, h:i:s A')}}</p>
                <p class="serve">Served by: {{$data->createdBy ? $data->createdBy->name: "N/L"}} </p>
            </div>
        </div>
        <div id="mid" style="margin-bottom: 30px;">
            <div class="payment-details">
                <ul class="payment-methods">
                    <!--  Cash : 75.23 -->
                </ul>
            </div>
        </div>
    
        <table style="font-size: 10px !important;">
            <!--border-top-->
            <tr><td colspan="4"  style="border-top:1px dashed gray;"></td></tr>
            <!--border-top-->
    
            <!--Item Heading-->
            <tr class="tabletitle items-table-label" style="font-size: 12px !important;">
                <td class="item">Item Description</td>
                <td class="qty">Unit Price</td>
                <td class="qty">Qty</td>
                <td class="total" style="text-align:right;">Total</td>
            </tr>
            <!--Item Heading-->
    
            <!--border-top-->
            <tr><td colspan="4"  style="border-top:1px dashed gray;"></td></tr>
            <!--border-top-->
            
            @foreach ($data->sellProducts ? $data->sellProducts : NULL  as $item)
            <tr class="service">
                @php
                    $cats = json_decode($item->cart,true);
                @endphp
                <td class="tableitem item-name" style="padding-bottom:1px;padding-top:3px;border-bottom: 0.10px dotted #c3c3c3;padding-bottom:2px;font-size: 10px !important;">
                    <span style="">
                    @if (array_key_exists('productName',$cats))
                        {{$cats['productName']}}
                        @else
                        NULL
                    @endif
                    </span>
                </td>
                <td class="tableitem item-price" style="padding-bottom:1px;padding-top:3px;border-bottom: 0.10px dotted #c3c3c3;padding-bottom:2px;font-size: 10px !important;">
                    <span style="">
                        {{$item->sold_price}}
                    </span>
                </td>
                <td class="tableitem item-qty" style="padding-bottom:1px;padding-top:3px;border-bottom: 0.10px dotted #c3c3c3;padding-bottom:2px;font-size: 10px !important;">
                    <span style="">
                        {{$item->total_quantity}}
                        {{-- @if (array_key_exists('unitName',$cats))
                            <small>{{$cats['unitName']}}</small>
                            @else
                            NULL
                        @endif --}}
                    </span>
                </td>
                <td class="tableitem item-total" style="padding-bottom:1px;padding-top:3px;border-bottom: 0.10px dotted #c3c3c3;text-align:right;padding-bottom:2px;font-size: 10px !important;">
                    <span style="">
                        {{$item->total_sold_amount}} 
                       {{--- @if ($item->total_discount > 0)
                            <br/>
                            (Less : {{ $item->total_discount }})
                        @endif ---}}
                    </span>
                </td>
            </tr>
            @endforeach
            <!--Item-->
    
            <!--border-top,-->
            <tr><td colspan="4"  style="border-top:1px dashed gray;"></td></tr>
            <!--border-top-->
            
    
            <tr class="subtotal tabletitle">
                <td class="Rate sub-total-title" style="text-align:right; padding-right:5px;padding-top:5px;padding-bottom:5px;" >
                    Sub Total
                </td>
                <td class="Rate grand-total-title"style="padding-top:5px;padding-bottom:5px;">:</td>
                <td class="payment sub-total-amount" style="text-align:right;padding-top:5px;padding-bottom:5px;" colspan="2">
                    {{$data->totalInvoicePayableAmountAfterRefundAfterDiscount()}}
                </td>
            </tr>
            <tr class="tabletitle">
                <td class="Rate tax-title" style="text-align: right; padding-right:5px;" >
                    (-{{$data->discount_amount}}@if($data->discount_type == 'percentage')%@endif) Discount 
                </td>
                <td class="Rate grand-total-title">:</td>
                <td class="payment cart-discount-amount" style="text-align:right;padding-top:7px;padding-bottom:5px;" colspan="2">
                    {{$data->total_discount}}
                </td>
            </tr>
    
            <!--border-bottom-->
            <tr><td colspan="1"></td><td colspan="3"  style="border-bottom: 1px dashed gray;"></td></tr>
            <!--border-bottom-->
    
            <!-- -->
            <tr>
                <td colspan="1"></td>
                <td colspan="3"  style="text-align:right;padding-top:5px">
                   {{ $data->totalInvoicePayableAmountAfterRefundAfterDiscount() - $data->total_discount }}
                </td>
            </tr>
            <!-- -->
    
            <tr class="tabletitle">
                <td class="Rate tax-title" style="text-align:right;padding-right:5px;padding-top:7px;" >
                    ({{ $data->vat_amount }}%) Vat
                </td>
                <td class="Rate grand-total-title" style="padding-top:7px;">:</td>
                <td class="payment tax-amount" style="text-align:right;padding-top:7px;padding-bottom:7px" colspan="2">
                    {{ $data->total_vat }}
                </td>
            </tr>
            <!--border-bottom-->
            <tr><td colspan="1"></td><td colspan="3"  style="border-bottom: 1px dashed gray;"></td></tr>
            <!--border-bottom-->
             <!-- -->
             <tr>
                <td colspan="1"></td>
                <td colspan="3"  style="text-align:right;padding-top:5px">
                    {{ number_format((( $data->totalInvoicePayableAmountAfterRefundAfterDiscount() - $data->total_discount ) + $data->total_vat),2,'.', '') }} 
                </td>
            </tr>
            <!-- -->


            <tr class="tabletitle">
                <td class="Rate tax-title" style="text-align:right;padding-right:5px;padding-top:7px;" >
                    (+) Shipping Cost
                </td>
                <td class="Rate grand-total-title" style="padding-top:7px;">:</td>
                <td class="payment tax-amount" style="text-align:right;padding-top:7px;padding-bottom:7px" colspan="2">
                    {{ $data->shipping_cost }}
                </td>
            </tr>
            <!--border-bottom-->
            <tr><td colspan="1"></td><td colspan="3"  style="border-bottom: 1px dashed gray;"></td></tr>
            <!--border-bottom-->
            <!-- -->
            <tr>
                <td colspan="1"></td>
                <td colspan="3"  style="text-align:right;padding-top:5px">
                    {{ number_format((( $data->totalInvoicePayableAmountAfterRefundAfterDiscount() - $data->total_discount ) + $data->total_vat + $data->shipping_cost),2,'.', '') }} 
                </td>
            </tr>
            <!-- -->


            <tr class="tabletitle">
                <td class="Rate tax-title" style="text-align:right;padding-right:5px;padding-top:7px;" >
                    (+) Others Cost
                </td>
                <td class="Rate grand-total-title" style="padding-top:7px;">:</td>
                <td class="payment tax-amount" style="text-align:right;padding-top:7px;padding-bottom:7px" colspan="2">
                    {{  $data->others_cost }}
                </td>
            </tr>
            <!--border-bottom-->
            <tr><td colspan="1"></td><td colspan="3"  style="border-bottom: 1px dashed gray;"></td></tr>
            <!--border-bottom-->
             <!-- -->
             <tr>
                <td colspan="1"></td>
                <td colspan="3"  style="text-align:right;padding-top:5px">
                    {{ number_format((( $data->totalInvoicePayableAmountAfterRefundAfterDiscount() - $data->total_discount ) + $data->total_vat + $data->shipping_cost + $data->others_cost ),2,'.', '') }} 
                </td>
            </tr>
            <!-- -->
           
            
    
            <tr class="tabletitle">
                <td class="Rate tax-title" style="text-align: right; padding-right: 5px;" >
                    (+/-) Rounding
                </td>
                <td class="Rate grand-total-title" style="padding-right: 5px;">:</td>
                <td class="payment tax-amount" style="text-align:right;padding-bottom:7px;" colspan="2">
                    {{ $data->round_amount }}
                </td>
            </tr>
    
            <!--border-bottom-->
            <tr><td colspan="1"></td><td colspan="3"  style="border-bottom: 1px dashed gray;"></td></tr>
            <!--border-bottom-->
    
            <tr class="tabletitle">
                <td class="Rate grand-total-title" style="text-align: right; padding-right:5px;padding-top:15px" >
                    <strong style="font-size:14px;">Net Payable</strong>
                </td>
                <td class="Rate grand-total-title" style="padding-top:15px">:</td>
                <td class="payment grand-total-amount" style="text-align:right;padding-top:15px" colspan="2">
                    <strong style="font-size:14px;">
                        {{ $data->totalInvoicePayableAmountAfterRefundAfterDiscount() }}
                    </strong>
                </td>
            </tr>
    
            <!--border-bottom,padding 5-->
            <tr><td colspan="1"></td><td colspan="3"  style="border-bottom: 1px dashed gray;padding-top:5px;"></td></tr>
            <!--border-bottom,padding 5-->
    
            {{-- <tr class="tabletitle">
                <td class="Rate grand-total-title" style="text-align: right; padding-right: 5px;padding-top:15px" >
                    Cash Paid
                </td>
                <td class="Rate grand-total-title" style="padding-top:15px">:</td>
                <td class="payment grand-total-amount" style="text-align:right;padding-top:15px;" colspan="2">
                    <strong>7,500.00</strong>
                </td>
            </tr> --}}
        </table>
    
        <div style="margin-top:20px;"></div>
    
        
        <!--discount details part-->
        {{-- <table style="font-size: 10px !important;">
    
            <!--border-top-->
            <tr><td colspan="4"  style="border-top:1px dashed gray;"></td></tr>
            <!--border-top-->
            
            <tr class="tabletitle items-table-label">
                <td class="item"  style="border-bottom:1px dashed gray;padding-bottom: 5px;padding-top: 10px;">
                    **Discount Items**
                </td>
                <td colspan="3"></td>
            </tr>
    
            <!--padding bottom-->
            <tr><td colspan="4"  style="padding-bottom: 10px;"></td></tr>
            <!--padding bottom-->
    
            <tr class="service">
                <td class="tableitem item-name" colspan="3" style="padding-bottom:2px;font-size: 10px !important;">
                    <p class="">ACME Oven </p>
                </td>
                <td class="tableitem item-total" style="text-align:right;padding-bottom:2px;font-size: 10px !important;">
                    <p class="">2,152.00</p>
                </td>
            </tr>
            <tr class="service">
                <td class="tableitem item-name" colspan="3" style="padding-bottom:2px;font-size: 10px !important;">
                    <p class="">ACME Oven </p>
                </td>
                <td class="tableitem item-total" style="text-align:right;padding-bottom:2px;font-size: 10px !important;">
                    <p class="">2,152.00</p>
                </td>
            </tr>
            <!--border-top-->
            <tr><td colspan="4"  style="border-top:1px dashed gray;"></td></tr>
            <!--border-top-->
    
            <tr>
                <td colspan="2">Discount Total</td>
                <td colspan="2"  style="text-align:right;">123</td>
            </tr>
        </table> --}}
        <!--discount details part-->
    
    
        <div  style="border-top:1px dashed gray;padding-top:10px;padding-bottom:10px;margin-top: 10px;"></div>
    
    
    
        <div id="legalcopy">
            <p class="legal">
                Thank you for shopping with <strong>us.</strong> <br />
            </p>
        </div>
    </div>


<script type="text/javascript">
setTimeout(function () {
        window.close();
      }, 500);
</script>

</body>
</html>