
<div class="modal fade" id="updatePassModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h4 class="modal-title">Change Password</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <div class="container">
                    <div class="form-group row">
                        <div class="col-md-4 mt-2">
                            <label for="">Current Password</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="current_password">
                            <span  style="color:red;" class="message_error text-red block current_password_error"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4 mt-2">
                            <label for="">New Password</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="new_password">
                            <span  style="color:red;" class="message_error text-red block new_password_error"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4 mt-2">
                            <label for="">Confirm Password</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="confirm_password">
                            <span  style="color:red;" class="message_error text-red block confirm_password_error"></span>
                        </div>
                    </div>
                   
               </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button id="save_change_password" type="button" class="btn btn-success">Save changes</button>
            </div>
        </div>
    </div>
</div>