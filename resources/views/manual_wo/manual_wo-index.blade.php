@extends('layouts.master')
@section('title', 'Manual Work Order')
@section('content')
<div class="container">
    <div class="row justify-content-center">
          <div class="col-md-10">
            <div class="card card-dark">
                <div class="card-header">
                        <label for="">Add Manual Work Order</label>
                </div>
                <div class="card-body">
                   <div class="container">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4 mt-2">
                                        <label for="">Request Type</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select name="" class="select2" id="select_request_type">
                                            <option value="">Choose Request Type</option>
                                            <option value="RFM">Request For Maintenance</option>
                                            <option value="RFP">Request For Project</option>
                                        </select>
                                        <input type="hidden" class="form-control" id="request_type">
                                        <span  style="color:red;" class="message_error text-red block request_type_error"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4 mt-2">
                                        <label for="">Request For</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select name="" class="select2" id="select_request_for">
                                            <option value="">Choose Departement</option>
                                        </select>
                                        <input type="hidden" class="form-control" id="request_for">
                                        <span  style="color:red;" class="message_error text-red block request_for_error"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4 mt-2">
                                        <label for="">Categories</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select name="" class="select2" id="select_categories">
                                         <option value="">Select Departement First</option>
                                        </select>
                                        <input type="hidden" class="form-control" id="categories">
                                        <span  style="color:red;" class="message_error text-red block categories_error"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4 mt-2">
                                        <label for="">Problem Type</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select name="" class="select2" id="select_problem_type">
                                            <option value="">Select Categories First</option>
                                        </select>
                                        <input type="hidden" class="form-control" id="problem_type">
                                        <span  style="color:red;" class="message_error text-red block problem_type_error"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4 mt-2">
                                        <label for="">Subject</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="subject">
                                        <span  style="color:red;" class="message_error text-red block subject_error"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-2 mt-2">
                                <label for="">Add info</label>
                            </div>
                            <div class="col-md-10">
                                <textarea class="form-control" id="add_info" rows="3"></textarea>
                                <span  style="color:red;" class="message_error text-red block add_info_error"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-2 mt-2">
                                <label for="">User</label>
                            </div>
                            <div class="col-md-4">
                                <select name="" class="select2" id="select_username"></select>
                                <input type="hidden" class="form-control" id="username">
                                <span  style="color:red;" class="message_error text-red block username_error"></span>
                            </div>
                        </div>
                   </div>
                </div>
                <div class="card-footer">
                    <button id="btnSaveManualWO" style="float:right" class="btn btn-success">
                        Save Change
                    </button>
                </div>
            </div>
      </div>
    </div>
</div>

@endsection
@push('custom-js')
@include('manual_wo.manual_wo-js')
@endpush