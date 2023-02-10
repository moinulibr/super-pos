<div class="table-responsive table-responsive-index-page">
    <table class="table table-bordered mb-0">
        <thead>
            <tr>
                <th  style="width:3%;">#</th>
                <th>Photo</th>
                <th>
                    <small>{{productCustomCodeLabel_hh()}}</small>
                </th>
                <th>Name</th>
                <th>Total Stock</th>
                <th><small style="font-size:10px;">Ready For Delivery</small></th>
                @foreach ($stocks as $stock)
                    <th>
                        {{$stock->label}}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($datas as $index => $item)
                <tr>
                    <th scope="row">
                        {{$index + 1}}
                    </th>
                    <td style="width:5%;">
                        <span style="cursor:pointer;" class="singleShowModal" data-id="{{$item->id}}" href="javascript:void(0)">
                            @if($item->photo)
                                <img src="{{ asset(productImageViewLocation_hh().$item->id.".".$item->photo) }}" alt="" width="40" height="40" style="padding:2px;border:1px solid #c7bbbb;background-color:#fbf8f8;border-radius:4px">
                                @else
                                <img src="{{ asset(defaultProductImageUrl_hh()) }}" alt="" width="40" height="40" style="padding:2px;border:1px solid #c7bbbb;background-color:#fbf8f8;border-radius:4px">
                            @endif
                        </span>
                    </td>
                    <td style="width:5%;">
                        <small>
                            {{ $item->custom_code }}
                        </small>
                    </td>
                    <td>
                        @php
                            $product = $item->name;
                            if(strlen($item->name) > 30)
                            {
                                $len = substr($item->name,0,30);
                                if(str_word_count($len) > 1)
                                {
                                    $product = implode(" ",(explode(' ',$len,-1)));
                                }else{
                                    $product = $len;
                                }
                                $product = $product ."...";
                            }
                        @endphp
                        <span style="cursor:pointer;" class="singleProductStockHistoryShowModal" data-id="{{$item->id}}">
                        {{$product}}
                        </span>
                    </td> 
                    <td style="background-color: #ebebeb;text-align: center;">
                        <span style="cursor:pointer;" class="singleProductStockHistoryShowModal" data-id="{{$item->id}}">
                        {{ $item->total_product_stock_with_remaining_delivery }}
                        </span>
                    </td>
                    <td style="background-color: #ebebeb;text-align: center;">
                        {{ $item->total_product_stock_ready_for_delivery }}
                    </td>
                    @foreach ($item->productStockNORWhereStatusIsActive() as $productStock)
                    <td style="text-align: center;">
                        {{ number_format($productStock->available_base_stock + $productStock->reduced_base_stock_remaining_delivery,2,'.', '') }}
                    </td>
                @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

</div>
<input type="hidden" class="page_no" name="page" value="{{$page_no}}">
                    
<div class="row">
    <div class="col-md-3">
        Showing {{$datas->count()}} from {{ $datas->firstItem() ?? 0 }} to {{ $datas->lastItem() }} of {{ $datas->total() }}  entries 
    </div>
    <div class="col-md-9">
        <div style="float: right">
        {{ $datas->links() }}
        </div>
    </div>
</div>