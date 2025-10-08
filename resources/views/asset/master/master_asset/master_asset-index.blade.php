@extends('layouts.master')
@section('title', 'Master Asset')
@section('content')
<style>
    label {
        font-weight: regular !important;
        font-size: 11px !important;
    }
</style>
<div class="row justify-content-center mx-2">
    <div class="col-12">
        <div class="card card-dark card-outline-tabs rounded-2">
            <div class="card-header p-0 border-bottom-0">
                <div class="row">
                    <div class="col-11">
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
                    <div class="col-1">
                        <div class="btn-group" style="float:right">
                            <button type="button" class="btn btn-sm btn-tool dropdown-toggle" style="margin-top:3px" data-toggle="dropdown">
                            <i class="fas fa-filter" style="color: white"></i>
                            </button>
                           <div class="dropdown-menu dropdown-menu-right p-3 shadow" id="filter" role="menu" style="width:300px !important;">
                                <div class="row g-2">
                                    <!-- Location -->
                                    <div class="col-12">
                                        <label for="select_location_filter" class="form-label mb-1">Location</label>
                                        <select class="select2 form-select form-select-sm w-100" name="select_location_filter" id="select_location_filter"></select>
                                    </div>

                                    <!-- Division -->
                                    <div class="col-12">
                                        <label for="select_division_filter" class="form-label mb-1">Division</label>
                                        <select class="select2 form-select form-select-sm w-100" name="select_division_filter" id="select_division_filter"></select>
                                    </div>

                                    <!-- Department -->
                                    <div class="col-12">
                                        <label for="select_department_filter" class="form-label mb-1">Department</label>
                                        <select class="select2 form-select form-select-sm w-100" name="select_department_filter" id="select_department_filter">
                                            <option value="">Choose Division First</option>
                                        </select>
                                    </div>

                                    <!-- Condition -->
                                    <div class="col-12">
                                        <label for="select_status_filter" class="form-label mb-1">Condition</label>
                                        <select class="select2 form-select form-select-sm w-100" name="select_status_filter" id="select_status_filter">
                                            <option value="">All Condition</option>
                                            <option value="1">Good</option>
                                            <option value="2">Partially Good</option>
                                            <option value="3">Damaged</option>
                                        </select>
                                    </div>

                                    <!-- Available -->
                                    <div class="col-12">
                                        <label for="select_status_available" class="form-label mb-1">Available</label>
                                        <select class="select2 form-select form-select-sm w-100" name="select_status_available" id="select_status_available">
                                            <option value="">All Status</option>
                                            <option value="1">True</option>
                                            <option value="0">False</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-6">
                                        <button class="btn btn-block btn-primary" style="font-size: 12px " id="btn_filter_master_asset">
                                            <i class="fas fa-filter"></i> Filter
                                        </button>
                                    </div>
                                    <div class="col-6">
                                        <button class="btn btn-block btn-danger" style="font-size: 12px " id="btn_export_all_asset">
                                            <i class="fa-solid fa-file-pdf"></i> Export
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
               
              
            </div>
            <div class="card-body">
                <button class="btn btn-success btn-sm" id="btn_add_master_asset" style="float: right" data-toggle="modal" data-target="#addMasterAssetModal">
                    <i class="fas fa-plus"></i>
                </button>
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

@include('asset.master.master_asset.modal.add-master_asset')
@include('asset.master.master_asset.modal.detail-master_asset')
@endsection
@push('custom-js')
@include('asset.master.master_asset.master_asset-js')
<script>
     $(document).ready(function () {
        $('#select_location_filter').select2({});
        $(document).on('click', '.dropdown-menu', function (e) {
            e.stopPropagation();
        });
        getCallbackNoSwal('getLocationFilter',null, function(response){
            $('#select_location_filter').empty();
            $('#select_location_filter').append('<option value="">All Location</option>');
            $.each(response.data, function (i, item) {
                $('#select_location_filter').append('<option value="' + item.id + '">' + item.initial + '</option>');
            });
        })
        getCallbackNoSwal('get_division',null, function(response){
            $('#select_division_filter').empty();
            $('#select_division_filter').append('<option value="">All Division</option>');
            $.each(response.data, function (i, item) {
                $('#select_division_filter').append('<option value="' + item.id + '">' + item.name + '</option>');
            });
        })
        $('#select_division_filter').on('change', function() {
            var divisionId = $(this).val();
            $('#select_department_filter').empty();
            $('#select_department_filter').append('<option value="">All Department</option>');
            if(divisionId) {
                $.ajax({
                    url: '{{ route("get_department_by_division") }}',
                    type: 'GET',
                    data: { division_id: divisionId },
                    success: function(response) {
                        $.each(response.data, function (i, item) {
                            $('#select_department_filter').append('<option value="' + item.id + '">' + item.name + '</option>');
                        });
                    },
                    error: function() {
                        console.error('Failed to fetch departments.');
                    }
                });
            }
        });

    });
    $(document).on('click', '#btn_export_all_asset', function () {
    let location_id   = $('#select_location_filter').val();
    let division_id   = $('#select_division_filter').val();
    let department_id = $('#select_department_filter').val();
    let condition     = $('#select_status_filter').val();
    let available     = $('#select_status_available').val();

    let url = "{{ route('exportMasterAsset') }}" 
        + "?location_id=" + location_id
        + "&division_id=" + division_id
        + "&department_id=" + department_id
        + "&condition=" + condition
        + "&available=" + available;

    window.open(url, '_blank'); // langsung buka PDF di tab baru
});

</script>
@endpush
