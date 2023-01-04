@extends('layouts.master')
@section('title', 'Master Kategori')
@section('content')
<div class="container">
    <div class="row justify-content-center">
          <div class="col-md-10">
            <div class="card card-dark">
                <div class="card-header">
                    <div class="card-title">List Kategori</div>
                    <div class="card-tools">
                        @can('create-master_category')
                        <button id="add_kantor" type="button" class="btn btn-success" data-toggle="modal" data-target="#addCategories" style="float:right">
                            <i class="fas fa-plus"></i>
                        </button>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <table class="datatable-bordered nowrap display" id="categories_table" >
                        <thead>
                            <tr>
                                <th style="text-align:center"></th>
                                <th style="text-align:center">Status</th>
                                <th style="text-align:center">Nama</th>
                                <th style="text-align:center">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
      </div>
    </div>
</div>
@include('master_category.add-master_category')
@include('master_category.edit-master_category')
@endsection
@push('custom-js')
@include('master_category.master_category-js')
@endpush