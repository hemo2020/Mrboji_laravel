@extends('layouts.basic')
@section('content')
    <div class="login-page">
        <div class="login-box">
            <div class="card card-outline card-primary">
                <div class="card-header text-center">
                    <a href="/" class="h1"><b>{{config('app.name')}}</b></a>
                </div>
                <div class="card-body">
                    <p class="login-box-msg">Reset Your Password</p>

                    <form method="POST" action="{{ route('password.store') }}">
                        @csrf
                        <!-- Password Reset Token -->
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">
                        <div class="input-group mb-3">
                            <input type="email" class="form-control @error('password') is-invalid @enderror" name="email" value="{{old('email', $request->email)}}" required placeholder="Email">
                            @error('email')
                                <div class="error text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password">New Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" value="" placeholder="New Passwrod">
                            @error('password')
                                <div class="error text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" id="password_confirmation" value="" placeholder="Confirm Password">
                            @error('password_confirmation')
                                <div class="error text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col">
                                {{session('status')}}
                                <button type="submit" class="btn btn-primary btn-block">{{ __('Reset Password') }}</button>
                            </div>
                        </div>
                    </form>

                    <p class="mb-1">
                        <a href="{{route('login')}}">Remember Login?</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
