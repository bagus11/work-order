@extends('layouts.master')
@section('title', 'Update System')
@section('content')

 <div class="row justify-content-center mx-2">
          <div class="col-12">
            <div class="card card-dark">
                <div class="card-header">
                    Ticket List
                    <div class="card-tools">
                        @can('create-update_system')
                        <button id="btn_add_ticket" type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#addSystemModal" style="float:right">
                            <i class="fas fa-plus"></i>
                        </button>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <table class="datatable-bordered nowrap display" id="update_system_table" >
                        <thead>
                            <tr>
                                <th style="text-align:center">Created At</th>
                                <th style="text-align:center">Ticket Code</th>
                                <th style="text-align:center">Location</th>
                                <th style="text-align:center">Department</th>
                                <th style="text-align:center">Created By</th>
                                <th style="text-align:center">Status</th>
                                <th style="text-align:center">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
      </div>
    </div>

@include('update_system.modal.check-update_system')
@include('update_system.modal.edit-update_system')
@include('update_system.modal.add-update_system')

@endsection
@push('custom-js')
@include('update_system.update_system-js')
@endpush