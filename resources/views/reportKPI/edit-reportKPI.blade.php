
<div class="modal fade" id="editKPIUser">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h4 class="modal-title">KPI User</h4>
                <button type="button" class="close" data-dismiss="modal" aria-span="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                   <div class="row">
                     <div class="col-12 col-sm-4 col-md-3">
                         <div class="d-flex justify-content-center">
                             <img src="{{URL::asset('profile.png')}}" class="img-circle elevation-2 mt-2" style="width:120px;margin-top:auto;margin-bottom:auto" alt="User Image">
                         </div>
                     </div>
                     <div class="col-12 col-sm-8 col-md-9 mt-4">
                         <div class="d-flex justify-content-center">
                            <input type="hidden" id="user_id">
                             <div class="row">
                                 <div class="col-4 col-sm-4 col-md-2 mt-2">
                                     <span for="">Name</span>
                                 </div>
                                 <div class="col-8 col-sm-8 col-md-10 mt-2">
                                   <span for="" id="userNameLabel"></span>
                                 </div>
                                 <div class="col-4 col-sm-4 col-md-2 mt-2">
                                     <span for="">Departement</span>
                                 </div>
                                 <div class="col-8 col-sm-8 col-md-10 mt-2">
                                     <span for="" id="departementUserLabel"></span>
                                 </div>
                                 <div class="col-4 col-sm-4 col-md-2 mt-2">
                                     <span for="">Position</span>
                                 </div>
                                 <div class="col-8 col-sm-8 col-md-10 mt-2">
                                     <span for="" id="positionUserLabel"></span>
                                 </div>
                             </div>
                         </div>  
                     </div>  
                   </div>
                </div>
                <hr>
                <div class="row justify-content-end">
                    <div class="col-2 col-sm-2 col-md-1 mt-2">
                        <span for="">Date</span>
                    </div>
                    <div class="col-6 col-sm-6 col-md-3">
                        <input type="month" class="form-control" id="dateFilter"  value="{{date('Y-m')}}">
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-5 col-sm-5 col-md-3">
                        <span>Ticket Total </span>
                    </div>  
                    <div class="col-7 col-sm-7 col-md-3">
                        <span id="totalWOLabel"></span>
                    </div>  
                    <div class="col-5 col-sm-5 col-md-3">
                        <span>Ticket Complete </span>
                    </div>  
                    <div class="col-7 col-sm-7 col-md-3">
                        <span id="completeWOLabel"></span>
                    </div>  
                   
                    <div class="col-5 col-sm-5 col-md-3">
                        <span>Duration Level 1</span>
                    </div>  
                    <div class="col-7 col-sm-7 col-md-3">
                        <span id="totalDurationLv1"></span>
                    </div>  
                    <div class="col-5 col-sm-5 col-md-3">
                        <span>Duration Level 2</span>
                    </div>  
                    <div class="col-7 col-sm-7 col-md-3">
                        <span id="totalDurationLv2"></span>
                    </div>  
                    <div class="col-5 col-sm-5 col-md-3">
                        <span>AVG Level 1</span>
                    </div>  
                    <div class="col-7 col-sm-7 col-md-3">
                        <span id="durationLv1"></span>
                    </div>  
                    <div class="col-5 col-sm-5 col-md-3">
                        <span>AVG Level 2</span>
                    </div>  
                    <div class="col-7 col-sm-7 col-md-3">
                        <span id="durationLv2"></span>
                    </div>  
                    <div class="col-5 col-sm-5 col-md-3">
                        <span>Percentage </span>
                    </div>  
                    <div class="col-7 col-sm-7 col-md-9">
                        <span id="percentageLabel"></span>
                    </div>  
                </div>
                <div class="row mt-4">
                    <div class="col-12 col-sm-12 col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <label for="" class="mt-2">Percentage Category</label>
                            </div>
                            <div class="card-body">
                                <div class="container" id="percentageCategoryContainer">
                                    <canvas id="percentageCategory" style="width:400px !important; height:400px !important"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <label for="" class="mt-2">Counting by Location</label>
                            </div>
                            <div class="card-body">
                                <div class="container" id="countingByCategoryContainer">
                                    <canvas id="countingByCategory" width="100" height="100"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button id="btn_update_roles" type="button" class="btn btn-success">
                <i class="fas fa-print"></i> Print KPI User
                </button>
            </div>
        </div>
    </div>
</div>