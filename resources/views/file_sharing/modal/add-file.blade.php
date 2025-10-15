<div class="modal fade" id="addFileSharingModal">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-core text-white">
                <span id="assetTitle">Add File Sharing</span>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="form_add_file_sharing" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-0">
                    <div class="row mx-2 my-2">
                        <div class="col-4 mt-2">
                            <p>Title</p>
                        </div>
                        <div class="col-8">
                            <input type="text" class="form-control" id="title" name="title">
                            <span class="message_error text-danger title_error"></span>
                        </div>

                        <div class="col-4 mt-2">
                            <p>Department</p>
                        </div>
                        <div class="col-8">
                            <select name="department_id" class="form-control select2" id="select_department"></select>
                            <span class="message_error text-danger department_error"></span>
                        </div>

                        <div class="col-4 mt-2">
                            <p>Attachment</p>
                        </div>
                        <div class="col-8">
                            <input type="file" class="form-control" id="attachment" name="attachment">
                            <span class="message_error text-danger attachment_error"></span>
                        </div>

                        <div class="col-4 mt-2">
                            <p>Description</p>
                        </div>
                        <div class="col-8">
                            <textarea name="description" class="form-control" id="description" cols="30" rows="4"></textarea>
                            <span class="message_error text-danger description_error"></span>
                        </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-end py-1">
                    <button type="submit" class="btn btn-sm btn-success" id="btn_save_file_sharing">
                        <i class="fas fa-check"></i> Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
