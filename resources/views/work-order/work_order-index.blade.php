@extends('layouts.master')
@section('title', 'Work Order')
@section('content')


    <div class="justify-content-center">
          <div class="col-12">
            <div class="card ">
                <div class="card-header bg-core">
                    <div class="card-title"></div>
                  
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
                                        <option value="0">NEW</option>
                                        <option value="1">ON PROGRESS</option>
                                        <option value="2">PENDING</option>
                                        <option value="3">REVISION</option>
                                        <option value="4">DONE</option>
                                        <option value="6">CHECKING</option>
                                        <option value="7">HOLD</option>
                                        <option value="8">TAKE OUT</option>
                                        <option value="5">REJECT</option>
                                        </select>
                                    </div>
                                    @can('view-user_setting')
                                    <div class="mt-2">
                                        <p for="">User Support</p>
                                        <select class="select2" id="selectSupportFilter" >
                                        </select>
                                        <input type="hidden" id="userIdSupportFilter">
                                    </div>
                                    @endcan
                                    <div class="mt-2 mb-2">
                                        @can('create-work_order_list')
                                        <button class="btn btn-info btn-block" id="btnReportWO">
                                            <ion-icon name="print"></ion-icon>  Print WO
                                        </button>
                                        @endcan
                                        <button class="btn btn-warning btn-block" id="btnFilter" onclick="get_work_order_list()">
                                            <ion-icon name="filter-sharp"></ion-icon> Filter
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- @can('create-work_order_list') --}}
                            <button id="add_wo" type="button" class="btn btn-sm btn-success " style="float:right"  data-toggle="modal" data-target="#addMasterKantor">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                        {{-- @endcan --}}
                    <button id="refresh" title="Refresh" style="float:right" class="btn btn-sm btn-info mr-2">
                    <i class="fas fa-refresh"></i>
                    </button>
                      
                    </div>
                </div>
                <div class="card-body">
                    
                    <table class="datatable-bordered nowrap display" id="wo_table">
                        <thead>
                            <tr>
                                @can('priority-work_order_list')
                                <th style="text-align:center;width:11%"></th>
                                @endcan
                                <th style="text-align:center;width:11%">Created At</th>
                                <th style="text-align:center;width:11%">Request By</th>
                                <th style="text-align:center;width:11%">Office</th>
                                <th style="text-align:center;width:11%">Request Code</th>
                                @can('priority-work_order_list')
                                <th style="text-align:center;width:11%">Priority</th>
                                @endcan
                                <th style="text-align:center;width:11%">Departement</th>
                                <th style="text-align:center;width:11%">Category</th>
                                <th style="text-align:center;width:11%">Status</th>
                                <th style="text-align:center;width:11%">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
      </div>
    </div>

@include('work-order.chat-work_order')
@include('work-order.add-work_order')
@include('work-order.edit-work_order')
@include('work-order.manual_assign-work_order')
@include('work-order.rating-work_order')
@include('work-order.detail-work_order')
@include('work-order.hold-work_order')
@endsection
@push('custom-js')
@include('work-order.work_order-js')
@endpush