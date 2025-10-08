

<div class="modal fade" id="infoSoModal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title">Stock Opname Ticket</h5>
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
                            <p id="so_ticket_code_label"></p>
                        </div>
                        <div class="col-2">
                            <p>Created By</p>
                        </div>
                        <div class="col-4">
                            <p id="so_created_by_label"></p>
                        </div>
                        <div class="col-2">
                            <p>Location</p>
                        </div>
                        <div class="col-4">
                            <p id="so_location_label"></p>
                        </div>
                        <div class="col-2">
                            <p>Department</p>
                        </div>
                        <div class="col-4">
                            <p id="so_department_label"></p>
                        </div>
                        <div class="col-2">
                            <p>Subject</p>
                        </div>
                        <div class="col-4">
                            <p id="so_subject_label"></p>
                        </div>
                        <div class="col-2">
                            <p>Status</p>
                        </div>
                        <div class="col-4">
                            <p id="so_status_label"></p>
                        </div>
                    </div>
                    <div class="row mx-2">
                        <div class="col-2">
                            <p>Start Date</p>
                        </div>
                        <div class="col-4">
                            <p id="so_start_date_label"></p>
                        </div>
                        <div class="col-2">
                            <p>End Date</p>
                        </div>
                        <div class="col-4">
                            <p id="so_end_date_label"></p>
                        </div>
                    </div>
                    <div class="row mx-2">
                        <div class="col-2">
                            <p>Description</p>
                        </div>
                        <div class="col-10">
                            <p id="so_description_label"></p>
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <legend>Stock Opname Operation</legend>
                        <div id="so_detail_content">
                        </div>
                </fieldset>
            </div>
            <div class="modal-footer justify-content-end">
                <button id="btn_save_stock_opname" type="button" class="btn btn-success">
                    <i class="fas fa-check"></i>
                </button>
            </div>
        </div>
    </div>
</div>