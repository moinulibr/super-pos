<!DOCTYPE html>
<html>
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="keywords" content=" {{ config('app.name') }}">
        <meta name="author" content="GeniusOcean">

        <title> {{ config('app.name') }} </title>
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
  </style>
</head>
<body onload="window.print();">
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

            <div class="row">

                <div class="col-lg-12">
                    <div class="invoice_table">
                        <div class="mr-table">
                            <div class="table-responsive">
                                <table id="example2" class="table table-hover dt-responsive" cellspacing="0"
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
                                    <tbody>
                                        @php
                                        $i = 0;
                                        @endphp
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
                                            <td>{{$item->total_payable_amount}}</td>
                                            <td>{{$item->total_paid_amount}}</td>
                                            <td>{{$item->total_due_amount}}</td>
                                            <td>{{$item->total_discount_amount}}</td>
                                            <td>{{$item->totalSellItemAfterRefund()}}</td>
                                            @php
                                                $totalSellAmount += $item->total_payable_amount;
                                                $totalPaidAmount += $item->total_paid_amount;
                                                $totalDueAmount += $item->total_due_amount;
                                                $totalLessAmount += $item->total_discount_amount;
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
                    </div>
                </div>
            
                
            </div>
            
             
        </div>

<script type="text/javascript">
setTimeout(function () {
        window.close();
      }, 500);
</script>

</body>
</html>