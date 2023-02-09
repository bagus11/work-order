@extends('layouts.master')

@section('content')
<div class="container" style="margin-top:-15px">
    <div class="row justify-content-start">
        <div class="col-12 col-sm-6 col-md-2">
         <input type="date" id="from_date" class="form-control" value="{{date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-1 month" ) )}}">
        </div>
        <div class="col-12 col-sm-6 col-md-2">
         <input type="date" id="end_date" class="form-control" value="{{date('Y-m-d')}}">
        </div>
     </div>
</div>
<div class="container mt-2">
    <div class="row justify-content-center">
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
    <div class="row justify-content-start">
        <div class="col-12 col-sm-12 col-md-6">
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
