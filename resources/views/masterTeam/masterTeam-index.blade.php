@extends('layouts.master')
@section('title', 'Master Team Project')
@section('content')
<div class="container">
    <div class="row justify-content-center">
          <div class="col-md-9">
            <div class="card card-dark">
                <div class="card-header">
                    <div class="card-title">List Team </div>
                    <div class="card-tools">
                        @can('create-masterTeamProject')
                            <button id="add_priority" type="button" class="btn btn-success" data-toggle="modal" data-target="#addMasterTeam" style="float:right">
                                <i class="fas fa-plus"></i>
                            </button>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <table class="datatable-bordered nowrap display" id="masterTeamTable">
                        <thead>
                            <tr>
                                <th style="text-align:center">Name</th>
                                <th style="text-align:center">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
      </div>
    </div>
</div>
@include('masterTeam.masterTeam-add')
@include('masterTeam.masterTeam-addDetail')
@include('masterTeam.masterTeam-edit')
@endsection
@push('custom-js')
@include('masterTeam.masterTeam-js')
@endpush