
<div class="modal fade" id="addSubDetailRFP">
    <div class="modal-dialog modal-lg  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h4 class="modal-title">Add Sub Detail Request</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-2 mt-2">
                                <label for="">Detail Code</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" style="text-align: center" readonly class="form-control" id="detailCodeRFPDetail">
                            </div>
                            <div class="col-md-2 mt-2">
                                <label for="">Request Code</label>
                            </div>
                            <div class="col-md-4">
                                <input type="hidden" name="idRFPDetail" id="idRFPDetail">
                                <input type="text" style="text-align: center" readonly class="form-control" id="requestCodeRFPDetail">
                            </div>
                      
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-2 mt-2">
                                <label for="">Activity</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" readonly class="form-control" style="text-align: center" name="activityRFPDetail" id="activityRFPDetail">
                            </div>
                            <div class="col-md-2 mt-2">
                                <label for="">Request By</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" readonly class="form-control" name="requestBySubDetail" id="requestBySubDetail">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-2 mt-2">
                                <label for="">Start Date</label>
                            </div>
                            <div class="col-md-4">
                                <input type="date" readonly class="form-control" name="startDateRFPSubDetail" id="startDateRFPSubDetail">
                            </div>
                            <div class="col-md-2 mt-2">
                                <label for="">Deadline</label>
                            </div>
                            <div class="col-md-4">
                                <input type="date" readonly class="form-control" name="deadlineRFPSubDetail" id="deadlineRFPSubDetail">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-2 mt-2">
                                <label for="">Activity Detail</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="activitySubDetail" id="activitySubDetail">
                                <span  style="color:red;" class="message_error text-red block activitySubDetail_error"></span>
                            </div>
                            <div class="col-md-2 mt-2">
                                <label for="">PIC</label>
                            </div>
                            <div class="col-md-4">
                                <select name="selectPICSubDetail" class="select2" id="selectPICSubDetail"></select>
                                <input type="hidden" name="userIdSubDetail" id="userIdSubDetail">
                            </div>
                        </div>
                      
                        <div class="row mt-2">
                            <div class="col-md-2 mt-2">
                                <label for="">Description</label>
                            </div>
                            <div class="col-md-10">
                                <textarea class="form-control" id="descriptionSubDetail" rows="3"></textarea>
                                <span  style="color:red;" class="message_error text-red block descriptionSubDetail_error"></span>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-2 mt-2">
                                <label for="">Start Date</label>
                            </div>
                            <div class="col-md-4">
                                <input type="date" id="startDateSubDetail" class="form-control" value="{{date('Y-m-d')}}">
                                <span  style="color:red;" class="message_error text-red block startDateSubDetail_error"></span>
                            </div>
                            <div class="col-md-2 mt-2">
                                <label for="">Deadline</label>
                            </div>
                            <div class="col-md-4">
                                <input type="date" id="datelineSubDetail" class="form-control" value="{{date('Y-m-d')}}">
                                <span  style="color:red;" class="message_error text-red block datelineSubDetail_error"></span>
                            </div>
                           
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-1 offset-11 mt-2">
                                <button class="btn btn-success" id="btnAddArraySubDetail">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <table class="datatable-bordered nowrap display" id="SubdetailRFPTable">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center">Detail Code</th>
                                            <th style="text-align:center">Activity</th>
                                            <th style="text-align:center">Start Date</th>
                                            <th style="text-align:center">Dateline</th>
                                            <th style="text-align:center">User ID</th>
                                            <th style="text-align:center">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
               </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button id="btnSaveSubDetailRFP" type="button" class="btn btn-success">Save changes</button>
            </div>
        </div>
    </div>
</div>