
<div class="modal fade" id="detailMasterAssetModal">
    <div class="modal-dialog modal-lg  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-core">
                <span id="assetTitle"></span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">General Information</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">History</a>
                    </li>
                
                </ul>
                <div class="tab-content" id="custom-tabs-one-tabContent">
                    <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">  
                        <div class="container">
                            <fieldset class="scheduler-border">
                                <legend class="scheduler-border"> General Information</legend>
                                <br>
                                <div class="row mt-2">
                                    <div class="col-2">
                                        <p>Asset Code</p>
                                    </div>
                                    <div class="col-4">
                                        <p id="label_asset_code"></p>
                                    </div>
                                    <div class="col-2">
                                        <p>Category</p>
                                    </div>
                                    <div class="col-4">
                                        <p id="label_category"></p>
                                    </div>
                                    <div class="col-2">
                                        <p>Brand</p>
                                    </div>
                                    <div class="col-4">
                                        <p id="label_brand"></p>
                                    </div>
                                    <div class="col-2">
                                        <p>Type</p>
                                    </div>
                                    <div class="col-4">
                                        <p id="label_type"></p>
                                    </div>
                                    <div class="col-2">
                                        <p>Parent</p>
                                    </div>
                                    <div class="col-4">
                                        <p id="label_parent_code"></p>
                                    </div>
                                    <div class="col-2">
                                        <p>Current PIC</p>
                                    </div>
                                    <div class="col-4">
                                        <p id="label_pic"></p>
                                    </div>
                                    <div class="col-2">
                                        <p>Location</p>
                                    </div>
                                    <div class="col-4">
                                        <p id="label_location"></p>
                                    </div>
                                    <div class="col-2">
                                        <p>Status</p>
                                    </div>
                                    <div class="col-4">
                                        <p id="label_is_active"></p>
                                    </div>
                                </div>
                            </fieldset>
                            
                            <fieldset class="scheduler-border specification_container">
                                <legend class="scheduler-border">Detail Asset</legend>
                                <div class="container">
                                    <div class="row mb-2">
                                        <div class="col-2">
                                            <p>Type</p>
                                        </div>
                                        <div class="col-4">
                                            <p id="label_detail_type"></p>
                                        </div>
                                        <div class="col-2">
                                            <p>CD / DVD</p>
                                        </div>
                                        <div class="col-4">
                                            <p id="label_cd"></p>
                                        </div>
                                 
                                        <div class="col-2">
                                            <p>IP Address</p>
                                        </div>
                                        <div class="col-4">
                                            <p id="label_ip"></p>
                                        </div>
                                        <div class="col-2">
                                            <p>Mac Address</p>
                                        </div>
                                        <div class="col-4">
                                            <p id="label_mac"></p>
                                        </div>
                                   
                                        <div class="col-2">
                                            <p>Processor</p>
                                        </div>
                                        <div class="col-4">
                                            <p id="label_processor"></p>
                                        </div>
                                        <div class="col-2">
                                            <p>Protection</p>
                                        </div>
                                        <div class="col-4">
                                            <p id="label_protection"></p>
                                        </div>
                                   
                                        <div class="col-2">
                                            <p>RAM</p>
                                        </div>
                                        <div class="col-4">
                                            <p id="label_ram"></p>
                                        </div>
                                        <div class="col-2">
                                            <p>Storage</p>
                                        </div>
                                        <div class="col-4">
                                            <p id="label_storage"></p>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            
                            <fieldset class="scheduler-border" class="specification_container">
                                <legend class="scheduler-border"> Asset Child</legend>
                                <table class="datatable-bordered nowrap display" id="asset_child_table">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center">Asset Code</th>
                                            <th style="text-align:center">Category</th>
                                            <th style="text-align:center">Brand</th>
                                        </tr>
                                    </thead>
                                </table>
                            </fieldset>
                        </div>
                    </div>
                    
                    <div class="tab-pane fade show" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">  
                        <table class="datatable-bordered nowrap display" id="asset_history_table">
                            <thead>
                                <tr>
                                    <th style="text-align:center">Created At</th>
                                    <th style="text-align:center">Creator</th>
                                    <th style="text-align:center">Laptop</th>
                                    <th style="text-align:center">Brand</th>
                                    <th style="text-align:center">Type</th>
                                    <th style="text-align:center">PIC</th>
                                    <th style="text-align:center">Status</th>
                                    <th style="text-align:center">Remark</th>
                                </tr>
                            </thead>
                        </table>

                    </div>

                </div>
           

            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
