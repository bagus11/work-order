@extends('layouts.master')
@section('title', 'Master Asset')
@section('content')
<div class="container">
    <div class="row justify-content-center">

        <div class="col-12">
            <div class="card card-dark card-outline-tabs rounded-2">
                <div class="card-header p-0 border-bottom-0">
                    <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                        <li class="nav-item">
                            <a style="font-size: 12px !important" class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">
                                <i class="fas fa-tv"></i> Master Asset</a>
                        </li>
                        <li class="nav-item">
                            <a style="font-size: 12px !important" class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">
                                <i class="fas fa-user"></i> User</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="custom-tabs-four-tabContent">
                        <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                            <table class="datatable-bordered nowrap display" id="master_asset">
                                <thead>
                                    <tr>
                                        <th style="text-align:center"></th>
                                        <th style="text-align:center">Asset Code</th>
                                        <th style="text-align:center">Category</th>
                                        <th style="text-align:center">Brand</th>
                                        <th style="text-align:center">Type</th>
                                        <th style="text-align:center">Parent Code</th>
                                        <th style="text-align:center">Department</th>
                                        <th style="text-align:center">Location</th>
                                        <th style="text-align:center">PIC</th>
                                        <th style="text-align:center">NIK</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
                            <table class="datatable-bordered nowrap display" id="master_asset_user">
                                <thead>
                                    <tr>
                                        <th style="text-align:center"></th>
                                        <th style="text-align:center">NIK</th>
                                        <th style="text-align:center">Name</th>
                                        <th style="text-align:center">Departement</th>
                                        <th style="text-align:center">Location</th>
                                    </tr>
                                </thead>
                            </table>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
@include('asset.master.master_asset.modal.detail-master_asset')
@endsection
@push('custom-js')
@include('asset.master.master_asset.master_asset-js')
@endpush
