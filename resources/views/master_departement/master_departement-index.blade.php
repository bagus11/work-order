@extends('layouts.master')
@section('title', 'Master Departement')
@section('content')
<div class="container">
    <div class="row justify-content-center">
          <div class="col-md-12">
            <div class="card card-dark">
                <div class="card-header">
                    List Departement
                    <div class="card-tools">
                        @can('create-master_departement')
                        <button id="add_kantor" type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#addDepartement" style="float:right">
                            <i class="fas fa-plus"></i>
                        </button>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <table class="datatable-bordered nowrap display" id="departement_table" >
                        <thead>
                            <tr>
                                <th style="text-align:center"></th>
                                <th style="text-align:center">Status</th>
                                <th style="text-align:center">Nama</th>
                                <th style="text-align:center">Inisial</th>
                                <th style="text-align:center">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
      </div>
    </div>
</div>
@include('master_departement.add-master_departement')
@include('master_departement.edit-master_departement')
@endsection
@push('custom-js')
@include('master_departement.master_departement-js')
@endpush