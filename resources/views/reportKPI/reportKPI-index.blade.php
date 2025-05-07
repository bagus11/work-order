@extends('layouts.master')
@section('title', 'KPI Support')
@section('content')
<div class="container">
    <div class="row justify-content-center">
          <div class="col-md-10">
            <div class="card card-dark">
                <div class="card-header">
                  <label class="mt-2"> List User</label>
                </div>
                <div class="card-body">
                    <table class="datatable-bordered nowrap display" id="kpiReportTable">
                        <thead>
                            <tr>
                                <th style="text-align:center">Name</th>
                                <th style="text-align:center">Departement</th>
                                <th style="text-align:center">Position</th>
                                <th style="text-align:center">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
      </div>
    </div>
</div>
@include('reportKPI.edit-reportKPI')
{{-- @include('reportKPI.edit-reportKPI') --}}
@endsection
@push('custom-js')
@include('reportKPI.reportKPI-js')
@endpush