
<div class="modal fade" id="addTeamDetail">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                Add Master Team Project
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <div class="container">
                  <div class="row">
                    <div class="col-12 mx-auto">
                        <input type="hidden" id="masterIdDetail">
                        <table class="datatable-bordered nowrap display" id="detailTeamTable">
                            <thead>
                                <tr>
                                    <th style="text-align: center"><input type="checkbox" id="checkAll" name="checkAll" class="checkAll" style="border-radius: 5px !important;"></th>
                                    <th>Name</th>
                                    <th>Departement</th>
                                    <th>Position</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button id="btnSaveDetail" type="button" class="btn btn-success">
                    <i class="fa-solid fa-user-plus"></i>
                </button>
                <button id="btnEditDetail" type="button" class="btn btn-danger">
                    <i class="fa-solid fa-user-minus"></i>
                </button>
            </div>
        </div>
    </div>
</div>