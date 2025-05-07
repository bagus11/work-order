@extends('layouts.master')
@section('title', 'Incident Log')
@section('content')
<div class="justify-content-center">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-dark">
                Incident Log
                <div class="card-tools">
                    <button id="btnAddHeader" type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#addHeader" style="float:right">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <table class="datatable-bordered" id="incidentTable">
                    <thead>
                        <tr>
                            <th style="text-align: center">Created At</th>
                            <th style="text-align: center">Incident Code</th>
                            <th style="text-align: center">Location</th>
                            <th style="text-align: center">Incident Category</th>
                            <th style="text-align: center">Incident Problem</th>
                            <th style="text-align: center">Status</th>
                            <th style="text-align: center">Duration</th>
                            <th style="text-align: center">Action</th>
                        </tr>
                    </thead>

                </table>
            </div>
        </div>
    </div>
</div>
@include('incident_log.incident_log-add')
@include('incident_log.incident_log-detail')
@include('incident_log.incident_log-edit')
@endsection
@push('custom-js')
@include('incident_log.incident_log-js')
@endpush