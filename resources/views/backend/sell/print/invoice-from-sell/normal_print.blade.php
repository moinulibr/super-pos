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
                        <strong style="font-size:25px;padding-bottom:0px;margin-bottom:0px;">{{ companyBanglaNameInInvoice_hh() }}</strong><br>
                        <strong style="font-size:22px;padding-top:0px;margin-top: 0px;">{{ companyNameInInvoice_hh() }}</strong><br>
                        <span>{{ companyAddressLineOneInInvoice_hh() }}</span> 
                        {{ companyAddressLineTwoInInvoice_hh() }}<br>
                        <span><strong>Call:  {{ companyPhone_hh() }} {{ companyPhoneOne_hh() ? ','. companyPhoneOne_hh() : NULL }} {{ companyPhoneTwo_hh() ? ','. companyPhoneTwo_hh() : NULL }}</strong> </span><br>
                    </div>
                </div>
                <div class="col-lg-3"></div>
            </div>
            <hr>

            <div class="invoice__metaInfo" style="margin-top:-10px;margin-bottom:0px;">
                <div class="col-lg-3" style="margin-top:-10px;">
                    {{-- <div class="invoice__orderDetails" style="margin-top:1px;">
                        <strong  style="font-size: 15px">{{ __('Order Details') }} </strong><br>
                        <span><strong>{{ __('Invoice Number') }} :</strong> {{ $data->invoice_no }}</span><br>
                        <span>{{ __('Order Date') }} : <span> </span> {{ date('d-m-Y',strtotime($data->created_at)) }}</span><br>
                        <span>{{  __('Order ID')}} : <span> </span> {{ sprintf("%'.08d", $data->id) }}</span>
                    </div>  --}}
                    <div class="invoice__orderDetails" style="margin-top:1px;">
                        <span>{{ __('Name') }}</span>:  <span> {{ $data->customer ? $data->customer->name : "N/L" }} </span><br>
                        <span>{{ __('Mobile No') }}</span>:  <span> {{ $data->customer ? $data->customer->phone : "N/L" }}</span>
                    </div>
                </div>
                <div class="col-lg-5"  style="margin-top:-10px;">
                    {{-- <div class="invoice__orderDetails" style="margin-top:1px;">
                        <strong  style="font-size: 15px">{{ __('Customer Details') }}</strong><br>
                        <span>{{ __('Name') }}</span>:  <span> {{ $data->customer ? $data->customer->name : "N/L" }} </span><br>
                        <span>{{ __('Phone') }}</span>:  <span> {{ $data->customer ? $data->customer->phone : "N/L" }}</span><br>
                        <span>{{ __('Address') }}</span>: <span>{{ $data->customer ? $data->customer->address : "N/L" }}</span>
                    </div> --}}
                    <div class="invoice__orderDetails" style="margin-top:1px;">
                        <span>{{ __('Address') }}</span>: <span>{{ $data->customer ? $data->customer->address : "N/L" }}</span>
                        {{--<span>{{__('Ref') }}</span>: <span>{{ $data->referenceBy ? $data->referenceBy->name : 'N/L' }}</span>--}}
                    </div>
                </div>
                
                <div class="col-lg-4" style="margin-top:-10px;">
                    {{-- <div class="invoice__orderDetails" style="margin-top:1px;">
                        <strong  style="font-size: 15px">{{ __('Shipping Details') }}</strong><br>
                        <span>{{ __('Shipping Phone') }}</span>: <span>{{ $data->shipping ? $data->shipping->phone : "N/L" }} </span><br>
                        <span>{{ __('Shipping Address') }}</span>: <span> {{ $data->shipping ? $data->shipping->address : "N/L" }}</span><br/>
                        <span>{{ __('Receiver Details') }}</span>: <span> {{$data->receiver_details ?? NULL}} </span><br>
                    </div> --}}
                    <div class="invoice__orderDetails" style="margin-top:1px;">
                        <span>{{ __('Invoice') }} : {{ $data->id }}</span><br>
                        <span>{{ __('Date') }} : <span> </span> {{ date('d-m-Y',strtotime($data->created_at)) }}</span>
                    </div>
                </div>
            </div>
            
            <div class="row" style="margin-top:2px;">

                <div class="col-lg-12">
                    <div class="invoice_table">
                        <div class="mr-table">
                            <div class="table-responsive">
                                <table  cellspacing="0"
                                    width="100%"> {{---class="table table-hover dt-responsive"---}}
                                    <thead style="border-top:1px solid rgba(0, 0, 0, 0.1) !important;">
                                        <tr>
                                            <th style="padding:0px 6px !important;">{{ __('Sl.') }}</th>
                                            <th style="padding:0px 6px !important;">{{ productCustomCodeLabel_hh() }}</th>
                                            <th style="width:50%;padding:0px 6px !important;">{{ __('Product') }}</th>
                                            <th style="text-align: center;padding:0px 6px !important;">{{ __('Qty') }}</th>
                                            <th style="text-align: center;padding:0px 6px !important;">{{ __('Sale Price') }}</th>
                                            <th style="text-align: right;padding:0px 6px !important;">{{ __('Subtotal') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $i = 0;
                                        @endphp
                                        @foreach ($data->sellProducts ? $data->sellProducts : NULL  as $item)
                                        <tr>
                                            @php
                                                $cats = json_decode($item->cart,true);
                                                $i++;
                                            @endphp
                                            <td style="padding:0px 6px !important;">{{ $i }}</td>
                                            <td style="padding:0px 6px !important;">{{$item->custom_code}} </td>
                                            <td style="width:50%;padding:0px 6px !important;">
                                                @if (is_array($cats) && array_key_exists('productName',$cats))
                                                    {{$cats['productName']}}
                                                    @else
                                                    NULL
                                                @endif    
                                            </td>
                                            <td style="text-align: center;padding:0px 6px !important;">
                                                {{$item->total_quantity}}
                                                {{-- @if (is_array($cats) && array_key_exists('unitName',$cats))
                                                    <small>{{$cats['unitName']}}</small>
                                                    @else
                                                    NULL
                                                @endif --}}    
                                            </td>
                                            <td style="text-align: center;padding:0px 6px !important;">{{$item->sold_price}}</th>
                                            <td style="text-align: right;padding:0px 6px !important;"> 
                                                {{$item->total_sold_amount}}
                                                {{--- @if ($item->total_discount > 0)
                                                    <br/>
                                                    (Less : {{ $item->total_discount }})
                                                @endif ---}}
                                            </td>
                                        </tr> 
                                        @endforeach
                                      
                                        <tr >
                                            <th colspan="6" style="border-bottom:1px solid rgba(24,28,33,.06);height:10px;"></th>
                                        </tr>
                                        <tr>
                                            <th colspan="2" style="padding:0px 6px !important;">Less : 
                                                <span style="margin-left:2px;">
                                                    {{$data->total_discount_amount}} 
                                                </span> 
                                            </th>
                                            <th style="text-align: center;padding:0px 6px !important;">
                                                <span style="margin-right:1px;">
                                                    Shipping :  {{$data->shipping_cost}},     
                                                </span>    
                                                <span style="margin-left:1px;margin-right:1px;">
                                                    Other :  {{$data->others_cost}}    
                                                </span>  
                                                
                                            </th>
                                            <th colspan="2" style="text-align: right;padding:0px 6px !important;">
                                                Subtotal
                                            </th>
                                            <th style="text-align: right;padding:0px 6px !important;">{{$data->subtotal}}</th>
                                        </tr>
                                        <tr>
                                            <th colspan="2" style="padding:0px 6px !important;">
                                                Paid  : 
                                                <span style="margin-left:5px;">
                                                    {{ $data->total_paid_amount ?? 0.00 }} 
                                                </span> 
                                            </th>
                                            <th style="text-align: center;padding:0px 6px !important;">
                                                <span style="margin-right:5px;">
                                                  <small> Invoice Current Due </small> :  {{ $data->total_due_amount ?? 0.00 }}   
                                                </span>    
                                                <!-- <span style="margin-left:5px;margin-right:5px;">
                                                   <small> Previous Invoice Due </small> :     
                                                </span>-->
                                            </th>
                                            <th colspan="2" style="text-align: right;padding:0px 6px !important;">
                                                <span style="margin-left:1px;">
                                                    Total
                                                </span>
                                            </th>
                                            <th style="text-align: right;padding:0px 6px !important;"> {{$data->total_payable_amount}}     
                                            </th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                {{---
                    {{$data->customer ? $data->customer->current_total_due : 0.0}} 
                    {{ $data->customer ? $data->customer->totalDueAmount() : 0.0 }}
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