@extends('layouts.master')
@section('title', 'Master Data Type')
@section('content')
<div class="container">
    <div class="row justify-content-center">
          <div class="col-12">
            <div class="card card-dark">
                <div class="card-header">
                    List Data Type
                    <div class="card-tools">
                        @can('create-master_category')
                        <button id="btn_add_room" type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#addSystemModal" style="float:right">
                            <i class="fas fa-plus"></i>
                        </button>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <table class="datatable-bordered nowrap display" id="master_system_table" >
                        <thead>
                            <tr>
                                <th style="text-align:center">System</th>
                                <th style="text-align:center">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
      </div>
    </div>
</div>
@include('master_aspek.modal.add-aspek')
@include('master_aspek.modal.edit-aspek'))

@endsection
@push('custom-js')
@include('master_aspek.master_aspek-js')
@endpush