<div class="modal fade" id="editResumeProgress">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                Resume Request Form
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
                                    <p id="resumeRequestCode"></p>
                                    <input type="hidden" id="resume_request_code">
                                </div>
                                <div class="col-4 col-sm-4 col-md-2">
                                    <p>PIC</p>
                                </div>
                                <div class="col-8 col-sm-8 col-md-4">
                                    <p id="resumePICName"></p>
                                </div>
        
                                <div class="col-4 col-sm-4 col-md-2">
                                <p>Request By</p>
                                </div>
                                <div class="col-8 col-sm-8 col-md-4">
                                    <p id="resumeRequestBy"></p>
                                </div>
        
                                <div class="col-4 col-sm-4 col-md-2">
                                    <p>Departement</p>
                                </div>
                                <div class="col-8 col-sm-8 col-md-4">
                                    <p id="resumeDepartement"></p>
                                </div>
                                <div class="col-4 col-sm-4 col-md-2">
                                    <p>Category</p>
                                </div>
                                <div class="col-8 col-sm-8 col-md-4">
                                    <p id="resumeCategory"></p>
                                </div>
        
                                <div class="col-4 col-sm-4 col-md-2">
                                    <p>Problem Type</p>
                                </div>
                                <div class="col-8 col-sm-8 col-md-4">
                                    <p id="resumeProblemType"></p>
                                </div>
                        </div>
                    </div>
                </div>
                        
            </div>
            <div class="modal-footer justify-content-end">
                <button id="btnResume" type="button" class="btn btn-success">
                    <i class="fas fa-check"></i>
                </button>
            </div>
        </div>
    </div>
</div>