<div class="modal fade" id="POModal">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header bg-core">
        <h5 class="modal-title">Form Add PO</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <!-- Modal Body -->
      <div class="modal-body p-0">
        <!-- Form Input -->
        <div class="row mx-2 my-2">
          <fieldset class="w-100">
            <legend class="text-left">Add PO</legend>
            <input type="hidden" id="po_id">
            <div class="row">
              <div class="col-1 mt-2">
                <p for="pr" class="mb-0">PR</p>
              </div>
              <div class="col-4">
                <input type="text" class="form-control" id="pr">
              </div>
              <div class="col-1 mt-2">
                <p for="po" class="mb-0">PO</p>
              </div>
              <div class="col-4">
                <input type="text" class="form-control" id="po">
              </div>
              <div class="col-1">
                <button class="btn btn-sm btn-success" id="btn_add_po">
                  <i class="fas fa-plus"></i>
                </button>
              </div>
            </div>
          </fieldset>
        </div>

        <!-- Table -->
        <div class="row mx-2 my-2">
          <div class="col-12">
            <table class="datatable-bordered nowrap display" id="po_table">
              <thead>
                <tr>
                  <th class="text-center">Created At</th>
                  <th class="text-center">PR</th>
                  <th class="text-center">PO</th>
                  <th class="text-center">Created By</th>
                  <th class="text-center">Action</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>

      <!-- Modal Footer -->
      <div class="modal-footer justify-content-end p-0 mx-2">
        <!-- Optional buttons can be added here -->
      </div>

    </div>
  </div>
</div>
