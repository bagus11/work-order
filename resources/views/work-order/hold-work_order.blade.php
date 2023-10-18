
<div class="modal fade" id="holdProgressModal">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                Hold Progress
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
                            <input type="hidden" id="holdProgressId">
                            <textarea class="form-control" id="holdProgressNote" rows="2"></textarea>
                            <span  style="color:red;" class="message_error text-red block holdProgressNote_error"></span>
                        </div>
                        
                    </div>
               </div>
            </div>
           
            <div class="modal-footer justify-content-end">
                <button id="btnHoldProgress" type="button" class="btn btn-success">
                    <i class="fas fa-check"></i>
                </button>
            </div>
        </div>
    </div>
</div>