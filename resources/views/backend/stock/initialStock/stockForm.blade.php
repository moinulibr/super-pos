<div class="table-responsive table-responsive-index-page">
    <table class="table table-bordered mb-0">
        <thead>
            <tr>
                <th>Stock Name</th>
                @foreach ($stocks as $item)
                    <th>{{$item->label}}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            <tr>
                <th>Stock Quantity</th>
                @foreach ($stocks as $item)
                    <td>
                        <input  class="from-control inputFieldValidatedOnlyNumeric" name="" type="text" step="any" style="width:95%;">
                    </td>
                @endforeach
            </tr>
            <tr>
                <th>Alert Quantity</th>
                @foreach ($stocks as $item)
                    <td>
                        <input  class="from-control inputFieldValidatedOnlyNumeric" name="" type="text" step="any" style="width:95%;">
                    </td>
                @endforeach
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="{{count($stocks)}}"></td>
                <td>
                    <button type="button" class="btn btn-danger cancelInsertStock">Cancel</button>
                    <input type="submit" class="btn btn-primary" disabled value="Add Inital Stock">
                </td>
            </tr>
        </tfoot>
    </table>
</div>
