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
                  <div class="form-group row">
                        <label class="col-md-3 col-form-label mt-2">Aspek</label>
                        <div class="col-md-9">
                            <select name="edit_select_module" class="select2" id="edit_select_module">
                                <option value="">Choose module</option>
                                <option value="1">Configuration</option>
                                <option value="2">Master Data</option>
                            </select>
                            <input type="hidden" class="form-control" id="edit_module">
                            <span class="message_error text-danger edit_module_error"></span>
                        </div>
                    </div>
                    <!-- Name -->
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label mt-2">Name</label>
                        <div class="col-md-9">
                            <input type="hidden" class="form-control" id="id">
                            <input type="text" class="form-control" id="edit_name">
                            <span class="message_error text-danger edit_name_error"></span>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label mt-2">Description</label>
                        <div class="col-md-9">
                            <textarea name="description" class="form-control" id="edit_description" rows="4"></textarea>
                            <span class="message_error text-danger edit_description_error"></span>
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
