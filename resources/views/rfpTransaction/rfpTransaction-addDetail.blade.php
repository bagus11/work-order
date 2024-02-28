
<div class="modal fade" id="addRFPDetail">
    <div class="modal-dialog modal-lg  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                Add Detail Request
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              
                    <div class="container">
                        <div class="card">
                            <div class="card-header">
                                <p class="mt-2" style="font-size:12px"> RFP Master</p>                    
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2 mt-2">
                                        <p for="">Request Code</p>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="hidden" name="rfpIdDetail" id="rfpIdDetail">
                                        <input type="text" style="text-align: center" readonly class="form-control" id="requestCodeDetail">
                                    </div>
                                    <div class="col-md-2 mt-2">
                                        <p for="">Departement</p>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" style="text-align: center" readonly class="form-control" id="departementDetail">
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-2 mt-2">
                                        <p for="">Title</p>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" readonly class="form-control" style="text-align: center" name="titleDetail" id="titleDetail">
                                    </div>
                                    <div class="col-md-2 mt-2">
                                        <p for="">Location</p>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" readonly class="form-control" name="locationDetail" id="locationDetail">
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-2 mt-2">
                                        <p for="">Category</p>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" readonly class="form-control" name="categoryDetail" id="categoryDetail">
                                    </div>
                                    <div class="col-md-2 mt-2">
                                        <p for="">Request By</p>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" readonly class="form-control" name="userNameDetail" id="userNameDetail">
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-2 mt-2">
                                        <p for="">Start Date</p>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="date" readonly class="form-control" name="startDateMaster" id="startDateMaster">
                                    </div>
                                    <div class="col-md-2 mt-2">
                                        <p for="">Deadline</p>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="date" readonly class="form-control" name="deadlineMaster" id="deadlineMaster">
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <div class="card collapsed-card">
                                        <div class="card-header">
                                            List Module
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <table class="datatable-bordered nowrap display" id="rfpModuleTable">
                                                <thead>
                                                    <tr>
                                                        <th style="text-align:center">Start Date</th>
                                                        <th style="text-align:center">Deadline</th>
                                                        <th style="text-align:center">Activity</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <p style="font-size: 12px">RFP Module</p>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2 mt-2">
                                        <p for="">Activity</p>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="activityDetail" id="activityDetail">
                                        <span  style="color:red;" class="message_error text-red block activityDetail_error"></span>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-2 mt-2">
                                        <p for="">Description</p>
                                    </div>
                                    <div class="col-md-10">
                                        <textarea class="form-control" id="descriptionDetail" rows="3"></textarea>
                                        <span  style="color:red;" class="message_error text-red block descriptionDetail_error"></span>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-2 mt-2">
                                        <p for="">Start Date</p>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="date" id="startDateDetail" class="form-control" value="{{date('Y-m-d')}}" >
                                    </div>
                                    <div class="col-md-2 mt-2">
                                        <p for="">Deadline</p>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="date" id="datelineDetail" class="form-control" value="{{date('Y-m-d')}}">
                                        <span  style="color:red;" class="message_error text-red block datelineDetail_error"></span>
                                    </div>
                               
                                </div>
                            </div>
                            <div class="card-footer justify-content-end">
                                <button class="btn btn-success btn-sm" style="float:right" id="btnAddArrayDetail">
                                    <i class="fas fa-plus"></i>
                                </button>
                                <button class="btn btn-info btn-sm " style="float:right" id="btnEditArrayDetail">
                                    <i class="fas fa-check"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card" id="listDetailRFPTable">
                            <div class="card-header">
                                <p for="" style="font-size:12px">List</p>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <input type="hidden" class="form-control" id="idArrayDetail">
                                        <table class="datatable-bordered nowrap display" id="detailRFPTable">
                                            <thead>
                                                <tr>
                                                    <th style="text-align:center">Request Code</th>
                                                    <th style="text-align:center">Activity</th>
                                                    <th style="text-align:center">Start Date</th>
                                                    <th style="text-align:center">Deadline</th>
                                                    <th style="text-align:center">Action</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
               </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button id="btnSaveRFPDetail" type="button" class="btn btn-success">Save changes</button>
            </div>
        </div>
    </div>
</div>