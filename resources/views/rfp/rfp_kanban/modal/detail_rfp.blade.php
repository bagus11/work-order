
<div class="modal fade" id="detailKanbanModal">
    <div class="modal-dialog modal-lg  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-core">
                <span id="detail_label"></span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <fieldset class="scheduler-border">
                    <legend class="scheduler-border"> Detail Module</legend>
                    <fieldset class="scheduler-border">
                        <legend class="scheduler-border"> General Module</legend>
                        <div class="row">
                           <div class="col-5 col-sm-5 col-md-2  mt-2">
                               <p> Request Code</p>
                            </div>
                            <div class="col-7 col-sm-7 col-md-4  mt-2">
                                <p id="request_code_kanban"></p>
                            </div>
                           <div class="col-5 col-sm-5 col-md-2  mt-2">
                                <p>Detail Code</p>
                            </div>
                            <div class="col-7 col-sm-7 col-md-4  mt-2">
                                <p id="detail_code_kanban"></p>
                            </div>
                           <div class="col-5 col-sm-5 col-md-2  mt-2">
                                <p>Title</p>
                            </div>
                            <div class="col-7 col-sm-7 col-md-4  mt-2">
                                <p id="title_kanban"></p>
                            </div>
                           <div class="col-5 col-sm-5 col-md-2  mt-2">
                                <p>Status</p>
                            </div>
                            <div class="col-7 col-sm-7 col-md-4  mt-2">
                                <p id="status_kanban"></p>
                            </div>
                           <div class="col-5 col-sm-5 col-md-2  mt-2">
                                <p>Percentage</p>
                            </div>
                            <div class="col-7 col-sm-7 col-md-4  mt-2">
                                <p id="percentage_kanban"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-5 col-sm-5 col-md-2  mt-2">
                                <p>Description</p>
                            </div>
                            <div class="col-7 col-sm-7 col-md-10  mt-2">
                                <p id="description_kanban"></p>
                            </div>
                        </div>
                    </fieldset>
                    <table class="datatable-bordered nowrap display " id="subDetailTable">
                        <thead>
                            <tr>
                                <th style="text-align:center"></th>
                                <th style="text-align:center">Title</th>
                                <th style="text-align:center">PIC</th>
                            </tr>
                        </thead>
                    </table>
                </fieldset>
                <div class="mt-2">
                    <fieldset class="scheduler-border">
                        <legend class="scheduler-border">Comment Activity</legend>
                        <input type="hidden" id="detail_code_chat">
                        <input type="hidden" id="request_code_chat">
                        <div class="container" id="chat_container">
                        </div>
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">Enter Comment Here</legend>
                            <div class="row">
                                <div class="col-11">
                                    <textarea class="form-control" id="add_remark" rows="3"></textarea>
                                    <span  style="color:red;" class="message_error text-red block add_remark_error"></span>
                                </div>
                                <div class="col-1">
                                    <button class="btn btn-success mt-2" title="send" id="send_chat">
                                        <i class="fa-solid fa-paper-plane"></i>
                                    </button>
                                </div>
                            </div>
                        </fieldset>
                    </fieldset>
                 
                </div>
                
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<style>
    p{
      font-size: 9px !important;
    }
</style>