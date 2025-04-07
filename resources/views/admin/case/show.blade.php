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
                            <li class="breadcrumb-item active">Case Detail</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Case Detail {!! Cases::getStatusLabel($case->status) !!} {{!empty($case->closing_date) ? "(".$case->closing_date.")" : ''}}</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Case No</label>
                                        <p>{{ $case->case_no ?? '' }}</p>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Brand</label>
                                        <p>{{ $case->brand ?? '' }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Model</label>
                                        <p>{{ $case->model ?? '' }}</p>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Year</label>
                                        <p>{{ $case->year ?? '' }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Vin</label>
                                        <p>{{ $case->vin ?? '' }}</p>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Date</label>
                                        <p>{{ !empty($case->date) ? date('d-m-Y', strtotime($case->date)) : '' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="card card-outline card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Pricing Detail</h3>
                                    </div>
                                    <form onsubmit="return false;" id="case_frm">
                                        @csrf
                                        @isset($case)
                                            @php $actionUrl = route('admin.case.submit.pricing', $case->id); @endphp
                                            @method('PUT')
                                        @endisset
                                        <div class="card-body">
                                            <table id="part_tbl" class="table table-sm table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Part Name</th>
                                                        <th>Qty</th>
                                                        <th>Part No</th>
                                                        <th>Rate</th>
                                                        <th>Discount (%)</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @if(\Auth::user()->isPricing() && ($case->status == Cases::IN_PROGRESS))
                                                    @foreach($case->pricing as $i => $price)
                                                        <tr>
                                                            <td>
                                                                <input type="hidden" name="parts[{{$i}}][id]" value="{{$price->id}}">
                                                                {{$price->part_name}}
                                                            </td>
                                                            <td>
                                                                {{$price->qty}}
                                                                <input type="hidden" name="parts[{{$i}}][qty]" value="{{$price->qty}}" class="qty-text" >
                                                            </td>
                                                            <td>
                                                                <input type="text" name="parts[{{$i}}][part_no]" value="{{$price->part_no}}" class="form-control form-control-sm part_no-text" placeholder="{{__('Part No')}}">
                                                            </td>
                                                            <td>
                                                                <input type="number" name="parts[{{$i}}][price]" value="{{$price->price}}" class="form-control form-control-sm price-text" placeholder="{{__('Price')}}">
                                                            </td>
                                                            <td>
                                                                <input type="number" name="parts[{{$i}}][discount]" value="{{$price->discount}}" class="form-control form-control-sm discount-text" placeholder="{{__('Discount')}}">
                                                            </td>
                                                            <td>
                                                                <span class="subtotal-text">{{$price->getTotal()}}</span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    @foreach($case->pricing as $i => $price)
                                                        <tr>
                                                            <td>
                                                                {{$price->part_name}}
                                                            </td>
                                                            <td>
                                                                {{$price->qty}}
                                                            </td>
                                                            <td>
                                                                {{$price->part_no}}
                                                            </td>
                                                            <td>
                                                                {{$price->price}}
                                                            </td>
                                                            <td>
                                                                {{$price->discount}}
                                                            </td>
                                                            <td>
                                                                {{$price->getTotal()}}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                                </tbody>
                                            </table>
                                        </div>
                                        @if(\Auth::user()->isPricing() && ($case->status == Cases::IN_PROGRESS))
                                            <div class="card-footer">
                                                <input type="button" id="" class="btn btn-primary modal_submit_info" data-url="{{ $actionUrl }}" value="Save" />
                                                <a type="button" id="back_btn" class="btn btn-default back_btn" href="{{ route('admin.cases') }}">Back</a>
                                                <button type="button" class="btn btn-success complete-case-btn float-right" data-status="Complete" data-href="{{ route('admin.case.complete', $case->id) }}">
                                                    <i class="fa fa-check"></i> Complete Case
                                                </button>
                                                <div class="submit_notification">
                                                @if (Session::has('message'))
                                                    <div class="text-{{ Session::get('status') }}">{{ Session::get('message') }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    </form>
                                </div>

                                @if(\Auth::user()->isWriter() && ($case->status == Cases::COMPLETED))
                                    <button class="btn btn-dark close-case-btn" data-status="Close" data-href="{{ route('admin.case.close', $case->id) }}">
                                        <i class="fa fa-times-circle"></i> Close Case
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">

        var getPartPrice = "{{route('admin.case.get-part-price')}}";

        function calculateDiscountAmount(total, discount) {
            if(total > 0) {
                return ((total * discount)/100);
            } else {
                return 0;
            }
        }

        function calculateTotalAmount(tr, price, discount) {
            let qty = tr.find('.qty-text').val();
            let total = (price*qty);
            let discountAmount = calculateDiscountAmount(total, discount);
            tr.find('.subtotal-text').text((total-discountAmount));
        }

        $(document).ready(function (){
            $(document).off("change", ".price-text").on("change", ".price-text", function(e) {
                let tr = $(this).closest('tr');
                let price = $(this).val();
                let discount = tr.find('.discount-text').val();
                calculateTotalAmount(tr, price, discount)
            });

            $(document).off("change", ".discount-text").on("change", ".discount-text", function(e) {
                let tr = $(this).closest('tr');
                let price = tr.find('.price-text').val();
                let discount = $(this).val();
                calculateTotalAmount(tr, price, discount);
            });

            $(document).off("change", ".part_no-text").on("change", ".part_no-text", function(e) {
                let tr = $(this).closest('tr');
                let partNo = $(this).val();

                $.ajax({
                    url: getPartPrice,
                    type: 'post',
                    dataType: 'json',
                    data:{
                        'part_no': partNo,
                        '_token' : $("meta[name='csrf-token']").attr("content")
                    },
                    success: function(data) {
                        console.log(data);
                        tr.find('.price-text').val(data.price);
                        tr.find('.discount-text').val(data.discount);

                        calculateTotalAmount(tr, data.price, data.discount);
                    }, error(e) {
                        notify(e.responseJSON.message, 'danger', 0);
                    }
                });
            });

            $(document).off('click', '.close-case-btn, .complete-case-btn').on('click', '.close-case-btn, .complete-case-btn', function (e) {
                e.stopPropagation();
                var btn = $(this);
                var status = $(this).data('status');
                bootbox.confirm({
                    size: 'medium',
                    title: "<span class='text-danger'>Alert !</span>",
                    message: "Are You Sure You Want to "+status+" This Case?",
                    buttons: {
                        cancel: {
                            label: '<i class="fa fa-times"></i> Cancel'
                        },
                        confirm: {
                            label: '<i class="fa fa-check"></i> Confirm',
                            class: 'btn-info'
                        }
                    },
                    callback: function (result) {
                        if (result) {
                            $.ajax({
                                url: btn.data('href'),
                                type: 'put',
                                dataType: 'json',
                                data:{'_token' : $("meta[name='csrf-token']").attr("content")},
                                success: function(data) {
                                    notify(data.message, 'success');
                                    window.location.reload();
                                }, error(e) {
                                    notify(e.responseJSON.message, 'danger', 0);
                                    // notify('Something went wrong please try again after refresh!', 'danger', 0);
                                }
                            });
                        }
                    }
                })
            });

        });
    </script>
@endsection
