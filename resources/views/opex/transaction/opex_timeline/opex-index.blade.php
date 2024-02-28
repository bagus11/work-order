@extends('layouts.master')
@section('title', 'OPEX Timeline')
@section('content')
<div class="container">
    <div class="row justify-content-center">
          <div class="col-md-12">
            <div class="card card-core">
                <div class="card-header bg-core" style="font-size:12px;font-weight:bold">
                    Project OPEX 
                    <div class="card-tools">
                        @can('create-masterTeamProject')
                            <button id="btn_add_head" type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#addHeadModal" style="float:right">
                                <i class="fas fa-plus"></i>
                            </button>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <table class="datatable-bordered nowrap display" id="timeline_table">
                        <thead>
                            <tr>
                                <th style="text-align:center"></th>
                                <th style="text-align:center">Request Code</th>
                                <th style="text-align:center">Office</th>
                                <th style="text-align:center">Project Name</th>
                                <th style="text-align:center">Progress</th>
                                <th style="text-align:center">Status</th>
                                <th style="text-align:center">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
      </div>
    </div>
</div>
@include('opex.transaction.opex_timeline.modal.add-head')
@include('opex.transaction.opex_timeline.modal.edit-head')
@endsection
@push('custom-js')
@include('opex.transaction.opex_timeline.opex-js')
@endpush