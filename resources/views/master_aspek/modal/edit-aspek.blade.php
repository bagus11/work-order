<div class="modal fade" id="editSystemModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h4 class="modal-title">Edit Data Type</h4>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body mx-2 my-2">
                 
                    <!-- Name -->
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label mt-2">Name</label>
                        <div class="col-md-9">
                            <input type="hidden" class="form-control" id="id">
                            <input type="text" class="form-control" id="edit_name">
                            <span class="message_error text-danger edit_name_error"></span>
                        </div>
                    </div>

            </div>

            <div class="modal-footer justify-content-end">
                <button id="btn_update_system" type="button" class="btn btn-success">
                    <i class="fas fa-check"></i> Save
                </button>
            </div>
        </div>
    </div>
</div>
