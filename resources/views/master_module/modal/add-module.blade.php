<div class="modal fade" id="addModuleModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h4 class="modal-title">Add Module</h4>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body mx-2 my-2">

                    <!-- System -->
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Aspek</label>
                        <div class="col-md-9">
                            <select name="select_aspek" class="select2" id="select_aspek"></select>
                            <input type="hidden" class="form-control" id="aspek_id">
                            <span class="message_error text-danger module_id_error"></span>
                        </div>
                    </div>


                    <!-- Name -->
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Name</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="name">
                            <span class="message_error text-danger name_error"></span>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Description</label>
                        <div class="col-md-9">
                            <textarea name="description" class="form-control" id="description" rows="4"></textarea>
                            <span class="message_error text-danger description_error"></span>
                        </div>
                    </div>
            </div>

            <div class="modal-footer justify-content-end">
                <button id="btn_save_module" type="button" class="btn btn-success">
                    <i class="fas fa-check"></i> Save
                </button>
            </div>
        </div>
    </div>
</div>
