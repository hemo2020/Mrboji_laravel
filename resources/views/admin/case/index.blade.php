@extends('layouts.admin')
@section('page_title')
    Case
@endsection

@section('content')
    @php
     use App\Models\Cases;
     use App\Models\User;
    @endphp
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Case</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active"><a href="{{ route('admin.cases') }}">Case</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-10">
                                <form id="filter-form">
                                    <div class=" row">
                                        <div class="col-md-2 mb-3">
                                            <select class="form-control form-control-sm" name="status">
                                                <option value="">Select Status</option>
                                                @foreach($statusList as $key => $status)
                                                    <option value="{{$status}}" @selected(!empty(request('status')) && ($status == request('status'))) > {{ucfirst($status)}} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <button type="button" class="btn btn-sm btn-primary search-case-btn">Search</button>
                                        </div>
                                    </div>
                                </form>
                                <div class="submit_notification">
                                    @if (Session::has('message'))
                                        <div class="text-{{ Session::get('status') }}">
                                            {{ Session::get('message') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-2 text-right">
                                @if(Auth::user()->isWriter())
                                    <a href="{{ route('admin.case.create') }}" class="btn btn-sm btn-primary font-weight-bolder">
                                        <i class="fa fa-plus"></i> New Case
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="load-table" class="table-responsive">
                            <table class="table table-bordered table-striped table-sm table-head-custom click_table" id="datatable">
                                <thead>
                                    <tr>
                                        <th>Case no</th>
                                        <th>Brand</th>
                                        <th>Model</th>
                                        <th>Year</th>
                                        <th>Vin</th>
                                        <th>Created By</th>
                                        <th>Assign To</th>
                                        <th>Status</th>
                                        @if (Auth::user()->isAdmin() || Auth::user()->isWriter())
                                            <th style="width: 100px;">Actions</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>

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
        var dataTableUrl = "{{route('admin.case.get-datatable')}}";
        var assignUrl = "{{route('admin.case.assign-to-pricing', ['case' => '__CASE_ID__'])}}";
        var caseUrl = "{{route('admin.case.show', ['case' => '__cId__'])}}";

        $(document).ready(function() {
            $(document).off('change', '.assigner_to').on('change', '.assigner_to', function() {
                var btn = $(this);
                var value = btn.val();
                var form = btn.closest('form');
                var formData = new FormData(form[0]);
                var caseId = btn.data('case-id');
                var submitUrl = btn.data('url') ? btn.data('url') : assignUrl;
                submitUrl = submitUrl.replace('__CASE_ID__', caseId);
                console.log(submitUrl);

                $.ajax({
                    url: submitUrl,
                    type: 'PUT',
                    dataType: 'json',
                    // data: form.serialize(),
                    data:  {'assigned_to': value},
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    beforeSend: function() {
                        $('.error,.submit_notification').html('');
                        form.find(".form-control").removeClass("red-border");
                        $('.btn').attr("disabled", "disabled");
                        // btn.val("Sending...");
                    },
                    success: function(result) {
                        $('.btn').removeAttr("disabled");

                        notify(result.message,'success',300);
                        btn.find('option:selected').text();
                        btn.closest('td').find('.assign_name').text(btn.find('option:selected').text());
                        btn.closest('td').next().html(result.status)
                    },
                    error: function(e) {
                        $('.btn').removeAttr("disabled");
                        btn.val(value);

                        if (e.status == 422) {
                            $.each(e.responseJSON.errors, function(i, val) {
                                if (val != "") {
                                    form.find("#" + i + "_error").text(val);
                                    notify(val,'danger',300);
                                }
                            });
                            $("body").animate({
                                scrollTop: 0
                            }, "slow");
                            notify(e.responseJSON.message,'danger',300);
                        } else if (e.message || e.responseJSON.message) {
                            notify((e.responseJSON.message ? e.responseJSON.message : e.message),'danger',300);
                        } else {
                            notify("Something Went Wrong!... Please try again after refresh",'danger',300);
                        }
                    }
                });
            });

            var searchform = $('#filter-form').serialize();

            loadComplainTable(searchform);

            $(document).off("click", ".search-case-btn").on("click", ".search-case-btn", function (e) {
                e.stopPropagation();
                if (searchform != $('#filter-form').serialize()) {
                    searchform = $('#filter-form').serialize()
                    // loadTable('#load-table', '#filter-form')
                    loadComplainTable(searchform);
                }
            });
        });

        var table;
        var columns = [];
        @foreach($columns as $key => $column)
            columns.push({ data: '{{$key}}' });
        @endforeach

        function loadComplainTable(formSerialize) {
            if(typeof table !== 'undefined'){
                table.destroy();
            }

            if (formSerialize == '') {
                const urlParams = new URLSearchParams(window.location.search);
                formSerialize = "status="+urlParams.get('status');
            }
            var domOption = 'lfrtip';
            var lengthMenu = [[40, 100], [40, 100]];


            table = $('#datatable').DataTable( {
                "processing": true,
                "serverSide": true,
                "aaSorting": [[0, 'desc']],
                "pageLength":40,
                "lengthMenu": lengthMenu,
                "searchDelay": 1000,
                "ajax": {
                    type:'POST',
                    url: dataTableUrl,
                    data: function ( d ) {
                        return formSerialize + "&" + $.param(d);
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                },
                'createdRow': function( row, data, dataIndex ) {
                    $(row).attr('data-href', caseUrl.replace('__cId__', data.id));
                },
                "columns": columns,
                "columnDefs": [
                    { className: 'no_redirect', targets: [columns.length-1] },
                    { className: 'no_redirect', targets: [columns.length-3] },
                    { orderable: false, targets: -1 },
                ],
                "dom": domOption,
            });
        }

    </script>
@endsection
