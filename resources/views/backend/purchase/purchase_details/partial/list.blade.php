<div class="table-responsive table-responsive-index-page">
    <table class="table table-bordered mb-0">
        <thead>
            <tr>
                <th  style="width:3%;">#</th>
                <th style="width:5%;">Action</th>
                <th style="width:;">Invoice No</th>
                <th style="width:;">Reference No</th>
                <th style="width:;">Chalan No</th>
                <th style="width:;">Date(Time) </th>
                <th style="width:;">Supplier </th>
                <th style="width:;">G.Total </th>
                <th style="width:;">Less Amount </th>
                <th style="width:;">Payment Status </th>
                <th style="width:;">Paid Amount </th>
                <th style="width:;">Due Amount </th>
                <th style="width:;">Created By </th>
                <th style="width:;">Total Item </th>
                {{-- <th style="width:;"><small>Product Receiving Status</small></th> --}}
            </tr>
        </thead>
        <tbody>
            @foreach ($datas as $index => $item)
                <tr>
                    <th scope="row">
                        {{$index + 1}}
                    </th>
                    
                    <td style="width:3%;">
                        <div class="btn-group btnGroupForMoreAction">
                            <button type="button" class="btn btn-sm btn-info" data-toggle="dropdown" aria-expanded="true">
                                <i class="fas fa-cog"></i>
                                <!--<i class="fas fa-ellipsis-v"></i>-->
                            </button>
                            <div class="dropdown-menu " x-placement="top-start" style="position: absolute; will-change: top, left; top: -183px; left: 0px;background-color: #f0f4f5;">
                                <a class="dropdown-item singlePurchaseView" data-id="{{$item->id}}" style="cursor: pointer">View</a>
                                <a class="dropdown-item print" target="_blank" data-id="{{$item->id}}" href="{{route('admin.purchase.regular.normal.print.from.purchase.list',$item->id)}}" style="cursor: pointer">Print</a>
                                {{-- <a class="dropdown-item print"  target="_blank" data-id="{{$item->id}}" href="{{route('admin.purchase.regular.pos.print.from.purchase.list',$item->id)}}" style="cursor: pointer">Print (POS)</a> --}}
                                <a class="dropdown-item singlePurchaseInvoiceWiseReceiveProduct" data-id="{{$item->id}}" style="cursor: pointer">Receive Product</a>
                                <a class="dropdown-item singleViewPurchaseInvoiceWiseMakePaymentModal" data-id="{{$item->id}}" style="cursor: pointer">Make Payment</a>
                                <a class="dropdown-item singleViewPurchaseInvoiceWisePaymentModal" data-id="{{$item->id}}" style="cursor: pointer">View Payment</a>
                                {{-- <a class="dropdown-item singleEditModal" data-id="{{$item->id}}" href="javascript:void(0)">Edit</a>
                                <a class="dropdown-item singleDeleteModal" data-id="{{$item->id}}" data-name="{{$item->name}}" href="javascript:void(0)">Delete</a> --}}
                                {{-- <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="javascript:void(0)">Separated link</a>--}}
                            </div> 
                        </div>
                    </td>
                    <td> 
                        <a  class="singlePurchaseView" data-id="{{$item->id}}" style="cursor: pointer">
                            {{$item->invoice_no}} 
                        </a>
                    </td> 
                    <td> 
                        <a  class="singlePurchaseView" data-id="{{$item->id}}" style="cursor: pointer">
                            {{$item->reference_no}} 
                        </a>
                    </td>
                    <td> 
                        <a  class="singlePurchaseView" data-id="{{$item->id}}" style="cursor: pointer">
                            {{$item->chalan_no}} 
                        </a>
                    </td>
                    <td>
                        <a  class="singlePurchaseView" data-id="{{$item->id}}" style="cursor: pointer">
                            {{date('d-m-Y h:i:s A',strtotime($item->created_at))}}
                        </a>
                    </td>
                    <td>{{$item->supplier ? $item->supplier->name : NULL}}</td>
                    <td>{{$item->total_payable_amount}}</td>
                    <td>{{$item->total_discount}}</td>
                    <td>
                        {{-- {{paymentStatus_hp($item->sell_type,$item->payment_status)}} --}}
                        {{paymentStatus_hh($item->total_payable_amount,$item->total_paid_amount)}}
                    </td>
                    <td>{{$item->total_paid_amount}}</td>
                    <td>{{$item->due_amount}}</td>
                    <td>{{$item->createdBy ? $item->createdBy->name : NULL}}</td>
                    <td>{{$item->total_item}}</td>
                    {{-- <td>{{$item->delivery_status}}</td> --}}
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