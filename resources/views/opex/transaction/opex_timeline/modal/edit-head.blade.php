
<div class="modal fade" id="editHeadModal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-core">
                <b class="headerTitle">Detail Project</b>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
        
                <div class="modal-body">
                    <div class="container">
                        <div class="form-group row">
                        <div class="col-2 mt-2">
                                <p>Start Date</p>
                            </div>
                            <div class="col-4">
                                <input type="date" class="form-control" disabled id="start_date_edit" value="{{date('Y-m-d')}}">
                                <span  style="color:red;" class="message_error text-red block start_date_edit_error"></span>
                            </div>
                            <div class="col-2 mt-2">
                                <p for="">Deadline</p>
                            </div>
                            <div class="col-4">
                                <input type="date" class="form-control" id="end_date_edit" value="{{date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "+1 month" ) )}}">
                                <span  style="color:red;" class="message_error text-red block end_date_edit_error"></span>
                            </div>
                            <div class="col-2 mt-2">
                            <p>Name</p>
                            </div>
                            <div class="col-4">
                                <input type="hidden" class="form-control" id="request_code">
                                <input type="text" class="form-control" id="title_edit">
                                <span  style="color:red;" class="message_error text-red block title_edit_error"></span>
                            </div>
                            <div class="col-2 mt-2">
                                <p>Location</p>
                            </div>
                            <div class="col-4">
                                <select name="select_location_edit" class="select2" id="select_location_edit" disabled></select>
                            </div>
                            <div class="col-2 mt-2">
                                <p>Description</p>
                            </div>
                            <div class="col-10">
                                <textarea class="form-control" id="description_edit" rows="3"></textarea>
                                <span  style="color:red;" class="message_error text-red block description_edit_error"></span>
                            </div>
                            <div class="col-2 mt-2">
                                <p>Created By</p>
                            </div>
                            <div class="col-4 mt-2">
                                <p id="created_by"></p>
                            </div>
                            <div class="col-2 mt-2">
                                <p>Attachment</p>
                            </div>
                            <div class="col-4 mt-2">
                                <div id="attachment_container"></div>
                            </div>
                        
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-end">
                    <button id="btn_update_head" type="submit" class="btn btn-sm btn-success">
                        <i class="fa-solid fa-floppy-disk"></i>
                    </button>
                </div>
        </div>
    </div>
</div>