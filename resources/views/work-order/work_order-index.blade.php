@extends('layouts.master')
@section('title', 'Work Order')
@section('content')
{{-- <div class="container">
    <div class="card collapsed-card">
        <div class="card-header bg-dark">
            <h3 class="card-title">Filter</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-plus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
        
        </div>
        
    </div>
</div> --}}
<div class="container">
    <div class="justify-content-center">
          <div class="col-md-12">
            <div class="card card-dark">
                <div class="card-header">
                    <div class="card-title"></div>
                  
                    <div class="card-tools">
                        <div class="btn-group" style="float:right">
                            <button type="button" class="btn btn-tool dropdown-toggle" style="margin-top:3px" data-toggle="dropdown">
                                <ion-icon name="filter-sharp"></ion-icon>
                            </button>
                       
                            <div class="dropdown-menu dropdown-menu-right" id="filter" role="menu" style="width:250px !important;">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-6 mt-2">
                                            <label for="">From</label>
                                            <input type="date" id="from" class="form-control" value="{{date('Y-m-d')}}">
                                        </div>
                                        <div class="col-md-6 mt-2">
                                            <label for="">To</label>
                                            <input type="date" class="form-control" id="to" value="{{date('Y-m-d')}}">
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <label for="">Office</label>
                                        <select name="officeFilter" id="officeFilter" class="select2" style="width:100%">
                                            <option value=""> * - All Office</option>
                                        </select>
                                    </div>
                                    <div class="mt-2">
                                        <label for=""> Status</label>
                                        <select class="select2" id="statusFilter">
                                        <option value="">* - All Progress</option>
                                        <option value="0">NEW</option>
                                        <option value="1">ON PROGRESS</option>
                                        <option value="2">PENDING</option>
                                        <option value="3">REVISION</option>
                                        <option value="4">DONE</option>
                                        </select>
                                    </div>
                                    <div class="mt-2 mb-2">
                                        <button class="btn btn-warning btn-block" id="btnFilter" onclick="get_work_order_list()">
                                            <ion-icon name="filter-sharp"></ion-icon> Filter
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @can('create-work_order_list')
                            <button id="add_wo" type="button" class="btn btn-success btn-sm" style="float:right"  data-toggle="modal" data-target="#addMasterKantor">
                                <ion-icon name="add-sharp"></ion-icon>
                            </button>
                        @endcan
                    <button id="refresh" onclick="get_work_order_list()" title="Refresh" style="float:right" class="btn btn-sm btn-info mr-2">
                        <ion-icon name="refresh-sharp"></ion-icon>
                    </button>
                      
                    </div>
                </div>
                <div class="card-body">
                    <input type="hidden" id="auth_id" value="{{auth()->user()->id}}">
                    <table class="datatable-bordered nowrap display" id="wo_table">
                        <thead>
                            <tr>
                                <th style="text-align:center"></th>
                                <th style="text-align:center">Request By</th>
                                <th style="text-align:center">Office</th>
                                <th style="text-align:center">Request Code</th>
                                <th style="text-align:center">Departement</th>
                                <th style="text-align:center">Category</th>
                                <th style="text-align:center">Status</th>
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
@include('work-order.edit-work_order')
@include('work-order.manual_assign-work_order')
@include('work-order.rating-work_order')
@include('work-order.detail-work_order')
@endsection
@push('custom-js')
@include('work-order.work_order-js')
@endpush