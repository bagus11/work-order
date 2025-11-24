@extends('layouts.master')
@section('title', 'Monitoring OPEX')
@section('content')
   <div class="row justify-content-center mx-2">
          <div class="col-12">
            <div class="card card-dark">
                <div class="card-header">
                    List OPX
                    <div class="card-tools">
                         <div class="btn-group" style="float:right">
                            <button type="button" class="btn btn-sm btn-tool dropdown-toggle" style="margin-top:3px" data-toggle="dropdown">
                               <i class="fas fa-filter" style="color: white"></i>
                            </button>
                       
                            <div class="dropdown-menu dropdown-menu-right" id="filter" role="menu" style="width:250px !important;">
                                <div class="container">
                                    <div class="mt-2">
                                        <div class="row">
                                            <div class="col-3 mt-2">
                                                <p for="">Office</p>
                                            </div>
                                            <div class="col">
                                                <select name="location_filter" id="location_filter" class="select2" style="width:100%">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-3 mt-2">
                                                <p>Period</p>
                                            </div>
                                            <div class="col">
                                                <input type="month" class="form-control" style="font-size: 10px;text-align:center" min="2020"  id="year_filter" value="{{ date('Y-m') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <div class="row">
                                            <div class="col-6">
                                                <button class="btn btn-success btn-block" id="btn_export_excel" style="font-size:10px">
                                                    <i class="fas fa-file-excel"></i>  Export Excell
                                                </button>
                                            </div>
                                            <div class="col-6">
                                                <button class="btn btn-info btn-block" id="btn_filter" style="font-size:10px">
                                                    <i class="fas fa-filter"></i> Filter
                                                </button>
                                            </div>
                                        </div>
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
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
@include('opex.monitoring_opx.modal.add-opx')
@include('opex.monitoring_opx.modal.edit_po')
@include('opex.monitoring_opx.modal.edit-Is')
@include('opex.monitoring_opx.modal.info-opx')
{{-- @include('opex.master_product_opx.modal.edit-product') --}}
@endsection
@push('custom-js')
@include('opex.monitoring_opx.monitoring_opx-js')
@endpush