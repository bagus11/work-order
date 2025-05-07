<div class="modal fade" id="POModal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-core">
                Add PO
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
        
                <div class="modal-body p-0">
                    <div class="row mx-2 my-2">
                        <input type="hidden" id="po_id">
                        <div class="col-1 mt-2">
                            <p>PR</p>
                        </div>
                        <div class="col-4">
                            <input type="text" class="form-control" id="pr">
                        </div>
                        <div class="col-1 mt-2">
                            <p>PO</p>
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
                    <div class="row mx-2 my-2">
                        <div class="col-12">
                            <table class="datatable-bordered nowrap display" id="po_table" >
                                <thead>
                                    <tr>
                                        <th style="text-align:center">Created At</th>
                                        <th style="text-align:center">PR</th>
                                        <th style="text-align:center">PO</th>
                                        <th style="text-align:center">Created By</th>
                                        <th style="text-align:center">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-end p-0 mx-2">
                  
                </div>
        </div>
    </div>
</div>

