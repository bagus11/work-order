
<div class="modal fade" id="editPriority">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h4 class="modal-title">Assign Ticket</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <div class="container">
                <div class="form-group row">
                    <div class="col-4 col-sm-4 col-md-2 mt-2">
                        <p for="">Request Type</p>
                    </div>
                    <div class="col-8 col-sm-8 col-md-4  mt-2">
                        <span id="select_request_type_priority"></span>
                    </div>
                    <div class="col-4 col-sm-4 col-md-2 mt-2">
                        <p for="">PIC</p>
                    </div>
                    <div class="col-8 col-sm-8 col-md-4  mt-2">
                        <span id="pic_priority"></span>
                    </div>
                </div>
                    <div class="form-group row" style="margin-top:-20px">
                        <div class="col-4 col-sm-4 col-md-2 mt-2">
                            <p for="">Request By</p>
                        </div>
                        <div class="col-8 col-sm-8 col-md-4  mt-2">
                            <input type="hidden" class="form-control" id="wo_id_priority" readonly>
                            <span id="username_priority"></span>
                        
                        </div>
                        <div class="col-4 col-sm-4 col-md-2 mt-2">
                            <p for="">Request Code</p>
                        </div>
                        <div class="col-8 col-sm-8 col-md-4  mt-2">
                            <span id="request_code_priority"></span>
                        </div>
                        <div class="col-4 col-sm-4 col-md-2 mt-2">
                            <p for="">Categories</p>
                        </div>
                        <div class="col-8 col-sm-8 col-md-4  mt-2">
                          <span id="select_categories_priority"></span>
                        </div>
                        <div class="col-4 col-sm-4 col-md-2 mt-2">
                            <p for="">Problem Type</p>
                        </div>
                        <div class="col-8 col-sm-8 col-md-4  mt-2">
                          <span id="select_problem_type_priority"></span>
                        </div>
                        <div class="col-4 col-sm-4 col-md-2 mt-2">
                            <p for="">Subject</p>
                        </div>
                        <div class="col-8 col-sm-8 col-md-10  mt-2">
                           <span id="subject_priority"></span>
                        </div>
                        <div class="col-4 col-sm-4 col-md-2 mt-2">
                            <p for="">Additional Info</p>
                        </div>
                        <div class="col-8 col-sm-8 col-md-10 mt-2">
                           <span id="add_info_priority"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-4 col-sm-4 col-md-2 mt-2">
                            <p for="">Level</p>
                        </div>
                        <div class="col-8 col-sm-8 col-md-4 ">
                            <select name="select_level_priority" class="select2" style="width: 100%" id="select_level_priority">
                                <option value="">Choose Level</option>
                                <option value="1">Low</option>
                                <option value="2">Medium</option>
                                <option value="3">High</option>
                            </select>
                            <input type="hidden" id="priority" class="form-control">
                            <span  style="color:red;" class="message_error text-red block priority_error"></span>
                        </div>
                      
                    </div>
               </div>
            </div>
           
            <div class="modal-footer justify-content-end">
                <button id="btnAssignPriority" type="button" class="btn btn-success">Save</button>
            </div>
        </div>
    </div>
</div>