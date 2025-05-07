<div class="modal fade" id="addOPXModal">
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
                            <p>Location</p>
                        </div>
                        <div class="col-9">
                            <select name="select_location" class="select2" id="select_location"></select>
                            <input type="hidden" class="form-control" id="location">
                            <span  style="color:red;font-size:9px" class="message_error text-red block location_error"></span>
                        </div>
                        <div class="col-3 mt-2">
                            <p>Date</p>
                        </div>
                        <div class="col-9">
                            <input type="date" class="form-control" id="date" value="{{date('Y-m-d')}}">
                            <span  style="color:red;font-size:9px" class="message_error text-red block date_error"></span>
                        </div>
                        <div class="col-3 mt-2">
                            <p>Category</p>
                        </div>
                        <div class="col-9">
                            <select class="select2" name="select_category" id="select_category"></select>
                            <input type="hidden" class="form-control" id="category">
                            <span  style="color:red;font-size:9px" class="message_error text-red block category_error"></span>
                        </div>
                    </div>
                    <div class="row  my-2 mx-2"" id="product_label">
                        <div class="col-3 mt-2">
                            <p>Product</p>
                        </div>
                        <div class="col-9">
                            <select class="select2" name="select_product" id="select_product"></select>
                            <input type="hidden" class="form-control" id="product">
                            <span  style="color:red;font-size:9px" class="message_error text-red block product_error"></span>
                        </div>
                    </div>
                    <div class="row my-2 mx-2"">
                        <div class="col-3 mt-2">
                            <p>Price</p>
                        </div>
                        <div class="col-9">
                            <input type="text" class="amount form-control" id="price">
                            <span  style="color:red;font-size:9px" class="message_error text-red block price_error"></span>
                        </div>
                        <div class="col-3 mt-2">
                            <p>PPH</p>
                        </div>
                        <div class="col-9">
                            <input type="text" class="amount form-control" id="pph">
                            <span  style="color:red;font-size:9px" class="message_error text-red block pph_error"></span>
                        </div>
                        <div class="col-3 mt-2">
                            <p>PPN</p>
                        </div>
                        <div class="col-9">
                            <input type="text" class="amount form-control" id="ppn">
                            <span  style="color:red;font-size:9px" class="message_error text-red block ppn_error"></span>
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
                    <button id="btn_save_opx" type="submit" class="btn btn-sm btn-success">
                        <i class="fa-solid fa-check"></i>
                    </button>
                </div>
        </div>
    </div>
</div>

