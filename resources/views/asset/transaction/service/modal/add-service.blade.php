<div class="modal fade" id="addServiceModal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-core">
                <span>Form Add Service Asset</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="form_serialize" enctype="multipart/form-data">
                <div class="modal-body p-0">
                    <!-- Request Code -->
                    <div class="row mx-2 my-2">
                        <div class="col-2 mt-2">
                            <p>Request Code</p>
                        </div>
                        <div class="col-4">
                            <select class="select2" name="select_request_code" id="select_request_code"></select>
                            <input type="text" id="request_code_id" name="request_code_id">
                            <span class="message_error request_code_id_error"></span>
                        </div>
                    </div>

                    <!-- Request Code Info -->
                    <div class="row mx-2" id="request_code_info">
                        <div class="col-12">
                            <fieldset>
                                <legend>Information About Ticket</legend>
                                <div class="row">
                                    <div class="col-2"><p>User Request</p></div>
                                    <div class="col-4"><p id="label_user_request"></p></div>

                                    <div class="col-2"><p>Location</p></div>
                                    <div class="col-4"><p id="label_location"></p></div>

                                    <div class="col-2"><p>Category</p></div>
                                    <div class="col-4"><p id="label_category"></p></div>

                                    <div class="col-2"><p>Problem Type</p></div>
                                    <div class="col-4"><p id="label_problem_type"></p></div>

                                    <div class="col-2"><p>Subject</p></div>
                                    <div class="col-4"><p id="label_subject"></p></div>

                                    <div class="col-2"><p>PIC Support</p></div>
                                    <div class="col-4"><p id="label_pic_support"></p></div>

                                    <div class="col-2"><p>Status</p></div>
                                    <div class="col-4"><p id="label_status"></p></div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-2"><p>Additional Info</p></div>
                                    <div class="col-10"><p id="label_additional_info"></p></div>

                                    <div class="col-2"><p>Attachment</p></div>
                                    <div class="col-4"><p id="label_attachment"></p></div>
                                </div>

                                <fieldset>
                                    <legend>Asset User </legend>
                                     <div class="row">
                                        <div class="col-12">
                                            <table id="array_table_asset" class="table table-bordered table-striped table-sm mt-2">
                                                <thead>
                                                    <tr>
                                                        <th style="text-align:center"></th>
                                                        <th style="text-align:center">Asset Code</th>
                                                        <th style="text-align:center">Category</th>
                                                        <th style="text-align:center">Type</th>
                                                        <th style="text-align:center">Brand</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                                
                                            </table>
                                        </div>
                                     </div>
                                </fieldset>
                            </fieldset>
                        </div>
                    </div>

                    <!-- Service Form Inputs -->
                    <div class="row mx-2 mt-2">
                        <div class="col-2 mt-2">
                            <p>Subject</p>
                        </div>
                        <div class="col-4">
                            <input type="text" id="subject" name="subject" class="form-control">
                            <input type="hidden" id="location_id" name="location_id" class="form-control">
                            <input type="hidden" id="department_id" name="department_id" class="form-control">
                            <span class="message_error subject_error"></span>
                        </div>

                        <div class="col-2 mt-2">
                            <p>Attachment</p>
                        </div>
                        <div class="col-4">
                            <input type="file" id="attachment" name="attachment" class="form-control" 
                                   accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.jpg,.jpeg,.png">
                            <span class="message_error attachment_error"></span>
                        </div>

                        <div class="col-2 mt-2">
                            <p>Description</p>
                        </div>
                        <div class="col-10">
                            <textarea id="description" name="description" class="form-control" rows="6"></textarea>
                            <span class="message_error description_error"></span>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer justify-content-end py-1">
                    <button type="submit" id="btn_save_service" class="btn btn-sm btn-success">
                        <i class="fas fa-check"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
