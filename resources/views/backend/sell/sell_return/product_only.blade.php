<div class="table-responsive">
    <table id="example1" class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
                <th style="width:5%;">{{productCustomCodeLabel_hh()}}</th>
                <th style="width:30%;">Product</th>
                <th style="width:5%;"><small>Total Sell Qty</small></th>
                <th style="width:60%;">
                    <div class="table-responsive"  style="padding-bottom: 0px;margin-bottom: -7px !important;">
                        <table id="example1" class="table table-bordered table-striped table-hover" style="padding-bottom: 0px;margin-bottom: 0px;">
                            <tr>
                                <td style="width:16%;">Stock Name</td>
                                <td style="width:12%;">Sell Unit</td>
                                <td style="width:12%;" >Sell Price</td>
                                <td style="width:10%;" >Sell Qty</td>
                                <td style="width:11%;">
                                    <small style="font-size:10px;">Returned Qty</small>
                                </td>
                                <td style="width:16%;">
                                    <small >Returning Qty</small>
                                </td>
                                <td style="width:16%;" ><small>Return Subtotal</small></td>
                                <td style="width:7%;text-align: center">
                                    <input class="check_all_class_for_return form-control" type="checkbox" value="all" name="check_all" style="box-shadow:none;">
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
                <td> {{$item->custom_code}}</td>
                <td>
                    @if (array_key_exists('productName',$cats))
                        {{$cats['productName']}}
                        @else
                        NULL
                    @endif
                </td>
                <td style="text-align: center">
                    <span style="color:green;">{{$item->total_quantity}} </span>
                    <br/> 
                    <del style="color:red">{{$item->total_refunded_qty}} </del> 
                    <br/>
                    {{$item->total_sell_qty}} 
                </td>
                <td>
                    <div class="table-responsive" style="padding-bottom: 0px;margin-bottom: -7px !important;">
                        <table id="example1" class="table table-bordered table-striped table-hover"  style="padding-bottom: 0px;margin-bottom: 0px;">
                            @foreach ($item->sellProductStocks as $spstock)
                            <tr>
                                <td style="width:16%;">
                                    <small>
                                        {{ $spstock->stock ? $spstock->stock->label : NULL}}
                                    </small>
                                </td>
                                <td style="width:12%">
                                    @if (array_key_exists('unitName',$cats))
                                        <small>{{$cats['unitName']}}</small>
                                        @else
                                        NULL
                                    @endif
                                </td>
                                <td style="width:12%;text-align: center">
                                    {{$spstock->sold_price}}
                                    <input type="hidden" class="sold_price_for_return sold_price_for_return_{{$spstock->id}}" value="{{$spstock->sold_price}}">
                                </td>
                                <td style="width:10%;text-align:center">{{$spstock->total_sell_qty}}</td>
                                <td style="width:11%;text-align:center;">
                                    {{$spstock->total_refunded_qty}}
                                </td>
                                <td style="width:16%;text-align: center">
                                    @php
                                        if($spstock->total_quantity > 0) 
                                        {
                                            $returningQtyNow = $spstock->total_quantity; 
                                        }
                                        else{
                                            $returningQtyNow = 0; 
                                        }
                                    @endphp
                                    @if ($returningQtyNow > 0)
                                        <input type="text" name="returning_qty_{{$spstock->id}}" value="{{$returningQtyNow}}" class="form-control returning_qty returning_qty_{{$spstock->id}} inputFieldValidatedOnlyNumeric" data-id="{{$spstock->id}}">
                                        @elseif ($returningQtyNow == 0)
                                        <input type="text" disabled value="{{$returningQtyNow}}" class="form-control" style="background-color: red;color:#ffff;">
                                    @endif
                                    <input type="hidden" value="{{$spstock->total_quantity}}" class="total_quantity total_quantity_{{$spstock->id}}">
                                </td>
                                <td style="width:16%;text-align: center">
                                    <input type="text" class="line_subtotal_for_return line_subtotal_for_return_{{$spstock->id}} form-control" disabled>
                                </td>
                                <td style="width:7%;text-align: center">
                                    @if ($returningQtyNow > 0)
                                    <input type="hidden" value="{{$data->id}}" name="sell_invoice_id">
                                    <input class="check_single_class_for_return form-control check_single_class_for_return_{{$spstock->id}}" type="checkbox"  name="checked_id[]" value="{{ $spstock->id }}" id="{{$spstock->id}}" style="box-shadow:none;">
                                        @else
                                        <input class="form-control" type="checkbox" disabled style="box-shadow:none;" >
                                    @endif
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
