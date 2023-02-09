
<div class="modal fade" id="addProblem">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h4 class="modal-title">Add Problem Type</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <div class="container">
                    <div class="form-group row">
                        <div class="col-md-4 mt-2">
                            <label for="">Kategori</label>
                        </div>
                        <div class="col-md-8">
                            <select name="select_categories" class="select2" style="width: 100%" id="select_categories"></select>
                            <input type="hidden" class="form-control" id="categories_id">
                            <span  style="color:red;" class="message_error text-red block categories_id_error"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4 mt-2">
                            <label for="">Tipe Problem</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="problem_name">
                            <span  style="color:red;" class="message_error text-red block problem_name_error"></span>
                        </div>
                    </div>
                   
               </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button id="btn_save_problem" type="button" class="btn btn-success">Save changes</button>
            </div>
        </div>
    </div>
</div>