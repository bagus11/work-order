
<div class="modal fade" id="editSubDetailRFP">
    <div class="modal-dialog modal-lg  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h4 class="modal-title">Edit Sub Detail RFP</h4>
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
                        <input type="hidden" readonly class="form-control" id="rfpSubDetailIdEdit">
                        <input type="text" readonly class="form-control" id="subDetailCodeSubDetailEdit">
                        <span  style="color:red;" class="message_error text-red block requestCodeEdit_error"></span>
                    </div>
                    <div class="col-md-2 mt-2">
                        <label for="">PIC</label>
                    </div>
                    <div class="col-md-4">
                        <input type="text" readonly name="usernameSubDetailEdit" class="form-control" id="usernameSubDetailEdit">
                    </div>
                   
                </div>
                <div class="form-group row">
                    <div class="col-md-2 mt-2">
                        <label for="">Start Date</label>
                    </div>
                    <div class="col-md-4">
                        <input type="date" readonly class="form-control" id="startDateSubDetailEdit">
                        <span  style="color:red;" class="message_error text-red block startDateSubDetailEdit_error"></span>
                    </div>
                    <div class="col-md-2 mt-2">
                        <label for="">Deadline</label>
                    </div>
                    <div class="col-md-4">
                        <input type="date" class="form-control" id="datelineSubDetailEdit">
                        <span  style="color:red;" class="message_error text-red block datelineSubDetailEdit_error"></span>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-2 mt-2">
                        <label for="">Title</label>
                    </div>
                    <div class="col-md-10">
                        <input type="text" class="form-control" id="titleSubDetailEdit">
                        <span  style="color:red;" class="message_error text-red block titleSubDetailEdit_error"></span>
                    </div>
                
                </div>
                <div class="form-group row">
                    <div class="col-md-2 mt-2">
                        <label for="">Description</label>
                    </div>
                    <div class="col-md-10">
                        <textarea class="form-control" id="descriptionSubDetailEdit" rows="3"></textarea>
                        <span  style="color:red;" class="message_error text-red block descriptionSubDetailEdit_error"></span>
                    </div>
                </div>
               </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button id="btnSubDetailEditRFP" type="button" class="btn btn-success">Save changes</button>
            </div>
        </div>
    </div>
</div>