<div class="modal fade" id="editHoldProgress">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                Hold Request Form
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
             
                            <div class="card">
                                <div class="card-header">
                                    Detail Ticket
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-4 col-sm-4 col-md-2">
                                            <p>Request Code</p>
                                            </div>
                                            <div class="col-8 col-sm-8 col-md-4">
                                                <p id="holdRequestCode"></p>
                                                <input type="hidden" id="hold_request_code">
                                            </div>
                                            <div class="col-4 col-sm-4 col-md-2">
                                                <p>PIC</p>
                                            </div>
                                            <div class="col-8 col-sm-8 col-md-4">
                                                <p id="holdPICName"></p>
                                            </div>
                    
                                            <div class="col-4 col-sm-4 col-md-2">
                                            <p>Request By</p>
                                            </div>
                                            <div class="col-8 col-sm-8 col-md-4">
                                                <p id="holdRequestBy"></p>
                                            </div>
                    
                                            <div class="col-4 col-sm-4 col-md-2">
                                                <p>Departement</p>
                                            </div>
                                            <div class="col-8 col-sm-8 col-md-4">
                                                <p id="holdDepartement"></p>
                                            </div>
                                            <div class="col-4 col-sm-4 col-md-2">
                                                <p>Category</p>
                                            </div>
                                            <div class="col-8 col-sm-8 col-md-4">
                                                <p id="holdCategory"></p>
                                            </div>
                    
                                            <div class="col-4 col-sm-4 col-md-2">
                                                <p>Problem Type</p>
                                            </div>
                                            <div class="col-8 col-sm-8 col-md-4">
                                                <p id="holdProblemType"></p>
                                            </div>
                    
                                            
                                            <div class="col-4 col-sm-4 col-md-2">
                                                <p>PIC Reason</p>
                                            </div>
                                            <div class="col-8 col-sm-8 col-md-10">
                                              <p id="holdPICReason"></p>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    Your Result
                                </div>
                                <div class="card-body">
                                    <div class="form-group row"> 
                                        <div class="col-4 col-sm-4 col-md-2">
                                            <p>Comment</p>
                                        </div>
                                        <div class="col-8 col-sm-8 col-md-10">
                                            <textarea class="form-control" id="holdComment" rows="3"></textarea>
                                            <span  style="color:red;" class="message_error text-red block holdComment_error"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

            </div>
            <div class="modal-footer justify-content-end">
                <button id="btnReject" type="button" class="btn btn-danger">
                    <i class="fas fa-xmark"></i>
                </button>
                <button id="btnAccept" type="button" class="btn btn-success">
                    <i class="fas fa-check"></i>
                </button>
            </div>
        </div>
    </div>
</div>