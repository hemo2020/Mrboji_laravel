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
                        <h3 class="card-title">Case List</h3>
                        <div class="card-tools">
                            <div class="submit_notification d-inline-block">
                                @if (Session::has('message'))
                                    <div class="text-{{ Session::get('status') }}">
                                        {{ Session::get('message') }}
                                    </div>
                                @endif
                            </div>
                            @if(Auth::user()->isWriter())
                                <a href="{{ route('admin.case.create') }}" class="btn btn-sm btn-primary font-weight-bolder">
                                    <i class="fa fa-plus"></i> New Case
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
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
                                    @if ($cases->count())
                                        @foreach ($cases as $i => $case)
                                            <tr class="" data-href="{{route('admin.case.show', ['case' => $case->id])}}">
                                                <td>{{ $case->case_no }}</td>
                                                <td>{{ $case->brand }}</td>
                                                <td>{{ $case->model }}</td>
                                                <td>{{ $case->year }}</td>
                                                <td>{{ $case->vin }}</td>
                                                <td>{{ $case->createdBy->name ?? '' }}</td>
                                                <td class="no_redirect">
                                                    @if ((Auth::user()->isAdmin() || ($case->created_by == Auth::user()->id)) && in_array($case->status, [Cases::IN_PROGRESS, Cases::PENDING]))
                                                        <select name="assigner_to" class="form-control form-control-sm assigner_to" id="assigner_to" data-case-id="{{$case->id}}">
                                                            <option value="">Assign To</option>
                                                            @foreach($pricingUsers as $id => $name)
                                                                <option value="{{$id}}" @selected($case->assigned_to == $id)>{{$name}}</option>
                                                            @endforeach
                                                        </select>
                                                    @else
                                                        <span class="assign_name">{{ $pricingUsers[$case->assigned_to] ?? '' }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    {!! Cases::getStatusLabel($case->status) !!}
                                                </td>
                                                @if (Auth::user()->isAdmin() || Auth::user()->isWriter())
                                                    <td nowrap="nowrap">
                                                        @if (in_array($case->status, [Cases::IN_PROGRESS, Cases::PENDING]))
                                                            <a class="btn btn-sm btn-info edit-btn" href="{{ route('admin.case.edit', ['case' => $case->id]) }}">
                                                                <i class="fa far fa-edit"></i>
                                                            </a>
                                                            <button class="btn btn-sm btn-danger comman-delete-btn" data-href="{{ route('admin.case.delete', $case->id) }}">
                                                                <i class="fa fa-times-circle"></i>
                                                            </button>
                                                        @endif
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
        var assignUrl = "{{route('admin.case.assign-to-pricing', ['case' => '__CASE_ID__'])}}";
        $(document).ready(function() {
            $('#datatable').DataTable({
                "paging": false,
                // "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
            });

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
        });
    </script>
@endsection
