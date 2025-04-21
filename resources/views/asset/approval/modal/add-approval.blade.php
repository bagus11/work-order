<div class="modal fade" id="addApprover">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header">
                <b class="headerTitle">Add Approval</b>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 mt-2">
                        <p>Location</p>
                    </div>
                    <div class="col-md-8">
                        <select name="select_location" class="select2" id="select_location"></select>
                        <input type="hidden" class="form-control" id="location_id">
                        <span  style="color:red;font-size:9px;" class="message_error text-red block location_id_error"></span>
                    </div>
                    <div class="col-md-4 mt-2">
                        <p>Step Approval</p>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="step">
                        <span  style="color:red;font-size:9px;" class="message_error text-red block step_error"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button id="btn_save_approval" type="button" class="btn btn-sm btn-success">
                    <i class="fa-solid fa-floppy-disk"></i>
                </button>
            </div>
        </div>
    </div>
</div>