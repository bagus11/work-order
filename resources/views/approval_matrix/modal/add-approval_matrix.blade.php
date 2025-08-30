<!-- Modal Add Approval -->
<div class="modal fade" id="addApprover">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form id="approvalForm"> <!-- form mulai dari sini -->
        <div class="modal-header">
          <h5 class="modal-title">Add Approval Matrix</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="modal-body">
            <div class="row mx-2">
                <div class="col-2 mt-2">
                    <p>Aspect</p>
                </div>
                <div class="col-4 mb-2">
                    <select name="select_aspect" class="select2" id="select_aspect"></select>
                    <input type="hidden" id="aspect">
                    <span class="message_error aspect_error"></span>
                </div>
                <div class="col-2 mt-2">
                    <p>Module</p>
                </div>
                <div class="col-4 mb-2">
                    <select name="select_module" class="select2" id="select_module"></select>
                    <input type="hidden" id="module">
                    <span class="message_error module_error"></span>
                </div>
                <div class="col-2 mt-2">
                    <p>Data Type</p>
                </div>
                <div class="col-4 mb-2">
                    <select name="select_data_type" class="select2" id="select_data_type"></select>
                    <input type="hidden" id="data_type">
                    <span class="message_error data_type_error"></span>
                </div>
                <div class="col-2 mt-2">
                    <p>Step</p>
                </div>
                <div class="col-4 mb-2">
                    <input type="number" class="form-control" id="step">
                    <span class="message_error step_error"></span>
                </div>
            </div>
        </div>

        <div class="modal-footer">
          <button type="button" id="btn_save_approval" class="btn btn-success">
            <i class="fas fa-check"></i>
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
