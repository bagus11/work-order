@extends('layouts.master')
@section('title', 'Role & Permission')
@section('content')
<div class="container">
    <div class="row justify-content-center">
          <div class="col-md-6">
                <div class="card card-dark">
                    <div class="card-header">
                        <div class="card-title">List Role</div>
                        <div class="card-tools">
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addRoleModal" style="float:right" onclick="clear_roles()">
                                <i class="fas fa-plus"></i>
                            </button>
                            
                        </div>
                    </div>
                    <div class="card-body">                     
                          <table class="datatable-bordered" id="roles_table">
                            <thead>
                                <tr>
                                    <th>Name</th>
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
                    <div class="card-title">List Permission</div>
                    <div class="card-tools">
                        {{-- <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button> --}}
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addPermissionModal" style="float:right" onclick="permission_menus_name()">
                            <i class="fas fa-plus"></i>
                        </button>
                        
                    </div>
                </div>
                <div class="card-body">
                    <table class="datatable-bordered nowrap display" id="permission_table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
      </div>
    </div>
</div>

@include('role_permission.add-role_modal')
@include('role_permission.edit-role_modal')
@include('role_permission.add-permission_modal')
@endsection
@push('custom-js')
    @include('role_permission.role_permission-js')
@endpush