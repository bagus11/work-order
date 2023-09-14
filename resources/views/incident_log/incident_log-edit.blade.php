<div class="modal fade" id="editHeader">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                Edit Incident
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
                                            <select name="select_categories_edit" class="select2" id="select_categories_edit"></select>
                                        </div>
                                        <div class="col-md-2 mt-2">
                                            <p>
                                                Problem
                                            </p>
                                        </div>
                                        <div class="col-md-4">
                                            <select name="select_problem_edit" class="select2" id="select_problem_edit">
                                            </select>
                                        
                                        </div>
                                    </div>
                            
                                    <div class="form-group row">
                                        <div class="col-md-2 mt-2">
                                            <p>Incident</p>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="hidden" class="form-control" id="incidentIdEdit">
                                            <input type="text" class="form-control" id="title_incident_edit">
                                            <span  style="color:red;" class="message_error text-red block title_incident_edit_error"></span>
                                        </div>
                                        <div class="col-md-2 mt-2">
                                            <p>Location</p>
                                        </div>
                                        <div class="col-md-4">
                                            <select name="select_location_edit" class="select2" id="select_location_edit"></select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-2 mt-2">
                                            <p>Start Date</p>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-group date" disabled id="start_date_incident_datetimepicker_edit" data-target-input="nearest">
                                                <input type="text" disabled id="start_date_incident_edit" class="form-control datetimepicker-input" data-target="#start_date_incident_datetimepicker_edit"/>
                                                <div class="input-group-append" data-target="#start_date_incident_datetimepicker_edit" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-2 mt-2">
                                            <p>Desctription</p>
                                        </div>
                                        <div class="col-md-10">
                                            <textarea class="form-control" id="description_incident_edit" rows="3"></textarea>
                                            <span  style="color:red;" class="message_error text-red block description_incident_edit_error"></span>
                                        </div>
                                    </div>
                            </fieldset>       

                            <fieldset class="scheduler-border">
                                <legend class="scheduler-border"> Update Incident</legend> 
                                <div class="row">
                                    <div class="col-md-2 mt-2">
                                        <p>End Date</p>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group date" id="end_date_incident_datetimepicker_edit" data-target-input="nearest">
                                            <input type="text" id="end_date_incident_edit" class="form-control datetimepicker-input" data-target="#end_date_incident_datetimepicker_edit"/>
                                            <div class="input-group-append" data-target="#end_date_incident_datetimepicker_edit" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                        <span  style="color:red;" class="message_error text-red block end_date_incident_edit_error"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2 mt-2">
                                        <p>Add Info</p>
                                    </div>
                                    <div class="col-md-10">
                                        <textarea class="form-control" id="comment_incident_edit" rows="3"></textarea>
                                        <span  style="color:red;" class="message_error text-red block comment_incident_edit_error"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2 mt-2">
                                        <p>Attachment</p>
                                    </div>
                                    <div class="col-md-4 mt-2">
                                        <input type="file" class="form-control-file" id="attachment_end">
                                    </div>
                                </div>
                            </fieldset>            
                </div>
                <div class="modal-footer justify-content-end">
                    <button id="btn_update_incident" type="submit" class="btn btn-success">
                        <i class="fas fa-check"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>