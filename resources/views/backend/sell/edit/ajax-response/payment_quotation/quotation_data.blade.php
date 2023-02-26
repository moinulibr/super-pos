
<div class="form-group">
    <label>Customer Name</label>
    <input type="text" value="{{$sellQuotation->quotation ?$sellQuotation->quotation->customer_name : NULL}}" name="customer_name" required placeholder="Customer Name" class="form-control">
</div>
<div class="form-group">
    <label>Customer Phone<strong style="color:red">*</strong> <small style="font-size:8px;color:red;">(Minimum 6 , Maximum 20)</small></label>
    <input type="text" value="{{$sellQuotation->quotation ?$sellQuotation->quotation->phone : NULL}}" name="phone" required min="6" placeholder="Customer Phone Number" autofocus autocomplete="off" class="customer_phone form-control">
</div>
<div class="form-group">
    <label>Quotation Number/Serial/ Others</label>
    <input type="text" value="{{$sellQuotation->quotation ?$sellQuotation->quotation->quotation_no : NULL}}" name="quotation_no" required placeholder="Quptation Number" class="form-control">
</div>
<div class="form-group">
    <label>Validate Date</label>
    <input type="date" value="{{$sellQuotation->quotation ?$sellQuotation->quotation->validate_date : NULL}}" name="validate_date" required class="form-control">
</div>
<div class="form-group">
    <label>Quotation Note</label>
    <textarea name="quotation_note" class="form-control">{{$sellQuotation->quotation ?$sellQuotation->quotation->quotation_note : NULL}}</textarea>
</div>