

<div class="modal fade" id="editSystemModal" role="dialog">
    <div class="modal-dialog modal-lg modal-scroll">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title"> Detail About Ticket</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mx-2">
                <fieldset class="mx-1">
                    <legend>General Information About Ticket</legend>
                    <div class="row mx-2">
                        <div class="col-2 mt-2">
                            <p>Ticket Code</p>
                        </div>
                        <div class="col-4">
                            <input type="text" class="form-control" id="edit_ticket_code" disabled>
                        </div>
                        <div class="col-2 mt-2">
                            <p>Created By</p>
                        </div>
                        <div class="col-4">
                            <input type="text" class="form-control" id="edit_created_by" disabled>
                        </div>
                    </div>
                    <div class="row mx-2">
                        <div class="col-2 mt-2">
                            <p>Subject</p>
                        </div>
                        <div class="col-4">
                            <input type="text" class="form-control" id="edit_subject" disabled>
                        </div>
                        <div class="col-2 mt-2">
                            <p>Created At</p>
                        </div>
                        <div class="col-4">
                            <input type="datetime" class="form-control" id="edit_created_at" disabled>
                        </div>
                    </div>
                    <div class="row mx-2">
                        <div class="col-2 mt-2">
                            <p>Additional Info</p>
                        </div>
                        <div class="col-10">
                            <textarea name="edit_add_info" disabled class="form-control" id="edit_add_info" rows="5"></textarea>
                        </div>
                    </div>
                </fieldset> 
                <fieldset class="mx-1">
                    <legend>Detail Task</legend>
                    <div class="row p-0">
                        <div class="col-12" id="detail_ticket_container">
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="modal-footer justify-content-end p-2">
              
            </div>
        </div>
    </div>
</div>