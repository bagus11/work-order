
<div class="modal fade" id="addRoomModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h4 class="modal-title">Add Room</h4>
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
                    <div class="col-md-8">
                        <select name="" id="select_location" class="select2">

                        </select>
                        <input type="hidden" class="form-control" id="location_id">
                        <span  style="color:red;" class="message_error text-red block location_id_error"></span>
                    </div>
                </div>
                    <div class="form-group row">
                        <div class="col-md-3 mt-2">
                            <label for="">Name</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="name">
                            <span  style="color:red;" class="message_error text-red block name_error"></span>
                        </div>
                    </div>
                   
               </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button id="btn_save_room" type="button" class="btn btn-success">
                    <i class="fas fa-check"></i>
                </button>
            </div>
        </div>
    </div>
</div>