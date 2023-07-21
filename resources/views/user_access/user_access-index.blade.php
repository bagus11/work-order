@extends('layouts.master')
@section('title', 'User Access')
@section('content')
<div class="container">
    <div class="row justify-content-center">
          <div class="col">
                <div class="card card-dark">
                    <div class="card-header">
                        Role User
                        <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#addRoleUserModal" style="float:right" onclick="get_username()">
                                <i class="fas fa-plus"></i>
                            </button>
                            
                        </div>
                    </div>
                    <div class="card-body">                     
                          <table class="datatable-bordered" id="role_user_table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                     
                    </div>
                </div>
          </div>
          @can('get-only_user-user_access')
          <div class="col">
            <div class="card card-dark">
                <div class="card-header">
                    Role Permission
                    <div class="card-tools">
                        <button type="button" class="btn  btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="datatable-bordered" id="role_permission_table">
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
              
          @endcan
    </div>
</div>
@include('user_access.add-role_user_modal')
@include('user_access.edit-role_user_modal')
@include('user_access.add-permission_modal')
@include('user_access.edit-permission_modal')
@endsection
@push('custom-js')
@include('user_access.user_access-js')
@endpush