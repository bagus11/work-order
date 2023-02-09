<div class="modal fade" id="updatePIC">
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
                        <input type="text" class="form-control" id="username_update" readonly>
                    </div>
                    <div class="col-md-2 mt-2">
                        <label for="">Request Code</label>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="request_code_update" readonly>
                    </div>
                </div>
                    <div class="form-group row">
                        <div class="col-md-2 mt-2">
                            <label for="">Request Type</label>
                        </div>
                        <div class="col-md-4">
                            <select name="select_request_type_update_update" class="select2" style="width: 100%" id="select_request_type_update">
                            </select>
                            <input type="hidden" id="request_type_update" class="form-controll">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 mt-2">
                            <label for="">Categories</label>
                        </div>
                        <div class="col-md-4">
                            <select name="select_categories_update" class="select2" style="width: 100%" id="select_categories_update">
                            </select>
                            <input type="hidden" class="form-control" id="categories_update">
                            <span  style="color:red;" class="message_error text-red block categories_update_error"></span>
                        </div>
                        <div class="col-md-2 mt-2">
                            <label for="">Problem Type</label>
                        </div>
                        <div class="col-md-4">
                            <select name="select_problem_type_update" class="select2" style="width: 100%" id="select_problem_type_update">
                                <option value="">Choose Categories First</option>
                            </select>
                            <input type="hidden" class="form-control" id="problem_type_update">
                            <span  style="color:red;" class="message_error text-red block problem_type_update_error"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 mt-2">
                            <label for="">Subject</label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="subject_update" readonly>
                            <span  style="color:red;" class="message_error text-red block add_info_error"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 mt-2">
                            <label for="">Additional Info</label>
                        </div>
                        <div class="col-md-8 ">
                            <textarea class="form-control" id="add_info_update" rows="3" readonly></textarea>
                            <span  style="color:red;" class="message_error text-red block add_info_update_error"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 mt-4">
                            <label for="">Note</label>
                        </div>
                        <div class="col-md-8">
                            <span for="" id ="creator" style="text-align: right;float:right"></span>
                            <textarea class="form-control" id="note" rows="2" readonly></textarea>
                            <span  style="color:red;" class="message_error text-red block note_error"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 mt-2">
                            <label for="">Progress</label>
                        </div>
                        <div class="col-md-4">
                            <select name="select_status_wo" class="select2 form-control" style="width:100%" id="select_status_wo">
                                <option value="">Select Progress</option>
                                <option value="4">DONE</option>
                                <option value="2">PENDING</option>
                            </select>
                            <input type="hidden" id="status_wo">
                            <span  style="color:red;" class="message_error text-red block status_wo_error"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 mt-2">
                            <label for="">Note PIC</label>
                        </div>
                        <div class="col-md-8">
                            <textarea class="form-control" id="note_pic" rows="2"></textarea>
                            <span  style="color:red;" class="message_error text-red block note_pic_error"></span>
                        </div>
                        
                    </div>
               </div>
            </div>
           
            <div class="modal-footer justify-content-end">
                <button id="btn_edit_wo" type="button" class="btn btn-success">Save Change</button>
            </div>
        </div>
    </div>
</div>