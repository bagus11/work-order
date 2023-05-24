<div class="modal fade" id="detailRFPMaster">
    <div class="modal-dialog modal-lg  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h4 class="modal-title">Master RFP Info</h4>
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
                        <input type="hidden" readonly class="form-control" id="rfpMasterIdInfo">
                        <input type="text" readonly class="form-control" id="requestCodeMasterInfo">
                        <span  style="color:red;" class="message_error text-red block requestCodeInfo_error"></span>
                    </div>
                   
                  </div>
                <div class="form-group row">
                    <div class="col-md-2 mt-2">
                        <label for="">Title</label>
                    </div>
                    <div class="col-md-10">
                        <input type="text" class="form-control" id="titleMasterInfo">
                        <span  style="color:red;" class="message_error text-red block titleMasterInfo_error"></span>
                    </div>
                
                </div>
                <div class="form-group row">
                    <div class="col-md-2 mt-2">
                        <label for="">Description</label>
                    </div>
                    <div class="col-md-10">
                        <textarea class="form-control" id="descriptionMasterInfo" rows="3"></textarea>
                        <span  style="color:red;" class="message_error text-red block descriptionMasterInfo_error"></span>
                    </div>
                </div>
                 
                    <div class="form-group row">
                        <div class="col-md-2 mt-2">
                            <label for="">Start Date</label>
                        </div>
                        <div class="col-md-4">
                            <input type="date" readonly class="form-control" id="startDateMasterInfo">
                            <span  style="color:red;" class="message_error text-red block startDateMasterInfo_error"></span>
                        </div>
                        <div class="col-md-2 mt-2">
                            <label for="">Deadline</label>
                        </div>
                        <div class="col-md-4">
                            <input type="date" class="form-control" id="datelineMasterInfo">
                            <span  style="color:red;" class="message_error text-red block datelineMasterInfo_error"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 mt-2">
                            <label for="">Attachment</label>
                        </div>
                        <div class="col-md-10 mt-2">
                            <div id="attachmentRFPMaster">

                            </div>
                            
                        </div>
                    </div>
               </div>
            </div>
            <div class="modal-footer justify-content-end">
              
            </div>
        </div>
    </div>
</div>