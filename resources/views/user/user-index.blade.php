@extends('layouts.master')
@section('title', 'Setting')
@section('content')
<div class="container">
    <div class="row justify-content-center">
          <div class="col-12">
            <div class="card card-dark">
                <div class="card-header">
                    List User
                    @can('import_user-user_setting')
                    <div class="card-tools">
                        <button class="btn btn-sm btn-success" title="Import User HRIS" id="btnImportUser">
                            <i class="fa-solid fa-user-secret"></i>
                        </button>
                    </div>
                    @endcan
                </div>
                <div class="card-body">
                    <table class="datatable-bordered" id="user_table" style="width: 100%">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Status</th>
                                <th>Name</th>
                                <th>NIK</th>
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