@extends('layouts.master')
@section('title', 'Menus')
@section('content')
<div class="container">
    <div class="row justify-content-center">
          <div class="col-md-6">
                <div class="card card-dark">
                    <div class="card-header">
                        List Menus
                        <div class="card-tools">
                            @can('create-menus')
                            <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-danger" style="float:right" onclick="clear_menus()">
                                <i class="fas fa-plus"></i>
                            </button>
                            @endcan
                            
                        </div>
                    </div>
                    <div class="card-body">                     
                          <table class="datatable-bordered nowrap display" id="menus_table">
                            <thead>
                                <tr>
                                    <th  style="text-align: center">Name</th>
                                    <th  style="text-align: center">Link</th>
                                    <th  style="text-align: center">Status</th>
                                    <th  style="text-align: center">Action</th>
                                </tr>
                            </thead>
                        </table>
                     
                    </div>
                </div>
          </div>
          <div class="col-md-6">
            <div class="card card-dark">
                <div class="card-header">
                    List Submenus
                    <div class="card-tools">
                        {{-- <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button> --}}
                        <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#addSubmenusModal" style="float:right" onclick="clear_submenus()">
                            <i class="fas fa-plus"></i>
                        </button>
                        
                    </div>
                </div>
                <div class="card-body">
                    <table class="datatable-bordered nowrap display" id="submenus_table">
                        <thead>
                            <tr>
                                <th style="text-align: center">Name</th>
                                <th style="text-align: center">Link</th>
                                <th style="text-align: center">Status</th>
                                <th style="text-align: center">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
      </div>
    </div>
</div>
@include('menus.add-menus_modal')
@include('menus.edit-menus_modal')
@include('menus.add-submenus_modal')
@include('menus.edit-submenus_modal')
@endsection
@push('custom-js')
@include('menus.menus-js')
@endpush