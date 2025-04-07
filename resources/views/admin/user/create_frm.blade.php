@php
$actionUrl = route('admin.user.save');
   use App\Models\User;
    @endphp
<div class="card card-outline card-primary">
{{--    <div class="card-header">--}}
{{--        <h3 class="card-title">Dealer Create</h3>--}}
{{--    </div>--}}
    <form onsubmit="return false;" id="users_frm">
        <div class="card-body">
            <div class="row">
                @csrf
                @if(!empty($user))
                    @php $actionUrl = route('admin.user.update', [$user->id]); @endphp
                    @method('PUT')
                @endif
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Contact Name</label>
                        <input type="text" class="form-control" name='name' id="name" value="{{$user->name ?? ''}}" placeholder="Contact Name">
                        <div class="error text-danger" id='name_error'></div>
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" class="form-control" name='phone' id="phone" value="{{$user->phone ?? ''}}" placeholder="Phone">
                        <div class="error text-danger" id='phone_error'></div>
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <textarea name="address" class="form-control" id="address" placeholder="Address">{{$user->address ?? ''}}</textarea>
                        <div class="error text-danger" id='address_error'></div>
                    </div>
                    <div class="form-group">
                        <label>City</label>
                        <input type="text" class="form-control" name='city' id="city" value="{{$user->city ?? ''}}" placeholder="City">
                        <div class="error text-danger" id='city_error'></div>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <div class="custom-control custom-switch custom-switch-off-warning custom-switch-on-success">
                            <input name="status" type="checkbox" class="custom-control-input" id="status" {{(!empty($user) && $user->status==0) ? '' : 'checked'}}>
                            <label class="custom-control-label" for="status">Is Active?</label>
                        </div>
                        <div class="error text-danger" id='status_error'></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email" value="{{$user->email ?? ''}}">
                        <div class="error text-danger" id='email_error'></div>
                    </div>
                    <div class="form-group">
                        <label>New Password</label>
                        <input type="password" class="form-control" name="password" id="password" value="" placeholder="Passwrod">
                        <div class="error text-danger" id='password_error'></div>
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" value="" placeholder="Confirm Password">
                    </div>
                    <div class="form-group">
                        <label>Select Role</label>
                        <select name="role" class="form-control">
                            <option value="">Select Role</option>
                            @foreach (User::OTHER_ROLE as $role)
                                <option value="{{ $role }}" @selected(!empty($user->role) && $user->role == $role)>
                                    {{ ucfirst($role) }}
                                </option>
                            @endforeach
                        </select>
                        <div class="error text-danger" id='role_error'></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <input type="button" id="" class="btn btn-primary modal_submit_info" data-url="{{ $actionUrl }}" value="Save"/>
            <a type="button" id="back_btn" class="btn btn-default back_btn" href="{{route('admin.users')}}" value="Back">Back</a>
            <span class="submit_notification">
                @if (Session::has('message'))
                <div class="text-{{ Session::get('status') }}">{{ Session::get('message') }}</div>
                @endif
            </span>
        </div>
    </form>
</div>

@section('extra-scripts')
<script type="text/javascript">
    $(document).ready(function() {

    });
</script>
@endsection
