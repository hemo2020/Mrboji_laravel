@extends('layouts.admin')

@section('page_title')
    Case Create
@endsection

@section('style')
@endsection

@section('content')
    @php
        use App\Models\Cases;
    @endphp
    <script>
        var i = 0;
    </script>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h1>Case</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.cases') }}">Case</a></li>
                            <li class="breadcrumb-item active">Case Create</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                @php $actionUrl = route('admin.case.save'); @endphp
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Case Create</h3>
                    </div>
                    <form onsubmit="return false;" id="case_frm">
                        <div class="card-body">
                            <div class="row">
                                @csrf
                                @isset($case)
                                    @php $actionUrl = route('admin.case.update', $case->id); @endphp
                                    @method('PUT')
                                @endisset
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Case No</label>
                                        <input type="text" class="form-control" name='case_no' id="case_no" value="{{ $case->case_no ?? '' }}" placeholder="Case No">
                                        <div class="error text-danger" id='case_no_error'></div>
                                    </div>
                                    <div class="form-group">
                                        <label>Brand</label>
                                        <select name='brand' id="brand" class="form-control">
                                            <option value="{{ $case->brand ?? '' }}" @selected(!empty($case->brand))>{{ $case->brand ?? '' }}</option>
                                        </select>
                                        <div class="error text-danger" id='brand_error'></div>
                                    </div>
                                    <div class="form-group">
                                        <label>Model</label>
                                        <select name='model' id="model" class="form-control">
                                            <option value="{{ $case->model ?? '' }}" @selected(!empty($case->model))>{{ $case->model ?? '' }}</option>
                                        </select>
                                        <div class="error text-danger" id='model_error'></div>
                                    </div>
                                    <div class="form-group">
                                        <label>Year</label>
                                        <input type="text" class="form-control" name='year' id="year" value="{{ $case->year ?? '' }}" placeholder="Year">
                                        <div class="error text-danger" id='year_error'></div>
                                    </div>
                                    <div class="form-group">
                                        <label>Vin</label>
                                        <input type="text" class="form-control" name='vin' id="vin" value="{{ $case->vin ?? '' }}" placeholder="Vin">
                                        <div class="error text-danger" id='vin_error'></div>
                                    </div>
                                    <div class="form-group">
                                        <label>Date</label>
                                        <input type="text" class="form-control comman-date-picker" name='date' id="date" value="{{ !empty($case->date) ? date('d-m-Y', strtotime($case->date)) : '' }}" placeholder="Date">
                                        <div class="error text-danger" id='date_error'></div>
                                    </div>
                                    <div class="form-group">
                                        <label>Assigned To</label>
                                        <select name='assigned_to' id="assigned_to" class="form-control">
                                            <option value="{{ $case->assigned_to ?? '' }}">{{ $case->assignedTo->name ?? '' }}</option>
                                        </select>
                                        <div class="error text-danger" id='assigned_to_error'></div>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="card card-outline card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">{{ __('Pricing Detail') }}</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <label>{{ __('Part Name') }}</label>
                                                    <input type="text" name="part_name" class="form-control form-control-sm" id="part_name" placeholder="Enter Part Name">
                                                    <div class="error text-danger" id='parts_error'></div>
                                                    <div class="error text-danger" id='part_name_error'></div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label>{{ __('Qty') }}</label>
                                                    <input type="number" min="1" oninput="validity.valid||(value='');" class="form-control form-control-sm" id="qty" value="" placeholder="{{ __('Qty') }}">
                                                    <div class="error text-danger" id='qty_error'></div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label> &nbsp;</label>
                                                    <div class="clearfix"></div>
                                                    <button type="button" onclick="addPart()" id="add_product_btn" class="btn btn-primary btn-sm">{{ __('Add') }}</button>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <table id="part_tbl" class="table table-sm table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Part Name</th>
                                                                <th>Qty</th>
                                                                @if(empty($case) || in_array($case->status, [Cases::PENDING, Cases::IN_PROGRESS]))
                                                                    <th>Action</th>
                                                                @endif
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if(!empty($case->pricing))
                                                                @foreach($case->pricing as $i => $price)
                                                                    <tr>
                                                                        <td>
                                                                            {{$price->part_name}}
                                                                            <input type="hidden" name="parts[{{$i}}][part_name]" value="{{$price->part_name}}">
                                                                        </td>
                                                                        <td>
                                                                            {{$price->qty}}
                                                                            <input type="hidden" name="parts[{{$i}}][qty]" value="{{$price->qty}}">
                                                                        </td>
                                                                        @if(in_array($case->status, [Cases::PENDING, Cases::IN_PROGRESS]))
                                                                            <td style="width:50px;">
                                                                                <button type="button" class="btn btn-sm btn-danger" onclick="removeItem($(this));"><i class="fa fa-times"></i></button>
                                                                            </td>
                                                                        @endif
                                                                    </tr>
                                                                    <script>
                                                                        i++;
                                                                    </script>
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
                        </div>
                        <div class="card-footer">
                            <input type="button" id="" class="btn btn-primary modal_submit_info" data-url="{{ $actionUrl }}" value="Save" />
                            <a type="button" id="back_btn" class="btn btn-default back_btn" href="{{ route('admin.cases') }}">Back</a>
                            <span class="submit_notification">
                                @if (Session::has('message'))
                                    <div class="text-{{ Session::get('status') }}">{{ Session::get('message') }}</div>
                                @endif
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        function addPart() {
            var partName = $('#part_name').val();
            var qty = parseInt($('#qty').val());
            $('.error').text('');

            if (!partName) {
                $('#part_name_error').text('{{ __('Enter Part Name') }}');
                return false;
            }

            if (!qty || isNaN(qty) || qty < 0) {
                $('#qty_error').text(!qty ? 'Enter Qty' : 'Quantity should contain only numbers');
                return false;
            }

            var tr = '<td>' +
                partName +
                '<input type="hidden" name="parts[' + i + '][part_name]" value="' + partName + '">' +
                '</td>' +
                '<td>' +
                qty +
                '<input type="hidden" name="parts[' + i + '][qty]" value="' + qty + '">' +
                '</td>' +

                '<td style="width:50px;">' +
                '<button type="button" class="btn btn-sm btn-danger" onclick="removeItem($(this));"><i class="fa fa-times"></i></button>' +
                '</td>';

            $('#part_tbl tbody').append('<tr>' + tr + '</tr>');

            $('#part_name').val('');
            $('#qty').val('');
            i++;
        }

        function removeItem(ele) {
            ele.closest('tr').remove();
        }

        var getBrandDropdown = "{{ route('admin.brand_drop_down') }}";
        var getModelDropdown = "{{ route('admin.model_drop_down') }}";
        var getUserDropdown = "{{ route('admin.user_drop_down') }}";

        $(document).ready(function (){
            loadSelect2("#brand", getBrandDropdown, "{{ __('Select Brand') }}");

            $("#model").select2({
                placeholder: "Select a Model",
                multiple: false,
                cache: false,
                ajax: {
                    url: getModelDropdown,
                    dataType: 'json',
                    type: "POST",
                    delay: 250,
                    data: function(params) {
                        var $query = {
                            "_token": $('meta[name="csrf-token"]').attr('content'),
                            search: params.term,
                            page: params.page,
                            "brand_id": $('#brand').val(),
                        };
                        return $query;
                    },
                    processResults: function(data, params) {
                        return {
                            results: data.results,
                            pagination: {
                                more: data.more
                            }
                        };
                    },
                    escapeMarkup: function escapeMarkup(markup) {
                        return markup;
                    },
                    // let our custom formatter work
                    minimumInputLength: 1,
                }
            });

            $("#assigned_to").select2(select2Option({
                placeholder: "Select a User",
                url: getUserDropdown,
                el: "#assigned_to",
                param: {
                    'role': 'pricing'
                }
            }));
        });
    </script>
@endsection
