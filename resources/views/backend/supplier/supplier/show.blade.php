
 <div class="modal-dialog modal-lg">
    <div class="modal-content">
    
        <div class="modal-header">
            <h5 class="modal-title">
                 Supplier 
                <span class="font-weight-light">Information</span>
                <br />
            
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
        </div>
        <div class="modal-body" style="margin-left:30px;margin-right:30px;">

            

            <div class="form-group row">
                <div class="col-sm-6">
                    <label class="col-form-label text-sm-right">Name</label>
                    <input  disabled type="text" value="{{$supplier->name}}" class="form-control" placeholder="Customer Name">
                    <strong class="name_err color-red"></strong>
                    <div class="clearfix"></div>
                </div>
                <div class="col-sm-6">
                    <label class="col-form-label text-sm-right">
                        Supplier Type
                    </label>
                    <input  disabled type="text" value="{{$supplier->supplierTypies ? $supplier->supplierTypies->name : NULL }}" class="form-control" placeholder="Customer Name">
                    
                    
                    <strong class="supplier_type_id_err color-red"></strong>
                    <div class="clearfix"></div>
                </div>
            </div>
            
          
            <div class="form-group row">
                <div class="col-sm-6">
                    <label class="col-form-label text-sm-right">Phone</label>
                    <input disabled  value="{{$supplier->phone}}" type="text" class="form-control" placeholder="Phone">
                    <strong class="phone_err color-red"></strong>
                    <div class="clearfix"></div>
                </div>
                <div class="col-sm-6">
                    <label class="col-form-label text-sm-right">Email (optional)</label>
                    <input disabled  value="{{$supplier->email}}" type="email" class="form-control" placeholder="Email">
                    <strong class="email_err color-red"></strong>
                    <div class="clearfix"></div>
                </div>
            </div>
            
            
            <div class="form-group row">
                <div class="col-sm-6">
                    <label class="col-form-label text-sm-right">Contract Person Name</label>
                    <input disabled value="{{$supplier->contract_person_name}}" type="text" class="form-control" placeholder="Contract Person Name">
                    <strong class="contract_person_name_err color-red"></strong>
                    <div class="clearfix"></div>
                </div>
                <div class="col-sm-6">
                    <label class="col-form-label text-sm-right">Contract Person Phone</label>
                    <input disabled  value="{{$supplier->contract_person_phone}}" type="text" class="form-control" placeholder="Contract Person Phone">
                    <strong class="contract_person_phone_err color-red"></strong>
                    <div class="clearfix"></div>
                </div>
            </div>


            <div class="form-group row">
                <div class="col-sm-6">
                    <label class="col-form-label text-sm-right">Contract Person Designation</label>
                    <input disabled  value="{{$supplier->contract_person_designation}}" type="text" class="form-control" placeholder="Contract Person Designation">
                    <strong class="contract_person_designation_err color-red"></strong>
                    <div class="clearfix"></div>
                </div>
                <div class="col-sm-6">
                    <label class="col-form-label text-sm-right">Opening/Previous Due</label>
                    <input disabled  type="number" step="any" value="0" class="form-control" placeholder="Previous Due">
                    <strong class="previous_due_err color-red"></strong>
                    <div class="clearfix"></div>
                </div>
            </div>

            
            <div class="form-group row">
                <div class="col-sm-6">
                    <label class="col-form-label text-sm-right">Address</label>
                    <textarea disabled class="form-control" placeholder="Address">{{$supplier->address}}</textarea>
                    <strong class="address_err color-red"></strong>
                    <div class="clearfix"></div>
                </div>
                <div class="col-sm-6">
                    <label class="col-form-label text-sm-right">Note</label>
                    <textarea disabled  class="form-control" placeholder="Note">{{$supplier->note}}</textarea>
                    <strong class="note_err color-red"></strong>
                    <div class="clearfix"></div>
                </div>
            </div>
            
            <div class="form-group row">
                <div class="col-sm-6">
                    <label class="col-form-label text-sm-right">{{productCustomCodeLabel_hh()}}</label>
                    <input disabled  value="{{$supplier->custom_id}}" type="text" class="form-control" placeholder="{{productCustomCodeLabel_hh()}}">
                    <strong class="custom_id_err color-red"></strong>
                    <div class="clearfix"></div>
                </div>
            </div>
            

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
