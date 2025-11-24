
<div class="modal fade" id="stockOpnameApproval">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <b class="modal-title">Stock Opname Ticket</b>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <fieldset>
                    <legend>Information About Ticket</legend>
                    <div class="row mx-2">
                        <div class="col-2">
                            <p>Ticket Code</p>
                        </div>
                        <div class="col-4">
                            <p id="approval_so_ticket_code_label"></p>
                        </div>
                        <div class="col-2">
                            <p>Created By</p>
                        </div>
                        <div class="col-4">
                            <p id="approval_so_created_by_label"></p>
                        </div>
                        <div class="col-2">
                            <p>Location</p>
                        </div>
                        <div class="col-4">
                            <p id="approval_so_location_label"></p>
                        </div>
                        <div class="col-2">
                            <p>Department</p>
                        </div>
                        <div class="col-4">
                            <p id="approval_so_department_label"></p>
                        </div>
                        <div class="col-2">
                            <p>Subject</p>
                        </div>
                        <div class="col-4">
                            <p id="approval_so_subject_label"></p>
                        </div>
                    </div>
                    <div class="row mx-2">
                        <div class="col-2">
                            <p>Description</p>
                        </div>
                        <div class="col-10">
                            <p id="approval_so_description_label"></p>
                        </div>
                    </div>
                </fieldset>

                <fieldset>
                    <legend>Approval Option</legend>
                    <div class="row mx-2">
                        <div class="col-2 mt-2">
                            <p>Approval</p>
                        </div>
                        <div class="col-4">
                            <select name="approval_so_select_status" id="approval_so_select_status" class="form-control">
                                <option value="">Choose Approval</option>
                                <option value="1">Approve</option>
                                <option value="2">Reject</option>
                            </select>
                            <input type="hidden" id="approval_so_ticket_code">
                            <input type="hidden" id="approval_so_status">
                            <span class="message_error approval_so_status_error"></span>
                        </div>
                        <div class="col-2 mt-2 approval_so_start_date_container">
                            <p>Start Date</p>
                        </div>
                        <div class="col-4 approval_so_start_date_container">
                            <input type="date" id="approval_so_start_date" value="{{date('Y-m-d')}}" class="form-control">
                            <span class="message_error approval_so_start_date_error"></span>
                        </div>
                        <div class="col-2 mt-2">
                            <p>Remark</p>
                        </div>
                        <div class="col-10">
                            <textarea name="approval_so_description" class="form-control" id="approval_so_description" cols="30" rows="10"></textarea>
                            <span class="message_error approval_so_description_error"></span>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="modal-footer justify-content-end">
                <button id="btn_update_so" type="button" class="btn btn-sm btn-success">
                    <i class="fas fa-check"></i>
                </button>
            </div>
        </div>
    </div>
</div>