@extends('layouts.master')
@section('title', 'Work Order')
@section('content')
<div class="container">
    <div class="row justify-content-center">
          <div class="col-md-12">
            <div class="card card-dark">
                <div class="card-header">
                    <div class="card-title"></div>
                    <div class="card-tools">
                        @can('create-work_order_list')
                        <button id="add_wo" type="button" class="btn btn-success" data-toggle="modal" data-target="#addMasterKantor" style="float:right">
                            <i class="fas fa-plus"></i>
                        </button>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <table class="datatable-bordered nowrap display" id="wo_table">
                        <thead>
                            <tr>
                                <th style="text-align:center">Request By</th>
                                <th style="text-align:center">Request Code</th>
                                <th style="text-align:center">Category</th>
                                <th style="text-align:center">Date</th>
                                <th style="text-align:center">Status</th>
                                <th style="text-align:center">Approval</th>
                                <th style="text-align:center">PIC</th>
                                <th style="text-align:center">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
      </div>
    </div>
</div>
@include('work-order.add-work_order')
@endsection
@push('custom-js')
@include('work-order.work_order-js')
@endpush