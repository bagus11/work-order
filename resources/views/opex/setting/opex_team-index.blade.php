@extends('layouts.master')
@section('title', 'Master Opex Team')
@section('content')


    <div class="justify-content-center">
          <div class="col-10">
            <div class="card ">
                <div class="card-header bg-core">
                    <div class="card-title"></div>
                    <div class="card-tools">
                        <button class="btn btn-sm btn-success">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    
                    <table class="datatable-bordered nowrap display" id="wo_table">
                        <thead>
                            <tr>
                                <th style="text-align:center;%">Name</th>
                                <th style="text-align:center;%">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
      </div>
    </div>

@endsection
@push('custom-js')

@endpush