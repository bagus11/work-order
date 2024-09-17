
<div class="modal fade" id="editSubmenusModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h4 class="modal-title">Edit Submenus</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <div class="container">
                    <div class="form-group row">
                        <div class="col-md-3 mt-2">
                            <p for="">Name</p>
                        </div>
                        <div class="col-md-8">
                            <input type="hidden" class="form-control" id="id_submenus_update">
                            <input type="text" class="form-control" id="submenus_name_update">
                            <span  style="color:red;" class="message_error text-red block submenus_name_update_error"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 mt-2">
                            <p for="">Derivative</p>
                        </div>
                        <div class="col-md-8">
                            <select name="select_submenus" class="select_submenus select2" id="select_submenus" style="width: 100%"></select>
                            <input type="hidden" class="form-control" id="derivative_update">
                            <span  style="color:red;" class="message_error text-red block derivative_update_error"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 mt-2">
                            <p for="">Status</p>
                        </div>
                        <div class="col-md-8">
                            <input type="checkbox" style="border-radius: 5px !important;" class="submenus_status_update" id="submenus_status_update" name="submenus_status_update">
                                        <p for="cc" id="label_submenus_status" style="margin-top:10px">
                                            Active                  
                                        </p>
                            <input type="hidden" class="form-control" id="status_submenus_update">
                            <span  style="color:red;" class="message_error text-red block menus_type_error"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 mt-2">
                            <p for="">Link</p>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="submenus_link_update" readonly>
                            <span  style="color:red;" class="message_error text-red block submenus_link_update_error"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 mt-2">
                            <p for="">Description</p>
                        </div>
                        <div class="col-md-8">
                            <textarea class="form-control" id="submenus_description_update" rows="3"></textarea>
                            <span  style="color:red;" class="message_error text-red block submenus_description_update_error"></span>
                        </div>
                    </div>
               </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button id="btn_submenus_update" type="button" class="btn btn-success">Save changes</button>
            </div>
        </div>
    </div>
</div>