
<div class="modal fade" id="editAssignment">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h4 class="modal-title">Detail Ticket</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <div class="container">
                <div class="form-group row">
                    <div class="col-5 col-sm-4 col-md-2 mt-2">
                        <p for="">Request Type</p>
                    </div>
                    <div class="col-7 col-sm-8 col-md-4  mt-2">
                        <span id="select_request_type"></span>
                    </div>
                </div>
                    <div class="form-group row" style="margin-top:-20px">
                        <div class="col-5 col-sm-4 col-md-2 mt-2">
                            <p for="">Request By</p>
                        </div>
                        <div class="col-7 col-sm-8 col-md-4  mt-2">
                            <input type="hidden" class="form-control" id="wo_id" readonly>
                            <span id="username"></span>
                        </div>
                        <div class="col-5 col-sm-4 col-md-2 mt-2">
                            <p for="">Request Code</p>
                        </div>
                        <div class="col-7 col-sm-8 col-md-4  mt-2">
                            <span id="request_code"></span>
                        </div>
                        <div class="col-5 col-sm-4 col-md-2 mt-2">
                            <p for="">Categories</p>
                        </div>
                        <div class="col-7 col-sm-8 col-md-4  mt-2">
                          <span id="select_categories"></span>
                        </div>
                        <div class="col-5 col-sm-4 col-md-2 mt-2">
                            <p for="">Problem Type</p>
                        </div>
                        <div class="col-7 col-sm-8 col-md-4  mt-2">
                          <span id="select_problem_type"></span>
                        </div>
                        <div class="col-5 col-sm-4 col-md-2 mt-2">
                            <p for="">Subject</p>
                        </div>
                        <div class="col-7 col-sm-8 col-md-10  mt-2">
                           <span id="subject"></span>
                        </div>
                        <div class="col-5 col-sm-4 col-md-2 mt-2">
                            <p for="">Additional Info</p>
                        </div>
                        <div class="col-7 col-sm-8 col-md-10 mt-2">
                           <span id="add_info"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12 col-sm-4 col-md-2 mt-2">
                            <p for="">Level</p>
                        </div>
                        <div class="col-12 col-sm-8 col-md-4 ">
                            <select name="selectPriority" class="select2" style="width: 100%" id="selectPriority">
                                <option value="">Chooose Level</option>
                                <option value="1">Low</option>
                                <option value="2">Medium</option>
                                <option value="3">High</option>
                            </select>
                            <input type="hidden" id="priority" class="form-control">
                            <span  style="color:red;" class="message_error text-red block priority_error"></span>
                        </div>
                        <div class="col-12 col-sm-4 col-md-2 mt-2 mt-2">
                            <p for="">PIC</p>
                        </div>
                        <div class="col-12 col-sm-8 col-md-4 ">
                            <select name="select_user" class="select2" style="width: 100%" id="select_user">
                            </select>
                            <input type="hidden" id="user_pic" class="form-control">
                            <span  style="color:red;" class="message_error text-red block user_pic_error"></span>
                        </div>
                    </div>
                
                    <div class="form-group row">
                        <div class="col-12 col-sm-4 col-md-2 mt-2">
                            <p for="">Note</p>
                        </div>
                        <div class="col-12 col-sm-8 col-md-10">
                            <textarea class="form-control" id="note" rows="3"></textarea>
                            <span  style="color:red;" class="message_error text-red block note_error"></span>
                        </div>
                    </div>
               </div>
            </div>
           
            <div class="modal-footer justify-content-end">
                <button id="btn_reject_assign" type="button" class="btn btn-danger">Reject</button>
                <button id="btn_approve_assign" type="button" class="btn btn-success">Accept</button>
            </div>
        </div>
    </div>
</div>