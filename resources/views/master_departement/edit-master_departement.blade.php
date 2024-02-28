
<div class="modal fade" id="editDepartement">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h4 class="modal-title">Edit Departement</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <div class="container">
                    <div class="form-group row">
                        <div class="col-md-3 mt-2">
                            <label for="">Name</label>
                        </div>
                        <div class="col-md-8">
                            <input type="hidden" class="form-control" id="departement_id">
                            <input type="text" class="form-control" id="departement_name_update">
                            <span  style="color:red;" class="message_error text-red block departement_name_update_error"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 mt-2">
                            <label for="">Initial</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="initial_name_update">
                            <span  style="color:red;" class="message_error text-red block initial_name_update_error"></span>
                        </div>
                    </div>
                   
               </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button id="btn_update_departement" type="button" class="btn btn-success">Save changes</button>
            </div>
        </div>
    </div>
</div>