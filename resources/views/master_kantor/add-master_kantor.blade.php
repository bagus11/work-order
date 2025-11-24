
<div class="modal fade" id="addMasterKantor">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h4 class="modal-title">Add Kantor</h4>
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
                            <input type="text" class="form-control" id="office_name">
                            <span  style="color:red;" class="message_error text-red block office_name_error"></span>
                        </div>
                    </div>
                  
                    <div class="form-group row">
                        <div class="col-md-3 mt-2">
                            <label for="">Tipe</label>
                        </div>
                        <div class="col-md-8">
                            <select name="" id="select_office_type" class="form-control select2" style="width:100%">
                                <option value="">Pilih Tipe</option>
                                <option value="Pusat">Pusat</option>
                                <option value="Cabang">Cabang</option>
                            </select>
                            <input type="hidden" class="form-control" id="office_type">
                            <span  style="color:red;" class="message_error text-red block menus_type_error"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 mt-2">
                            <label for="">Provinsi</label>
                        </div>
                        <div class="col-md-8">
                            <select name="select_province" class="select2" style="width:100%" id="select_province"></select>
                            <input type="hidden" class="form-control" id="id_province">
                            <span  style="color:red;" class="message_error text-red block id_province_error"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 mt-2">
                            <label for="">Kabupaten</label>
                        </div>
                        <div class="col-md-8">
                            <select name="select_regency" class="select2" style="width:100%" id="select_regency">
                                <option value="">Pilih Provinsi terlebih dahulu</option>
                            </select>
                            <input type="hidden" class="form-control" id="id_regency">
                            <span  style="color:red;" class="message_error text-red block id_regency_error"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 mt-2">
                            <label for="">Kecamatan</label>
                        </div>
                        <div class="col-md-8">
                            <select name="select_district" class="select2" style="width:100%" id="select_district">
                                <option value="">Pilih Kabupaten terlebih dahulu</option>
                            </select>
                            <input type="hidden" class="form-control" id="id_district">
                            <span  style="color:red;" class="message_error text-red block id_district_error"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 mt-2">
                            <label for="">Kelurahan</label>
                        </div>
                        <div class="col-md-8">
                            <select name="select_village" class="select2" style="width:100%" id="select_village">
                                <option value="">Pilih Kecamatan terlebih dahulu</option>
                            </select>
                            <input type="hidden" class="form-control" id="id_village">
                            <span  style="color:red;" class="message_error text-red block id_village_error"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 mt-2">
                            <label for="">Kode Pos</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="postal_code">
                            <span  style="color:red;" class="message_error text-red block postal_code_error"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 mt-2">
                            <label for="">Alamat</label>
                        </div>
                        <div class="col-md-8">
                            <textarea class="form-control" id="office_address" rows="3"></textarea>
                            <span  style="color:red;" class="message_error text-red block office_address_error"></span>
                        </div>
                    </div>
               </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button id="btn_save_office" type="button" class="btn btn-success">Save changes</button>
            </div>
        </div>
    </div>
</div>