<div class="modal fade" id="updateServiceModal">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-core">
                <span>Form Update Service Asset</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_update_service" enctype="multipart/form-data">
            <div class="modal-body mx-2">
                <fieldset>
                    <legend>Detail Information About Update Service Asset</legend>
                    <div class="row">
                        <div class="col-2">
                            <p>Asset Code</p>
                        </div>
                        <div class="col-4">
                            <p id="update_service_asset_code"></p>
                        </div>
                        <div class="col-2">
                            <p>Service Code</p>
                        </div>
                        <div class="col-4">
                            <p id="update_service_code"></p>
                        </div>
                        <div class="col-2 mt-2">
                            <p>Progress</p>
                        </div>
                        <div class="col-4">
                            <select name="select_service_progress" class="select2" id="select_service_progress">
                                <option value="">Choose Progress</option>
                                <option value="1">In Progress</option>
                                <option value="2">Pending</option>
                                <option value="3">Done</option>
                            </select>
                            <input type="hidden" id="update_service_progress_id" name="update_service_progress_id">
                            <span class="message_error update_service_progress_id_error"></span>
                        </div>
                        <div class="col-2 mt-2">
                            <p>Condition</p>
                        </div>
                        <div class="col-4">
                            <select name="select_service_condition" class="select2" id="select_service_condition">
                                <option value="">Choose Condition</option>
                                <option value="1">Good</option>
                                <option value="2">Partially Good</option>
                                <option value="3">Broken</option>
                            </select>
                            <input type="hidden" id="update_service_condition_id" name="update_service_condition_id">
                            <span class="message_error update_service_condition_id_error"></span>
                        </div>
                        <div class="col-2 mt-2">
                            <p>Attachment</p>
                        </div>
                        <div class="col-4">
                            <input type="file" name="update_service_attachment" id="update_service_attachment" class="form-control">
                            <span class="message_error update_service_attachment_error"></span>
                        </div>
                    </div>
                    <div class="row">
                         <div class="col-2 mt-2">
                            <p>Additional Info</p>
                        </div>
                        <div class="col-10">
                            <textarea name="update_service_description" id="update_service_description" class="form-control" rows="10"></textarea>
                            <span class="message_error update_service_description_error"></span>
                        </div>
                    </div>
                    <div class="row justify-content-end my-2 mx-1">
                          <button type="submit" class="btn btn-sm btn-success" id="btn_save_update_service" type="button">
                            <i class="fas fa-check"></i>
                        </button>
                    </div>
                </fieldset>
            </div>
            </form>
        </div>
    </div>
</div>
