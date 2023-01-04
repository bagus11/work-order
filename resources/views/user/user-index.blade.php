@extends('layouts.master')
@section('title', 'Setting')
@section('content')
<div class="container">
    <div class="row justify-content-center">
          <div class="col-md-10">
            <div class="card card-dark">
                <div class="card-header">
                    <div class="card-title">List User</div>
                    <div class="card-tools">
                        {{-- <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addRoleModal" style="float:right" onclick="clear_roles()">
                            <i class="fas fa-plus"></i>
                        </button> --}}
                    </div>
                </div>
                <div class="card-body">
                    <table class="datatable-bordered" id="user_table" style="width: 100%">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Status</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
      </div>
    </div>
</div>
@include('user.edit-user')
@endsection
@push('custom-js')
@include('user.user-js')
@endpush