@extends('layouts.master')
@section('title', 'Master Kategori')
@section('content')
<div class="container">
    <div class="row justify-content-center">
          <div class="col-12">
            <div class="card card-dark">
                <div class="card-header">
                    List Room
                    <div class="card-tools">
                        @can('create-master_category')
                        <button id="btn_add_room" type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#addRoomModal" style="float:right">
                            <i class="fas fa-plus"></i>
                        </button>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <table class="datatable-bordered nowrap display" id="master_room_table" >
                        <thead>
                            <tr>
                                <th style="text-align:center">Location</th>
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
@include('master_room.modal.add-room')
@include('master_room.modal.edit-room')

@endsection
@push('custom-js')
@include('master_room.master_room-js')
@endpush