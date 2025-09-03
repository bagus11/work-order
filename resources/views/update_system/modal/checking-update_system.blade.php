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
                      <ul class="nav nav-tabs border-0" id="ticketTabCheck" role="tablist" style="gap:6px;">
                        <li class="nav-item">
                            <a class="nav-link active px-4 rounded-pill shadow-sm" style="font-size:12px;"
                                id="task-tab-check"
                                data-toggle="tab"
                                href="#task-check"
                                role="tab"
                                aria-controls="task"
                                aria-selected="true">
                                <i class="fas fa-tasks me-1"></i> Task
                            </a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link px-4 rounded-pill shadow-sm" style="font-size:12px;"
                            id="log-tab-check"
                            data-toggle="tab"
                            href="#log-task-check"
                            role="tab"
                            aria-controls="log-task"
                            aria-selected="false">
                            <i class="fas fa-history me-1"></i> Log Task
                        </a>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content mt-3 p-3 rounded-3 shadow-sm bg-light" id="ticketTabCheckContent">
                        <!-- Task -->
                        <div class="tab-pane fade show active" id="task-check" role="tabpanel" aria-labelledby="task-tab-check">
                        <div id="detail_ticket_container_check"></div>
                        </div>

                        <!-- Log Task -->
                        <div class="tab-pane fade" id="log-task-check" role="tabpanel" aria-labelledby="log-tab-check">
                        <div id="log_task_container_check"></div>
                        </div>
                    </div>
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
