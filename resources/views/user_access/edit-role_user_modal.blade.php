
<div class="modal fade" id="editRolesUserModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h4 class="modal-title">Edit Role</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <div class="container">
                    <div class="form-group row">
                        <div class="col-md-3 mt-2">
                            <label for="">User</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" readonly class="form-control" id="user_name">
                            <input type="hidden" class="form-control" id="user_id_update">
                            <span  style="color:red;" class="message_error text-red block user_id_update_error"></span>
                        </div>
                    </div>
                   
                    <div class="form-group row">
                        <div class="col-md-3 mt-2">
                            <label for="">Role</label>
                        </div>
                        <div class="col-md-8">
                            <select name="select_role_update" class="select2" style="width:100%" id="select_role_update"></select>
                            <input type="hidden" class="form-control" id="role_id_update">
                            <span  style="color:red;" class="message_error text-red block role_id_update_error"></span>
                        </div>
                    </div>
               </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button id="btn_update_role_user" type="button" class="btn btn-success">Save changes</button>
            </div>
        </div>
    </div>
</div>