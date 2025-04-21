<div class="modal fade" id="stepApprovalModal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <b class="headerTitle">Step Approval</b>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <div class="container"> 
                <input type="hidden" name="step_approval_code" id="step_approval_code">
                <table class="datatable-stepper nowrap display" id="approver_step_table">
                    <thead>
                        <tr>
                            <th  style="text-align: center;width:10% !important">No</th>
                            <th  style="text-align: center;width:90% !important">Name</th>
                        </tr>
                    </thead>
                </table> 
               </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button id="btn_set_approver" type="button" class="btn btn-sm btn-success">
                    <i class="fa-solid fa-floppy-disk"></i>
                </button>
            </div>
        </div>
    </div>
</div>