@extends('layouts.master')
@section('title', 'Monitoring OPEX')
@section('content')
<div class="container">
    <div class="row justify-content-center">
          <div class="col-12">
            <div class="card card-dark">
                <div class="card-header">
                    List OPX
                    <div class="card-tools">
                        @can('create-master_departement')
                        <button id="btn_add_opx" type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#addOPXModal" style="float:right">
                            <i class="fas fa-plus"></i>
                        </button>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <table class="datatable-bordered nowrap display" id="opx_table" >
                        <thead>
                            <tr>
                                <th style="text-align:center"></th>
                                <th style="text-align:center">Category</th>
                                <th style="text-align:center">Location</th>
                                <th style="text-align:center">Amount</th>
                                <th style="text-align:center">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
      </div>
    </div>
</div>
@include('opex.monitoring_opx.modal.add-opx')
@include('opex.monitoring_opx.modal.edit_po')
@include('opex.monitoring_opx.modal.edit-Is')
{{-- @include('opex.master_product_opx.modal.edit-product') --}}
@endsection
@push('custom-js')
@include('opex.monitoring_opx.monitoring_opx-js')
@endpush