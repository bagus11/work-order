@extends('layouts.master')
@section('title', 'Assignment')
@section('content')
<div class="justify-content-center">
      <div class="col-12">
        <div class="card card-dark">
            <div class="card-header">
                <label for="">List Assignment</label>
                <div class="card-tools">
                    <button id="refresh" onclick="get_work_order_list()" title="Refresh" class="btn btn-sm btn-info mr-2" style="float:right">
                        <i class="fas fa-refresh"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <table class="datatable-bordered nowrap display" id="assignment_table">
                    <thead>
                        <tr>
                            <th style="text-align:center">Request By</th>
                            <th style="text-align:center">Request Code</th>
                            <th style="text-align:center">Departement</th>
                            <th style="text-align:center">Category</th>
                            <th style="text-align:center">Status</th>
                            <th style="text-align:center">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
  </div>
</div>
@include('assignment.edit-assignment')
@include('assignment.priority-assignment')
@endsection
@push('custom-js')
@include('assignment.assignment-js')
@endpush