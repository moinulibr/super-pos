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
                    <th class="sticky-head" style="width:30%;text-align:center;background-color: #f7f7f7;">Product</th>
                    <th class="sticky-head" style="width:7%;text-align:center;background-color: #f7f7f7;">Sell <br/> Unit</th>
                    <th class="sticky-head" style="width:5%;text-align:center;background-color: #f7f7f7;">Total <br/>Qty</th>
                    <th class="sticky-head" style="width:50%;text-align:center;padding:0px !important">
                        <table class="display" style="width:100%;border:none;">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="sticky-head" style="width: 25%;text-align:center;background-color: #f7f7f7;">Stock <br/> Name</th>
                                    <th class="sticky-head" style="width: 18%;text-align:right;background-color: #f7f7f7;">Sell Price</th>
                                    <th class="sticky-head" style="width: 30%;text-align:right;background-color: #f7f7f7;">Update Qty</th>
                                    <th class="sticky-head" style="width: 22%;background-color:#f7f7f7;text-align:right;">Subtotal</th>
                                    <th class="sticky-head" style="width: 10%;background-color:#f7f7f7;text-align:right;">#</th>
                                </tr>
                            </thead>
                        </table>
                    </th>
                    <th class="sticky-head" style="width: 5%;text-align:center;background-color: #f7f7f7;"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($sellEditCart->editSellCartProducts as $editSellCartProduct)
                <tr class="" style="border-bottom: 0.05px dashed #dddfe0;">
                    <td style="width:3%;text-align:center;padding-top:1%;padding-bottom:1%;background-color: #f5f5f5">
                        {{$loop->iteration}}
                    </td>
                    <td style="width:30%;text-align:center;padding-top:1%;padding-bottom:1%;">
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
                    <td style="width:50%;text-align:center;padding-right:0px !important;padding-left:0px !important;">
                        <table class="display" style="width:100%;">
                            <thead class="thead-dark">
                                @foreach ($editSellCartProduct->editSellCartProductStocks as $item)
                                <tr>
                                    <td style="width:20%;text-align:center;padding-left: 0px !important;padding-right: 0px !important;">
                                        <small>
                                                {{ $item->stock ? $item->stock->label : NULL}}
                                        </small>
                                    </td>
                                    <td class="" style="width:18%;text-align:right;padding-left: 0px !important;padding-right: 0px !important;">
                                        {{ $item->sold_price}}
                                        <input type="hidden" class="sold_price_for_return sold_price_for_return_2" value="95.00" />
                                    </td>
                                    
                                    <td class="" style="width:30%;text-align:right;padding-left: 0px !important;padding-right: 0px !important;">
                                        <span class="quantityChange" data-change_type="minus" data-edit_sell_cart_product_stock_id="{{$item->id}}" data-quantity="1" style="cursor:pointer">
                                            <i class="fa fa-minus-circle"></i>
                                        </span>
                                        <span id="set-1" class="total_cart_quantity">{{ number_format($item->total_quantity,2,'.','')}}</span>
                                        <span class="quantityChange" data-change_type="plus" data-edit_sell_cart_product_stock_id="{{$item->id}}" data-quantity="1" style="cursor:pointer">
                                            <i class="fa fa-plus-circle"></i>
                                        </span>
                                        <br>
                                        <strong id="not_available_message_{{$item->id}}" style="font-size:11px; color:red;"></strong>
                                    </td>
                                    <td class="" style="width:22%;text-align:right;padding-left: 0px !important;padding-right: 0px !important;">
                                        <span>{{ number_format($item->total_quantity *  $item->sold_price ,2,'.','')}}</span>
                                        <input type="hidden" class="selling_final_subtotal_amount_from_cartlist" value="{{ number_format($item->total_quantity *  $item->sold_price ,2,'.','')}}">
                                        <input type="hidden" class="total_purchase_price_of_all_quantity_from_cartlist" value="{{ number_format($item->total_quantity *  $item->purchase_price ,2,'.','')}}">
                                    </td>
                                    <td  style="width: 10%;text-align:right;padding-left: 0px !important;padding-right: 0px !important;">
                                        <a href="#" data-edit_sell_cart_product_stock_id="{{$item->id}}" class="remove_this_edit_sell_cart_product_stock_item  remove_this_edit_sell_cart_product_stock_item_{{$item->id}}"><i class="fa fa-trash" style="color:#992222;"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </thead>
                        </table>
                    </td>

                    <td style="padding-top:1%;padding-bottom:1%;">
                        <div class="card-toolbar text-right">
                            <a href="#" data-edit_sell_product_id="{{$editSellCartProduct->id}}" class="remove_this_item_from_sell_cart_list remove_this_item_from_sell_cart_list_{{$editSellCartProduct->id}}" title="Delete"><i style="color: red" class="fas fa-trash-alt"></i></a>
                        </div>
                    </td>
                </tr>
                
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
<input type="hidden" class="total_item_from_cartlist" value="{{$sellEditCart->count()}}">
<input type="hidden" name="sell_invoice_id" value="{{$sellEditCart->sell_invoice_id}}">
