@extends('layouts.master')

@section('content')
<div class="container" style="margin-top:-15px">
    <div class="row">
        <div class="col-6 col-sm-6 col-md-2">
         <input type="date" id="from_date" class="form-control" value="{{date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-1 month" ) )}}">
        </div>
        <div class="col-6 col-sm-6 col-md-2">
         <input type="date" id="end_date" class="form-control" value="{{date('Y-m-d')}}">
        </div>
     </div>
</div>
<div class="container mt-2">
    <div class="row">
            <div class="col-12 col-sm-6 col-md-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-white elevation-1"><i class="fas fa-chart-bar"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">New</span>
                                <span class="info-box-number" id="status_new">
                            </span>
                        </div>
                        <div class="btn-group" style="float:right">
                            <button type="button" class="btn btn-tool dropdown-toggle" id="btnNewLog" style="margin-top:3px" data-toggle="dropdown">
                            <i class="fas fa-history"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" role="menu" style="min-width:285px; max-width:330px; !important;">
                                <div class="container">
                                        <table class="datatable-bordered nowrap display" id="logNewTable">
                                            <thead>
                                                <tr>
                                                    <th style="text-align:center;width:33%">No</th>
                                                    <th style="text-align:center;width:33%">Created At</th>
                                                    <th style="text-align:center;width:33%">Request Code</th>
                                                    <th style="text-align:center;width:33%">Category</th>
                                                </tr>
                                            </thead>
                                        </table>
                                </div>
                            </div>
                            
                        </div>
                    </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-chart-bar"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Progress</span>
                                <span class="info-box-number" id="status_on_progress">
                            </span>
                        </div>
                        <div class="btn-group" style="float:right">
                            <button type="button" class="btn btn-tool dropdown-toggle" id="btnProgressLog" style="margin-top:3px" data-toggle="dropdown">
                            <i class="fas fa-history"></i>
                            </button>

                            <div class="dropdown-menu dropdown-menu-right" role="menu" style="min-width:285px; max-width:330px; !important;">
                                <div class="container">
                                        <table class="datatable-bordered nowrap display" id="logProgressTable">
                                            <thead>
                                                <tr>
                                                    <th style="text-align:center;width:33%">No</th>
                                                    <th style="text-align:center;width:33%">Created At</th>
                                                    <th style="text-align:center;width:33%">Request Code</th>
                                                    <th style="text-align:center;width:33%">Category</th>
                                                </tr>
                                            </thead>
                                        </table>
                                </div>
                            </div>

                        </div>
                    </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-chart-bar"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Pending</span>
                                <span class="info-box-number" id="status_pending">
                            </span>
                        </div>
                        <div class="btn-group" style="float:right">
                            <button type="button" class="btn btn-tool dropdown-toggle" id="btnPendingLog" style="margin-top:3px" data-toggle="dropdown">
                            <i class="fas fa-history"></i>
                            </button>

                            <div class="dropdown-menu dropdown-menu-right" role="menu" style="min-width:285px; max-width:330px; !important;">
                                <div class="container">
                                        <table class="datatable-bordered nowrap display" id="logPendingTable">
                                            <thead>
                                                <tr>
                                                    <th style="text-align:center;width:33%">No</th>
                                                    <th style="text-align:center;width:33%">Created At</th>
                                                    <th style="text-align:center;width:33%">Request Code</th>
                                                    <th style="text-align:center;width:33%">Category</th>
                                                </tr>
                                            </thead>
                                        </table>
                                </div>
                            </div>

                        </div>
                    </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-chart-bar"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Revision</span>
                                <span class="info-box-number" id="status_revision">
                            </span>
                        </div>
                        <button type="button" class="btn btn-tool dropdown-toggle" id="btnRevisionLog" style="margin-top:3px" data-toggle="dropdown">
                          <i class="fas fa-history"></i>
                          </button>
    
                          <div class="dropdown-menu dropdown-menu-right" role="menu" style="min-width:285px; max-width:330px; !important;">
                              <div class="container">
                                      <table class="datatable-bordered nowrap display" id="logRevisionTable">
                                          <thead>
                                              <tr>
                                                  <th style="text-align:center;width:33%">No</th>
                                                  <th style="text-align:center;width:33%">Created At</th>
                                                  <th style="text-align:center;width:33%">Request Code</th>
                                                  <th style="text-align:center;width:33%">Category</th>
                                              </tr>
                                          </thead>
                                      </table>
                              </div>
                          </div>
                    </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-chart-bar"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Done</span>
                                <span class="info-box-number" id="status_done">
                            </span>
                        </div>
                        <button type="button" class="btn btn-tool dropdown-toggle" id="btnDoneLog" style="margin-top:3px" data-toggle="dropdown">
                          <i class="fas fa-history"></i>
                          </button>
    
                          <div class="dropdown-menu dropdown-menu-right" role="menu" style="min-width:285px; max-width:330px; !important;">
                              <div class="container">
                                      <table class="datatable-bordered nowrap display" id="logDoneTable">
                                          <thead>
                                              <tr>
                                                  <th style="text-align:center;width:33%">No</th>
                                                  <th style="text-align:center;width:33%">Created At</th>
                                                  <th style="text-align:center;width:33%">Request Code</th>
                                                  <th style="text-align:center;width:33%">Category</th>
                                              </tr>
                                          </thead>
                                      </table>
                              </div>
                          </div>
                    </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-black elevation-1"><i class="fas fa-chart-bar"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Reject</span>
                                <span class="info-box-number"  id="status_reject">
                            </span>
                        </div>
                        <button type="button" class="btn btn-tool dropdown-toggle" id="btnRejectLog" style="margin-top:3px" data-toggle="dropdown">
                          <i class="fas fa-history"></i>
                          </button>
    
                          <div class="dropdown-menu dropdown-menu-right" role="menu" style="min-width:285px; max-width:330px; !important;">
                              <div class="container">
                                      <table class="datatable-bordered nowrap display" id="logRejectTable">
                                          <thead>
                                              <tr>
                                                  <th style="text-align:center;width:33%">No</th>
                                                  <th style="text-align:center;width:33%">Created At</th>
                                                  <th style="text-align:center;width:33%">Request Code</th>
                                                  <th style="text-align:center;width:33%">Category</th>
                                              </tr>
                                          </thead>
                                      </table>
                              </div>
                          </div>
                    </div>
            </div>
        </div>
       

</div>
<div class="container">
    <div class="row">
        @can('rating-pic-dashboard')
        <div class="col-12 col-sm-6 col-md-3">
            <div class="card">
                <div class="card-header bg-white">
                    <label class="mt-2"> Rating</label>
                    <div class="card-tools">
                            <div class="btn-group" style="float:right">
                                <button type="button" class="btn btn-tool dropdown-toggle" style="margin-top:3px" data-toggle="dropdown">
                                <i class="fas fa-history"></i>
                                </button>
                        
                                <div class="dropdown-menu dropdown-menu-left" id="filter" role="menu" style="width:350px !important;">
                                    <div class="container">
                                    
                                    
                                            <table class="datatable-bordered nowrap display" id="ratingLog">
                                                <thead>
                                                    <tr>
                                                        <th style="text-align:center;width:33%">No</th>
                                                        <th style="text-align:center;width:33%">Date</th>
                                                        <th style="text-align:center;width:33%">Request Code</th>
                                                        <th style="text-align:center;width:33%">Rating</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                    </div>
                                </div>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-tool dropdown-toggle" style="margin-top:3px" data-toggle="dropdown">
                                    <ion-icon name="filter-sharp"></ion-icon>
                                </button>
                            
                                <div class="dropdown-menu dropdown-menu-center" id="ratingFilter" role="menu" style="width:350px !important;">
                                    <div class="container">
                                        <div class="row">
                                                <div class="col-md-4 mt-2">
                                                    <label for="">Filter Type</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <select  id="selectRatingFilter" class="select2">
                                                        <option value="1">All Period</option>    
                                                        <option value="2">Month</option>    
                                                        <option value="3">Year</option>    
                                                    </select>       
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-md-4 mt-2">
                                                    <label for="">Filter</label>
                                                </div>
                                                <div class="col-md-8" id="paramterRatingFilter">
                                                        <label class="mt-2" for="">All Period</label>
                                                </div>
                                            </div>
                                            <button class="btn btn-warning btn-block mt-2" id="btnRatingFilter">
                                                <ion-icon name="filter-sharp"></ion-icon> Filter
                                            </button>     
                                        </div>
                                    </div>  
                            </div>
                    </div>
                </div>
                <div class="card-body" style="font-size:12px;text-align:center;margin-bottom:-20px">
                        <img style="display:block;width:60%;margin:auto" src="{{URL::asset('profile.png')}}" alt="">
                      <br>
                            <b for="" style="text-align:center">{{auth()->user()->name}}</b> <br>
                            <strong for="" style="margin-top:10px" id="ratingUser"> Rating</strong>
                </div>
                <div class="card-footer"></div>
            </div>
        </div>
        @endcan
        @can('get-all-dashboard')
        <div class="col-12 col-sm-6 col-md-4">
            <div class="card">
                <div class="card-header bg-white">
                    <label class="mt-2"> Ranking PIC</label>
                    <div class="card-tools">
                            <div class="btn-group">
                                <button type="button" class="btn btn-tool dropdown-toggle" style="margin-top:3px" data-toggle="dropdown">
                                    <ion-icon name="filter-sharp"></ion-icon>
                                </button>
                            
                                <div class="dropdown-menu dropdown-menu-left" id="rankingFilter" role="menu" style="width:350px !important;">
                                    <div class="container">
                                            <div class="row">
                                                    <div class="col-md-4 mt-2">
                                                        <label for="">Filter Type</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <select  id="selectFilter" class="select2">
                                                            <option value="1">All Period</option>    
                                                            <option value="2">Month</option>    
                                                            <option value="3">Year</option>    
                                                        </select>       
                                                    </div>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-md-4 mt-2">
                                                        <label for="">Filter</label>
                                                    </div>
                                                    <div class="col-md-8" id="paramterFilter">
                                                            <label class="mt-2" for="">All Period</label>
                                                    </div>
                                                </div>
                                                <button class="btn btn-warning btn-block mt-2" id="btnRankingFilter">
                                                    <ion-icon name="filter-sharp"></ion-icon> Filter
                                                </button>     
                                    </div>
                                </div>  
                            </div>


                    </div>
                </div>
                <div class="card-body" style="font-size:12px;text-align:center;margin-bottom:-20px">
                    <table class="datatable-bordered nowrap display" id="classementTable">
                        <thead>
                            <tr>
                                <th style="text-align:center;width:25%">No</th>
                                <th style="text-align:center;width:25%">PIC</th>
                                <th style="text-align:center;width:25%">Total WO</th>
                                <th style="text-align:center;width:25%">Rating</th>
                            </tr>
                        </thead>
                    </table> 
                </div>
                <div class="card-footer"></div>
            </div>
        </div>
        @endcan
        @can('get-problem_type-dashboard')
        <div class="col-12 col-sm-6 col-md-3">
            <div class="card">
                <div class="card-header bg-white">
                    <label class="mt-2">Percentage</label>
                    <div class="card-tools">
                        <div class="btn-group">
                            <button type="button" class="btn btn-tool dropdown-toggle" style="margin-top:3px" data-toggle="dropdown">
                                <ion-icon name="filter-sharp"></ion-icon>
                            </button>
                        
                            <div class="dropdown-menu dropdown-menu-center" id="percentageFilter" role="menu" style="width:350px !important;">
                                <div class="container">
                                    <div class="row">
                                            <div class="col-md-4 mt-2">
                                                <label for="">Filter Type</label>
                                            </div>
                                            <div class="col-md-8">
                                                <select  id="selectPercentageFilter" class="select2">
                                                    <option value="1">All Period</option>    
                                                    <option value="2">Month</option>    
                                                    <option value="3">Year</option>    
                                                </select>       
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-4 mt-2">
                                                <label for="">Filter</label>
                                            </div>
                                            <div class="col-md-8" id="paramterPercentageFilter">
                                                <label class="mt-2" for="">All Period</label>
                                            </div>
                                        </div>
                                        <button class="btn btn-warning btn-block mt-2" id="btnPercentageFilter">
                                            <ion-icon name="filter-sharp"></ion-icon> Filter
                                        </button>     
                                    </div>
                                </div>  
                            </div>
                        </div>
                    </div>
                <div class="card-body">
                    <div class="container" id="percentageChart_container">
                        <h4 id="percentageLabel" style="text-align:center"></h4>
                        <canvas id="percentageChart"></canvas>
                    </div>
                </div>
                <div class="card-footer"></div>
            </div>
        </div>
        @endcan
        <div class="col-12 col-sm-12 col-md-6">
            <div class="card">
                <div class="card-header bg-white">
                    <label for=""> Tracking History</label>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="container" id="chart_container">
                        <canvas id="chart"></canvas>
                    </div>
                </div>
                <div class="card-footer">
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('custom-js')
@include('home.home-js')
@endpush
