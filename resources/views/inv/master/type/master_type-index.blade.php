@extends('layouts.master')
@section('title', 'Master Type')
@section('content')


    <div class="justify-content-center">
          <div class="col-12">
            <div class="card card-dark">
                <div class="card-header">
                    <div class="card-title"></div>
                  
                    <div class="card-tools">
                        <button id="add_category" type="button" class="btn btn-sm btn-success " style="float:right"  data-toggle="modal" data-target="#addMasterCategory">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    
                    <table class="datatable-bordered nowrap display" id="type_table">
                        <thead>
                            <tr>
                              <th>No</th>
                              <th>Name</th>
                              <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
      </div>
    </div>

@include('inv.master.type.modal.add-type')
@include('inv.master.type.modal.edit-type')
@endsection
@push('custom-js')
@include('inv.master.type.master_type-js')
@endpush