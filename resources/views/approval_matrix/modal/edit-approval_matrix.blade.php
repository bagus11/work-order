<!-- Modal Add Approval -->
<div class="modal fade" id="editApprovalModal">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form id="approvalForm"> <!-- form mulai dari sini -->
        <div class="modal-header">
          <h5 class="modal-title">Edit Approval Matrix</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="modal-body">
            <div class="row mx-2">
                <div class="col-2">
                    <p>Approval Code </p>
                </div>
                <div class="col-4">
                    <input type="hidden" id="approval_code">
                     <p id="approval_code_label"></p>
                </div>
                <div class="col-2">
                    <p>Aspect</p>
                </div>
                <div class="col-4">
                     <p id="aspect_label"></p>
                </div>
                <div class="col-2">
                    <p>Module</p>
                </div>
                <div class="col-4">
                    <p id="module_label"></p>
                </div>
                <div class="col-2">
                    <p>Data Type</p>
                </div>
                <div class="col-4">
                    <p id="data_type_label"></p>
                </div>
                <div class="col-2 mt-2">
                    <p>Step</p>
                </div>
                <div class="col-2">
                    <input type="number" class="form-control" id="edit_step">
                    <span class="message_error step_error"></span>
                </div>
            </div>
        </div>

        <div class="modal-footer">
          <button type="button" id="btn_save_approver" class="btn btn-success">
            <i class="fas fa-check"></i>
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
