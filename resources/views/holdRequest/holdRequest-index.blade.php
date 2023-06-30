@extends('layouts.master')
@section('title', 'WO Transfer & Hold')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-dark">
                    List Assignment
                    <div class="card-tools">
                        <button id="btnAddTransfer" type="button" class="btn btn-success" data-toggle="modal" data-target="#addPICTransfer" style="float:right">
                            <i class="fa-solid fa-square-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="datatable-bordered" id="holdRequestTable">
                        <thead>
                            <tr>
                                <th>Request By</th>
                                <th>Request Code</th>
                                <th>Departement</th>
                                <th>Category</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@include('holdRequest.holdRequest-add')
@include('holdRequest.holdRequest-edit')
@include('holdRequest.resumeRequest-edit')
@endsection
@push('custom-js')
@include('holdRequest.holdRequest-js')
@endpush