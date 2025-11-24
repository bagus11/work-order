

<div class="modal fade" id="addStockOpnameModal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title">Add Stock Opname Ticket</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mx-2">
                    <div class="col-2 mt-2">
                        <p>Subject</p>
                    </div>
                    <div class="col-4">
                        <input type="text" class="form-control" id="subject" placeholder="Enter Subject">
                        <span style="color:red;" class="message_error text-red block subject_error"></span>
                    </div>
                </div>
                <div class="row mx-2">
                      <div class="col-2 mt-2">
                    <p>Description</p>
                </div>
                <div class="col-10">
                    <textarea name="description" class="form-control" id="description" rows="10"></textarea>
                         <span style="color:red;" class="message_error text-red block description_error"></span>
                </div>
                </div>
              
            </div>
            <div class="modal-footer justify-content-end">
                <button id="btn_save_stock_opname" type="button" class="btn btn-success">
                    <i class="fas fa-check"></i>
                </button>
            </div>
        </div>
    </div>
</div>