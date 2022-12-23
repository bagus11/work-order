
<div class="modal fade" id="addSubmenusModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h4 class="modal-title">Add Submenus</h4>
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
                            <input type="text" class="form-control" id="submenus_name">
                            <span  style="color:red;" class="message_error text-red block submenus_name_error"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 mt-2">
                            <label for="">Menus</label>
                        </div>
                        <div class="col-md-8">
                            <select name="select_menus_id" class="select2" id="select_menus_id" style="width:100%"></select>
                            <input type="hidden" class="form-control" id="menus_id">
                            <span  style="color:red;" class="message_error text-red block menus_id_error"></span>
                        </div>
                    </div>
                  
                    <div class="form-group row">
                        <div class="col-md-3 mt-2">
                            <label for="">Link</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="submenus_link">
                            <span  style="color:red;" class="message_error text-red block submenus_link_error"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 mt-2">
                            <label for="">Description</label>
                        </div>
                        <div class="col-md-8">
                            <textarea class="form-control" id="submenus_description" rows="3"></textarea>
                            <span  style="color:red;" class="message_error text-red block submenus_description_link_error"></span>
                        </div>
                    </div>
               </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button type="button" class="btn btn-success" id="submenus_save">Save changes</button>
            </div>
        </div>
    </div>
</div>