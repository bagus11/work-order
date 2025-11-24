<div class="modal fade" id="detailServiceModal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-core">
                <span>Detail Service Ticket</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
         
                <div class="modal-body p-0">
                   <div class="row mx-2">
                    <div class="col-12">
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                              <button class="nav-link active" id="nav-home-tab" data-toggle="tab" data-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">General Information</button>
                              <button class="nav-link" id="nav-profile-tab" data-toggle="tab" data-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Detail Information</button>
                            </div>
                          </nav>
                          <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                <div class="row my-2">
                                    <div class="col-12">
                                        <input type="hidden" id="service_code" name="service_code">
                                        <input type="hidden" id="asset_code_detail" name="asset_code_detail">
                                           <fieldset>
                                                <legend>General Information About Ticket</legend>
                                                <div class="row">
                                                    <div class="col-2">
                                                        <p>Service Code</p>
                                                    </div>
                                                    <div class="col-4">
                                                        <p id="detail_service_code"></p>
                                                    </div>
                                                    <div class="col-2">
                                                        <p>Created By</p>
                                                    </div>
                                                    <div class="col-4">
                                                        <p id="detail_created_by"></p>
                                                    </div>
                                                    <div class="col-2">
                                                        <p>Request Code</p>
                                                    </div>
                                                    <div class="col-4">
                                                        <p id="detail_request_code"></p>
                                                    </div>
                                                    <div class="col-2">
                                                        <p>Asset Code</p>
                                                    </div>
                                                    <div class="col-4">
                                                        <p id="detail_asset_code"></p>
                                                    </div>
                                                    <div class="col-2">
                                                        <p>Location</p>
                                                    </div>
                                                    <div class="col-4">
                                                        <p id="detail_location"></p>
                                                    </div>
                                                    <div class="col-2">
                                                        <p>Department</p>
                                                    </div>
                                                    <div class="col-4">
                                                        <p id="detail_department"></p>
                                                    </div>
                                                    <div class="col-2">
                                                        <p>Subject</p>
                                                    </div>
                                                    <div class="col-4">
                                                        <p id="detail_subject"></p>
                                                    </div>
                                                    <div class="col-2">
                                                        <p>Status</p>
                                                    </div>
                                                    <div class="col-4">
                                                        <p id="detail_status"></p>
                                                    </div>
                                                    <div class="col-2">
                                                        <p>Attachment</p>
                                                    </div>
                                                    <div class="col-4">
                                                        <p id="detail_attachment"></p>
                                                    </div>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-2">
                                                        <p>Notes</p>
                                                    </div>
                                                    <div class="col-10">
                                                        <p id="detail_notes"></p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                   <div class="col-12">
                                                    <button id="btn_start_service" type="button" class="btn btn-warning btn-sm" style="float: right">
                                                        <i class="fas fa-circle-play"></i>
                                                    </button>
                                                    <button id="btn_update_service" type="button" class="btn btn-info btn-sm" style="float: right" title="Update Service">
                                                        <i class="fa-solid fa-scroll-torah"></i>                                         
                                                    </button>
                                                   </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <button style="float: right;font-size:10px !important" class="btn btn-danger btn-sm mt-2" id="btn_export_pdf_service">
                                                            <i class="fas fa-file"></i> Export to PDF
                                                        </button>
                                                        <button class="btn btn-danger btn-sm mt-2" style="float: right;font-size:10px !important; margin-right: 5px;" id="btn_print_service_history">
                                                            <i class="fas fa-print"></i> Print Service Asset
                                                        </button>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <fieldset>
                                                <legend>Log Transaction</legend>
                                                <div id="detail_history_log"></div>
                                            </fieldset>
                                    </div>
                                </div>
                            </div>
                            {{-- Detail Information --}}
                            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                               <div class="row my-2">
                                    <div class="col-12">
                                        <fieldset>
                                            <legend>Detail Information About Ticket</legend>
                                            <div class="row">
                                                <div class="col-2">
                                                    <p>Request Code</p>
                                                </div>
                                                <div class="col-4">
                                                    <p id="wo_request_code"></p>
                                                </div>
                                                <div class="col-2">
                                                    <p>Request Type</p>
                                                </div>
                                                <div class="col-4">
                                                    <p id="wo_request_type"></p>
                                                </div>
                                                <div class="col-2">
                                                    <p>Category</p>
                                                </div>
                                                <div class="col-4">
                                                    <p id="wo_category"></p>
                                                </div>
                                                <div class="col-2">
                                                    <p>Problem Type</p>
                                                </div>
                                                <div class="col-4">
                                                    <p id="wo_problem_type"></p>
                                                </div>
                                                <div class="col-2">
                                                    <p>Subject</p>
                                                </div>
                                                <div class="col-4">
                                                    <p id="wo_subject"></p>
                                                </div>
                                                <div class="col-2">
                                                    <p>Request By</p>
                                                </div>
                                                <div class="col-4">
                                                    <p id="wo_pic"></p>
                                                </div>
                                                <div class="col-2">
                                                    <p>Additional Info</p>
                                                </div>
                                                <div class="col-10">
                                                    <p id="wo_additional_info"></p>
                                                </div>
                                                <div class="col-2">
                                                    <p>Attachment</p>
                                                </div>
                                                <div class="col-4">
                                                    <p id="wo_attachment"></p>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                <div class="col-12">
                                    <fieldset class="mb-2">
                                        <legend>Detail Asset</legend>
                                        <div class="row">
                                            <div class="col-2">
                                                <p>Asset Code</p>
                                            </div>
                                            <div class="col-4">
                                                <p id="wo_asset_code"></p>
                                            </div>
                                            <div class="col-2">
                                                <p>Category</p>
                                            </div>
                                            <div class="col-4">
                                                <p id="wo_asset_category"></p>
                                            </div>
                                            <div class="col-2">
                                                <p>Brand</p>
                                            </div>
                                            <div class="col-4">
                                                <p id="wo_asset_brand"></p>
                                            </div>
                                            <div class="col-2">
                                                <p>Type</p>
                                            </div>
                                            <div class="col-4">
                                                <p id="wo_asset_type"></p>
                                            </div>
                                            <div class="col-2">
                                                <p>Condition</p>
                                            </div>
                                            <div class="col-4">
                                                <p id="wo_asset_condition"></p>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                                </div>
                            </div>
                            {{-- Detail Information --}}
                          </div>
                    </div>
                   </div>
                  
                </div>
                <div class="modal-footer justify-content-end py-1">
                </div>
           
        </div>
    </div>
</div>
