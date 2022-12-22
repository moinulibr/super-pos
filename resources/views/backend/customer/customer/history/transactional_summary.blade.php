

    <h4 class="text-center">Transaction Summery </h4>
    <div class="table-responsive">
        <table id="example1" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>Module</th>
                    <th>Amount</th>
                    <th style="text-align:right;">Module</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>Previous Due</th>
                    <td>{{$customer->previous_total_due}}</td>
                    <th style="text-align:right;">Total Due</th>
                    <td>{{$customer->total_due}}</td>
                </tr>
                <tr>
                    <th>Total Loan</th>
                    <td>{{$customer->total_loan}}</td>
                    <th style="text-align:right;">Total Sell</th>
                    <td>{{$customer->total_sell_amount}}</td>
                </tr>
                <tr>
                    <th>Total Return</th>
                    <td>{{$customer->total_return}}</td>
                    <th style="text-align:right;">Advance</th>
                    <td>{{$customer->total_advance}}</td>
                </tr>
            </tbody>
        </table>
    </div>

