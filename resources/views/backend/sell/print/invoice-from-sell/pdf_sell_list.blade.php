<!DOCTYPE html>
<html>
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="keywords" content=" {{ config('app.name') }}">
        <meta name="author" content="GeniusOcean">

        <title> {{ config('app.name') }} | {{$title}} </title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{asset('backend/print/bootstrap.main.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('backend/print/font-awesome/css/font-awesome.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{asset('backend/print/Ionicons/css/ionicons.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('backend/print/css/style.css')}}">
  <link href="{{asset('backend/print/css/print.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        <link rel="icon" type="image/png" href="{{asset('assets/images/favicon.ipg')}}"> 
<style type="text/css">
   h2 {
  text-align: center;
  padding: 20px 0;
}

.table-bordered {
  border: 1px solid #ddd !important;
}

table caption {
	padding: .5em 0;
}

@media screen and (max-width: 767px) {
  table caption {
    display: none;
  }
}

.p {
  text-align: center;
  padding-top: 140px;
  font-size: 14px;
}
  </style>
</head>
<body ">
    <div class="invoice-wrap">
            <!---
            <div class="invoice__title">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="invoice__logo text-left">
                            <img src=" asset('assets/images/e-basket.png')" alt="AMADER SANITARY">
                        </div>
                    </div>
                </div>
            </div>
            -->

            <div class="invoice__metaInfo" style="margin-top:-10px;margin-bottom: -30px;">
                <div class="col-lg-3"></div>
                <div class="col-lg-6">
                    <div class="invoice__orderDetails" style="text-align: center;font-size: 14px">
                        <strong style="font-size: 19px">{{ companyNameInInvoice_hh() }}</strong><br>
                        <span>{{ companyAddressLineOneInInvoice_hh() }}</span> 
                        {{ companyAddressLineTwoInInvoice_hh() }}<br>
                        <span><strong>Call:  {{ companyPhone_hh() }} {{ companyPhoneOne_hh() ? ','. companyPhoneOne_hh() : NULL }} {{ companyPhoneTwo_hh() ? ','. companyPhoneTwo_hh() : NULL }}</strong> </span><br>
                    </div>
                </div>
                <div class="col-lg-3"></div>
            </div>
            <hr>

            <div style="margin:3% 2%;">
                
        <div class="container">
        <div class="row">
            <div class="col-xs-12">
            <div class="table-responsive" data-pattern="priority-columns">
                
            
                    <table id="example2" style="border:1px solid gray !important;" cellspacing="0"
                    width="100%">
                    <thead style="border-top:1px solid rgba(0, 0, 0, 0.1) !important;">
                        <tr>
                            <th  style="width:3%;">#</th>
                            <th style="width:;">Invoice No</th>
                            <th style="width:;">Date(Time) </th>
                            <th style="width:;">Customer </th>
                            <th style="width:;">Total Amount </th>
                            <th style="width:;">Paid Amount </th>
                            <th style="width:;">Due Amount </th>
                            <th style="width:;">Less Amount </th>
                            <th style="width:;">Total Item </th>
                        </tr>
                    </thead>
                    <tbody style="border:1px solid gray !important;">
                        @php
                            $totalSellAmount = 0;
                            $totalPaidAmount = 0;
                            $totalDueAmount = 0;
                            $totalLessAmount = 0;
                            $totalItem = 0;
                        @endphp
                        @foreach ($datas as $index => $item)
                            <tr>
                                <th scope="row">
                                    {{$index + 1}}
                                </th>
                                <td> {{$item->invoice_no}}</td>
                                <td>
                                    {{date('d-m-Y h:i:s A',strtotime($item->created_at))}}
                                </td>
                                <td>{{$item->customer?$item->customer->name:NULL}}</td>
                                <td>{{$item->totalInvoicePayableAmountAfterRefundAfterDiscount()}}</td>
                                <td>{{$item->total_paid_amount}}</td>
                                <td>{{$item->totalInvoicePayableAmountAfterRefundAfterDiscount() - $item->total_paid_amount}}</td>
                                <td>{{$item->totalInvoiceDiscountAmountWithAdjustment()}}</td>
                                <td>{{$item->totalSellItemAfterRefund()}}</td>
                                @php
                                    $totalSellAmount += $item->totalInvoicePayableAmountAfterRefundAfterDiscount();
                                    $totalPaidAmount += $item->total_paid_amount;
                                    $totalDueAmount += $item->total_due_amount;
                                    $totalLessAmount += $item->totalInvoiceDiscountAmountWithAdjustment();
                                    $totalItem += $item->totalSellItemAfterRefund();
                                @endphp
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4" style="text-align:right">Total</th>
                            <th>{{number_format($totalSellAmount,2,'.','')}}</th>
                            <th>{{number_format($totalPaidAmount,2,'.','')}}</th>
                            <th>{{number_format($totalDueAmount,2,'.','')}}</th>
                            <th>{{number_format($totalLessAmount,2,'.','')}}</th>
                            <th>{{$totalItem}}</th>
                        </tr>
                    </tfoot>
                </table> 
                
                 
            </div>
            
        </div>


</body>
</html>