<div class="modal fade" id="incomingModal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-core">
                <span>Confirmation Asset Progress</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form" id="incoming_form" enctype="multipart/form-data">
                <div class="modal-body p-0 mx-2 mb-2">
                    <fieldset>
                        <legend>Asset Item</legend>
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-bordered" id="ict_asset_incoming_table">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Asset Code</th>
                                            <th>Category</th>
                                            <th>Brand</th>
                                            <th>Type</th>
                                            <th>Condition</th>
                                            <th>Status</th>
                                            <th>Attachment</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Isi tabel akan dimasukkan di sini -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row mx-2">
                            <div class="col-2 mt-2">
                                <p>Notes</p>
                            </div>
                            <div class="col-10">
                                <textarea name="ict_incoming_notes" class="form-control" id="ict_incoming_notes" cols="30" rows="10"></textarea>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col-12">
                                <button class="btn btn-sm btn-success" style="float: right" type="submit" id="incoming_btn">
                                    <i class="fas fa-check"></i>
                                </button>
                            </div>
                        </div>

                    </fieldset>
                </div>
            </form>
        </div>
    </div>
</div>
