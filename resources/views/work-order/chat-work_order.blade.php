
<div class="modal fade" id="chatModal">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-core">
                Media Disscuss
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <fieldset>
                    <legend>Activity</legend>
                    <div id="chat_container"></div>
                </fieldset>
               <div class="row mx-1 mt-2">
                <div class="col-11">
                    <input type="hidden" id="chat_request">
                    <textarea class="form-control" id="remark_chat" rows="3"></textarea>
                    <span  style="color:red;" class="message_error text-red block remark_chat_error"></span>
                </div>
                <div class="col-1 mt-3">
                    <button id="btn_send_chat" type="button" title="Send Message" class="btn btn-success btn-sm">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
               </div>
            </div>
           
          
        </div>
    </div>
</div>