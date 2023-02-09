
<div class="modal fade" id="editAssignment">
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
                    <div class="col-md-2 mt-2">
                        <label for="">Request By</label>
                    </div>
                    <div class="col-md-4">
                        <input type="hidden" class="form-control" id="wo_id" readonly>
                        <input type="text" class="form-control" id="username" readonly>
                        <span  style="color:red;" class="message_error text-red block add_info_error"></span>
                    </div>
                    <div class="col-md-2 mt-2">
                        <label for="">Request Code</label>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="request_code" readonly>
                        <span  style="color:red;" class="message_error text-red block add_info_error"></span>
                    </div>
                </div>
                    <div class="form-group row">
                        <div class="col-md-2 mt-2">
                            <label for="">Request Type</label>
                        </div>
                        <div class="col-md-4">
                            <select name="select_request_type" class="select2" style="width: 100%" id="select_request_type">
                                <option value="">Choose Request type</option>
                                <option value="RFM">Request For Maintainance</option>
                                <option value="RFP">Request For Project</option>
                            </select>
                            <input type="hidden" id="request_type" class="form-controll">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 mt-2">
                            <label for="">Categories</label>
                        </div>
                        <div class="col-md-4">
                            <select name="select_categories" class="select2" style="width: 100%" id="select_categories">
                            </select>
                            <input type="hidden" class="form-control" id="categories">
                            <span  style="color:red;" class="message_error text-red block categories_error"></span>
                        </div>
                        <div class="col-md-2 mt-2">
                            <label for="">Problem Type</label>
                        </div>
                        <div class="col-md-4">
                            <select name="select_problem_type" class="select2" style="width: 100%" id="select_problem_type">
                                <option value="">Choose Categories First</option>
                            </select>
                            <input type="hidden" class="form-control" id="problem_type">
                            <span  style="color:red;" class="message_error text-red block problem_type_error"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 mt-2">
                            <label for="">Subject</label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="subject" readonly>
                            <span  style="color:red;" class="message_error text-red block add_info_error"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 mt-2">
                            <label for="">Additional Info</label>
                        </div>
                        <div class="col-md-10">
                            <textarea class="form-control" id="add_info" rows="3" readonly></textarea>
                            <span  style="color:red;" class="message_error text-red block add_info_error"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 mt-2">
                            <label for="">PIC</label>
                        </div>
                        <div class="col-md-4">
                            <select name="select_user" class="select2" style="width: 100%" id="select_user">
                            </select>
                            <input type="hidden" id="user_pic" class="form-control">
                            <span  style="color:red;" class="message_error text-red block user_pic_error"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 mt-2">
                            <label for="">Note</label>
                        </div>
                        <div class="col-md-10">
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