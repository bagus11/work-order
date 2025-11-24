

<div class="modal fade" id="checkModal" role="dialog">
    <div class="modal-dialog modal-lg modal-scroll">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <b class="detail_code"></b>
                <button type="button" class="close" data-dismiss="modal" id="btn_close_check_modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mx-2">
                <fieldset class="mx-1">
                    <legend>Detail Task</legend>
                    <div class="row mx-2">
                        <div class="col-2 mt-2">
                            <p>Aspect</p>
                        </div>
                        <div class="col-4 mb-2">
                            <input type="text" class="form-control" id="finish_aspect" disabled>
                        </div>
                        <div class="col-2 mt-2">
                            <p>Module</p>
                        </div>
                        <div class="col-4 mb-2">
                            <input type="text" class="form-control" id="finish_module" disabled>
                        </div>
                        <div class="col-2 mt-2">
                            <p>Data Type</p>
                        </div>
                        <div class="col-4 mb-2">
                            <input type="text" class="form-control" id="finish_data_type" disabled>
                        </div>
                    </div>
                    <div class="row mx-2">
                        <div class="col-2 mt-2">
                            <p>Task</p>
                        </div>
                        <div class="col-10 mb-2">
                            <textarea name="finish_task_text" class="form-control" id="finish_task_text" rows="2" disabled></textarea>
                        </div>
                    </div>
                    <div class="row mx-2">
                         <div class="col-2 mt-2">
                            <p>Remark</p>
                        </div>
                        <div class="col-10 mb-2">
                            <textarea name="finish_remark" id="finish_remark" class="form-control" rows="2" ></textarea>
                            <span class="message_error finish_remark_error"></span>
                        </div>
                        <div class="col-2 mt-2">
                            <p>attachment</p>
                        </div>
                        <div class="col-4 mb-2">
                            <input type="file" class="form-control" id="finish_attachment">
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="modal-footer justify-content-end p-2">
                <button id="finish_task" type="button" class="btn btn-sm btn-success">
                    <i class="fas fa-check"></i>
                </button>
            </div>
        </div>
    </div>
</div>