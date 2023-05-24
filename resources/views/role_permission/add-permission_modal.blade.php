
<div class="modal fade" id="addPermissionModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h4 class="modal-title">Add Permisson</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <div class="container">
                    <div class="form-group row">
                        <div class="col-md-3 mt-2">
                            <label for="">Option</label>
                        </div>
                        <div class="col-md-8">
                            <select name="option" class="select2" style="width:100%"  id="option">
                                <option value="view">View</option>
                                <option value="get-only_user">Only User</option>
                                <option value="get-all">Get All</option>
                                <option value="get-problem_type">Problem Tyoe</option>
                                <option value="rating-pic">Rating PIC</option>
                                <option value="activation">Activation</option>
                                <option value="rating">Rating</option>
                                <option value="priority">Priority</option>
                                <option value="manual">Manual</option>
                                <option value="create">Create</option>
                                <option value="create_detail">Create Detail</option>
                                <option value="create_subdetail">Create Sub Detail</option>
                                <option value="update_detail">Update Detail</option>
                                <option value="update_subdetail">Update Sub Detail</option>
                                <option value="update">Update</option>
                                <option value="delete">Delete</option>
                            </select>
                            <input type="hidden" class="form-control" id="permission_name">
                            <span  style="color:red;" class="message_error text-red block permission_name_error"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 mt-2">
                            <label for="">Menus</label>
                        </div>
                        <div class="col-md-8">
                            <select name="menus_name" class="menus_name select2" style="width:100%" id="menus_name">
                            </select>
                        </div>
                    </div>
                   
               </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button id="btn_save_permission" type="button" class="btn btn-success">Save changes</button>
            </div>
        </div>
    </div>
</div>