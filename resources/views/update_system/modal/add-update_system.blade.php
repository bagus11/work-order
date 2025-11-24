

<div class="modal fade" id="addSystemModal" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title">Form Request</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <fieldset class="mx-1">
                    <legend>General Transaction</legend>
                       <div class="row mt-3 mx-1 mb-2">
                        <div class="col-2 mt-2">
                            <p>Subject</p>
                        </div>
                        <div class="col-4 mb-2">
                             <input type="text" class="form-control" id="subject">
                            <span class="message_error subject_error"></span>
                        </div>
                    </div>
                    <div class="row mx-2 mb-2">
                          <div class="col-2 mt-2">
                            <p>Additional Info</p>
                        </div>
                        <div class="col-10">
                            <textarea name="add_info" id="add_info" class="form-control" cols="30" rows="2"></textarea>
                             <span class="message_error add_info_error"></span>
                        </div>
                    </div>
                </fieldset>
                 <fieldset>
                        <legend>Detail Transaction</legend>
                            <div class="row mx-2">
                                <div class="col-2 mt-2">
                                    <p>Aspect</p>
                                </div>
                                <div class="col-4 mb-2">
                                    <select class="select2" name="select_aspect" id="select_aspect"></select>
                                    <input type="hidden" id="aspect">
                                    <span class="message_error aspect_error"></span>
                                </div>
                                <div class="col-2 mt-2">
                                    <p>Module</p>
                                </div>
                                <div class="col-4 mb-2">
                                    <select class="select2" name="select_module" id="select_module">
                                        <option value="">Choose Aspect First</option>
                                    </select>
                                    <input type="hidden" id="module">
                                    <span class="message_error module_error"></span>
                                </div>
                                <div class="col-2 mt-2">
                                    <p>Data Type</p>
                                </div>
                                <div class="col-4 mb-2">
                                    <select class="select2" name="select_data_type" id="select_data_type">
                                        <option value="">Choose Module First</option>
                                    </select>
                                    <input type="hidden" id="data_type">
                                    <span class="message_error data_type_error"></span>
                                </div>
                                <div class="col-2 mt-2">
                                    <p>Request Type</p>
                                </div>
                                <div class="col-4 mb-2">
                                    <select class="select2" name="select_request_type" id="select_request_type">
                                        <option value="">Choose Request Type</option>
                                        <option value="1">Adding Data</option>
                                        <option value="2">Updating Data</option>
                                    </select>
                                    <input type="hidden" id="request_type">
                                    <span class="message_error request_type_error"></span>
                                </div>
                                <div class="col-2 mt-2">
                                    <p>Remark</p>
                                </div>
                                <div class="col-10 mb-2">
                                    <input type="hidden" id="uploaded_images" value="">
                                    <textarea name="remark" class="form-control" id="remark" cols="30" rows="5"></textarea>
                                    <span class="message_error remark_error"></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button class="btn btn-sm btn-primary" id="btn_add_array" style="float: right">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                             <div class="row mt-3 mx-1">
                                <div class="col-12">
                                    <table class="table table-bordered table-sm" id="arrayTable">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>No</th>
                                                <th>Aspect</th>
                                                <th>Module</th>
                                                <th>Data Type</th>
                                                <th>Request Type</th>
                                                <th>Subject</th>
                                                <th>Image</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                    </fieldset>

            </div>
            <div class="modal-footer justify-content-end p-2">
                <button id="btn_save_ticket" type="button" class="btn btn-sm btn-success">
                    <i class="fas fa-check"></i>
                </button>
            </div>
        </div>
    </div>
</div>
<style>
    #addSystemModal .modal-body {
    max-height: 90vh; /* tinggi maksimal modal body */
    overflow-y: auto; /* biar bisa scroll */
}
</style>