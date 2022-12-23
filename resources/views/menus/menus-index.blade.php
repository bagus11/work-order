@extends('layouts.master')
@section('title', 'Menus')
@section('content')
<div class="container">
    <div class="row justify-content-center">
          <div class="col-md-6">
                <div class="card card-dark">
                    <div class="card-header">
                        <div class="card-title">List Menus</div>
                        <div class="card-tools">
                            {{-- <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button> --}}
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-danger" style="float:right" onclick="clear_menus()">
                                <i class="fas fa-plus"></i>
                            </button>
                            
                        </div>
                    </div>
                    <div class="card-body">                     
                          <table class="datatable-bordered" id="menus_table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Link</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                     
                    </div>
                </div>
          </div>
          <div class="col-md-6">
            <div class="card card-dark">
                <div class="card-header">
                    <div class="card-title">List Submenus</div>
                    <div class="card-tools">
                        {{-- <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button> --}}
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addSubmenusModal" style="float:right" onclick="clear_submenus()">
                            <i class="fas fa-plus"></i>
                        </button>
                        
                    </div>
                </div>
                <div class="card-body">
                    <table class="datatable-bordered" id="submenus_table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Link</th>
                                <th>Status</th>
                                <th>Action</th>
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
@endsection
@push('custom-js')
@include('menus.menus-js')
@endpush