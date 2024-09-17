<div class="modal fade" id="addCategoryModal">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-core">
                Add Category
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
        
                <div class="modal-body p-0">
                    <div class="row my-2 mx-2">
                        <div class="col-3 mt-2">
                            <p>Name</p>
                        </div>
                        <div class="col-9">
                            <input type="text" class="form-control" id="name">
                            <span  style="color:red;font-size:9px" class="message_error text-red block name_error"></span>
                        </div>
                        <div class="col-3 mt-2">
                            <p>Type</p>
                        </div>
                        <div class="col-9">
                            <select name="select_type" class="select2" id="select_type">
                                <option value="">Choose Type</option>
                                <option value="1">Single</option>
                                <option value="2">Derivative</option>
                            </select>
                            <input type="hidden" class="form-control" id="type">
                            <span  style="color:red;font-size:9px" class="message_error text-red block type_error"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-end p-0 mx-2">
                    <button id="btn_save_category" type="submit" class="btn btn-sm btn-success">
                        <i class="fa-solid fa-check"></i>
                    </button>
                </div>
        </div>
    </div>
</div>

