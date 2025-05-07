<div class="modal fade" id="addPermissionModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h4 class="modal-title">Add Permission</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <div class="container">
                <input type="hidden" id="role_id_permission">
                <table class="datatable-bordered" id="permission_table">
                    <thead>
                        <tr>
                            <th style="text-align: center"><input type="checkbox" id="check_all_add_permission" name="check_all_add_permission" class="check_all_add_permission" style="border-radius: 5px !important;"></th>
                            <th>Permission</th>
                        </tr>
                    </thead>
                </table>
               </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button id="btn_add_permission" type="button" class="btn btn-success">Save changes</button>
            </div>
        </div>
    </div>
</div>