@extends('layouts.admin')

@section('page_title') User Create @endsection

{{-- Style Section --}}
@section('style')
<!--Custon stylesheet for this page-->
@endsection

@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1>User</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ route('admin.users') }}">User</a></li>
              <li class="breadcrumb-item active">User Create</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    @include('admin.user.create_frm')
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
