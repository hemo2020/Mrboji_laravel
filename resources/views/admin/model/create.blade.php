@php $actionUrl = route('admin.model.save'); @endphp
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Model Create</h3>
    </div>
    <form onsubmit="return false;" id="model_frm">
        <div class="card-body">
            <div class="row">
                @csrf
                @isset($model)
                    @php $actionUrl = route('admin.model.update', $model->id); @endphp
                    @method('PUT')
                @endisset

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name='name' id="name" value="{{ $model->name ?? '' }}" placeholder="Model Name">
                        <div class="error text-danger" id='name_error'></div>
                    </div>
                    <div class="form-group">
                        <label>Brand</label>
                        <select name="brand_id" class="form-control">
                            @foreach($brands as $id => $brand)
                                <option value="{{$id}}" @selected(!empty($model->brand_id) && $model->brand_id == $id)>{{$brand}}</option>
                            @endforeach
                        </select>
                        <div class="error text-danger" id='brand_id_error'></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <input type="button" id="" class="btn btn-primary modal_submit_info" data-url="{{ $actionUrl }}" value="Save" />
            <a type="button" id="back_btn" class="btn btn-default back_btn" href="{{ route('admin.models') }}">Back</a>
            <span class="submit_notification">
                @if (Session::has('message'))
                    <div class="text-{{ Session::get('status') }}">{{ Session::get('message') }}
                    </div>
                @endif
            </span>
        </div>
    </form>
</div>
