
<div class="modal fade" id="addMasterAssetModal">
    <div class="modal-dialog modal-lg  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-core">
                <span id="assetTitle"></span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <div class="row mx-2 my-2">
                    <div class="col-2 mt-2">
                        <p>Join Date</p>
                    </div>
                    <div class="col-4">
                        <input type="date" class="form-control" id="join_date" name="join_date" value="{{ date('Y-m-d') }}">
                        <span  style="color:red;font-size:9px" class="message_error text-red block join_date_error"></span>
                    </div>
                    <div class="col-2 mt-2">
                        <p>Location</p>
                    </div>
                    <div class="col-4">
                        <select class="select2" name="select_location" id="select_location"></select>
                        <input type="hidden" id="location_id" name="location_id">
                        <span  style="color:red;font-size:9px" class="message_error text-red block location_id_error"></span>
                    </div>
                    <div class="col-2 mt-2">
                        <p>Category</p>
                    </div>
                    <div class="col-4">
                        <select class="select2" name="select_category" id="select_category"></select>
                        <input type="hidden" id="category_id" name="category_id">
                        <span  style="color:red;font-size:9px" class="message_error text-red block category_id_error"></span>
                    </div>
                    <div class="col-2 mt-2">
                        <p>Brand</p>
                    </div>
                    <div class="col-4">
                        <select class="select2" name="select_brand" id="select_brand"></select>
                        <input type="hidden" id="brand_id" name="brand_id">
                        <span  style="color:red;font-size:9px" class="message_error text-red block brand_id_error"></span>
                    </div>
                    <div class="col-2 mt-2">
                        <p>Type</p>
                    </div>
                    <div class="col-4">
                        <select class="select2" name="select_type" id="select_type">
                            <option value="">Choose Type</option>
                            <option value="1">Parent</option>
                            <option value="2">Child</option>
                        </select>
                        <input type="hidden" id="type_id" name="type_id">
                        <span  style="color:red;font-size:9px" class="message_error text-red block type_id_error"></span>
                    </div>
                    <div class="col-2 mt-2 parent_container">
                        <p>Parent</p>
                    </div>
                    <div class="col-4 parent_container">
                        <select class="select2" name="select_parent" id="select_parent"></select>
                        <input type="hidden" id="parent_id" name="parent_id">
                        <span  style="color:red;font-size:9px" class="message_error text-red block parent_id_error"></span>
                    </div>
                    <div class="col-2 mt-2">
                        <p>PIC</p>
                    </div>
                    <div class="col-4">
                        <select class="select2" name="select_pic" id="select_pic"></select>
                        <input type="hidden" id="pic_id" name="pic_id">
                        <span  style="color:red;font-size:9px" class="message_error text-red block pic_id_error"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-end py-1">
                    <button class="btn btn-sm btn-success" id="btn_save_master_asset">
                        <i class="fas fa-check"></i>
                    </button>
            </div>
        </div>
    </div>
</div>
