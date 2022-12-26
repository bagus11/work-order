
<div class="modal fade" id="addRoleUserModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h4 class="modal-title">Add Role</h4>
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
                            <select name="select_user" class="select2" style="width:100%" id="select_user"></select>
                            <input type="hidden" class="form-control" id="user_id">
                            <span  style="color:red;" class="message_error text-red block user_id_error"></span>
                        </div>
                    </div>
                   
                    <div class="form-group row">
                        <div class="col-md-3 mt-2">
                            <label for="">Role</label>
                        </div>
                        <div class="col-md-8">
                            <select name="select_role" class="select2" style="width:100%" id="select_role"></select>
                            <input type="hidden" class="form-control" id="role_id">
                            <span  style="color:red;" class="message_error text-red block role_id_error"></span>
                        </div>
                    </div>
               </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button id="btn_save_role_user" type="button" class="btn btn-success">Save changes</button>
            </div>
        </div>
    </div>
</div>