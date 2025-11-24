
<div class="modal fade" id="editMasterKantor">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h4 class="modal-title">Edit Kantor</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <div class="container">
                    <div class="form-group row">
                        <div class="col-md-3 mt-2">
                            <label for="">Nama</label>
                        </div>
                        <div class="col-md-8">
                            <input type="hidden" class="form-control" id="office_id">
                            <input type="text" class="form-control" id="office_name_update">
                            <span  style="color:red;" class="message_error text-red block office_name_update_error"></span>
                        </div>
                    </div>
                  
                    <div class="form-group row">
                        <div class="col-md-3 mt-2">
                            <label for="">Tipe</label>
                        </div>
                        <div class="col-md-8">
                            <select name="" id="select_office_type_update" class="form-control select2" style="width:100%">
                            </select>
                            <input type="hidden" class="form-control" id="office_type_update">
                            <span  style="color:red;" class="message_error text-red block office_type_update_error"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 mt-2">
                            <label for="">Provinsi</label>
                        </div>
                        <div class="col-md-8">
                            <select name="select_province_update" class="select2" style="width:100%" id="select_province_update"></select>
                            <input type="hidden" class="form-control" id="id_province_update">
                            <span  style="color:red;" class="message_error text-red block id_province_update_error"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 mt-2">
                            <label for="">Kabupaten</label>
                        </div>
                        <div class="col-md-8">
                            <select name="select_regency_update" class="select2" style="width:100%" id="select_regency_update">
                                <option value="">Pilih Provinsi terlebih dahulu</option>
                            </select>
                            <input type="hidden" class="form-control" id="id_regency_update">
                            <span  style="color:red;" class="message_error text-red block id_regency_update_error"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 mt-2">
                            <label for="">Kecamatan</label>
                        </div>
                        <div class="col-md-8">
                            <select name="select_district_update" class="select2" style="width:100%" id="select_district_update">
                                <option value="">Pilih Kabupaten terlebih dahulu</option>
                            </select>
                            <input type="hidden" class="form-control" id="id_district_update">
                            <span  style="color:red;" class="message_error text-red block id_district_update_error"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 mt-2">
                            <label for="">Kelurahan</label>
                        </div>
                        <div class="col-md-8">
                            <select name="select_village_update" class="select2" style="width:100%" id="select_village_update">
                                <option value="">Pilih Kecamatan terlebih dahulu</option>
                            </select>
                            <input type="hidden" class="form-control" id="id_village_update">
                            <span  style="color:red;" class="message_error text-red block id_village_update_error"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 mt-2">
                            <label for="">Kode Pos</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="postal_code_update">
                            <span  style="color:red;" class="message_error text-red block postal_code_update_error"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 mt-2">
                            <label for="">Alamat</label>
                        </div>
                        <div class="col-md-8">
                            <textarea class="form-control" id="office_address_update" rows="3"></textarea>
                            <span  style="color:red;" class="message_error text-red block office_address_update_error"></span>
                        </div>
                    </div>
               </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button id="btn_update_office" type="button" class="btn btn-success">Save changes</button>
            </div>
        </div>
    </div>
</div>