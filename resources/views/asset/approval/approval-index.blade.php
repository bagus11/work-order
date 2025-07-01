@extends('layouts.master')
@section('title', 'Approver')
@section('content')
<div class="pl-2 pr-2">
    <div class="row">
            <div class="col-md-12">
                <div class="card card-radius">
                    <div class="card-header">
                        <b class="headerTitle">Approver By Location</b>
                      <div class="card-tools">
                        <button class="btn btn-success btn-sm" id="btn_add_approver" data-toggle="modal" type="button" data-target="#addApprover">
                            <i class="fas fa-plus"></i>
                        </button>
                      </div>
                    </div>
                    <div class="card-body">
                        <table class="datatable-bordered nowrap display" id="approver_table">
                            <thead>
                                <tr>
                                    <th  style="text-align: center">No</th>
                                    <th  style="text-align: center">Approval ID</th>
                                    <th  style="text-align: center">Link</th>
                                    <th  style="text-align: center">Location</th>
                                    <th  style="text-align: center">Department</th>
                                    <th  style="text-align: center">Step Approval</th>
                                    <th  style="text-align: center">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="card-footer"></div>
                </div>
            </div>
    </div>
</div>
@include('asset.approval.modal.edit-approval')
@include('asset.approval.modal.add-approval')
@include('asset.approval.modal.step-approval')
@endsection
@push('custom-js')
@include('asset.approval.approver-js')
@endpush
