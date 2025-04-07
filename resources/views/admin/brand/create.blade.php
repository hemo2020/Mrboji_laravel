@php $actionUrl = route('admin.brand.save'); @endphp
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Brand Create</h3>
    </div>
    <form onsubmit="return false;" id="brand_frm">
        <div class="card-body">
            <div class="row">
                @csrf
                @isset($brand)
                    @php $actionUrl = route('admin.brand.update', $brand->id); @endphp
                    @method('PUT')
                @endisset

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name='name' id="name" value="{{ $brand->name ?? '' }}" placeholder="Brand Name">
                        <div class="error text-danger" id='name_error'></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <input type="button" id="" class="btn btn-primary modal_submit_info" data-url="{{ $actionUrl }}" value="Save" />
            <a type="button" id="back_btn" class="btn btn-default back_btn" href="{{ route('admin.brands') }}">Back</a>
            <span class="submit_notification">
                @if (Session::has('message'))
                    <div class="text-{{ Session::get('status') }}">{{ Session::get('message') }}
                    </div>
                @endif
            </span>
        </div>
    </form>
</div>
