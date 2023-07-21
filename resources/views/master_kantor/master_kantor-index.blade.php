@extends('layouts.master')
@section('title', 'Master Kantor')
@section('content')
<div class="container">
    <div class="row justify-content-center">
          <div class="col-md-12">
            <div class="card card-dark">
                <div class="card-header">
                    List kantor
                    <div class="card-tools">
                        @can('create-master_kantor')
                        <button id="add_kantor" type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#addMasterKantor" style="float:right">
                            <i class="fas fa-plus"></i>
                        </button>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <table class="datatable-bordered nowrap display" id="kantor_table">
                        <thead>
                            <tr>
                                <th style="text-align:center"></th>
                                <th style="text-align:center">Status</th>
                                <th style="text-align:center">Kode Kantor</th>
                                <th style="text-align:center">Nama</th>
                                <th style="text-align:center">Lokasi</th>
                                <th style="text-align:center">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
      </div>
    </div>
</div>
@include('master_kantor.add-master_kantor')
@include('master_kantor.edit-master_kantor')
@endsection
@push('custom-js')
@include('master_kantor.master_kantor-js')
@endpush