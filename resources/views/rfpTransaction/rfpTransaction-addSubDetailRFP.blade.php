
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
                       <div class="card">
                        <div class="card-header">
                            <p for="">RFP Detail</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2 mt-2">
                                    <p for="">Detail Code</p>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" style="text-align: center" readonly class="form-control" id="detailCodeRFPDetail">
                                </div>
                                <div class="col-md-2 mt-2">
                                    <p for="">Request Code</p>
                                </div>
                                <div class="col-md-4">
                                    <input type="hidden" name="idRFPDetail" id="idRFPDetail">
                                    <input type="text" style="text-align: center" readonly class="form-control" id="requestCodeRFPDetail">
                                </div>
                          
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-2 mt-2">
                                    <p for="">Activity</p>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" readonly class="form-control" style="text-align: center" name="activityRFPDetail" id="activityRFPDetail">
                                </div>
                                <div class="col-md-2 mt-2">
                                    <p for="">Request By</p>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" readonly class="form-control" name="requestBySubDetail" id="requestBySubDetail">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-2 mt-2">
                                    <p for="">Start Date</p>
                                </div>
                                <div class="col-md-4">
                                    <input type="date" readonly class="form-control" name="startDateRFPSubDetail" id="startDateRFPSubDetail">
                                </div>
                                <div class="col-md-2 mt-2">
                                    <p for="">Deadline</p>
                                </div>
                                <div class="col-md-4">
                                    <input type="date" readonly class="form-control" name="deadlineRFPSubDetail" id="deadlineRFPSubDetail">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12">
                                    <div class="card collapsed-card">
                                        <div class="card-header">
                                            List Sub Module
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <table class="datatable-bordered nowrap display" id="rfpSubModuleTable">
                                                <thead>
                                                    <tr>
                                                        <th style="text-align:center">Start Date</th>
                                                        <th style="text-align:center">Deadline</th>
                                                        <th style="text-align:center">Activity</th>
                                                        <th style="text-align:center">PIC</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                       </div>
                       <div class="card">
                        <div class="card-header">
                            <p for="">RFP Sub Module</p>
                        </div>
                        <div class="card-body">
                            <div class="row mt-2">
                                <div class="col-md-2 mt-2">
                                    <p for="">Activity</p>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="activitySubDetail" id="activitySubDetail">
                                    <span  style="color:red;" class="message_error text-red block activitySubDetail_error"></span>
                                </div>
                                <div class="col-md-2 mt-2">
                                    <p for="">PIC</p>
                                </div>
                                <div class="col-md-4">
                                    <select name="selectPICSubDetail" class="select2" id="selectPICSubDetail"></select>
                                    <input type="hidden" name="userIdSubDetail" id="userIdSubDetail">
                                </div>
                            </div>
                          
                            <div class="row mt-2">
                                <div class="col-md-2 mt-2">
                                    <p for="">Description</p>
                                </div>
                                <div class="col-md-10">
                                    <textarea class="form-control" id="descriptionSubDetail" rows="3"></textarea>
                                    <span  style="color:red;" class="message_error text-red block descriptionSubDetail_error"></span>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-2 mt-2">
                                    <p for="">Start Date</p>
                                </div>
                                <div class="col-md-4">
                                    <input type="date" id="startDateSubDetail" style="text-align:center" class="form-control" valu="{{date('Y-m-d')}}">
                                    <span  style="color:red;" class="message_error text-red block startDateSubDetail_error"></span>
                                </div>
                                <div class="col-md-2 mt-2">
                                    <p for="">Deadline</p>
                                </div>
                                <div class="col-md-4">
                                    <input type="date" id="datelineSubDetail" style="text-align:center" class="form-control" value="{{date('Y-m-d')}}">
                                    <span  style="color:red;" class="message_error text-red block datelineSubDetail_error"></span>
                                </div>
                               
                            </div>
                            <div class="row mt-2">
                                <div class="col-12">
                                    <input type="hidden"  id="idSubArrayDetail">
                                    <table class="datatable-bordered nowrap display" id="SubdetailRFPTable">
                                        <thead>
                                            <tr>
                                                <th style="text-align:center">Detail Code</th>
                                                <th style="text-align:center">Activity</th>
                                                <th style="text-align:center">Start Date</th>
                                                <th style="text-align:center">Dateline</th>
                                                <th style="text-align:center">PIC</th>
                                                <th style="text-align:center">Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                              <button class="btn btn-success btn-sm" style="float:right" id="btnAddArraySubDetail">
                                  <i class="fas fa-plus"></i>
                              </button>
                              <button class="btn btn-info btn-sm" style="float:right" id="btnEditArraySubDetail">
                                  <i class="fas fa-check"></i>
                              </button>
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