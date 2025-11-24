<div class="modal fade" id="detailMasterAssetModal">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content shadow-lg rounded-lg">

      <!-- Header -->
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title font-weight-bold">
          <i class="fas fa-box-open mr-2"></i> <span id="assetTitle"></span>
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <!-- Body -->
      <div class="modal-body p-0">
        
        <!-- Tabs (Main) -->
        <ul class="nav nav-tabs nav-justified bg-info border-bottom" id="main-asset-tab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="general-tab" data-toggle="pill" href="#general-tab-pane" role="tab">
              <i class="fas fa-info-circle mr-1"></i> General Information
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="history-tab" data-toggle="pill" href="#history-tab-pane" role="tab">
              <i class="fas fa-history mr-1"></i> History
            </a>
          </li>
        </ul>

        <!-- Content -->
        <div class="tab-content p-3" id="main-asset-tabContent">

          <!-- Tab General Info -->
          <div class="tab-pane fade show active" id="general-tab-pane" role="tabpanel">
            <!-- General & Detail -->
            <div class="card card-outline card-info">
              <div class="card-header p-2">
                 <div class="row">
              <div class="col-11">
                  <ul class="nav nav-pills" id="asset-info-tabs">
                    <li class="nav-item">
                      <a class="nav-link active" href="#general_info" data-toggle="tab">
                        <i class="fas fa-info-circle mr-1"></i> General Information
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#detail_asset" data-toggle="tab">
                        <i class="fas fa-cogs mr-1"></i> Detail Asset
                      </a>
                    </li>
                  </ul>
              </div>
              <div class="col-1">
                    <button class="btn btn-sm btn-danger" style="float: right" id="btn_export_pdf" title="Export To PDF">
                      <i class="fa-solid fa-file-pdf"></i>
                    </button>
              </div>
            </div>
              
              </div>
              <div class="card-body">
                <div class="tab-content">

                  <!-- General Info -->
                  <div class="tab-pane fade show active" id="general_info">
                    <div class="row mb-2">
                      <div class="col-md-3 text-muted">Asset Code</div>
                      <div class="col-md-3" id="label_asset_code"></div>
                      <div class="col-md-3 text-muted">Category</div>
                      <div class="col-md-3" id="label_category"></div>
                    </div>
                    <div class="row mb-2">
                      <div class="col-md-3 text-muted">Brand</div>
                      <div class="col-md-3" id="label_brand"></div>
                      <div class="col-md-3 text-muted">Type</div>
                      <div class="col-md-3" id="label_type"></div>
                    </div>
                    <div class="row mb-2">
                      <div class="col-md-3 text-muted">Parent</div>
                      <div class="col-md-3" id="label_parent_code"></div>
                      <div class="col-md-3 text-muted">Current PIC</div>
                      <div class="col-md-3" id="label_pic"></div>
                    </div>
                    <div class="row mb-2">
                      <div class="col-md-3 text-muted">Location</div>
                      <div class="col-md-3" id="label_location"></div>
                      <div class="col-md-3 text-muted">Status</div>
                      <div class="col-md-3" id="label_is_active"></div>
                    </div>
                    
                    <div class="row mb-2">
                      <div class="col-md-3 text-muted">QR Code</div>
                      <div class="col-md-3" id="label_qr"></div>
                    </div>

                  </div>

                  <!-- Detail Asset -->
                  <div class="tab-pane fade" id="detail_asset">
                    <div class="row mb-2">
                      <div class="col-md-3 text-muted">Type</div>
                      <div class="col-md-3" id="label_detail_type"></div>
                      <div class="col-md-3 text-muted">CD / DVD</div>
                      <div class="col-md-3" id="label_cd"></div>
                    </div>
                    <div class="row mb-2">
                      <div class="col-md-3 text-muted">IP Address</div>
                      <div class="col-md-3" id="label_ip"></div>
                      <div class="col-md-3 text-muted">Mac Address</div>
                      <div class="col-md-3" id="label_mac"></div>
                    </div>
                    <div class="row mb-2">
                      <div class="col-md-3 text-muted">Processor</div>
                      <div class="col-md-3" id="label_processor"></div>
                      <div class="col-md-3 text-muted">Protection</div>
                      <div class="col-md-3" id="label_protection"></div>
                    </div>
                    <div class="row mb-2">
                      <div class="col-md-3 text-muted">RAM</div>
                      <div class="col-md-3" id="label_ram"></div>
                      <div class="col-md-3 text-muted">Storage</div>
                      <div class="col-md-3" id="label_storage"></div>
                    </div>
                  </div>

                </div>
              </div>
            </div>

            <!-- Parent Asset -->
            <div id="parent_asset_container" class="mb-3">
                <div class="card card-outline card-info">
                    <div class="card-header">
                        <ul class="nav nav-pills" id="assetChildTab" role="tablist">
                          <li class="nav-item">
                              <a class="nav-link active" id="child-tab" data-toggle="tab" href="#child" role="tab">
                              <i class="fas fa-sitemap mr-1"></i> Asset Child
                              </a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link" id="software-tab" data-toggle="tab" href="#software" role="tab">
                              <i class="fas fa-laptop-code mr-1"></i> Installed Software
                              </a>
                          </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content mt-3" id="assetChildTabContent">

                        <!-- Asset Child -->
                        <div class="tab-pane fade show active" id="child" role="tabpanel" aria-labelledby="child-tab">
                            <div class="row mb-3">
                            <div class="col-12">
                                <button class="btn btn-sm btn-success" id="btn_add_asset_child" title="Add Asset Child">
                                <i class="fa-solid fa-plus"></i> Asset Child
                                </button>
                            </div>
                            </div>

                            <div id="asset_child_container" class="mb-3"></div>
                            <div class="table-responsive">
                            <table class="table table-bordered table-hover table-sm" id="asset_child_table" width="100%">
                                <thead class="thead-light">
                                <tr>
                                    <th class="text-center">Asset Code</th>
                                    <th class="text-center">Category</th>
                                    <th class="text-center">Brand</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                            </div>
                        </div>

                        <!-- Installed Software -->
                        <div class="tab-pane fade" id="software" role="tabpanel" aria-labelledby="software-tab">
                            <div class="row">
                                <div class="col-12">
                                    <button id="btn_add_software" class="btn btn-sm btn-success mb-3" title="Add Software">
                                        <i class="fas fa-plus"></i> Software
                                    </button>
                                </div>
                                <div class="col-12">
                                    <div id="software_container" class="mb-3"></div>
                                </div>
                            </div>
                            <div class="table-responsive">
                            <table class="table table-sm table-hover align-middle" id="software_table" style="width: 100%">
                                <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Software Name</th>
                                    <th>Details</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                            </div>
                        </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Asset Child & Software -->
           
          </div>

          <!-- Tab History -->
          <div class="tab-pane fade" id="history-tab-pane" role="tabpanel">
            <div class="card card-outline card-primary">
              <div class="card-header">
                <div class="row">
                  <div class="col-8">
                    <h6 class="mb-0 font-weight-bold">History</h6>
                  </div>
                  <div class="col-4">
                   
                  </div>
                </div>
              </div>
              <div class="card-body">
                <table class="table table-bordered table-hover table-sm" id="asset_history_table" width="100%">
                  <thead class="thead-light">
                    <tr>
                      <th class="text-center">Created At</th>
                      <th class="text-center">Creator</th>
                      <th class="text-center">Laptop</th>
                      <th class="text-center">Brand</th>
                      <th class="text-center">Type</th>
                      <th class="text-center">PIC</th>
                      <th class="text-center">Status</th>
                      <th class="text-center">Remark</th>
                    </tr>
                  </thead>
                  <tbody></tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
      </div>

      <!-- Footer -->
      <div class="modal-footer bg-light">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
          <i class="fas fa-times"></i> Close
        </button>
      </div>

    </div>
  </div>
</div>
