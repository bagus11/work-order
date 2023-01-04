@extends('layouts.master')
@section('title', 'Master Jabatan')
@section('content')
<div class="container">
    <div class="row justify-content-center">
          <div class="col-md-10">
            <div class="card card-dark">
                <div class="card-header">
                    <div class="card-title">List Jabatan</div>
                    <div class="card-tools">
                        @can('create-master_jabatan')
                        <button id="add_jabatan" type="button" class="btn btn-success" data-toggle="modal" data-target="#addJabatan" style="float:right">
                            <i class="fas fa-plus"></i>
                        </button>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <table class="datatable-bordered nowrap display" id="jabatan_table" >
                        <thead>
                            <tr>
                                <th style="text-align:center"></th>
                                <th style="text-align:center">Status</th>
                                <th style="text-align:center">Nama</th>
                                <th style="text-align:center">Departement</th>
                                <th style="text-align:center">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
      </div>
    </div>
</div>
@include('master_jabatan.add-master_jabatan')
@include('master_jabatan.edit-master_jabatan')
@endsection
@push('custom-js')
@include('master_jabatan.master_jabatan-js')
@endpush