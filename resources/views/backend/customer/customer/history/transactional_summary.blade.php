

    <h4 class="text-center">Transaction Summery </h4>
    <div class="table-responsive">
        <table id="example1" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th style="background-color:rgb(114, 73, 24);width:25%;color:#ffff;">Module</th>
                    <th style="background-color:rgb(114, 73, 24);width: 15%;color:#ffff;">Amount</th>
                    <th style="text-align:right;background-color:rgb(114, 73, 24);color:#ffff;">Module</th>
                    <th style="background-color:rgb(114, 73, 24);color:#ffff;">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th style="background-color:bisque;width:25%">Previous Due</th>
                    <td style="background-color:bisque;width: 15%;">{{$customer->previous_total_due}}</td>
                    {{-- <th style="text-align:right;background-color:#cbcaca;">Total Due</th>
                    <td style="background-color:#cbcaca;">{{$customer->total_due}}</td> --}}
                    <th style="text-align:right;background-color:#cbcaca;">Total Sell</th>
                    <td style="background-color:#cbcaca;">{{$customer->total_sell_amount}}</td>
                </tr>
                <tr>
                    {{-- <th style="background-color:bisque;width:25%">Total Current Loan</th>
                    <td style="background-color:bisque;width: 15%;">{{$customer->total_loan}}</td> --}}
                    {{-- <th style="text-align:right;background-color:#cbcaca;">Total Sell</th>
                    <td style="background-color:#cbcaca;">{{$customer->total_sell_amount}}</td> --}}
                    <th></th>
                    <td></td>
                    <th style="background-color:bisque;width:25%;text-align:right;">Product Return</th>
                    <td style="background-color:bisque;width: 15%;">{{$customer->total_return}}</td>
                </tr>
                <tr>
                    {{-- <th style="background-color:bisque;width:25%">Product Return</th>
                    <td style="background-color:bisque;width: 15%;">{{$customer->total_return}}</td> --}}
                    {{-- <th style="text-align:right;background-color:#cbcaca;">Advance</th>
                    <td style="background-color:#cbcaca;">{{$customer->total_advance}}</td> --}}
                </tr>
                <tr>
                    <td colspan="3" style="text-align: right;background-color:#830303;color:yellow">
                       <small style="color:#ffff;margin-left:20px;">{{-- ((previous due + current due + loan) - (advance + return)) --}}</small>
                        Total Balance
                    </td>
                    <th colspan="2" style="text-align: left;background-color:#830303;color:yellow">
                    {{ number_format($customerTransactionalBalanceSummary ? $customerTransactionalBalanceSummary->cdc_amount : 0,2,'.','')}}
                    </th>
                </tr>
            </tbody>
        </table>
    </div>

