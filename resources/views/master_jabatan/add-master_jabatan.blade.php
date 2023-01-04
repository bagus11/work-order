
<div class="modal fade" id="addJabatan">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h4 class="modal-title">Add Jabatan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <div class="container">
                    <div class="form-group row">
                        <div class="col-md-3 mt-2">
                            <label for="">Departement</label>
                        </div>
                        <div class="col-md-8">
                            <select name="select_departement" class="select2" style="width:100%" id="select_departement"></select>
                            <input type="hidden" class="form-control" id="departement_id">
                            <span  style="color:red;" class="message_error text-red block departement_id_error"></span>
                        </div>
                    </div> 
                    <div class="form-group row">
                        <div class="col-md-3 mt-2">
                            <label for="">Name</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="jabatan_name">
                            <span  style="color:red;" class="message_error text-red block jabatan_name_error"></span>
                        </div>
                    </div> 
               </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button id="btn_save_jabatan" type="button" class="btn btn-success">Save changes</button>
            </div>
        </div>
    </div>
</div>