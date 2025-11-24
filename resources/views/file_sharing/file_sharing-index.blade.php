@extends('layouts.master')
@section('title', 'File Sharing')
@section('content')
<div class="justify-content-center">
    <div class="col-12">
      <div class="card card-dark">
          <div class="card-header bg-core">
              <strong>File Sharing List</strong>
            <div class="card-tools">
                 <div class="btn-group" style="float:right">
                            <button type="button" class="btn btn-sm btn-tool dropdown-toggle" style="margin-top:3px" data-toggle="dropdown">
                               <i class="fas fa-filter" style="color: white"></i>
                            </button>
                       
                            <div class="dropdown-menu dropdown-menu-right" id="filter" role="menu" style="width:300px !important;">
                                <div class="row mx-2">
                                      <div class="col-4 mt-2">
                                        <p for="">Department</p>
                                    </div>
                                    <div class="col-8">
                                        <select name="department_filter" id="department_filter" class="select2" style="width:100%">
                                            <option value=""> * - All Office</option>
                                        </select>
                                    </div>
                                    <div class="col-4 mt-2">
                                        <p for="">User</p>
                                    </div>
                                    <div class="col-8">
                                        <select name="user_filter" id="user_filter" class="select2" style="width:100%">
                                            <option value=""> * - All Office</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mx-2">
                                        <div class="col-12">
                                            <button class="btn btn-sm btn-info" id="btnFilter" style="font-size:12px !important; float:right">
                                                <i class="fa-solid fa-filter"></i> Filter
                                            </button>
                                        </div>
                                </div>
                            </div>
                        </div>
                <button class="btn btn-sm btn-success" id="btn_add_file" data-toggle="modal" data-target="#addFileSharingModal" style="float:right">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
          </div>
          <div class="card-body">
             <table class="datatable-bordered nowrap display" id="file_sharing_table" >
                        <thead>
                            <tr>
                                <th style="text-align:center">Created At</th>
                                <th style="text-align:center">Title</th>
                                <th style="text-align:center">Departement</th>
                                <th style="text-align:center">Created By</th>
                                <th style="text-align:center">Attachment</th>
                                <th style="text-align:center">Action</th>
                            </tr>
                        </thead>
                    </table>
          </div>
      </div>
    </div>
</div>
@include('file_sharing.modal.add-file')
@include('file_sharing.modal.info-file')
@endsection
@push('custom-js')
@include('file_sharing.file_sharing-js')
@endpush