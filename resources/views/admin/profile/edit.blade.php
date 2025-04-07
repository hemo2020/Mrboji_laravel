@extends('layouts.admin')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Profile</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Profile</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <form id="user_frm" action="{{route('admin.profile.update')}}" method="post">
                            @csrf
                            @method('patch')
                            @php $disabled = !$user->isAdmin(); @endphp
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="fas fa-info-circle"></i> Basic Info</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Enter Customer Name" value="{{old('name') ? old('name') : $user->name}}" @disabled($disabled)>
                                        @error('name')
                                            <div class="error text-danger" id="name_error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="Enter Email" value="{{old('email') ? old('email') : $user->email}}" @disabled($disabled)>
                                        @error('email')
                                            <div class="error text-danger" id="name_error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Phone</label>
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" id="phone" placeholder="Enter Phone" value="{{old('phone') ? old('phone') : $user->phone}}" @disabled($disabled)>
                                        @error('phone')
                                            <div class="error text-danger" id="name_error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <textarea class="form-control @error('address') is-invalid @enderror" name="address" id="address" placeholder="Enter Address" @disabled($disabled)>{{old('address') ? old('address') : $user->address}}</textarea>
                                        @error('address')
                                            <div class="error text-danger" id="name_error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="city">City</label>
                                        <input type="city" class="form-control @error('city') is-invalid @enderror" name="city" id="city" placeholder="Enter City" value="{{old('city') ? old('city') : $user->city}}" @disabled($disabled)>
                                        @error('city')
                                            <div class="error text-danger" id="name_error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="card-footer {{$disabled ? 'd-none' : ''}}" >
                                    <input type="submit" id="" class="btn btn-primary" value="Save">
                                    <span class="submit_notification"></span>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="col-md-6">
                        <form id="password_frm" action="{{route('password.update')}}" method="post">
                            @csrf
                            @method('put')
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="fas fa-bars"></i> Change Password</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="current_password">Current Password</label>
                                        <input type="password" class="form-control {{($errors->updatePassword->first('current_password') ? 'is-invalid' : '')}}" name="current_password" id="current_password" value="" placeholder="Current Password">
                                        <div class="error text-danger">{{ $errors->updatePassword->first('current_password') }}</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">New Password</label>
                                        <input type="password" class="form-control {{($errors->updatePassword->first('password') ? 'is-invalid' : '')}}" name="password" id="password" value="" placeholder="New Passwrod">
                                        <div class="error text-danger" id="password_error">{{ $errors->updatePassword->first('password') }}</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="password_confirmation">Confirm Password</label>
                                        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" value="" placeholder="Confirm Password">
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <input type="submit" id="" class="btn btn-primary" value="Save">
                                    <span class="submit_notification"></span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
