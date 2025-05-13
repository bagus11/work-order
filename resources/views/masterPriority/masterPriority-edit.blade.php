
<div class="modal fade" id="editPriority">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h4 class="modal-title">Edit Priority</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <div class="container">
                    <div class="form-group row">
                        <div class="col-md-4 mt-2">
                            <label for="">Name</label>
                        </div>
                        <div class="col-md-8">
                            <input type="hidden" class="form-control" id="id">
                            <input type="text" class="form-control" id="nameUpdate">
                            <span  style="color:red;" class="message_error text-red block nameUpdate_error"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4 mt-2">
                            <label for="">Duration</label>
                        </div>
                        <div class="col-md-4">
                            <input type="number" class="form-control" style="text-align:center" id="durationUpdate">
                            <span  style="color:red;" class="message_error text-red block durationUpdate_error"></span>
                        </div>
                        <div class="col-md-2 mt-2">
                        <label for="">Hour</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4 mt-2">
                            <label for="">Duration Lv 2</label>
                        </div>
                        <div class="col-md-4">
                            <input type="number" class="form-control" style="text-align:center" id="duration_lv2Update">
                            <span  style="color:red;" class="message_error text-red block duration_lv2Update_error"></span>
                        </div>
                        <div class="col-md-2 mt-2">
                        <label for="">Hour</label>
                        </div>
                    </div>
                   
               </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button id="btnEditPriority" type="button" class="btn btn-success">Save changes</button>
            </div>
        </div>
    </div>
</div>