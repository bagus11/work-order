<div class="modal fade" id="detailIncident">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                Detail Incident
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            
                            <fieldset class="scheduler-border">
                                <legend class="scheduler-border"> Detail Incident</legend>
                                <div class="form-group row">
                                    <div class="col-md-2 mt-2">
                                        <p>
                                            INC Code
                                        </p>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" name="incident_code_detail" class="form-control" id="incident_code_detail">
                                    </div>

                                    <div class="col-md-2 mt-2">
                                        <p>
                                            PIC
                                        </p>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" name="user_id_detail" class="form-control" id="user_id_detail">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2 mt-2">
                                        <p>
                                            Categories
                                        </p>
                                    </div>
                                    <div class="col-md-4">
                                        <select name="select_categories_detail" class="select2" id="select_categories_detail"></select>
                                    </div>
                                    <div class="col-md-2 mt-2">
                                        <p>
                                            Problem
                                        </p>
                                    </div>
                                    <div class="col-md-4">
                                        <select name="select_problem_detail" class="select2" id="select_problem_detail">
                                            <option value="">Select Categories First</option>
                                        </select>
                                    </div>
                                </div>
                  
                                <div class="form-group row">
                                    <div class="col-md-2 mt-2">
                                        <p>Incident</p>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" id="title_incident_detail">
                                    </div>
                                    <div class="col-md-2 mt-2">
                                        <p>Location</p>
                                    </div>
                                    <div class="col-md-4">
                                        <select name="select_location_detail" class="select2" id="select_location_detail"></select>
                                        <input type="hidden" name="location_id" id="location_id">
                                       
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2 mt-2">
                                        <p>Start Date</p>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group date" id="start_date_incident_datetimepicker_detail" data-target-input="nearest">
                                            <input type="text" id="start_date_incident_detail" class="form-control datetimepicker-input" data-target="#start_date_incident_datetimepicker_detail"/>
                                            <div class="input-group-append" data-target="#start_date_incident_datetimepicker_detail" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-2 mt-2">
                                        <p>End Date</p>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group date" id="end_date_incident_datetimepicker_detail" data-target-input="nearest">
                                            <input type="text" id="end_date_incident_detail" class="form-control datetimepicker-input" data-target="#end_date_incident_datetimepicker_detail"/>
                                            <div class="input-group-append" data-target="#end_date_incident_datetimepicker_detail" data-toggle="datetimepicker">
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
                                        <textarea class="form-control" id="description_incident_detail" rows="3"></textarea>
                                    </div>
                                </div>
                                {{-- <div class="form-group row">
                                    <div class="col-md-2 mt-2">
                                        <p>Attachment</p>
                                    </div>
                                    <div class="col-md-4">
                                       
                                    </div>
                                </div> --}}
                        </fieldset>

                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border"> Log Incident</legend>
                            <table class="datatable-stepper" id="incidentLogTable">
                                <thead>
                                    <tr>
                                        <th style="text-align: center">No</th>
                                        <th style="text-align: center">Attachment</th>
                                        <th style="text-align: center">Add Info</th>
                                        <th style="text-align: center">Duration</th>
                                    </tr>
                                </thead>
            
                            </table>

                        </fieldset>
                  

                   
               </div>
            <div class="modal-footer justify-content-end">
            </div>
        </div>
    </div>
</div>