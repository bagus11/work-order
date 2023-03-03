
<div class="modal fade" id="addMasterKantor">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h4 class="modal-title">Form Add Ticket</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <div class="container">
                    <div class="form-group row">
                        <div class="col-12 col-sm-5 col-md-2 mt-2">
                            <label for="">Request Type</label>
                        </div>
                        <div class="col-12 col-sm-7 col-md-4">
                            <select name="select_request_type" class="select2" style="width: 100%" id="select_request_type">
                                <option value="">Choose Request type</option>
                                <option value="RFM">Request For Maintenance</option>
                                <option value="RFP">Request For Project</option>
                            </select>
                            <input type="hidden" id="request_type" class="form-controll">
                        </div>
                        <div class="col-12 col-sm-5 col-md-2 mt-2">
                            <label for="">Request For</label>
                        </div>
                        <div class="col-12 col-sm-7 col-md-4 ">
                            <select name="select_departement" id="select_departement" class="select2" style="width: 100%"></select>
                            <input type="hidden" id="departement_for">
                            <span  style="color:red;" class="message_error text-red block departement_for_error"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12 col-sm-5 col-md-2 mt-2">
                            <label for="">Categories</label>
                        </div>
                        <div class="col-12 col-sm-7 col-md-4">
                            <select name="select_categories" class="select2" style="width: 100%" id="select_categories">
                                <option value="">Choose Departement First</option>
                            </select>
                            <input type="hidden" class="form-control" id="categories">
                            <span  style="color:red;" class="message_error text-red block categories_error"></span>
                        </div>
                        <div class="col-12 col-sm-5 col-md-2 mt-2">
                            <label for="">Problem Type</label>
                        </div>
                        <div class="col-12 col-sm-7 col-md-4">
                            <select name="select_problem_type" class="select2" style="width: 100%" id="select_problem_type">
                                <option value="">Choose Categories First</option>
                            </select>
                            <input type="hidden" class="form-control" id="problem_type">
                            <span  style="color:red;" class="message_error text-red block problem_type_error"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12 col-sm-5 col-md-2 mt-2">
                            <label for="">Subject</label>
                        </div>
                        <div class="col-12 col-sm-7 col-md-6">
                            <input type="text" class="form-control" id="subject">
                            <span  style="color:red;" class="message_error text-red block add_info_error"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12 col-sm-5 col-md-2 mt-2">
                            <label for="">Additional Info</label>
                        </div>
                        <div class="col-12 col-sm-7 col-md-10">
                            <textarea class="form-control" id="add_info" rows="3"></textarea>
                            <span  style="color:red;" class="message_error text-red block add_info_error"></span>
                        </div>
                    </div>
                    {{-- <div class="form-group row">
                        <div class="col-md-2 mt-2">
                            <label for="">Attachment</label>
                        </div>
                        <div class="col-md-10">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="attachment" required>
                                <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                              </div>
                            <span  style="color:red;" class="message_error text-red block attachment_error"></span>
                        </div>
                    </div> --}}
               </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button id="btn_save_wo" type="button" class="btn btn-success">Save</button>
            </div>
        </div>
    </div>
</div>