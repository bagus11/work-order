
<div class="modal fade" id="editUser">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h4 class="modal-title">Edit User</h4>
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
                            <input type="hidden" class="form-control" id="user_id">
                            <input type="text" class="form-control" id="user_name">
                            <span  style="color:red;" class="message_error text-red block user_name_error"></span>
                        </div>
                    </div> 
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
                            <label for="">Jabatan</label>
                        </div>
                        <div class="col-md-8">
                            <select name="select_jabatan" class="select2" style="width:100%" id="select_jabatan"></select>
                            <input type="hidden" class="form-control" id="jabatan_id">
                            <span  style="color:red;" class="message_error text-red block jabatan_id_error"></span>
                        </div>
                    </div> 
                    <div class="form-group row">
                        <div class="col-md-3 mt-2">
                            <label for="">Kantor</label>
                        </div>
                        <div class="col-md-8">
                            <select name="select_kantor" class="select2" style="width:100%" id="select_kantor"></select>
                            <input type="hidden" class="form-control" id="kode_kantor">
                            <span  style="color:red;" class="message_error text-red block kode_kantor_error"></span>
                        </div>
                    </div> 
                  
               </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button id="btn_update_user" type="button" class="btn btn-success">Save changes</button>
            </div>
        </div>
    </div>
</div>