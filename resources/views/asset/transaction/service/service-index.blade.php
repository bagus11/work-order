@extends('layouts.master')
@section('title', 'Service Asset')
@section('content')
<style>
    #service_table tbody tr {
    cursor: pointer;
}
.list-group-item:nth-child(odd) {
    background-color: #f9f9f9;  /* warna terang */
}

.list-group-item:nth-child(even) {
    background-color: #e9ecef;  /* warna agak gelap */
}
.timeline {
    position: relative;
    margin: 0;
    padding: 0;
    list-style: none;
}
.timeline::before {
    content: "";
    position: absolute;
    top: 0;
    left: 25px;
    width: 2px;
    height: 100%;
    background: #dee2e6;
}
.timeline-item {
    position: relative;
    margin-bottom: 30px;
    padding-left: 60px;
}
.timeline-icon {
    position: absolute;
    left: 10px;
    top: 20px;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 14px;
    box-shadow: 0 0 0 2px #fff;
}
.timeline-icon.success { background-color: #198754; }  /* hijau */
.timeline-icon.pending { background-color: #ffc107; color:#000; } /* kuning */
.timeline-icon.approved { background-color: #0d6efd; } /* biru */
.timeline-icon.rejected { background-color: #dc3545; } /* merah */


</style>
<div class="row justify-content-center mx-2">

    <div class="col-12">
        <div class="card card-dark card-outline-tabs rounded-2">
            <div class="card-header p-0 border-bottom-0">
                <label style="margin-top:10px;font-size:14px ;margin-left:10px">Service List</label>
                <div class="card-tools">
                    <button class="btn btn-success btn-sm" id="btn_add_service" style="float: right" data-toggle="modal" data-target="#addServiceModal">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="row mx-1">
                    <div class="col-12">
                        <table class="datatable-bordered nowrap display" id="service_table">
                            <thead>
                                <tr>
                                    <th style="text-align:center"></th>
                                    <th style="text-align:center">Service Code</th>
                                    <th style="text-align:center">Request Code</th>
                                    <th style="text-align:center">Asset Code</th>
                                    <th style="text-align:center">Location</th>
                                    <th style="text-align:center">PIC Support</th>
                                    <th style="text-align:center">Department</th>
                                    <th style="text-align:center">Status</th>
                                    <th style="text-align:center">Duration</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
@include('asset.transaction.service.modal.detail-service')
@include('asset.transaction.service.modal.update-service')
@include('asset.transaction.service.modal.add-service')
@endsection
@push('custom-js')
@include('asset.transaction.service.service-js')
@endpush
