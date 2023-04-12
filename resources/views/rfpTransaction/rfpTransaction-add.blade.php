
<div class="modal fade" id="addRFPTransaction">
    <div class="modal-dialog modal-lg  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h4 class="modal-title">Add Master Project</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <div class="container">
                <div class="form-group row">
                    <div class="col-md-2 mt-2">
                        <label for=""> Departement</label>
                    </div>
                    <div class="col-md-4">
                        <select name="selectDepartement" class="select2" id="selectDepartement"></select>
                        <input type="hidden" id="departement">
                        <span  style="color:red;" class="message_error text-red block departement_error"></span>
                    </div>
                    <div class="col-md-2 mt-2">
                        <label for=""> Categories</label>
                    </div>
                    <div class="col-md-4">
                        <select name="selectCategories" class="select2" id="selectCategories">
                            <option value="">Choose Departement First</option>
                        </select>
                        <input type="hidden" id="categories">
                        <span  style="color:red;" class="message_error text-red block categories_error"></span>
                    </div>
                  </div>
                <div class="form-group row">
                    <div class="col-md-2 mt-2">
                        <label for="">Title</label>
                    </div>
                    <div class="col-md-10">
                        <input type="text" class="form-control" id="title">
                        <span  style="color:red;" class="message_error text-red block title_error"></span>
                    </div>
                
                </div>
                <div class="form-group row">
                    <div class="col-md-2 mt-2">
                        <label for="">Description</label>
                    </div>
                    <div class="col-md-10">
                        <textarea class="form-control" id="description" rows="3"></textarea>
                        <span  style="color:red;" class="message_error text-red block description_error"></span>
                    </div>
                </div>
                 
                    <div class="form-group row">
                        <div class="col-md-2 mt-2">
                            <label for="">Start Date</label>
                        </div>
                        <div class="col-md-4">
                            <input type="date" class="form-control" id="startDate" value="{{date('Y-m-d')}}">
                            <span  style="color:red;" class="message_error text-red block startDate_error"></span>
                        </div>
                        <div class="col-md-2 mt-2">
                            <label for="">Deadline</label>
                        </div>
                        <div class="col-md-4">
                            <input type="date" class="form-control" id="dateline" value="{{date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "+1 month" ) )}}">
                            <span  style="color:red;" class="message_error text-red block dateline_error"></span>
                        </div>
                    </div>
  
                    <div class="form-group row">
                        <div class="col-md-2 mt-2">
                            <label  class="form-label" for="attachmentRFP" for="">Attachment</label>
                        </div>
                        <div class="col-md-4">
                            <input type="file" class="form-control-file" id="attachmentRFP" required>
                           
                            <span  style="color:red;" class="message_error text-red block attachmentRFP_error"></span>
                        </div>
                        <div class="col-md-2 mt-2">
                            <label for="">Team</label>
                        </div>
                        <div class="col-md-4">
                            <select name="selectTeam" class="select2" id="selectTeam"></select>
                            <input type="hidden" id="team">
                            <span  style="color:red;" class="message_error text-red block team_error"></span>
                        </div>
                    </div>
                  
                  
                    <div class="form-gruop row">
                        <div class="col-md-12">
                            <table class="datatable-bordered nowrap display" id="detailTeamTable">
                                <thead>
                                    <tr>
                                        <th style="text-align:center">Name</th>
                                        <th style="text-align:center">Departement</th>
                                        <th style="text-align:center">Position</th>
                                        <th style="text-align:center">Role</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                   
                 
               </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button id="btnSaveRFP" type="button" class="btn btn-success">Save changes</button>
            </div>
        </div>
    </div>
</div>