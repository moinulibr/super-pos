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
    <div class="table-responsive table-datapos  col-md-12" id="printableTable">
        <table id="orderTable" class="display table-striped" style="width:100%;font-family: Open Sans, Roboto, -apple-system, BlinkMacSystemFont,
        Segoe UI, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, sans-serif;">
            <thead class="thead-dark">
                <tr>
                    <th class="sticky-head" style="width:3%;background-color: #f7f7f7;">Sl</th>
                    <th class="sticky-head" style="width:25%;text-align:center;background-color: #f7f7f7;">Product</th>
                    <th class="sticky-head" style="width:7%;text-align:center;background-color: #f7f7f7;">Sell <br/> Unit</th>
                    <th class="sticky-head" style="width:5%;text-align:center;background-color: #f7f7f7;">Total <br/>Qty</th>
                    <th class="sticky-head" style="width:55%;text-align:center;padding:0px !important">
                        <table class="display" style="width:100%;border:none;">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="sticky-head" style="width: 25%;text-align:center;background-color: #f7f7f7;">Stock <br/> Name</th>
                                    <th class="sticky-head" style="width: 15%;text-align:center;background-color: #f7f7f7;">Sell Price</th>
                                    <th class="sticky-head" style="width: 10%;text-align:center;background-color: #f7f7f7;">Sell Qty</th>
                                    <th class="sticky-head" style="width: 25%;text-align:center;background-color: #f7f7f7;">Update Qty</th>
                                    <th class="sticky-head" style="width: 20%;background-color: #f7f7f7;">Subtotal</th>
                                    <th class="sticky-head" style="width: 10%;background-color: #f7f7f7;">#</th>
                                </tr>
                            </thead>
                        </table>
                    </th>
                    <th class="sticky-head" style="width: 5%;text-align:center;background-color: #f7f7f7;"></th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalProduct = 1;
                @endphp
                @forelse ($sellEditCart->editSellCartProducts as $editSellCartProduct)
                <tr class="" style="border-bottom: 0.05px dashed #dddfe0;">
                    <td style="width:3%;text-align:center;padding-top:1%;padding-bottom:1%;background-color: #f5f5f5">
                        {{$loop->iteration}}
                    </td>
                    <td style="width:25%;text-align:center;padding-top:1%;padding-bottom:1%;">
                         @php
                            $cats = json_decode($editSellCartProduct->cart,true);
                        @endphp
                        @if (array_key_exists('productName',$cats))
                            {{$cats['productName']}}
                            @else
                            NULL
                        @endif
                        <br/>
                        <b>{{productCustomCodeLabel_hh()}} : {{$editSellCartProduct->custom_code}}</b>
                    </td>
                    <td style="width:7%;text-align:center;padding-top:1%;padding-bottom:1%;">
                         @if (array_key_exists('unitName',$cats))
                            <small>{{$cats['unitName']}}</small>
                            @else
                            NULL
                        @endif
                    </td>
                    <td style="width:5%;text-align:center;padding-top:1%;padding-bottom:1%;">
                       {{number_format($editSellCartProduct->total_quantity,2,'.','')}}
                    </td>
                    <td style="width:55%;text-align:center;padding-right:0px !important;padding-left:0px !important;">
                        <table class="display" style="width:100%;">
                            <thead class="thead-dark">
                                @foreach ($editSellCartProduct->editSellCartProductStocks as $item)
                                <tr>
                                    <td  style="width:20%;text-align:center;padding-left: 0px !important;padding-right: 0px !important;">
                                     <small>
                                                {{ $item->stock ? $item->stock->label : NULL}}
                                        </small>
                                    </td>
                                    <td class="" style="width: 15%;text-align:center;text-align:center;padding-left: 0px !important;padding-right: 0px !important;">
                                    {{ $item->sold_price}}
                                            <input type="hidden" class="sold_price_for_return sold_price_for_return_2" value="95.00" />
                                    </td>
                                    <td class="" style="width: 10%;text-align:center;text-align:center;padding-left: 0px !important;padding-right: 0px !important;">
                                    {{ number_format($item->total_quantity,2,'.','')}}
                                    </td>
                                    <td class="" style="width: 25%;text-align:center;text-align:center;padding-left: 0px !important;padding-right: 0px !important;">
                                    <span class="quantityChange" data-change_type="minus" data-product_id="1766" data-quantity="1" style="cursor:pointer">
                                                <i class="fa fa-minus-circle"></i>
                                            </span>
                                
                                            <span id="set-1" class="total_cart_quantity">{{ number_format($item->total_quantity,2,'.','')}}</span>
                                
                                            <span class="quantityChange" data-change_type="plus" data-product_id="1766" data-quantity="1" style="cursor:pointer">
                                                <i class="fa fa-plus-circle"></i>
                                            </span>
                                            
                                            <br>
                                            <strong id="not_available_message_1" style="font-size:11px; color:red;"></strong>
                                    </td>
                                    <td class="" style="width: 20%;text-align:center;padding-left: 0px !important;padding-right: 0px !important;">
                                     <span>{{ number_format($item->total_quantity *  $item->sold_price ,2,'.','')}}</span>
                                            <input type="hidden" class="selling_final_subtotal_amount_from_cartlist" value=" 88.61">
                                            <input type="hidden" class="total_purchase_price_of_all_quantity_from_cartlist" value=" 71.8">
                                    </td>
                                    <td class="" style="width: 10%;text-align:center;padding-left: 0px !important;padding-right: 0px !important;">
                                        <i class="fa fa-trash" style="color:#992222;"></i>
                                    </td>
                                </tr>
                                @endforeach
                            </thead>
                        </table>
                    </td>

                    {{-- <td style="text-align:center;background-color: #f5f5f5;padding-top:1%;padding-bottom:1%;">
                        <span class="quantityChange" data-change_type="minus" data-product_id="" data-quantity="1" style="cursor:pointer">
                            <i class="fa fa-minus-circle"></i>
                        </span>
            
                        <span id="set-1" class="total_cart_quantity">0</span>
            
                        <span class="quantityChange" data-change_type="plus" data-product_id="" data-quantity="1" style="cursor:pointer">
                            <i class="fa fa-plus-circle"></i>
                        </span>
                        
                        <br>
                        <strong id="not_available_message_1" style="font-size:11px; color:red;"></strong>
                    </td>
                    <td style="text-align:center;padding-top:1%;padding-bottom:1%;">
                        0
                    </td>
                    <td style="text-align:center;background-color: #f5f5f5;padding-top:1%;padding-bottom:1%;">
                        0
                        <input type="hidden" class="selling_final_subtotal_amount_from_cartlist" value="">
                        <input type="hidden" class="total_purchase_price_of_all_quantity_from_cartlist" value="">
                    </td> --}}
                    <td style="padding-top:1%;padding-bottom:1%;">
                        <div class="card-toolbar text-right">
                            <a href="#" data-product_id="" class="remove_this_item_from_sell_cart_list remove_this_item_from_sell_cart_list_" title="Delete"><i style="color: red" class="fas fa-trash-alt"></i></a>
                        </div>
                    </td>
                </tr>
                @php
                    $totalProduct++;
                @endphp

                @empty
                <tr>
                    <th colspan="9" style="text-align: center;border-bottom: 1px solid ##f7f7f7;">No data found</th>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<!---------added to cart product list----------->
<input type="hidden" class="total_item_from_cartlist" value="0">
<input type="hidden" name="sell_invoice_id" value="{{$sellEditCart->sell_invoice_id}}">

{{-- <div class="return_product_related_response_here">
    <div class="table-responsive" style="padding-left:5px; padding-right:5px;">
        <table id="example1" class="table table-bordered  table-hover">
            <thead>
                <tr>
                    <th style="width:3%;">SL.</th>
                    <th style="width:30%;">Product</th>
                    <th style="width:5%;">Sell Unit</th>
                    <th style="width:4%;"><small>Total Qty</small></th>
                    <th style="width:60%;">
                        <div class="table-responsive" style="padding-bottom:0px; margin-bottom:-5px !important;margin-top:-5px !important;padding-top:0px;">
                            <table id="example1" class="table table-bordered table-striped table-hover" style="padding-bottom: 0px; margin-bottom: 0px;">
                                <tbody>
                                    <tr>
                                        <td style="width:20%;text-align: center">Stock Name</td>
                                        <td style="width:15%;text-align: center"><small>Sell Price</small></td>
                                        <td style="width:13%;text-align: center"><small>Sell Qty</small></td>
                                        <td style="width:23%;text-align: center">
                                            <small>Updating Qty</small>
                                        </td>
                                        <td style="width:22%;text-align: center"><small>Subtotal</small></td>
                                        <td style="width:7%; text-align: center;">
                                            <input class="check_all_class_for_return form-control" type="checkbox" value="all" name="check_all" style="box-shadow: none;" />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </th>
                    <th style="width:3%;">#</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sellEditCart->editSellCartProducts as $editSellCartProduct)
                <tr>
                    <td  style="width:3%;">{{$loop->iteration}}</td>
                    <td  style="width:30%;">
                        @php
                            $cats = json_decode($editSellCartProduct->cart,true);
                        @endphp
                        @if (array_key_exists('productName',$cats))
                            {{$cats['productName']}}
                            @else
                            NULL
                        @endif
                        <br/>
                        <b>{{productCustomCodeLabel_hh()}} : {{$editSellCartProduct->custom_code}}</b>
                    </td>
                    <td style="width:5%;text-align: center;">
                        @if (array_key_exists('unitName',$cats))
                            <small>{{$cats['unitName']}}</small>
                            @else
                            NULL
                        @endif
                    </td>
                    <td style="width:4%;text-align: center;">
                        {{number_format($editSellCartProduct->total_quantity,2,'.','')}}
                    </td>
                    <td  style="width:55%;">
                        <div class="table-responsive" style="padding-padding:0px;margin-padding:-7px !important;padding-bottom:0px;margin-bottom:-7px !important;">
                            <table id="example1" class="table table-bordered  table-hover" style="padding-bottom: 0px; margin-bottom: 0px;">
                                <tbody>
                                    @foreach ($editSellCartProduct->editSellCartProductStocks as $item)
                                    <tr>
                                        <td style="width:20%;">
                                            <small>
                                                {{ $item->stock ? $item->stock->label : NULL}}
                                            </small>
                                        </td>
                                        <td style="width:15%; text-align: center;">
                                            {{ $item->sold_price}}
                                            <input type="hidden" class="sold_price_for_return sold_price_for_return_2" value="95.00" />
                                        </td>
                                        <td style="width:13%; text-align: center;">{{ number_format($item->total_quantity,2,'.','')}}</td>
                                        <td style="width:23%; text-align: center;">
                                            <span class="quantityChange" data-change_type="minus" data-product_id="1766" data-quantity="1" style="cursor:pointer">
                                                <i class="fa fa-minus-circle"></i>
                                            </span>
                                
                                            <span id="set-1" class="total_cart_quantity">{{ number_format($item->total_quantity,2,'.','')}}</span>
                                
                                            <span class="quantityChange" data-change_type="plus" data-product_id="1766" data-quantity="1" style="cursor:pointer">
                                                <i class="fa fa-plus-circle"></i>
                                            </span>
                                            
                                            <br>
                                            <strong id="not_available_message_1" style="font-size:11px; color:red;"></strong>
                                            <!-- 
                                            <input type="text" name="returning_qty_2" value="3.000" class="form-control returning_qty returning_qty_2 inputFieldValidatedOnlyNumeric" data-id="2" />
                                            <input type="hidden" value="3.000" class="total_quantity total_quantity_2" /> -->
                                        </td>
                                        <td style="width:22%; text-align: center;">
                                            <!--<input type="text" class="line_subtotal_for_return line_subtotal_for_return_2 form-control" disabled="" />-->
                                            <span>{{ number_format($item->total_quantity *  $item->sold_price ,2,'.','')}}</span>
                                            <input type="hidden" class="selling_final_subtotal_amount_from_cartlist" value=" 88.61">
                                            <input type="hidden" class="total_purchase_price_of_all_quantity_from_cartlist" value=" 71.8">
                                        </td>
                                        <td style="width:7%; text-align: center;">
                                            <input type="hidden" value="1" name="sell_invoice_id" />
                                            <i class="fa fa-trash" style="color:#992222;"></i>
                                            <!-- <input class="check_single_class_for_return form-control check_single_class_for_return_2" type="checkbox" name="checked_id[]" value="" id="2" style="box-shadow: none;" /> -->
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </td>
                    <td style="width:3%;">
                        <i class="fa fa-trash" style="color:red;"></i>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
 --}}