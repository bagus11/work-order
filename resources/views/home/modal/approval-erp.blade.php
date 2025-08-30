<div class="modal fade" id="approvalERPModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      
      <!-- Modal Header -->
      <div class="modal-header bg-core">
        <h4>Approval ERP Request</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <!-- Modal Body -->
      <div class="modal-body p-0 mx-2">
        <!-- Tabs Navigation -->
        <ul class="nav nav-tabs mt-2" id="erpTab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="general-tab" data-toggle="tab" href="#general" role="tab">
              General Information
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="detail-tab" data-toggle="tab" href="#detail" role="tab">
              Detail Transaction
            </a>
          </li>
        </ul>

        <!-- Tabs Content -->
        <div class="tab-content mt-3" id="erpTabContent">
          
          <!-- General Information -->
          <div class="tab-pane fade show active" id="general" role="tabpanel">
            <div class="row">
              <div class="col-2"><p>Ticket Code</p></div>
              <div class="col-4"><p id="erp_ticket_code"></p></div>
              <div class="col-2"><p>Created At</p></div>
              <div class="col-4"><p id="erp_created_at"></p></div>

              <div class="col-2"><p>Created By</p></div>
              <div class="col-4"><p id="erp_created_by"></p></div>
              <div class="col-2"><p>Subject</p></div>
              <div class="col-4"><p id="erp_subject"></p></div>

              <div class="col-2"><p>Additional Info</p></div>
              <div class="col-10"><p id="erp_additional_info"></p></div>
            </div>

            <div class="row mt-2">
              <div class="col-2"><p>Approval</p></div>
              <div class="col-4 mb-2">
                <select name="erp_select_approval" class="select2" id="erp_select_approval">
                  <option value="">Choose Approval</option>
                  <option value="1">Approve</option>
                  <option value="2">Reject</option>
                </select>
                <input type="hidden" id="erp_approval">
                <span class="message_error erp_approval_error"></span>
              </div>

              <div class="col-2 erp_pic_container"><p>PIC</p></div>
              <div class="col-4 mb-2 erp_pic_container">
                <select name="erp_select_pic" class="select2" id="erp_select_pic"></select>
                <input type="hidden" id="erp_pic">
                <span class="message_error erp_pic_error"></span>
              </div>
            </div>
            <div class="row mt-2">
                <div class="col-2"><p>Remark</p></div>
                <div class="col-10">
                    <textarea name="erp_remark" class="form-control" id="erp_remark" rows="5"></textarea>
                    <span class="message_error erp_remark_error"></span>
                </div>
            </div>

          </div>

          <!-- Detail Transaction -->
          <div class="tab-pane fade" id="detail" role="tabpanel">
            <div id="erp_detail_relation"></div>
          </div>

        </div>
      </div>

      <!-- Modal Footer -->
      <div class="modal-footer justify-content-end py-1">
        <button class="btn btn-sm btn-success" id="erp_approval_btn">
            <i class="fas fa-check"></i>
        </button>
      </div>
    </div>
  </div>
</div>
