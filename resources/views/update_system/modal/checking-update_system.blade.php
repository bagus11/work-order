<div class="modal fade" id="finalizeERPModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <!-- Header -->
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">Finalize Ticket</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Body -->
            <div class="modal-body">
                <input type="hidden" id="check_ticket_code">
                <fieldset class="mx-2">
                    <legend>General Information About Ticket</legend>
                      <div class="row mb-2">
                    <div class="col-2 mt-2">
                        <p class="form-label">Subject</p>
                    </div>
                    <div class="col-4 mb-2">
                        <input type="text" class="form-control" id="check_subject" readonly>
                    </div>
                </div>

                <div class="row">
                    <div class="col-2 mb-2">
                        <p class="form-label">Created At</p>
                    </div>
                    <div class="col-4 mb-2">
                        <input type="text" class="form-control" id="check_created_at" readonly>
                    </div>
                    <div class="col-md-2 mt-2">
                        <p class="form-label">Created By</p>
                    </div>
                    <div class="col-4 mb-2">
                        <input type="text" class="form-control" id="check_created_by" readonly>
                    </div>
                </div>

                <div class="row">
                    <div class="col-2">
                        <p class="form-label">Additional Info</p>
                    </div>
                    <div class="col-10">
                        <textarea class="form-control" id="check_add_info" rows="2" readonly></textarea>
                    </div>
                </div>
                </fieldset>

                <fieldset class="mx-2">
                    <legend>Detail Task</legend>
                    <div id="detail_ticket_container_check"></div>
                </fieldset>

                <fieldset class="mx-2">
                    <legend>Result</legend>
                    <div class="row">
                        <div class="col-2 mt-2">
                            <p>Result</p>
                        </div>
                        <div class="col-4 mb-2">
                            <select name="erp_select_result" class="select2" id="erp_select_result">
                                <option value="">Choose Result</option>
                                <option value="1">Match</option>
                                <option value="2">Doesn't Match</option>
                            </select>
                            <input type="hidden" id="erp_result">
                            <span class="message_error erp_result_error"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2 mt-2">
                            <p>Remark</p>
                        </div>
                        <div class="col-10">
                            <textarea name="erp_remark_result" class="form-control" id="erp_remark_result" rows="5"></textarea>
                            <span class="message_error erp_remark_result_error"></span>
                        </div>
                    </div>
                </fieldset>
            </div>

            <!-- Footer -->
            <div class="modal-footer justify-content-end p-2">
                <button id="btn_erp_finish" type="button" class="btn btn-sm btn-success">
                    <i class="fas fa-check"></i> Submit Check
                </button>
            </div>
        </div>
    </div>
</div>
