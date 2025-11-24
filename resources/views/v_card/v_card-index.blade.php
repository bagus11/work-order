@extends('layouts.master')
@section('title', 'V Card')
@section('content')
<div class="container">
    <div class="row justify-content-center">
          <div class="col">
                <div class="card card-dark">
                    <div class="card-header">
                        User List
                        <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#addRoleUserModal" style="float:right" onclick="get_username()">
                                <i class="fas fa-plus"></i>
                            </button>
                            
                        </div>
                    </div>
                    <div class="card-body">                     
                          <table class="datatable-bordered" id="card_table">
                            <thead>
                                <tr>
                                    <th>NIK</th>
                                    <th>Name</th>
                                    <th>Title</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                     
                    </div>
                </div>
          </div>
        
    </div>
</div>
@include('v_card.modal.detail-card')
@endsection
@push('custom-js')
@include('v_card.v_card-js')
@endpush