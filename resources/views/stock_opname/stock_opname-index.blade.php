@extends('layouts.master')
@section('title', 'Setting')
@section('content')
 <div class="row justify-content-center mx-2">
          <div class="col-12">
            <div class="card card-dark">
                <div class="card-header">
                    
                    <div class="card-tools">
                        <button class="btn btn-sm btn-primary" title="Refresh Data" id="btn_refresh_stock_opname">
                            <i class="fa-solid fa-rotate"></i>
                        </button>
                    @can('import_user-user_setting')
                        <button class="btn btn-sm btn-success" title="Import User HRIS" id="btn_add_stock_opname" data-toggle="modal" data-target="#addStockOpnameModal">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    @endcan
                       
                    </div>
                </div>
                <div class="card-body">
                    <table class="datatable-bordered" id="stock_opname_table" style="width: 100%">
                        <thead>
                            <tr>
                              <th>Ticket Code</th>
                              <th>Status</th>
                              <th>Start Date</th>
                              <th>Subject</th>
                              <th>Location</th>
                              <th>Department</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
      </div>
    </div>
@include('stock_opname.modal.add-stock-opname')
@include('stock_opname.modal.info-so')
@endsection
@push('custom-js')
@include('stock_opname.stock_opname-js')
@endpush