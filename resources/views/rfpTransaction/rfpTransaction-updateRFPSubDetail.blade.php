<div class="modal fade" id="updateRFPSubDetail">
    <div class="modal-dialog modal-lg  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h4 class="modal-title">Update Progress Sub Detail RFP</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <div class="container">
                <div class="form-group row">
                    <div class="col-md-2 mt-2">
                        <label for=""> SD Code</label>
                    </div>
                    <div class="col-md-4">
                        <input type="hidden" readonly class="form-control" id="rfpSubDetailIdUpdate">
                        <input type="text" readonly class="form-control" id="subDetailCodeSubDetailUpdate">
                        <span  style="color:red;" class="message_error text-red block requestCodeUpdate_error"></span>
                    </div>
                    <div class="col-md-2 mt-2">
                        <label for="">PIC</label>
                    </div>
                    <div class="col-md-4">
                        <input type="text" readonly name="usernameSubDetailUpdate" class="form-control" id="usernameSubDetailUpdate">
                    </div>
                   
                  </div>
                <div class="form-group row">
                    <div class="col-md-2 mt-2">
                        <label for="">Title</label>
                    </div>
                    <div class="col-md-10">
                        <input type="text" readonly class="form-control" id="titleSubDetailUpdate">
                        <span  style="color:red;" class="message_error text-red block titleSubDetailUpdate_error"></span>
                    </div>
                
                </div>
                <div class="form-group row">
                    <div class="col-md-2 mt-2">
                        <label for="">Description</label>
                    </div>
                    <div class="col-md-10">
                        <textarea class="form-control" readonly id="descriptionSubDetailUpdate" rows="3"></textarea>
                        <span  style="color:red;" class="message_error text-red block descriptionSubDetailUpdate_error"></span>
                    </div>
                </div>
                 
                    <div class="form-group row">
                        <div class="col-md-2 mt-2">
                            <label for="">Start Date</label>
                        </div>
                        <div class="col-md-4">
                            <input type="date" readonly class="form-control" id="startDateSubDetailUpdate">
                            <span  style="color:red;" class="message_error text-red block startDateSubDetailUpdate_error"></span>
                        </div>
                        <div class="col-md-2 mt-2">
                            <label for="">Deadline</label>
                        </div>
                        <div class="col-md-4">
                            <input type="date" readonly class="form-control" id="datelineSubDetailUpdate">
                            <span  style="color:red;" class="message_error text-red block datelineSubDetailUpdate_error"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 mt-2">
                            <label for="">Progress</label>
                        </div>
                        <div class="col-md-4">
                            <select name="selectProgressUpdate" class="select2" id="selectProgressUpdate">
                                <option value="">Choose Progress</option>
                                <option value="0">On Progress</option>
                                <option value="1">Done</option>
                            </select>
                            <input type="hidden" name="progressUpdate" id="progressUpdate">
                            <input type="hidden" name="requestCodeUpdateProgress" id="requestCodeUpdateProgress">
                            <span  style="color:red;" class="message_error text-red block progressUpdate_error"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 mt-2">
                            <label for="">Add Info</label>
                        </div>
                        <div class="col-md-10">
                            <textarea name="addInfoUpdate" class="form-control" id="addInfoUpdate" cols="30" rows="3"></textarea>
                            <span  style="color:red;" class="message_error text-red block addInfoUpdate_error"></span>
                        </div>
                    </div>
               </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button id="btnSubDetailUpdateRFP" type="button" class="btn btn-success">Save changes</button>
            </div>
        </div>
    </div>
</div>