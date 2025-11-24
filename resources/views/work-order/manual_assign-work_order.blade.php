
<div class="modal fade" id="manualAssign">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-core">
                Manual Assign
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <div class="container">
                    <div class="form-group row">
                        <div class="col-md-4 mt-2">
                            <p for="">Note PIC</p>
                        </div>
                        <div class="col-md-8">
                            <input type="hidden" id="manual_assign_id_wo">
                            <textarea class="form-control" id="manual_pic_note" rows="2"></textarea>
                            <span  style="color:red;" class="message_error text-red block manual_pic_note_error"></span>
                        </div>
                        
                    </div>
               </div>
            </div>
           
            <div class="modal-footer justify-content-end">
                {{-- <button id="btn_manual_reject" type="button" class="btn btn-danger">Reject</button> --}}
                <button id="btn_manual_approve" type="button" class="btn btn-success">Accept</button>
            </div>
        </div>
    </div>
</div>