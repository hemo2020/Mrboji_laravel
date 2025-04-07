@extends('layouts.basic')
@section('content')
    <div class="login-page">
        <div class="login-box">
            <div class="card card-outline card-primary">
                <div class="card-header text-center">
                    <a href="/" class="h1"><b>{{config('app.name')}}</b></a>
                </div>
                <div class="card-body">
                    <p class="login-box-msg">{{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}</p>

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="email" name="email" value="{{old('email')}}" required class="form-control" placeholder="Email">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                {{session('status')}}
                                <button type="submit" class="btn btn-primary btn-block">{{ __('Email Password Reset Link') }}</button>
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
