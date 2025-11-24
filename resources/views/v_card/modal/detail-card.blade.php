
<div class="modal fade" id="detailCardModal">
    <div class="modal-dialog modal-lg  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-core">
                <span >Detail Employee</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <div class="container mt-2">
                    <fieldset class="scheduler-border">
                        <legend class="scheduler-border"> General Information</legend>
                        <div class="row">
                            <div class="col-2">
                                <p>Employee No</p>
                            </div>
                            <div class="col-4">
                                <p id="label_nik"></p>
                            </div>
                        </div>
                        <div class="row">
                           <input type="hidden" id="nik">
                            <div class="col-2">
                                <p>Name</p>
                            </div>
                            <div class="col-4">
                                <p id="label_name"></p>
                            </div>
                            <div class="col-2">
                                <p>Location</p>
                            </div>
                            <div class="col-4">
                                <p id="label_location"></p>
                            </div>
                            <div class="col-2">
                                <p>Department</p>
                            </div>
                            <div class="col-4">
                                <p id="label_departement"></p>
                            </div>
                            <div class="col-2">
                                <p>Title</p>
                            </div>
                            <div class="col-4">
                                <p id="label_title"></p>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button title="Generate Card" class="btn bt-sm btn-warning" id="generate_card">
                    <i class="fas fa-address-card"></i>
                </button>
            </div>
        </div>
    </div>
</div>
