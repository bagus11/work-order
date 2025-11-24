<div class="modal fade" id="detailDistributionModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-core">
                <span>Detail Ticket</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body p-0">
                <ul class="nav nav-tabs px-3 pt-3" id="mainTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="general-tab" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="true">General Information</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="asset-tab" data-toggle="tab" href="#asset" role="tab" aria-controls="asset" aria-selected="false">Log Transaction</a>
                    </li>
                </ul>

                <div class="tab-content p-3" id="mainTabContent">
                    <!-- General Information Tab -->
                    <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                        <!-- Fieldset General Information -->
                        <fieldset class="mb-4">
                            <legend>General Information</legend>
                            <div class="row">
                                <div class="col-2"><p>Request Code</p></div>
                                <input type="hidden" id="request_code_id">
                                <div class="col-4"><p id="ict_request_code"></p></div>
                                <div class="col-2"><p>Request Type</p></div>
                                <div class="col-4"><p id="ict_request_type"></p></div>
                                <div class="col-2"><p>Current Location</p></div>
                                <div class="col-4"><p id="ict_current_location"></p></div>
                                <div class="col-2"><p>Des Location</p></div>
                                <div class="col-4"><p id="ict_destination_location"></p></div>
                                <div class="col-2"><p>Current User</p></div>
                                <div class="col-4"><p id="ict_current_user"></p></div>
                                <div class="col-2"><p>Receiver User</p></div>
                                <div class="col-4"><p id="ict_receiver_user"></p></div>
                                <div class="col-2"><p>Attachment</p></div>
                                <div class="col-4"><p id="ict_attachment"></p></div>
                            </div>
                            <div class="row">
                                <div class="col-2"><p>Notes</p></div>
                                <div class="col-10"><p id="ict_notes"></p></div>
                            </div>
                            <div class="row mt-2 mx-1">
                                <div class="col-12">
                                    <button class="btn btn-warning btn-sm" style="float: right;" id="ict_progress_btn">
                                        <i class="fa-solid fa-paper-plane"></i> Progress Asset
                                    </button>
                                    <button class="btn btn-info btn-sm" style="float: right;" id="ict_incoming_btn">
                                        <i class="fa-solid fa-dolly"></i> Incoming Shipment
                                    </button>
                                </div>
                            </div>
                        </fieldset>
       
                           <!-- Fieldset Asset Information -->
                        <fieldset class="mb-4">
                            <legend>Asset Information</legend>
                            <div class="row">
                                <div class="col-12">
                                    <table class="table table-bordered" id="ict_asset_table">
                                        <thead>
                                            <tr>
                                                <th>Asset Code</th>
                                                <th>Category</th>
                                                <th>Brand</th>
                                                <th>Type</th>
                                                <th>Condition</th>
                                                <th>Status</th>
                                                <th>Attachment</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </fieldset>

                        <!-- Fieldset Detail Asset -->
                        <fieldset class="border p-3" id="ict_asset_fieldset">
                            <legend class="w-auto px-2">Detail Asset</legend>
                            <div id="ict_asset_info"></div>
                        </fieldset>


                    </div>

                    <!-- Asset Information Tab -->
                    <div class="tab-pane fade" id="asset" role="tabpanel" aria-labelledby="asset-tab">
                            <!-- Fieldset Log Transaction -->
                        <fieldset class="border p-3">
                            <legend class="w-auto px-2">Log Transaction</legend>
                            <div class="form-group">
                                <div id="ict_log_list"></div>
                            </div>
                        </fieldset>
                        
                    </div>
                </div>
            </div>

            <div class="modal-footer justify-content-end py-1">
                <!-- Optional buttons -->
            </div>
        </div>
    </div>
</div>

<style>
    .modal-xl-custom {
        max-width: 98% !important;
        margin: 1.75rem auto;
    }
</style>
