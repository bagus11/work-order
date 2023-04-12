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
                        <div class="col-5 col-sm-4 col-md-2  mt-2">
                            <label for="">Request By</label>
                        </div>
                        <div class="col-7 col-sm-8 col-md-4  mt-2">
                            <input type="hidden" class="form-control" id="wo_id" readonly>
                           <span id="username_update"></span>
                        </div>
                        <div class="col-5 col-sm-4 col-md-2  mt-2">
                            <label for="">Request Code</label>
                        </div>
                        <div class="col-7 col-sm-8 col-md-4  mt-2">
                          <span id="request_code_update"></span>
                        </div>
                        <div class="col-5 col-sm-4 col-md-2  mt-2">
                            <label for="">Request Type</label>
                        </div>
                        <div class="col-7 col-sm-8 col-md-4  mt-2">
                            <span id="select_request_type_update"></span>
                        </div>
                        <div class="col-5 col-sm-4 col-md-2  mt-2">
                            <label for="">Categories</label>
                        </div>
                        <div class="col-7 col-sm-8 col-md-4  mt-2">
                         <span id="select_categories_update"></span>
                        </div>
                        <div class="col-5 col-sm-4 col-md-2  mt-2">
                            <label for="">Problem Type</label>
                        </div>
                        <div class="col-7 col-sm-8 col-md-4  mt-2">
                          <span id="select_problem_type_update"></span>
                        </div>
                        <div class="col-5 col-sm-4 col-md-2  mt-2">
                            <label for="">Subject</label>
                        </div>
                        <div class="col-7 col-sm-8 col-md-4  mt-2">
                          <span id="subject_update"></span>
                        </div>
                        <div class="col-5 col-sm-4 col-md-2  mt-2">
                            <label for="">Additional Info</label>
                        </div>
                        <div class="col-7 col-sm-8 col-md-10  mt-2 ">
                          <span id="add_info_update"></span>
                        </div>
                    </div>
                
                   
                    <div class="form-group row">
                        <div class="col-12 col-sm-4 col-md-2  mt-2">
                            <label for="">Note</label>
                        </div>
                        <div class="col-12 col-sm-8 col-md-8 ">
                            <span for="" id ="creator" style="text-align: right;float:right"></span>
                            <textarea class="form-control" id="note" rows="2" readonly></textarea>
                            <span  style="color:red;" class="message_error text-red block note_error"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12 col-sm-4 col-md-2 mt-2">
                            <label for="">Progress</label>
                        </div>
                        <div class="col-12 col-sm-8 col-md-4">
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
                        <div class="col-12 col-sm-4 col-md-2  mt-2 mt-2">
                            <label for="">Note PIC</label>
                        </div>
                        <div class="col-12 col-sm-8 col-md-8">
                            <textarea class="form-control" id="note_pic" rows="2"></textarea>
                            <span  style="color:red;" class="message_error text-red block note_pic_error"></span>
                        </div>
                        
                    </div>
                    <input type="hidden" class="form-control" id="picFileName">
                    <div id="attachment_container">
                        <div class="form-group row">
                            <div class="col-12 col-sm-4 col-md-2  mt-2 mt-2">
                                <label for="">Attachment</label>
                            </div>
                            <div class="col-12 col-sm-8 col-md-8 mt-2">
                                <input type="file" class="form-control-file" id="attachmentPIC">
                                <span  style="color:red;" class="message_error text-red block attachmentPIC_error"></span>                                
                            </div>

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