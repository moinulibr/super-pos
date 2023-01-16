<div class="table-responsive">
    <table id="example1" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th style="width:5%;">{{productCustomCodeLabel_hh()}}</th>
                <th style="width:30%;">Product</th>
                <th style="width:5%;">Quantity</th>
                <th style="width:60%;">
                    <div class="table-responsive"  style="padding-bottom: 0px;margin-bottom: -7px !important;">
                        <table id="example1" class="table table-bordered table-striped table-hover" style="padding-bottom: 0px;margin-bottom: 0px;">
                            <tr>
                                <td style="width:20%;text-align:center">Stock Name</td>
                                <td style="width:10%;text-align:center">
                                    <small>Sell Qty</small>
                                </td>
                                <td style="width:10%;text-align:center">
                                    <small>Return Qty</small>
                                </td>
                                <td  style="width:10%;text-align:center">
                                    <small>Delivered Qty</small>
                                </td>
                                <td  style="width:15%;text-align:center">
                                    <small style="font-size:10px">Remaining Del. Qty</small>
                                </td>
                                <td  style="width:25%;text-align:center">
                                    <small>Deliverying Qty</small>
                                </td>
                                <td  style="width:10%;text-align:center">
                                    <input class="check_all_class_for_delivery form-control" type="checkbox" value="all" name="check_all" style="box-shadow:none;">
                                </td>
                            </tr>
                        </table>
                    </div> 
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data->sellProducts ? $data->sellProducts : NULL  as $item)
            <tr>
                @php
                    $cats = json_decode($item->cart,true);
                @endphp
                <td style="width:5%;"> {{$item->custom_code}}</td>
                <td style="width:30%;">
                    @if (array_key_exists('productName',$cats))
                        {{$cats['productName']}}
                        @else
                        NULL
                    @endif
                </td>
                <td style="width:5%;text-align: center">
                    {{$item->total_sell_qty}}
                    {{-- @if (array_key_exists('unitName',$cats))
                        <small>{{$cats['unitName']}}</small>
                        @else
                        NULL
                    @endif --}}
                </td>
                <td style="width:60%;">
                    <div class="table-responsive" style="padding-bottom: 0px;margin-bottom: -7px !important;">
                        <table id="example1" class="table table-bordered table-hover"  style="padding-bottom: 0px;margin-bottom: 0px;">
                            @foreach ($item->sellProductStocks as $pstock)
                            <tr>
                                <td style="width:20%;text-align: center">
                                    <small>
                                        {{ $pstock->stock ? $pstock->stock->label : NULL}}
                                    </small>
                                </td>
                              
                                <td style="width:10%;text-align:center">{{$pstock->total_sell_qty}}</td>
                                <td style="width:10%;text-align:center">{{$pstock->total_refunded_qty}}</td>
                                <td style="width:10%;text-align:center">{{$pstock->total_delivered_qty}}</td>
                                <td style="width:15%;text-align:center">{{$pstock->remaining_delivery_qty}}</td>
                                <td style="width:25%;text-align:center">
                                    @php
                                        //$pstock->total_quantity, total_delivered_qty

                                        //available base stock + reduced_base stock remaining delivery (both are from product_stocks table)
                                        $totalAvailableStockWithReducedStockButNotDelivered = ($pstock->productStock ? $pstock->productStock->available_base_stock : 0) 
                                        + ($pstock->productStock ? $pstock->productStock->reduced_base_stock_remaining_delivery : 0);

                                        //total available stock = available base stock
                                        $totalAvailableStock = ($pstock->productStock ? $pstock->productStock->available_base_stock : 0);
                                        
                                        //total remaining delivery qty = remaining delivery qty (from sell_product_stocks table)
                                        $totalRemainingDeliveryQty = $pstock->remaining_delivery_qty;

                                        //deliverying qty now
                                        $deliveryingQtyNow = 0;

                                        //if total available stock with reduced stock but not delivered is more then total remaining delivery qty
                                        if(($totalAvailableStockWithReducedStockButNotDelivered > $totalRemainingDeliveryQty) && ($totalRemainingDeliveryQty > 0) ){
                                            $deliveryingQtyNow = $totalRemainingDeliveryQty; 
                                        }
                                        //if total available stock with reduced stock but not delivered is equal to total remaining delivery qty
                                        else if(($totalAvailableStockWithReducedStockButNotDelivered == $totalRemainingDeliveryQty) && ($totalRemainingDeliveryQty > 0) ){
                                            $deliveryingQtyNow = $totalRemainingDeliveryQty; 
                                        }
                                        //if total available stock with reduced stock but not delivered is less then total remaining delivery qty
                                        else if(($totalAvailableStockWithReducedStockButNotDelivered < $totalRemainingDeliveryQty)&& ($totalRemainingDeliveryQty > 0) ){
                                            $deliveryingQtyNow = $totalAvailableStockWithReducedStockButNotDelivered; 
                                        }
                                        //if total remaining delivery qty is equal to zero
                                        else if($totalRemainingDeliveryQty == 0) {
                                            $deliveryingQtyNow = 0; 
                                        }else{
                                            $deliveryingQtyNow = 0; 
                                        }
                                    @endphp
                                    @if ($deliveryingQtyNow > 0 && $totalRemainingDeliveryQty > 0)
                                        <input type="text" name="deliverying_qty_{{$pstock->id}}" value="{{$deliveryingQtyNow}}" style="width:90%;" class="form-control deliverying_qty deliverying_qty_{{$pstock->id}} inputFieldValidatedOnlyNumeric" data-id="{{$pstock->id}}">
                                        @elseif ($deliveryingQtyNow == 0 && $totalRemainingDeliveryQty == 0)
                                        <input type="text" disabled value="{{$deliveryingQtyNow}}" class="form-control" style="width:90%;background-color:green;color:#ffff;">
                                        @elseif ($deliveryingQtyNow == 0 && $totalRemainingDeliveryQty > 0)
                                        <input type="text" disabled value="{{$deliveryingQtyNow}}" class="form-control" style="width:90%;background-color:red;color:#ffff;">
                                    @endif
                                </td>
                                <td style="width:10%;text-align:center">
                                    @if ($deliveryingQtyNow > 0)
                                    <input type="hidden" value="{{$data->id}}" name="sell_invoice_id">
                                    <input class="check_single_class_for_delivery form-control check_single_class_for_delivery_{{$pstock->id}}" type="checkbox"  name="checked_id[]" value="{{ $pstock->id }}" id="{{$pstock->id}}" style="box-shadow:none;">
                                        @else
                                        <input class="form-control" type="checkbox" disabled style="box-shadow:none;" >
                                    @endif

                                    <input type="hidden" class="total_processed_qty total_processed_qty_{{$pstock->id}}" value="{{$pstock->total_stock_processed_qty}}">
                                    <input type="hidden" class="total_remaining_delivery_qty total_remaining_delivery_qty_{{$pstock->id}}" value="{{$pstock->remaining_delivery_qty}}">
                                    <input type="hidden" class="total_base_available_stock_WRBND_qty total_base_available_stock_WRBND_qty_{{$pstock->id}}" value="{{$totalAvailableStockWithReducedStockButNotDelivered}}">
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div> 
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>