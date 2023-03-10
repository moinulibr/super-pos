<!DOCTYPE html>
<html>
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="keywords" content=" {{ config('app.name') }}">
        <meta name="author" content="GeniusOcean">

        <title> {{ config('app.name') }}</title>
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

            <div class="invoice__metaInfo" style="margin-top:-10px;">
                <div class="col-lg-3" style="margin-top:-10px;">
                    <div class="invoice__orderDetails" style="margin-top:1px;">
                        <strong  style="font-size: 15px">{{ __('Order Details') }} </strong><br>
                        <span><span>{{ __('Invoice Number') }} :</span> {{ $data->invoice_no }}</span><br>
                        <span>{{ __('Order Date') }} : <span> </span> {{ date('d-m-Y',strtotime($data->created_at)) }}</span>
                    </div>
                </div>
                <div class="col-lg-5"  style="margin-top:-10px;">
                    <div class="invoice__orderDetails" style="margin-top:1px;">
                        <strong  style="font-size: 15px">{{ __('Supplier Details') }}</strong><br>
                        <span>Supplier Name : </span> <span style="font-size:14px;"> {{$data->supplier ? $data->supplier->name  :NULL}}</span><br>
                        <span>{{ __('Supplier Phone') }}</span>:  <span>  {{$data->supplier ? $data->supplier->phone  :NULL}}</span>
                    </div>
                </div>
                
                <div class="col-lg-4" style="margin-top:-10px;">
                    <div class="invoice__orderDetails" style="margin-top:1px;">
                        <strong  style="font-size: 15px">{{ __('Notes') }}</strong><br>
                        <span>{{ __('Shipping Note') }}</span>: <span>{{ $data->shipping_note }} </span><br>
                        <span>{{ __('Shipping Note') }}</span>: <span> {{ $data->purchase_note }}</span>
                    </div>
                </div>
            </div>
            <div class="row">

                <div class="col-lg-12">
                    <div class="invoice_table">
                        <div class="mr-table">
                            <div class="table-responsive">
                                <table id="example2" class="table table-hover dt-responsive" cellspacing="0"
                                    width="100%">
                                    <thead style="border-top:1px solid rgba(0, 0, 0, 0.1) !important;">
                                        <tr>
                                            <th>{{ __('Sl.') }}</th>
                                            <th>{{productCustomCodeLabel_hh()}}</th>
                                            <th style="width:50%">{{ __('Product') }}</th>
                                            <th style="text-align: center;">{{ __('Qty') }}</th>
                                            <th style="text-align: center;">{{ __('Purchase Price') }}</th>
                                            <th style="text-align: right;">{{ __('Subtotal') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $i = 0;
                                        @endphp
                                        @foreach ($data->purchaseProducts ? $data->purchaseProducts : NULL  as $item)
                                        <tr>
                                            @php
                                                $cat = json_decode($item->carts,true);
                                                $i++;
                                            @endphp
                                            <td>{{$i}}</td>
                                            <td>{{$item->custom_code}} </th>
                                            <td style="width:50%">
                                                @if (array_key_exists('productName',$cat))
                                                    {{$cat['productName']}}
                                                    @else
                                                    NULL
                                                @endif    
                                            </th>
                                            <td style="text-align: center;">
                                                {{$item->quantity}}
                                                {{-- @if (array_key_exists('unitName',$cat))
                                                    <small>{{$cat['unitName']}}</small>
                                                    @else
                                                    NULL
                                                @endif --}}    
                                            </th>
                                            <td style="text-align: center;">{{number_format(($item->total_purchase_price / $item->quantity),2,'.','')}}</td>

                                            <td style="text-align: right;">{{$item->total_purchase_price}}</td>
                                        </tr> 
                                        @endforeach
                                        <tr>
                                            <th colspan="2">Less : 
                                                <span style="margin-left:5px;">
                                                    {{$data->total_discount}} 
                                                </span> 
                                            </th>
                                            <th style="text-align: center;">
                                                <span style="margin-right:5px;">
                                                    Shipping :  {{$data->shipping_cost}},     
                                                </span>    
                                                <span style="margin-left:5px;margin-right:5px;">
                                                    Other :  {{$data->others_cost}},     
                                                </span>  
                                                <span style="margin-left:8px;margin-right:2px;">
                                                    Total :  {{$data->total_payable_amount}}     
                                                </span> 
                                            </th>
                                            <th colspan="2" style="text-align: right;">
                                                Subtotal
                                            </th>
                                            <th style="text-align: right;">{{$data->subtotal}}</th>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                {{---
                    <div class="invoice__metaInfo" style="margin-top:0px;">
                        <div class="col-lg-6">
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Reference No</th>
                                            <th>Amount</th>
                                            <th>Credit/Debit</th>
                                            <th>Payment Method</th>
                                            <th>Payment Note</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        
                        <div class="col-lg-6">
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-striped table-hover">
                                    <tbody>
                                        <tr>
                                            <td colspan="2">
                                                <strong>Sub Total</strong>
                                            </td>
                                            <td></td>
                                            <td style="text-align:center;">
                                                <span style="font-size:14px;"> {{$data->subtotal}}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <strong>Less Amount</strong>
                                            </td>
                                            <td>(-)</td>
                                            <td style="text-align:center;">
                                                <span style="font-size:14px;"> {{$data->total_discount}}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <strong>({{ $data->vat_amount }}%) Vat</strong>
                                            </td>
                                            <td>(+)</td>
                                            <td style="text-align:center;">
                                                {{ $data->total_vat }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <strong>Shipping</strong>
                                            </td>
                                            <td></td>
                                            <td style="text-align:center;">
                                                <span style="font-size:14px;"> {{$data->shipping_cost}}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <strong>Other cost</strong>
                                            </td>
                                            <td></td>
                                            <td style="text-align:center;">
                                                <span style="font-size:14px;"> {{$data->others_cost}}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <strong>Round off</strong>
                                            </td>
                                            <td>(+/-)</td>
                                            <td style="text-align:center;">
                                                <span style="font-size:14px;"> {{$data->round_amount}}</span>
                                            </td>
                                        </tr> 
                                        <tr>
                                            <td colspan="2">
                                                <strong>Total Payable</strong>
                                            </td>
                                            <td></td>
                                            <td style="text-align:center;">
                                                {{$data->total_payable_amount}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <strong>Total Paid</strong>
                                            </td>
                                            <td></td>
                                            <td style="text-align:center;">
                                                {{$data->total_paid_amount}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <strong>Total Due</strong>
                                            </td>
                                            <td></td>
                                            <td style="text-align:center;">
                                                {{$data->due_amount}}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    
                    </div>
                --}}
            </div>
            
             
                

        </div>

<script type="text/javascript">
setTimeout(function () {
        window.close();
      }, 500);
</script>

</body>
</html>