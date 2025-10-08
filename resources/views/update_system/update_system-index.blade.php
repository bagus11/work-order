@extends('layouts.master')
@section('title', 'Update System')
@section('content')

 <div class="row justify-content-center mx-2">
          <div class="col-12">
            <div class="card card-dark">
                <div class="card-header">
                    Ticket List
                    <div class="card-tools">
                            <div class="btn-group" style="float:right">
                            <button type="button" class="btn btn-sm btn-tool dropdown-toggle" style="margin-top:3px" data-toggle="dropdown">
                               <i class="fas fa-filter" style="color: white"></i>
                            </button>
                       
                            <div class="dropdown-menu dropdown-menu-right" id="filter" role="menu" style="width:250px !important;">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-6 mt-2">
                                            <p for="">From</p>
                                            <input type="date" id="from" class="form-control" value="{{date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-1 month" ) )}}">
                                        </div>
                                        <div class="col-md-6 mt-2">
                                            <p for="">To</p>
                                            <input type="date" class="form-control" id="to" value="{{date('Y-m-d')}}">
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <p for="">Office</p>
                                        <select name="officeFilter" id="officeFilter" class="select2" style="width:100%">
                                            <option value=""> * - All Office</option>
                                        </select>
                                    </div>
                                    <div class="mt-2">
                                        <p for=""> Status</p>
                                        <select class="select2" id="statusFilter">
                                        <option value="">* - All Progress</option>
                                        <option value="0">Waiting For Approval</option>
                                        <option value="1">On Progress</option>
                                        <option value="2">Checking</option>
                                        <option value="3">Revise</option>
                                        <option value="4">DONE</option>
                                        <option value="5">REJECT</option>
                                        </select>
                                    </div>
                                    <div class="mt-2 mb-2">
                                        <button class="btn btn-info btn-block" id="btnReportWO">
                                            <ion-icon name="print"></ion-icon>  Print WO
                                        </button>
                                    <button class="btn btn-warning btn-block" id="btnFilter" onclick="get_work_order_list()">
                                        <ion-icon name="filter-sharp"></ion-icon> Filter
                                    </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @can('create-update_system')
                        <button id="btn_add_ticket" type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#addSystemModal" style="float:right">
                            <i class="fas fa-plus"></i>
                        </button>
                        @endcan
                        <button id="btn_refresh" type="button" class="btn btn-sm btn-info mr-2" style="float:right">
                            <i class="fas fa-refresh"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="datatable-bordered nowrap display" id="update_system_table" >
                        <thead>
                            <tr>
                                <th style="text-align:center">Created At</th>
                                <th style="text-align:center">Ticket Code</th>
                                <th style="text-align:center">Location</th>
                                <th style="text-align:center">Department</th>
                                <th style="text-align:center">Created By</th>
                                <th style="text-align:center">Status</th>
                                <th style="text-align:center">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
      </div>
    </div>

@include('update_system.modal.check-update_system')
@include('update_system.modal.approval-update_system')
@include('update_system.modal.checking-update_system')
@include('update_system.modal.edit-update_system')
@include('update_system.modal.add-update_system')

@endsection
@push('custom-js')
@include('update_system.update_system-js')
@endpush