<div class="modal fade" id="infoFileSharingModal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-core text-white">
                <span id="assetTitle">Add File Sharing</span>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="form_update_file_sharing" enctype="multipart/form-data">
                <div class="modal-body p-0 mx-2">
                    <fieldset>
                        <legend>Basic Information</legend>
                        <div class="row">
                            <input type="hidden" id="edit_id" >
                            <div class="col-2">
                                <p>Title</p>
                            </div>
                            <div class="col-4">
                                <p id="title_label"></p>
                            </div>
                            <div class="col-2">
                                <p>Created At</p>
                            </div>
                            <div class="col-4">
                                <p id="created_at_label"></p>
                            </div>
                            <div class="col-2">
                                <p>Created By</p>
                            </div>
                            <div class="col-4">
                                <p id="created_by_label"></p>
                            </div>
                            <div class="col-2">
                                <p>Department</p>
                            </div>
                            <div class="col-4">
                                <p id="department_label"></p>
                            </div>
                            <div class="col-2">
                                <p>Description</p>
                            </div>
                            <div class="col-10">
                                <p id="description_label"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button id="btn_edit" style="float: right" class=" btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button id="btn_cancel" style="float: right" class=" btn btn-sm btn-danger">
                                    <i class="fas fa-circle-xmark"></i>
                                </button>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="edit_container">
                        <legend>Form Edit File</legend>
                        <div class="row mx-2 mb-2">
                            <div class="col-2">
                                <p>Attachment</p>
                            </div>
                            <div class="col-4">
                                <input type="file" class="form-control" id="attachment_update">
                                <span class="message_error attachment_update_error"></span>
                            </div>
                        </div>
                        <div class="row mx-2"> 
                            <div class="col-2">
                                <p>Remark</p>
                            </div>
                            <div class="col-10">
                                <textarea name="remark" id="remark" cols="30" class="form-control" rows="5"></textarea>
                                <span class="message_error remark_error"></span>
                            </div>
                        </div>
                        <div class="row mx-2 mt-2">
                            <div class="col-12">
                                <button type="submit" class="btn btn-sm btn-success" style="float:right" id="btn_update_file_sharing">
                                    <i class="fas fa-check"></i>
                                </button>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend>Updated Log</legend>
                           <table class="datatable-bordered nowrap display" id="log_table" >
                        <thead>
                            <tr>
                                <th style="text-align:center">Created At</th>
                                <th style="text-align:center">Created By</th>
                                <th style="text-align:center">Remark</th>
                                <th style="text-align:center">Attachment</th>
                            </tr>
                        </thead>
                    </table>
                    </fieldset>
                </div>

                <div class="modal-footer justify-content-end py-1">
                
                </div>
            </form>
        </div>
    </div>
</div>
