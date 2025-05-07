

<div class="modal fade" id="editMasterCategory">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                Add Category
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 mt-2">
                        <p>Type</p>
                    </div>
                    <div class="col-md-8">
                        <select name="select_type_edit" class="select2" id="select_type_edit"></select>
                        <input type="hidden" name="categoryId" id="categoryId">
                        <input type="hidden" name="type_id_edit" id="type_id_edit">
                    </div>
                    <div class="col-md-4 mt-2">
                        <p>Name</p>
                    </div>
                    <div class="col-md-8">
                        <input type="text" id="name_edit" class="form-control">
                        <span  style="color:red;font-size:9px" class="message_error text-red block name_edit_error"></span>
                    </div>
                    <div class="col-md-4 mt-2">
                        <p>Description</p>
                    </div>
                    <div class="col-md-8">
                        <textarea class="form-control" id="description_edit" rows="3"></textarea>
                        <span  style="color:red;font-size:9px" class="message_error text-red block description_edit_error"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button id="btn_update_category" type="button" class="btn btn-success">
                    <i class="fas fa-save"></i>
                </button>
            </div>
        </div>
    </div>
</div>