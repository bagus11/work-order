@extends('layouts.master')

@section('content')
<div class="container" style="margin-top:-15px">
    <div class="row">
        <div class="col-12 col-sm-6 col-md-2">
         <input type="date" id="from_date" class="form-control" value="{{date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-1 month" ) )}}">
        </div>
        <div class="col-12 col-sm-6 col-md-2">
         <input type="date" id="end_date" class="form-control" value="{{date('Y-m-d')}}">
        </div>
     </div>
</div>
<div class="container mt-2">
    <div class="row">
            <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-white elevation-1"><i class="fas fa-chart-bar"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">New</span>
                                <span class="info-box-number" id="status_new">
                            </span>
                        </div>
                    </div>
            </div>
            <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-chart-bar"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Progress</span>
                                <span class="info-box-number" id="status_on_progress">
                            </span>
                        </div>
                    </div>
            </div>
            <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-chart-bar"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Pending</span>
                                <span class="info-box-number" id="status_pending">
                            </span>
                        </div>
                    </div>
            </div>
            <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-chart-bar"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Revision</span>
                                <span class="info-box-number" id="status_revision">
                            </span>
                        </div>
                    </div>
            </div>
            <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-chart-bar"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Done</span>
                                <span class="info-box-number" id="status_done">
                            </span>
                        </div>
                    </div>
            </div>
            <div class="col-12 col-sm-6 col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon bg-black elevation-1"><i class="fas fa-chart-bar"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Reject</span>
                                <span class="info-box-number"  id="status_reject">
                            </span>
                        </div>
                    </div>
            </div>
    </div>
</div>
<div class="container">
    <div class="row">
        @can('rating-pic-dashboard')
        <div class="col-12 col-sm-6 col-md-4">
            <div class="card">
                <div class="card-header bg-dark">
                    <label for=""> Rating User</label>
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
                                                <th style="text-align:center;width:33%">RFM</th>
                                                <th style="text-align:center;width:33%">Rating</th>
                                            </tr>
                                        </thead>
                                    </table>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
                <div class="card-body" style="font-size:12px;text-align:center;margin-bottom:-20px">
                        <img style="display:block;width:60%;margin:auto" src="{{URL::asset('profile.png')}}" alt="">
                      <br>
                            <b for="" style="text-align:center">{{auth()->user()->name}}</b> <br>
                            {{-- <b for="" id="jabatanUser" style="text-align:center">Jabatan</b> <br> --}}
                            {{-- <p style="text-align: left;font-size:12px" class="mt-2"> --}}
                                {{-- <strong for="" id="totalTask">Total Task </strong> <br> --}}
                                <strong for="" style="margin-top:10px" id="ratingUser"> Rating</strong>
                            {{-- </p> --}}
                </div>
                <div class="card-footer"></div>
            </div>
        </div>
        @endcan
        @can('get-all-dashboard')
            
        <div class="col-12 col-sm-6 col-md-4">
            <div class="card">
                <div class="card-header bg-dark">
                    <label for=""> Rating User</label>
                  <div class="card-tools">
                  
                  </div>
                </div>
                <div class="card-body" style="font-size:12px;text-align:center;margin-bottom:-20px">
                    <table class="datatable-bordered nowrap display" id="classementTable">
                        <thead>
                            <tr>
                                <th style="text-align:center;width:33%">No</th>
                                <th style="text-align:center;width:33%">PIC</th>
                                <th style="text-align:center;width:33%">Rating</th>
                            </tr>
                        </thead>
                    </table> 
                </div>
                <div class="card-footer"></div>
            </div>
        </div>
        @endcan
        <div class="col-12 col-sm-12 col-md-8">
            <div class="card">
                <div class="card-header bg-dark">
                    <h3 class="card-title">Tracking History</h3>
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
      
        {{-- <div class="col-12 col-sm-12 col-md-4">
            <div class="card collapsed-card">
                <div class="card-header bg-dark">
                    <h3 class="card-title">Filter</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="date" id="from_date" class="form-control" value="{{date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-1 month" ) )}}">
                        </div>
                        <div class="col-md-6">
                            <input type="date" id="end_date" class="form-control" value="{{date('Y-m-d')}}">
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

    </div>
</div>

@endsection
@push('custom-js')
@include('home.home-js')
@endpush
