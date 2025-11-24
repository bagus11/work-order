<div class="modal fade" id="editISModal">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-core">
                Add IS
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
        
                <div class="modal-body p-0">
                    <div class="row mx-2 my-2">
                        <input type="hidden" id="is_id">
                        <div class="col-1 mt-2">
                            <p>IS</p>
                        </div>
                        <div class="col-4">
                            <input type="text" class="form-control" id="is">
                        </div>
                        <div class="col-1">
                            <button class="btn btn-sm btn-success" id="btn_add_is">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="row mx-2 my-2">
                        <div class="col-12">
                            <table class="datatable-bordered nowrap display" id="is_table" >
                                <thead>
                                    <tr>
                                        <th style="text-align:center">IS</th>
                                        <th style="text-align:center">Created By</th>
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

