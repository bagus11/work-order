@extends('layouts.master')
@section('title', 'Assignment')
@section('content')
<div class="justify-content-center">
      <div class="col-12">
        <div class="card card-dark">
            <div class="card-header bg-core">
                <label for="">Approval Matrix</label>
                <div class="card-tools">
                    <button id="btn_add_approval" title="Add Approval" class="btn btn-sm btn-success mr-2" style="float:right">
                        <i class="fas fa-plus"></i>
                    </button>
                    <button id="refresh" title="Refresh" class="btn btn-sm btn-info mr-2" style="float:right">
                        <i class="fas fa-refresh"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <table class="datatable-bordered nowrap display" id="approval_table">
                    <thead>
                        <tr>
                             <tr>
                                <th style="text-align: center">Approval Code</th>
                                <th style="text-align: center">Step</th>
                                <th style="text-align: center">Aspect</th>
                                <th style="text-align: center">Module</th>
                                <th style="text-align: center">Data Type</th>
                                <th style="text-align: center">Action</th>
                            </tr>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
  </div>
</div>
@include('approval_matrix.modal.update-approval_matrix')
@include('approval_matrix.modal.edit-approval_matrix')
@include('approval_matrix.modal.add-approval_matrix')
@endsection
@push('custom-js')
@include('approval_matrix.approval_matrix-js')
@endpush