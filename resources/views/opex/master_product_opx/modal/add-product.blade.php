<div class="modal fade" id="addProductModal">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-core">
                Add Product
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
        
                <div class="modal-body p-0">
                    <div class="row my-2 mx-2">
                        <div class="col-3 mt-2">
                            <p>Name</p>
                        </div>
                        <div class="col-9">
                            <input type="text" class="form-control" id="name">
                            <span  style="color:red;font-size:9px" class="message_error text-red block name_error"></span>
                        </div>
                        <div class="col-3 mt-2">
                            <p>Category</p>
                        </div>
                        <div class="col-9">
                            <select name="select_category" class="select2" id="select_category">
                            </select>
                            <input type="hidden" class="form-control" id="category">
                            <span  style="color:red;font-size:9px" class="message_error text-red block category_error"></span>
                        </div>
                        <div class="col-3 mt-2">
                            <p>Description</p>
                        </div>
                        <div class="col-9">
                            <textarea class="form-control" id="description" rows="3"></textarea>
                            <span  style="color:red;" class="message_error text-red block description_error"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-end p-0 mx-2">
                    <button id="btn_save_product" type="submit" class="btn btn-sm btn-success">
                        <i class="fa-solid fa-check"></i>
                    </button>
                </div>
        </div>
    </div>
</div>

