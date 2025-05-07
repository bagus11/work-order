<div class="modal fade" id="addHeader">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                Add Incident
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="your_path" method="post" enctype="multipart/form-data">
            <div class="modal-body">
                <fieldset class="scheduler-border">
                    <legend class="scheduler-border"> Detail Incident</legend>
                                <div class="form-group row">
                                    <div class="col-md-2 mt-2">
                                        <p>
                                            Categories
                                        </p>
                                    </div>
                                    <div class="col-md-4">
                                        <select name="select_categories" class="select2" id="select_categories"></select>
                                        <input type="hidden" name="categories_id" id="categories_id">
                                        <span  style="color:red;" class="message_error text-red block categories_id_error"></span>
                                    </div>
                                    <div class="col-md-2 mt-2">
                                        <p>
                                            Problem
                                        </p>
                                    </div>
                                    <div class="col-md-4">
                                        <select name="select_problem" class="select2" id="select_problem">
                                            <option value="">Select Categories First</option>
                                        </select>
                                        <input type="hidden" name="problem_id" id="problem_id">
                                        <span  style="color:red;" class="message_error text-red block problem_id_error"></span>
                                    </div>
                                </div>
                        
                                <div class="form-group row">
                                    <div class="col-md-2 mt-2">
                                        <p>Incident</p>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" id="title_incident">
                                        <span  style="color:red;" class="message_error text-red block title_incident_error"></span>
                                    </div>
                                    <div class="col-md-2 mt-2">
                                        <p>Location</p>
                                    </div>
                                    <div class="col-md-4">
                                        <select name="select_location" class="select2" id="select_location"></select>
                                        <input type="hidden" name="location_id" id="location_id">
                                        <span  style="color:red;" class="message_error text-red block location_id_error"></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2 mt-2">
                                        <p>Start Date</p>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group date" id="start_date_incident_datetimepicker" data-target-input="nearest">
                                            <input type="text" id="start_date_incident" class="form-control datetimepicker-input" data-target="#start_date_incident_datetimepicker"/>
                                            <div class="input-group-append" data-target="#start_date_incident_datetimepicker" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                        <span  style="color:red;" class="message_error text-red block start_date_incident_error"></span>
                                    </div>
                                
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2 mt-2">
                                        <p>Desctription</p>
                                    </div>
                                    <div class="col-md-10">
                                        <textarea class="form-control" id="description_incident" rows="3"></textarea>
                                        <span  style="color:red;" class="message_error text-red block description_incident_error"></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2 mt-2">
                                        <p>Attachment</p>
                                    </div>
                                    <div class="col-md-4 mt-2">
                                        <input type="file" class="form-control-file" id="attachment_start">
                                        <span  style="color:red;" class="message_error text-red block attachment_start_error"></span>
                                    </div>
                                </div>

                        </fieldset>                   
            </div>
            <div class="modal-footer justify-content-end">
                <button id="btn_save_incident" type="submit" class="btn btn-success">
                    <i class="fas fa-check"></i>
                </button>
            </div>
            </form>
        </div>
    </div>
</div>