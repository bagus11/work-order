@extends('layouts.master')
@section('title', 'Master Category')
@section('content')
<div class="container">
    <div class="row justify-content-center">
          <div class="col-12">
            <div class="card card-dark">
                <div class="card-header">
                    List Product
                    <div class="card-tools">
                        @can('create-master_departement')
                        <button id="add_product" type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#addProductModal" style="float:right">
                            <i class="fas fa-plus"></i>
                        </button>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <table class="datatable-bordered nowrap display" id="product_table" >
                        <thead>
                            <tr>
                                <th style="text-align:center"></th>
                                <th style="text-align:center">Status</th>
                                <th style="text-align:center">Name</th>
                                <th style="text-align:center">Category</th>
                                <th style="text-align:center">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
      </div>
    </div>
</div>
@include('opex.master_product_opx.modal.add-product')
@include('opex.master_product_opx.modal.edit-product')
@endsection
@push('custom-js')
@include('opex.master_product_opx.master_product_opx-js')
@endpush