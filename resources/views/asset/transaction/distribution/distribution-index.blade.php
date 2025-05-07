@extends('layouts.master')
@section('title', 'Asset Distribution')
@section('content')
<div class="row justify-content-center mx-2">

    <div class="col-12">
        <div class="card card-dark card-outline-tabs rounded-2">
            <div class="card-header p-0 border-bottom-0">
                <label style="margin-top:10px;font-size:14px ;margin-left:10px">Distribution Request</label>
                <div class="card-tools">
                    <button class="btn btn-success btn-sm" id="btn_add_distribution" style="float: right" data-toggle="modal" data-target="#addDistributionModal">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="row mx-1">
                    <div class="col-12">
                        <table class="datatable-bordered nowrap display" id="distribution_table">
                            <thead>
                                <tr>
                                    <th style="text-align:center">Request Code</th>
                                    <th style="text-align:center">Location</th>
                                    <th style="text-align:center">Destination Location</th>
                                    <th style="text-align:center">Request Type</th>
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


</div>
@include('asset.transaction.distribution.modal.add-distribution')
@include('asset.transaction.distribution.modal.info-distribution')
@endsection
@push('custom-js')
@include('asset.transaction.distribution.distribution-js')
@endpush
