@extends('layouts.master')
@section('title', 'Master Opex Team')
@section('content')


    <div class="row justify-content-center">
          <div class="col-10">
            <div class="card ">
                <div class="card-header bg-core">
                    <div class="card-title"></div>
                    <div class="card-tools">
                        <button class="btn btn-success btn-sm" id="btn_add_pc" data-toggle="modal" type="button" data-target="#addHeadModal">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    
                    <table class="datatable-bordered nowrap display" id="teamTable">
                        <thead>
                            <tr>
                                <th style="text-align:center;%">Name</th>
                                <th style="text-align:center;%">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
      </div>
    </div>
@endsection
@include('opex.setting.opex_team.modal.editMasterTeam')
@include('opex.setting.opex_team.modal.addHeadTeam')
@include('opex.setting.opex_team.modal.addTeam')
@push('custom-js')
@include('opex.setting.opex_team.opex_team-js')
@endpush