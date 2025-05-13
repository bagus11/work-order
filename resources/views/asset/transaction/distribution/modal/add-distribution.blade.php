
<div class="modal fade" id="addDistributionModal">
    <div class="modal-dialog modal-lg  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-core">
                <span>Form Add Distribution</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <form class="form" id="form_serialize" enctype="multipart/form-data">
            <div class="modal-body p-0">
                <fieldset class="mx-2 my-2">
                    <legend>General Transaction</legend>
                    <div class="row mx-2 my-2">
                       
                        <div class="col-2 mt-2">
                            <p>Location</p>
                        </div>
                        <div class="col-4">
                            <select class="select2" name="select_location" id="select_location"></select>
                            <input type="hidden" id="location_id" name="location_id">
                            <span  style="color:red;font-size:9px" class="message_error text-red block location_id_error"></span>
                        </div>
                        <div class="col-2 mt-2">
                            <p>Request Type</p>
                        </div>
                        <div class="col-4">
                            <select name="select_request_type" class="select2" style="width: 100%" id="select_request_type">
                                <option value="">Choose Request type</option>
                                <option value="1">Distribution</option>
                                <option value="2">Hand Over</option>
                                <option value="3">Return</option>
                            </select>
                            <input type="hidden" id="request_type" class="form-controll">
                            <span  style="color:red;font-size:9px" class="message_error text-red block request_type_error"></span>
                        </div>
                        <div class="col-2 mt-2 destination_location_container">
                            <p>Destination Location</p>
                        </div>
                        <div class="col-4 destination_location_container">
                            <select class="select2" name="select_destination_location" id="select_destination_location"></select>
                            <input type="hidden" id="destination_location_id" name="destination_location_id">
                            <span  style="color:red;font-size:9px" class="message_error text-red block destination_location_id_error"></span>
                        </div>
                        <div class="user_container col-2 mt-2">
                            <p>Current User</p>
                        </div>
                        <div class="user_container col-4">
                            <select class="select2" name="select_current_user" id="select_current_user">
                                <option value="">Choose Location First</option>
                            </select>
                            <input type="hidden" id="current_user_id" name="current_user_id">
                            <span  style="color:red;font-size:9px" class="message_error text-red block current_user_id_error"></span>
                        </div>
                        <div class="col-2 mt-2 receiver_container">
                            <p>Receiver</p>
                        </div>
                        <div class="col-4 receiver_container">
                            <select class="select2" name="select_receiver" id="select_receiver">
                                <option value="">Choose Des Location First</option>
                            </select>
                            <input type="hidden" id="receiver_id" name="receiver_id">
                            <span  style="color:red;font-size:9px" class="message_error text-red block receiver_id_error"></span>
                        </div>

                        <div class="col-2 mt-2">
                            <p>Attachment</p>
                        </div>
                        <div class="col-4">
                            <input type="file" class="form-control" id="attachment" name="attachment">
                            <span  style="color:red;font-size:9px" class="message_error text-red block attachment_error"></span>
                        </div>
                    </div>
                    <div class="row mx-2 mt-2 mb-2">
                        <div class="col-2 mt-2">
                            <p>Notes</p>
                        </div>
                        <div class="col-10">
                            <textarea class="form-control" id="notes"  rows="3" name="notes"></textarea>
                            <span  style="color:red;font-size:9px" class="message_error text-red block notes_error"></span>
                        </div>
                    </div>
                </fieldset>
                <fieldset class="mx-2 my-2" id="item_container">
                    <legend>Detail Item</legend>
                    <div class="row my-2">
                        <div class="col-12">
                            <table class="table table-bordered table-striped" id="detail_item_table">
                                <thead>
                                    <tr>
                                        <th style="text-align:center"></th>
                                        <th style="text-align:center">Asset Code</th>
                                        <th style="text-align:center">Category</th>
                                        <th style="text-align:center">Brand</th>
                                        <th style="text-align:center">Type</th>
                                        <th style="text-align:center">Parent Code</th>
                                        <th style="text-align:center">Department</th>
                                        <th style="text-align:center">Location</th>
                                        <th style="text-align:center">PIC</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </fieldset>

                <fieldset class="mx-2 my-2" id="array_container">
                    <table class="table table-bordered mt-3" id="distribution_array">
                        <thead>
                            <tr>
                                <th>Asset Code</th>
                                <th>Category</th>
                                <th>Brand</th>
                                <th>Type</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </fieldset>
            </div>
            <div class="modal-footer justify-content-end py-1">
                    <button class="btn btn-sm btn-success" id="btn_save_distributuibn" type="submit">
                        <i class="fas fa-check"></i>
                    </button>
            </div>
        </form>
        </div>
    </div>
</div>
