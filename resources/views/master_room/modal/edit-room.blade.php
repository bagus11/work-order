
<div class="modal fade" id="editRoomModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h4 class="modal-title">Edit Room</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <div class="container">
                <div class="form-group row">
                    <div class="col-md-3 mt-2">
                        <label for="">Location</label>
                    </div>
                    <input type="hidden" id="id">
                    <div class="col-md-8">
                        <select name="" id="edit_select_location" class="select2">

                        </select>
                        <input type="hidden" class="form-control" id="edit_location_id">
                        <span  style="color:red;" class="message_error text-red block edit_location_id_error"></span>
                    </div>
                </div>
                    <div class="form-group row">
                        <div class="col-md-3 mt-2">
                            <label for="">Name</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="edit_name">
                            <span  style="color:red;" class="message_error text-red block edit_name_error"></span>
                        </div>
                    </div>
                   
               </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button id="btn_update_room" type="button" class="btn btn-success">
                    <i class="fas fa-check"></i>
                </button>
            </div>
        </div>
    </div>
</div>