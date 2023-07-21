@extends('layouts.master')
@section('title', 'Master Problem Type')
@section('content')
<div class="container">
    <div class="row justify-content-center">
          <div class="col-md-12">
            <div class="card card-dark">
                <div class="card-header">
                    List Problem
                    <div class="card-tools">
                        @can('create-problem_type')
                        <button id="add_problem" type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#addProblem" style="float:right">
                            <i class="fas fa-plus"></i>
                        </button>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <table class="datatable-bordered nowrap display" id="problem_table">
                        <thead>
                            <tr>
                                <th style="text-align:center"></th>
                                <th style="text-align:center">Status</th>
                                <th style="text-align:center">Nama</th>
                                <th style="text-align:center">Kategori</th>
                                <th style="text-align:center">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
      </div>
    </div>
</div>
@include('problem_type.add-problem_type')
@include('problem_type.edit-problem_type')
@endsection
@push('custom-js')
@include('problem_type.problem_type-js')
@endpush