@extends('layouts.master')
@section('title', 'Master Category')
@section('content')
<div class="container">
    <div class="row justify-content-center">
          <div class="col-12">
            <div class="card card-dark">
                <div class="card-header">
                    List Category
                    <div class="card-tools">
                        @can('create-master_departement')
                        <button id="add_kantor" type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#addCategoryModal" style="float:right">
                            <i class="fas fa-plus"></i>
                        </button>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <table class="datatable-bordered nowrap display" id="category_table" >
                        <thead>
                            <tr>
                                <th style="text-align:center"></th>
                                <th style="text-align:center">Status</th>
                                <th style="text-align:center">Name</th>
                                <th style="text-align:center">Type</th>
                                <th style="text-align:center">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
      </div>
    </div>
</div>
@include('opex.master_category_opex.modal.add-category')
@include('opex.master_category_opex.modal.edit-category')
@endsection
@push('custom-js')
@include('opex.master_category_opex.master_category_opex-js')
@endpush