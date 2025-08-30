<!-- Modal Add Approval -->
<div class="modal fade" id="updateApprovalModal">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form id="approvalForm"> <!-- form mulai dari sini -->
        <div class="modal-header">
          <h5 class="modal-title">Update Approval Matrix</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="modal-body">
          <div class="row mb-2">
            <div class="col-12">
              <button style="float: right" class="btn btn-sm btn-success" type="button" id="btnAdd">
                <i class="fas fa-plus"></i>
              </button>
              <input type="hidden" id="approver_step">
            </div>
          </div>
             <table class="datatable-stepper nowrap display" id="approver_step_table">
                    <thead>
                        <tr>
                            <th  style="text-align: center;width:10% !important">Step</th>
                            <th  style="text-align: center;width:90% !important">Name</th>
                            <th  style="text-align: center;width:90% !important">Action</th>
                        </tr>
                    </thead>
                </table> 
        </div>

        <div class="modal-footer">
          <button type="button" id="btn_update_approver" class="btn btn-success">
            <i class="fas fa-check"></i>
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
