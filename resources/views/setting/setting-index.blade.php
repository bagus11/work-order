@extends('layouts.master')
@section('title', 'Setting')
@section('content')
<div class="container">
    <div class="row justify-content-center">
          <div class="col-md-6">
            <div class="card card-dark">
                <div class="card-header">
                    <div class="card-title">Profile</div>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                   <div class="form-group row">
                        <img style="width:40%;margin:auto" src="{{URL::asset('profile.png')}}" alt="">                     
                   </div>
                   <div class="form-group row justify-content-center">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#updatePassModal" onclick="clear_pass()">
                            <i class="fas fa-lock"></i> Change Password
                        </button>
                   </div>
                   <div class="container mt-2 justify-content-center ">
                        <div class="form-groyup row">
                            <div class="col-md-2 mt-2">
                                <label for="">Name</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" id="user_name" value="{{auth()->user()->name}}" class="form-control">
                            </div>
                        </div>
                        <div class="form-groyup row mt-2">
                            <div class="col-md-2 mt-2">
                                <label for="">Email</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" id="email_user" value="{{auth()->user()->email}}" class="form-control" readonly>
                            </div>
                        </div>
                   </div>

                </div>
                <div class="card-footer">
                    <button class="btn btn-success" id="update_profile" style="float: right;">
                       Update Profile
                    </button>
                </div>
            </div>
      </div>
    </div>
</div>

@include('setting.update-pass_modal')
@endsection
@push('custom-js')
@include('setting.setting-js')
@endpush