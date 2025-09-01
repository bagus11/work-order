<div class="modal fade" id="editSystemModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
    <div class="modal-content rounded-3 shadow-lg">
      <!-- Header -->
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title">
          <i class="fas fa-ticket-alt me-2"></i> Detail About Ticket
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <!-- Body -->
      <div class="modal-body px-3">
        <fieldset class="mb-4">
          <legend class="fw-bold text-secondary">General Information</legend>
          <div class="row mb-3">
            <div class="col-2 d-flex align-items-center"><p class="mb-0">Ticket Code</p></div>
            <div class="col-4"><input type="text" class="form-control" id="edit_ticket_code" disabled></div>
            <div class="col-2 d-flex align-items-center"><p class="mb-0">Created By</p></div>
            <div class="col-4"><input type="text" class="form-control" id="edit_created_by" disabled></div>
          </div>

          <div class="row mb-3">
            <div class="col-2 d-flex align-items-center"><p class="mb-0">Subject</p></div>
            <div class="col-4"><input type="text" class="form-control" id="edit_subject" disabled></div>
            <div class="col-2 d-flex align-items-center"><p class="mb-0">Created At</p></div>
            <div class="col-4"><input type="datetime" class="form-control" id="edit_created_at" disabled></div>
          </div>

          <div class="row">
            <div class="col-2 d-flex align-items-start mt-2"><p class="mb-0">Additional Info</p></div>
            <div class="col-10">
              <textarea name="edit_add_info" disabled class="form-control" id="edit_add_info" rows="4"></textarea>
            </div>
          </div>
        </fieldset>

        <fieldset>
          <legend class="fw-bold text-secondary">Detail Task</legend>

          <!-- Tabs -->
          <ul class="nav nav-tabs border-0" id="ticketTab" role="tablist" style="gap:6px;">
            <li class="nav-item">
              <a class="nav-link active px-4 rounded-pill shadow-sm" style="font-size:12px;"
                 id="task-tab"
                 data-toggle="tab"
                 href="#task"
                 role="tab"
                 aria-controls="task"
                 aria-selected="true">
                <i class="fas fa-tasks me-1"></i> Task
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link px-4 rounded-pill shadow-sm" style="font-size:12px;"
                 id="log-tab"
                 data-toggle="tab"
                 href="#log-task"
                 role="tab"
                 aria-controls="log-task"
                 aria-selected="false">
                <i class="fas fa-history me-1"></i> Log Task
              </a>
            </li>
          </ul>

          <!-- Tab Content -->
          <div class="tab-content mt-3 p-3 rounded-3 shadow-sm bg-light" id="ticketTabContent">
            <!-- Task -->
            <div class="tab-pane fade show active" id="task" role="tabpanel" aria-labelledby="task-tab">
              <div id="detail_ticket_container"></div>
            </div>

            <!-- Log Task -->
            <div class="tab-pane fade" id="log-task" role="tabpanel" aria-labelledby="log-tab">
              <div id="log_task_container"></div>
            </div>
          </div>
        </fieldset>
      </div>

      <!-- Footer -->
      <div class="modal-footer p-2">
        <button type="button" class="btn btn-secondary rounded-pill px-3" data-dismiss="modal">
          <i class="fas fa-times"></i> Close
        </button>
      </div>
    </div>
  </div>
</div>

<style>
/* Nav Tabs modern style */
.nav-tabs .nav-link {
  background: #f8f9fa;
  color: #495057;
  border: none;
  transition: all 0.3s ease;
}
.nav-tabs .nav-link:hover {
  background: #e9ecef;
  color: #212529;
}
.nav-tabs .nav-link.active {
  background: #212529;
  color: #fff !important;
  box-shadow: 0 2px 6px rgba(0,0,0,0.15);
}

/* Limit modal height for scroll */
.modal-dialog-scrollable .modal-body {
  max-height: calc(100vh - 180px);
  overflow-y: auto;
}
</style>
