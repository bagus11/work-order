
<div class="modal fade" id="modal-danger">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h4 class="modal-title">Add Menus</h4>
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
                            <input type="text" class="form-control" id="menus_name">
                            <span  style="color:red;" class="message_error text-red block menus_name_error"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 mt-2">
                            <p for="">Icon</p>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="menus_icon">
                            <span  style="color:red;" class="message_error text-red block menus_icon_error"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 mt-2">
                            <p for="">Tipe</p>
                        </div>
                        <div class="col-md-8">
                            <select name="" id="select_menus_type" class="form-control">
                                <option value="">Pilih Tipe</option>
                                <option value="1">Menus</option>
                                <option value="2">Submenus</option>
                            </select>
                            <input type="hidden" class="form-control" id="menus_type">
                            <span  style="color:red;" class="message_error text-red block menus_type_error"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 mt-2">
                            <p for="">Link</p>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="menus_link">
                            <span  style="color:red;" class="message_error text-red block menus_link_error"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 mt-2">
                            <p for="">Description</p>
                        </div>
                        <div class="col-md-8">
                            <textarea class="form-control" id="menus_description" rows="3"></textarea>
                            <span  style="color:red;" class="message_error text-red block menus_description_error"></span>
                        </div>
                    </div>
               </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button id="btn_save_menus" type="button" class="btn btn-success">Save changes</button>
            </div>
        </div>
    </div>
</div>