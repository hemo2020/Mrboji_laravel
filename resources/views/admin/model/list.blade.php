@extends('layouts.admin')
@section('page_title')
    Model
@endsection
@section('styles')
@endsection
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Model</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active"><a href="{{ route('admin.models') }}">Model</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Model List</h3>
                        <div class="card-tools">
                            <div class="submit_notification d-inline-block">
                                @if (Session::has('message'))
                                    <div class="text-{{ Session::get('status') }}">
                                        {{ Session::get('message') }}
                                    </div>
                                @endif
                            </div>
                            <button type="button" class="btn btn-sm btn-primary font-weight-bolder" data-toggle="modal" data-target=".loadModal" data-action="Create New Model" data-type="model" data-url="{{route('admin.model.create', ['modal' => 'yes'])}}"><i class="fa fa-plus"></i> New Model</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm table-head-custom table-checkable" id="datatable">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Brand</th>
                                    @if (Auth::user()->isAdmin())
                                        <th style="width: 100px;">Actions</th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>
                                @if ($data->count())
                                    @foreach ($data as $i => $model)
                                        <tr>
                                            <td>{{ $model->name }}</td>
                                            <td>{{ $model->brand->name }}</td>
                                            @if (Auth::user()->isAdmin())
                                                <td nowrap="nowrap">
                                                    <button type="button" class="btn btn-sm btn-info edit-btn" data-toggle="modal" data-target=".loadModal" data-action="Edit Model" data-type="model" data-url="{{route('admin.model.edit', ['model' => $model->id])}}"><i class="fa far fa-edit"></i></button>
                                                    <button class="btn btn-sm btn-danger comman-delete-btn" data-href="{{ route('admin.model.delete', $model->id) }}"><i class="fa fa-times-circle"></i></button>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('scripts')
    <script type="module">
        $(document).ready(function() {
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
