
<div class="modal fade" id="addHeadModal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-core">
                <b class="headerTitle">Add Project</b>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="your_path" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="container">
                        <div class="form-group row">
                        <div class="col-2 mt-2">
                                <p>Start Date</p>
                            </div>
                            <div class="col-4">
                                <input type="date" class="form-control" id="start_date" value="{{date('Y-m-d')}}">
                                <span  style="color:red;" class="message_error text-red block start_date_error"></span>
                            </div>
                            <div class="col-2 mt-2">
                                <p for="">Deadline</p>
                            </div>
                            <div class="col-4">
                                <input type="date" class="form-control" id="end_date" value="{{date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "+1 month" ) )}}">
                                <span  style="color:red;" class="message_error text-red block end_date_error"></span>
                            </div>
                            <div class="col-2 mt-2">
                            <p>Name</p>
                            </div>
                            <div class="col-4">
                                <input type="text" class="form-control" id="title">
                                <span  style="color:red;" class="message_error text-red block title_error"></span>
                            </div>
                            <div class="col-2 mt-2">
                                <p>Location</p>
                            </div>
                            <div class="col-4">
                                <select name="select_location" class="select2" id="select_location"></select>
                                <input type="hidden" class="form-control" id="location_id">
                                <span  style="color:red;" class="message_error text-red block location_id_error"></span>
                            </div>
                            <div class="col-2 mt-2">
                                <p>Description</p>
                            </div>
                            <div class="col-10">
                                <textarea class="form-control" id="description" rows="3"></textarea>
                                <span  style="color:red;" class="message_error text-red block description_error"></span>
                            </div>
                            <div class="col-2 mt-2">
                                <p>Attachment</p>
                            </div>
                            <div class="col-4 mt-2">
                            <input type="file" class="form-control-file" id="attachment" required style="font-size: 10px">
                            <span  style="color:red;" class="message_error text-red block attachment_error"></span>
                            </div>
                        
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-end">
                    <button id="btn_save_head" type="submit" class="btn btn-sm btn-success">
                        <i class="fa-solid fa-floppy-disk"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>