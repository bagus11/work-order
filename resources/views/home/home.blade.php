@extends('layouts.master')
@section('content')
<div>
    <div class="pr-2 pl-2" style="margin-top:-15px">
        <div class="row">
            <div class="col-6 col-sm-6 col-md-2">
             <input type="date" id="from_date" class="form-control" value="{{date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-1 month" ) )}}">
            </div>
            <div class="col-6 col-sm-6 col-md-2">
             <input type="date" id="end_date" class="form-control" value="{{date('Y-m-d')}}">
            </div>
         </div>
    </div>
    <div class="pl-2 pr-2 mt-2">
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
                                                        <th style="text-align:center;width:5%">No</th>
                                                        <th style="text-align:center;width:30%;padding: 0 60px 0 60px">Created At</th>
                                                        <th style="text-align:center;width:35%;padding: 0 60px 0 60px">Request Code</th>
                                                        <th style="text-align:center;width:30%;padding: 0 60px 0 60px">Category</th>
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
                                                        <th style="text-align:center;width:5%">No</th>
                                                        <th style="text-align:center;width:30%;padding: 0 60px 0 60px">Created At</th>
                                                        <th style="text-align:center;width:35%;padding: 0 60px 0 60px">Request Code</th>
                                                        <th style="text-align:center;width:30%;padding: 0 60px 0 60px">Category</th>
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
                                                        <th style="text-align:center;width:5%">No</th>
                                                        <th style="text-align:center;width:30%;padding: 0 60px 0 60px">Created At</th>
                                                        <th style="text-align:center;width:35%;padding: 0 60px 0 60px">Request Code</th>
                                                        <th style="text-align:center;width:30%;padding: 0 60px 0 60px">Category</th>
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
                                                    <th style="text-align:center;width:5%">No</th>
                                                    <th style="text-align:center;width:30%;padding: 0 60px 0 60px">Created At</th>
                                                    <th style="text-align:center;width:35%;padding: 0 60px 0 60px">Request Code</th>
                                                    <th style="text-align:center;width:30%;padding: 0 60px 0 60px">Category</th>
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
                                                    <th style="text-align:center;width:5%">No</th>
                                                    <th style="text-align:center;width:30%;padding: 0 60px 0 60px">Created At</th>
                                                    <th style="text-align:center;width:35%;padding: 0 60px 0 60px">Request Code</th>
                                                    <th style="text-align:center;width:30%;padding: 0 60px 0 60px">Category</th>
                                                  </tr>
                                              </thead>
                                          </table>
                                  </div>
                              </div>
                        </div>
                </div>
                <div class="col-12 col-sm-6 col-md-4">
                        <div class="info-box">
                            <span class="info-box-icon bg-orange elevation-1"><i class="fas fa-chart-bar"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Checking</span>
                                    <span class="info-box-number"  id="status_checking">
                                </span>
                            </div>
                            <button type="button" class="btn btn-tool dropdown-toggle" id="btnCheckingLog" style="margin-top:3px" data-toggle="dropdown">
                              <i class="fas fa-history"></i>
                              </button>
        
                              <div class="dropdown-menu dropdown-menu-right" role="menu" style="min-width:285px; max-width:330px; !important;">
                                  <div class="container">
                                          <table class="datatable-bordered nowrap display" id="logCheckingTable">
                                              <thead>
                                                  <tr>
                                                    <th style="text-align:center;width:5%">No</th>
                                                    <th style="text-align:center;width:30%;padding: 0 60px 0 60px">Created At</th>
                                                    <th style="text-align:center;width:35%;padding: 0 60px 0 60px">Request Code</th>
                                                    <th style="text-align:center;width:30%;padding: 0 60px 0 60px">Category</th>
                                                  </tr>
                                              </thead>
                                          </table>
                                  </div>
                              </div>
                        </div>
                </div>
            </div>
           
    
    </div>
    <div class="pr-2 pl-2">
        <div class="row">
            @can('rating-pic-dashboard')
            <div class="col-12 col-sm-12 col-md-4">
                <div class="card">
                    <div class="card-header bg-white">
                        Rating
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
                                                            <th style="text-align:center;width:2%">No</th>
                                                            <th style="text-align:center;width:19%;padding: 0 30px 0 30px">Date</th>
                                                            <th style="text-align:center;width:23%;padding: 0 30px 0 30px">Request Code</th>
                                                            <th style="text-align:center;width:15%;padding: 0 30px 0 30px">Rating</th>
                                                            <th style="text-align:center;width:19%;padding: 0 30px 0 30px">Duration</th>
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
                                                        Filter Type
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
                                                        Filter
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
                    <div class="card-body" style="font-size:12px;text-align:center;margin-bottom:-20px;min-height:283px">
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
            <div class="col-12 col-sm-12 col-md-6">
                <div class="card">
                    <div class="card-header bg-white">
                         Ranking PIC
                        <div class="card-tools">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-tool dropdown-toggle" style="margin-top:3px" data-toggle="dropdown">
                                        <ion-icon name="filter-sharp"></ion-icon>
                                    </button>
                                
                                    <div class="dropdown-menu dropdown-menu-left" id="rankingFilter" role="menu" style="width:350px !important;">
                                        <div class="container">
                                                <div class="row">
                                                        <div class="col-md-4 mt-2">
                                                            Filter Type
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
                                                            Filter
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
                      
                            <table class="datatable-bordered nowrap display table-wrapper" id="classementTable" >
                                <thead>
                                    <tr>
                                        <th style="text-align:center;width:5%">No</th>
                                        <th style="text-align:center;width:59%;padding:0 90px 0 90px">PIC</th>
                                        <th style="text-align:center;width:12%">Total WO</th>
                                        <th style="text-align:center;width:12%">Rating</th>
                                        <th style="text-align:center;width:12%;padding: 0 30px 0 30px">Duration</th>
                                    </tr>
                                </thead>
                            </table> 
                       
                    </div>
                    <div class="card-footer"></div>
                </div>
            </div>
    
            
            @endcan
            @can('get-problem_type-dashboard')
            <div class="col-12 col-sm-12 col-md-4 col-xd-4">
                <div class="card">
                    <div class="card-header bg-white">
                        Percentage
                        <div class="card-tools">
                            <div class="btn-group">
                                <button type="button" class="btn btn-tool dropdown-toggle" style="margin-top:3px" data-toggle="dropdown">
                                    <ion-icon name="filter-sharp"></ion-icon>
                                </button>
                            
                                <div class="dropdown-menu dropdown-menu-left" id="percentageFilter" role="menu" style="width:350px !important;">
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
                        <div class="card-body" style="font-size:12px;text-align:center;margin-bottom:-20px;min-height:283px">
                        <div class="container" id="percentageChart_container">
                            <h4 id="percentageLabel" style="text-align:center"></h4>
                            <canvas id="percentageChart"></canvas>
                        </div>
                    </div>
                    <div class="card-footer"></div>
                </div>
            </div>
            @endcan
            @if (auth()->user()->can('get-problem_type-dashboard') || auth()->user()->can('get-all-dashboard'))
            <div class="col-12 col-sm-12 col-md-6 col-xd-6" id="level2TableContainer">
                <div class="card">
                    <div class="card-header bg-white">
                        Ticket Lv 2
                        <div class="card-tools">
                            <div class="btn-group">
                                <button type="button" class="btn btn-tool dropdown-toggle" style="margin-top:3px" data-toggle="dropdown">
                                    <ion-icon name="filter-sharp"></ion-icon>
                                </button>
                            
                                <div class="dropdown-menu dropdown-menu-right" id="ticketFilter" role="menu" style="width:350px !important;">
                                    <div class="container">
                                            <div class="row">
                                                    <div class="col-md-4 mt-2">
                                                        Filter Type
                                                    </div>
                                                    <div class="col-md-8">
                                                        <select  id="selectTicketFilter" class="select2">
                                                            <option value="1">All Period</option>    
                                                            <option value="2">Month</option>    
                                                            <option value="3">Year</option>    
                                                        </select>       
                                                    </div>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-md-4 mt-2">
                                                        Filter
                                                    </div>
                                                    <div class="col-md-8" id="paramterTicketFilter">
                                                            <label class="mt-2" for="">All Period</label>
                                                    </div>
                                                </div>
                                                <button class="btn btn-warning btn-block mt-2" id="btnLevel2">
                                                    <ion-icon name="filter-sharp"></ion-icon> Filter
                                                </button>     
                                    </div>
                                </div>  
                            </div>
    
    
                    </div>
                    </div>
                        <div class="card-body" style="font-size:12px;text-align:center;margin-bottom:-20px;">
                            <table class="datatable-bordered nowrap display table-wrapper no-footer dataTable" id="level2Table">
                                <thead>
                                    <tr>
                                        <th>RFM</th>
                                        <th>Departement</th>
                                        <th>Category</th>
                                        <th>Problem Type</th>
                                        <th>PIC</th>
                                        <th>Durasi</th>
                                    </tr>
                                </thead>
    
                            </table>
                        
                    </div>
                    <div class="card-footer"></div>
                </div>
            </div>
            @endif
            <div class="col-12 col-sm-12 col-md-4" hidden>
                <div class="card">
                    <div class="card-header bg-white">
                        Tracking History
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
</div>

@endsection
@push('custom-js')
@include('home.home-js')
@endpush
