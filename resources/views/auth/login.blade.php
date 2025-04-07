@extends('layouts.basic')
@section('content')
    <div class="login-page">
        <div class="login-box">
            <div class="card card-outline card-primary">
                <div class="card-header text-center">
                    <a href="/" class="h1"><b>{{config('app.name')}}</b></a>
                </div>
                <div class="card-body">
                    <p class="login-box-msg">Sign in to start your session</p>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <div class="input-group @error('email') is-invalid @enderror">
                                <input type="email" class="form-control" name="email" value="{{old('email')}}" placeholder="Email">
                            </div>
                            @error('email')
                                <div class="error text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <div class="input-group @error('password') is-invalid @enderror">
                                <input type="password" class="form-control" name="password" placeholder="Password">
                            </div>
                            @error('password')
                                <div class="error text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-8">
                                <div class="icheck-primary">
                                    <input type="checkbox" id="remember">
                                    <label for="remember">
                                        Remember Me
                                    </label>
                                </div>
                            </div>
                            <div class="col-4">
                                <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                            </div>
                        </div>
                    </form>

                    <p class="mb-1">
                        <a href="{{route('password.request')}}">I forgot my password</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
