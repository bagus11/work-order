<div class="modal fade" id="detailWO">
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
                        <input type="hidden" class="form-control" id="wo_id_detail" >
                        <input type="text" class="form-control" id="username_detail" >
                    </div>
                    <div class="col-md-2 mt-2">
                        <label for="">Request Code</label>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="request_code_detail" >
                    </div>
                </div>
                    <div class="form-group row">
                        <div class="col-md-2 mt-2">
                            <label for="">Request Type</label>
                        </div>
                        <div class="col-md-4">
                            <select name="select_request_type_detail_detail" class="select2" style="width: 100%" id="select_request_type_detail">
                            </select>
                            <input type="hidden" id="request_type_detail" class="form-controll">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 mt-2">
                            <label for="">Categories</label>
                        </div>
                        <div class="col-md-4">
                            <select name="select_categories_detail" class="select2" style="width: 100%" id="select_categories_detail">
                            </select>
                            <input type="hidden" class="form-control" id="categories_detail">
                            <span  style="color:red;" class="message_error text-red block categories_detail_error"></span>
                        </div>
                        <div class="col-md-2 mt-2">
                            <label for="">Problem Type</label>
                        </div>
                        <div class="col-md-4">
                            <select name="select_problem_type_detail" class="select2" style="width: 100%" id="select_problem_type_detail">
                                <option value="">Choose Categories First</option>
                            </select>
                            <input type="hidden" class="form-control" id="problem_type_detail">
                            <span  style="color:red;" class="message_error text-red block problem_type_detail_error"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 mt-2">
                            <label for="">Subject</label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="subject_detail" >
                            <span  style="color:red;" class="message_error text-red block add_info_error"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 mt-2">
                            <label for="">Additional Info</label>
                        </div>
                        <div class="col-md-8 ">
                            <textarea class="form-control" id="add_info_detail" rows="3" ></textarea>
                            <span  style="color:red;" class="message_error text-red block add_info_detail_error"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 mt-2">
                            <label for="">Status</label>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="status_wo_detail">
                        </div>
                    </div>
                    <div id="note_status">
                        <div class="form-group row">
                            <div class="col-md-2 mt-4">
                                <label for="">Note</label>
                            </div>
                            <div class="col-md-8">
                                <span for="" id ="creator_detail" style="text-align: right;float:right"></span>
                                <textarea class="form-control" id="note_detail" rows="2" ></textarea>
                                <span  style="color:red;" class="message_error text-red block note_detail_error"></span>
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