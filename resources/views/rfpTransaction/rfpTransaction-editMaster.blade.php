
<div class="modal fade" id="editMasterRFP">
    <div class="modal-dialog modal-lg  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h4 class="modal-title">Edit Master RFP</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <div class="container">
                <div class="form-group row">
                    <div class="col-md-2 mt-2">
                        <label for=""> Request Code</label>
                    </div>
                    <div class="col-md-4">
                        <input type="hidden" readonly class="form-control" id="rfpMasterIdEdit">
                        <input type="text" readonly class="form-control" id="requestCodeMasterEdit">
                        <span  style="color:red;" class="message_error text-red block requestCodeEdit_error"></span>
                    </div>
                   
                  </div>
                <div class="form-group row">
                    <div class="col-md-2 mt-2">
                        <label for="">Title</label>
                    </div>
                    <div class="col-md-10">
                        <input type="text" class="form-control" id="titleMasterEdit">
                        <span  style="color:red;" class="message_error text-red block titleMasterEdit_error"></span>
                    </div>
                
                </div>
                <div class="form-group row">
                    <div class="col-md-2 mt-2">
                        <label for="">Description</label>
                    </div>
                    <div class="col-md-10">
                        <textarea class="form-control" id="descriptionMasterEdit" rows="3"></textarea>
                        <span  style="color:red;" class="message_error text-red block descriptionMasterEdit_error"></span>
                    </div>
                </div>
                 
                    <div class="form-group row">
                        <div class="col-md-2 mt-2">
                            <label for="">Start Date</label>
                        </div>
                        <div class="col-md-4">
                            <input type="date" readonly class="form-control" id="startDateMasterEdit">
                            <span  style="color:red;" class="message_error text-red block startDateMasterEdit_error"></span>
                        </div>
                        <div class="col-md-2 mt-2">
                            <label for="">Deadline</label>
                        </div>
                        <div class="col-md-4">
                            <input type="date" class="form-control" id="datelineMasterEdit">
                            <span  style="color:red;" class="message_error text-red block datelineMasterEdit_error"></span>
                        </div>
                    </div>
               </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button id="btnMasterEditRFP" type="button" class="btn btn-success">Save changes</button>
            </div>
        </div>
    </div>
</div>