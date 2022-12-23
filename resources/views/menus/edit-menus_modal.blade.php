
<div class="modal fade" id="editMenusModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h4 class="modal-title">Edit Menus</h4>
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
                            <input type="hidden" class="form-control" id="id_menus_update">
                            <input type="text" class="form-control" id="menus_name_update">
                            <span  style="color:red;" class="message_error text-red block menus_name_update_error"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 mt-2">
                            <label for="">Icon</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="menus_icon_update">
                            <span  style="color:red;" class="message_error text-red block menus_icon_update_error"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 mt-2">
                            <label for="">Status</label>
                        </div>
                        <div class="col-md-8">
                            <input type="checkbox" style="border-radius: 5px !important;" class="menus_status_update" id="menus_status_update" name="menus_status_update">
                                        <label for="cc" id="label_menus_status" style="margin-top:10px">
                                            Active                  
                                        </label>
                            <input type="hidden" class="form-control" id="status_menus_update">
                            <span  style="color:red;" class="message_error text-red block menus_type_error"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 mt-2">
                            <label for="">Link</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="menus_link_update">
                            <span  style="color:red;" class="message_error text-red block menus_link_update_error"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 mt-2">
                            <label for="">Description</label>
                        </div>
                        <div class="col-md-8">
                            <textarea class="form-control" id="menus_description_update" rows="3"></textarea>
                            <span  style="color:red;" class="message_error text-red block menus_description_update_error"></span>
                        </div>
                    </div>
               </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button id="btn_menus_update" type="button" class="btn btn-success">Save changes</button>
            </div>
        </div>
    </div>
</div>