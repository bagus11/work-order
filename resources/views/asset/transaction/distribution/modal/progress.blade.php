
<div class="modal fade" id="progressModal">
    <div class="modal-dialog modal-lg  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-core">
                <span>Confirmation Asset Progress </span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <form class="form" id="progress_form" enctype="multipart/form-data">
            <div class="modal-body p-0 mx-2 mb-2">
                <fieldset>
                        <legend>Confirmation Form</legend>
                            <div class="row">
                                <div class="col-2 mt-2">
                                    <p>Notes</p>
                                </div>
                                <div class="col-10">
                                    <textarea name="ict_notes_progress" class="form-control mb-2" id="ict_notes_progress" cols="30" rows="10"></textarea>
                                    <span  style="color:red;font-size:9px" class="message_error text-red block ict_notes_progress_error"></span>
                                </div>
                                <div class="col-2 mt-2">
                                    <p>Attachment</p>
                                </div>
                                <div class="col-4">
                                    <input type="file" class="form-control" id="ict_progress_attachment">
                                    <span  style="color:red;font-size:9px" class="message_error text-red block ict_progress_attachment_error"></span>
                                </div>
                            </div>
                            <div class="mt-2 justify-content-end">
                                <button class="btn btn-sm btn-success" style="float: right" id="btn_progress_asset" type="submit">
                                    <i class="fas fa-check"></i>
                                </button>
                            </div>
                </fieldset>
            </div>
        </form>
        </div>
    </div>
</div>
