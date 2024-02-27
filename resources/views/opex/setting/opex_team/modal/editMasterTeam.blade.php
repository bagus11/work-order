
<div class="modal fade" id="editMasterTeam">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-core">
                Edit Master Team Project
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <div class="container">
                  
                    <div class="form-group row">
                        <div class="col-md-2 mt-2">
                            <p for="">Name</p>
                    </div>
                        <div class="col-md-4">
                            <input type="hidden" class="form-control" id="teamHeadId">
                            <input type="text" class="form-control" id="teamNameUpdate">
                            <span  style="color:red;" class="message_error text-red block teamNameUpdate_error"></span>
                        </div>
                        <div class="col-md-2 mt-2">
                            <p for="">Leader</p>
                        </div>
                        <div class="col-md-4">
                            <select name="selectLeader" id="selectLeader" class="select2"></select>
                            <input type="hidden" name="leaderId" id="leaderId">
                            <span  style="color:red;" class="message_error text-red block leaderId_error"></span>
                        </div>
                    </div>
                 
                    <div class="row">
                        <div class="col-12">
                            <table class="datatable-bordered nowrap display" id="listTeamProject">
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
                <button id="btnUpdateName" type="button" class="btn btn-success">Save changes</button>
            </div>
        </div>
    </div>
</div>