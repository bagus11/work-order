<style>
    span{
        font-size: 10px !important
    }
</style>
<div class="modal fade" id="addMasterKantor">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-core">
                Form Add Ticket
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <form class="form" id="form_serialize" enctype="multipart/form-data">
            <div class="modal-body">
               <div class="container">
      
                    <div class="form-group row">
                        <div class="col-12 col-sm-5 col-md-2 mt-2">
                            <p for="">Request Type</p>
                        </div>
                        <div class="col-12 col-sm-7 col-md-4">
                            <select name="select_request_type" class="select2" style="width: 100%" id="select_request_type">
                                <option value="">Choose Request type</option>
                                <option value="RFM">Request For Maintenance</option>
                                {{-- <option value="RFP">Request For Project</option> --}}
                            </select>
                            <input type="hidden" id="request_type" class="form-controll">
                            <span  style="color:red;" class="message_error text-red block request_type_error"></span>
                        </div>
                        <div class="col-12 col-sm-5 col-md-2 mt-2">
                            <p for="">Request For</p>
                        </div>
                        <div class="col-12 col-sm-7 col-md-4 ">
                            <select name="select_departement" id="select_departement" class="select2" style="width: 100%"></select>
                            <input type="hidden" id="departement_for">
                            <span  style="color:red;" class="message_error text-red block departement_for_error"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12 col-sm-5 col-md-2 mt-2">
                            <p for="">Categories</p>
                        </div>
                        <div class="col-12 col-sm-7 col-md-4">
                            <select name="select_categories" class="select2" style="width: 100%" id="select_categories">
                                <option value="">Choose Departement First</option>
                            </select>
                            <input type="hidden" class="form-control" id="categories">
                            <span  style="color:red;" class="message_error text-red block categories_error"></span>
                        </div>
                        <div class="col-12 col-sm-5 col-md-2 mt-2">
                            <p for="">Problem Type</p>
                        </div>
                        <div class="col-12 col-sm-7 col-md-4">
                            <select name="select_problem_type" class="select2" style="width: 100%" id="select_problem_type">
                                <option value="">Choose Categories First</option>
                            </select>
                            <input type="hidden" class="form-control" id="problem_type">
                            <span  style="color:red;" class="message_error text-red block problem_type_error"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12 col-sm-5 col-md-2 mt-2">
                            <p for="">Subject</p>
                        </div>
                        <div class="col-12 col-sm-7 col-md-6">
                            <input type="text" class="form-control" id="subject">
                            <span  style="color:red;" class="message_error text-red block add_info_error"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12 col-sm-5 col-md-2 mt-2">
                            <p for="">Additional Info</p>
                        </div>
                        <div class="col-12 col-sm-7 col-md-10">
                            <textarea class="form-control" id="add_info" rows="3"></textarea>
                            <span  style="color:red;" class="message_error text-red block add_info_error"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 mt-2">
                            <p  class="form-label" for="attachment" for="">Attachment</p>
                        </div>
                        <div class="col-md-10">
                            <input type="file" class="form-control-file" id="attachment" required>
                           
                            <span  style="color:red;" class="message_error text-red block attachment_error"></span>
                        </div>
                    </div>
               </div>
           
            </div>
            <div class="modal-footer justify-content-end">
                <button id="btn_save_wo" type="submit" class="btn btn-success">Save</button>
            </div>
        </form>
        </div>
    </div>
</div>