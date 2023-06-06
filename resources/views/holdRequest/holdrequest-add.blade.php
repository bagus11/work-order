<div class="modal fade" id="addPICTransfer">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                Add Categories
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <div class="container">
                <div class="form-group row">
                    <div class="col-md-2 mt-2">
                       <p>Request Code</p>
                    </div>
                    <div class="col-md-4">
                        <select name="" id="selectRequestCode" class="select2">

                        </select>
                        <input type="hidden" class="form-control" id="requestCode">
                        <span  style="color:red;" class="message_error text-red block requestCode_error"></span>
                    </div>
                
                </div>
                    <div class="card" id="detailTicketContainer">
                        <div class="card-header">
                            Detail Ticket
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2 mt-2">
                                    <p>Request By</p>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" disabled name="detailRequestBy" id="detailRequestBy">
                                </div>
                                 <div class="col-md-2 mt-2">
                                    <p>PIC</p>
                                </div>
                                <div class="col-md-4">
                                    <select name="selectPIC" class="select2" id="selectPIC"></select>
                                    <input type="hidden" class="form-control" id="picId">
                                    <span  style="color:red;" class="message_error text-red block picId_error"></span>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-md-2 mt-2">
                                    <p>Departement</p>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" disabled name="detailDepartement" id="detailDepartement">
                                </div>
                                <div class="col-md-2 mt-2">
                                    <p>Category</p>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" disabled name="detailCategory" id="detailCategory">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2 mt-2">
                                    <p>Problem Type</p>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" disabled name="detailProblemType" id="detailProblemType">
                                </div>
                                <div class="col-md-2 mt-2">
                                    <p>Subject</p>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" disabled name="detailSubject" id="detailSubject">
                                </div>
                            </div>
                        </div>
                    </div>
                   
               </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button id="btn_save_categories" type="button" class="btn btn-success">
                    <i class="fas fa-check"></i>
                </button>
            </div>
        </div>
    </div>
</div>