@extends('layouts.admin')

@section('page_title')
    Car Create
@endsection

@section('style')
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h1>Car</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.cars') }}">Car</a></li>
                            <li class="breadcrumb-item active">Car Create</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        @php $actionUrl = route('admin.car.save'); @endphp
                        <div class="card card-outline card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Car Create</h3>
                            </div>
                            <form onsubmit="return false;" id="Car_frm">
                                <div class="card-body">
                                    <div class="row">
                                        @csrf
                                        @isset($car)
                                            @php $actionUrl = route('admin.car.update', $car->id); @endphp
                                            @method('PUT')
                                        @endisset

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="text" class="form-control" name='name' id="name"
                                                    value="{{ $car->name ?? '' }}" placeholder="Car Name">
                                                <div class="error text-danger" id='name_error'></div>
                                            </div>
                                            <div class="form-group">
                                                <label>Brand</label>
                                                <input type="text" class="form-control" name='brand' id="brand"
                                                    value="{{ $car->brand ?? '' }}" placeholder="Car Brand">
                                                <div class="error text-danger" id='brand_error'></div>
                                            </div>
                                            <div class="form-group">
                                                <label>Model</label>
                                                <input type="text" class="form-control" name='model' id="model"
                                                    value="{{ $car->model ?? '' }}" placeholder="Car Model">
                                                <div class="error text-danger" id='model_error'></div>
                                            </div>
                                            <div class="form-group">
                                                <label>Year</label>
                                                <input type="text" class="form-control" name='year' id="year"
                                                       value="{{ $car->year ?? '' }}" placeholder="Year">
                                                <div class="error text-danger" id='year_error'></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <input type="button" id="" class="btn btn-primary modal_submit_info" data-url="{{ $actionUrl }}" value="Save" />
                                    <a type="button" id="back_btn" class="btn btn-default back_btn" href="{{ route('admin.cars') }}">Back</a>
                                    <span class="submit_notification">
                                        @if (Session::has('message'))
                                            <div class="text-{{ Session::get('status') }}">{{ Session::get('message') }}
                                            </div>
                                        @endif
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('extra-scripts')
    <script type="text/javascript"></script>
@endsection
