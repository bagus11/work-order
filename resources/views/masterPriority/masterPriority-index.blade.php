@extends('layouts.master')
@section('title', 'Master Priority')
@section('content')
<div class="container">
    <div class="row justify-content-center">
          <div class="col-md-10">
            <div class="card card-dark">
                <div class="card-header">
                    <div class="card-title">List Priority</div>
                    <div class="card-tools">
                        @can('create-master_priority')
                            <button id="add_priority" type="button" class="btn btn-success" data-toggle="modal" data-target="#addPriority" style="float:right">
                                <i class="fas fa-plus"></i>
                            </button>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <table class="datatable-bordered nowrap display" id="masterPriorityTable">
                        <thead>
                            <tr>
                                <th style="text-align:center">Name</th>
                                <th style="text-align:center">Duration Lv 1</th>
                                <th style="text-align:center">Duration Lv 2</th>
                                <th style="text-align:center">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
      </div>
    </div>
</div>
@include('masterPriority.masterPriority-add')
@include('masterPriority.masterPriority-edit')
@endsection
@push('custom-js')
@include('masterPriority.masterPriority-js')
@endpush