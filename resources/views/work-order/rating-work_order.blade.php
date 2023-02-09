<div class="modal fade" id="ratingPIC">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h4 class="modal-title">Assign Ticket</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <div class="container">
                <div class="form-group row">
                    <div class="col-md-2 mt-2">
                        <label for="">Request By</label>
                    </div>
                    <div class="col-md-4">
                        <input type="hidden" class="form-control" id="wo_id_rating" readonly>
                        <input type="text" class="form-control" id="username_rating" readonly>
                    </div>
                    <div class="col-md-2 mt-2">
                        <label for="">Request Code</label>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="request_code_rating" readonly>
                    </div>
                </div>
                    <div class="form-group row">
                        <div class="col-md-2 mt-2">
                            <label for="">Request Type</label>
                        </div>
                        <div class="col-md-4">
                            <select name="select_request_type_rating_rating" class="select2" style="width: 100%" id="select_request_type_rating">
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 mt-2">
                            <label for="">Categories</label>
                        </div>
                        <div class="col-md-4">
                            <select name="select_categories_rating" class="select2" style="width: 100%" id="select_categories_rating">
                            </select>
                        </div>
                        <div class="col-md-2 mt-2">
                            <label for="">Problem Type</label>
                        </div>
                        <div class="col-md-4">
                            <select name="select_problem_type_rating" class="select2" style="width: 100%" id="select_problem_type_rating">
                                <option value="">Choose Categories First</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 mt-2">
                            <label for="">Subject</label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="subject_rating" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 mt-2">
                            <label for="">Additional Info</label>
                        </div>
                        <div class="col-md-8 ">
                            <textarea class="form-control" id="add_info_rating" rows="3" readonly></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 mt-4">
                            <label for="">Note</label>
                        </div>
                        <div class="col-md-8">
                            <span for="" id ="creator_rating" style="text-align: right;float:right"></span>
                            <textarea class="form-control" id="note_rating" rows="2" readonly></textarea>
                        </div>
                    </div>
                 
                    <div class="form-group row">
                        <div class="col-md-2 mt-2">
                            <label for="">Note PIC</label>
                        </div>
                        <div class="col-md-8">
                            <textarea class="form-control" id="note_pic_rating" rows="2"></textarea>
                            <span  style="color:red;" class="message_error text-red block note_pic_rating_error"></span>
                        </div>
                        
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2">
                            <label for="">Rating</label>
                        </div>
                        <div class="col-md-8 offset-2">
                            <div class="rating">
                               <span id="rating__result" class="rating__result"> </span>
                               <i class="rating__star far fa-star"></i>
                               <i class="rating__star far fa-star"></i>
                               <i class="rating__star far fa-star"></i>
                               <i class="rating__star far fa-star"></i>
                               <i class="rating__star far fa-star"></i>
                            </div>
                            <span  style="color:red;" class="message_error text-red block rating__result_error"></span>
                        </div>
                    </div>
               </div>
            </div>
           
            <div class="modal-footer justify-content-end">
                <button id="btn_rating_pic_reject" type="button" class="btn btn-danger">Doesn't Match</button>
                <button id="btn_rating_pic" type="button" class="btn btn-success">Match</button>
            </div>
        </div>
    </div>
</div>