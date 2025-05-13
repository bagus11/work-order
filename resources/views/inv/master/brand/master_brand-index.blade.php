@extends('layouts.master')
@section('title', 'Master Brand')
@section('content')


    <div class="justify-content-center">
          <div class="col-12">
            <div class="card card-dark">
                <div class="card-header bg-core">
                    <div class="card-title">
                        Brand List
                    </div>
                  
                    <div class="card-tools">
                        <button id="add_brand" type="button" class="btn btn-sm btn-success " style="float:right"  data-toggle="modal" data-target="#addMasterBrandModal">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                        <button id="btn_import_modal" type="button" class="btn btn-sm btn-info mr-2" style="float:right"  data-toggle="modal" data-target="#importMasterCategory">
                            <i class="fa-solid fa-file-import"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    
                    <table class="datatable-bordered nowrap display" id="brand_table">
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

    @include('inv.master.brand.modal.add-master_brand')
    @include('inv.master.brand.modal.edit-master_brand')
@endsection
@push('custom-js')
@include('inv.master.brand.master_brand-js')
@endpush