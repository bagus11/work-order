

<div class="modal fade" id="editMasterBrandModal">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-core">
                Edit Brand
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 mt-2">
                        <p>Name</p>
                    </div>
                    <div class="col-md-8">
                        <input type="hidden" id="brandId" class="form-control">
                        <input type="text" id="name_edit" class="form-control">
                        <span  style="color:red;font-size:9px" class="message_error text-red block name_edit_error"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button id="btn_update_brand" type="button" class="btn btn-success">
                    <i class="fas fa-save"></i>
                </button>
            </div>
        </div>
    </div>
</div>