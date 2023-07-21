@extends('layouts.master')
@section('title', 'RFP Transaction')
@section('content')
<div class="container">
    <div class="row justify-content-center">
          <div class="col-12">
            <div class="card card-dark">
                <div class="card-header">
                    <div class="card-title">List Request For Project</div>
                    <div class="card-tools">
                        @can('create-rfp_transaction')
                            <button id="addRFP" type="button" class="btn btn-success" data-toggle="modal" data-target="#addRFPTransaction" style="float:right">
                                <i class="fas fa-plus"></i>
                            </button>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <table class="datatable-bordered nowrap display " id="rfpTable">
                        <thead>
                            <tr>
                                <th style="text-align:center"></th>
                                <th style="text-align:center">Request Code</th>
                                <th style="text-align:center">Office</th>
                                <th style="text-align:center">Name</th>
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
@include('rfpTransaction.rfpTransaction-add')
@include('rfpTransaction.rfpTransaction-edit')
@include('rfpTransaction.rfpTransaction-editMaster')
@include('rfpTransaction.rfpTransaction-editSubDetail')
@include('rfpTransaction.rfpTransaction-addDetail')
@include('rfpTransaction.rfpTransaction-detailRFPMaster')
@include('rfpTransaction.rfpTransaction-addSubDetailRFP')
@include('rfpTransaction.rfpTransaction-updateRFPSubDetail')
@include('rfpTransaction.rfpTransaction-listSubDetailRFP')
@include('rfpTransaction.rfpTransaction-infoSubDetailRFP')
@endsection
@push('custom-js')
@include('rfpTransaction.rfpTransaction-js')
@endpush