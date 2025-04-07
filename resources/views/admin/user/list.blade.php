@extends('layouts.admin')

@section('page_title') User @endsection

@section('styles')
<!--begin::Page Vendors Styles(used by this page)-->
@endsection

@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>User Control Panel</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
              <li class="breadcrumb-item active"><a href="{{ route('admin.users') }}">User</a></li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">User List</h3>
                            <div class="card-tools">
                                <div class="submit_notification d-inline-block">
                                    @if (Session::has('message'))
                                    <div class="text-{{ Session::get('status') }}">
                                        {{ Session::get('message') }}
                                    </div>
                                    @endif
                                </div>
                                <button type="button" class="btn btn-sm btn-primary font-weight-bolder" data-toggle="modal" data-target=".loadModal" data-action="Create New User" data-type="user" data-url="{{route('admin.user.create', ['modal' => 'yes'])}}"><i class="fa fa-plus"></i> New User</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-sm table-head-custom table-checkable" id="datatable">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Role</th>
                                            <th>Status</th>
                                            <th style="width: 100px;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($data->count())
                                            @foreach ($data as $i => $user)
                                            <tr>
                                                <td>{{$user->name}}</td>
                                                <td>{{$user->email}}</td>
                                                <td>{{ $user->phone ?? '' }}</td>
                                                <td class="text-capitalize">{{ $user->role }}</td>
                                                <td>
                                                    <span class="badge bg-{{$user->status ? 'success' : 'warning'}}">{{$user->status ? 'Active' : 'Inactive'}}</span>
                                                </td>
                                                <td nowrap="nowrap">
                                                    <button type="button" class="btn btn-sm btn-info edit-btn" data-toggle="modal" data-target=".loadModal" data-action="Edit User" data-type="user" data-url="{{route('admin.user.edit', ['user' => $user->id, 'modal' => 'yes'])}}"><i class="fa far fa-edit"></i></button>
                                                    <button class="btn btn-sm btn-danger comman-delete-btn"
                                                            data-href="{{ route('admin.user.delete', $user->id) }}"><i
                                                            class="fa fa-times-circle"></i></button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('scripts')
<script type="module">
    $(document).ready(function () {
        $('#datatable').DataTable({
            "paging": false,
            // "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
        });
    });
</script>
@endsection
