@php use App\Models\Cases; @endphp

@if ((Auth::user()->isAdmin() || ($case->created_by == Auth::user()->id)) && in_array($case->status, [Cases::IN_PROGRESS, Cases::PENDING]))
    <select name="assigner_to" class="form-control form-control-sm assigner_to" data-case-id="{{$case->id}}">
        <option value="">Assign To</option>
        @foreach($pricingUsers as $id => $name)
            <option value="{{$id}}" @selected($case->assigned_to == $id)>{{$name}}</option>
        @endforeach
    </select>
@else
    <span class="assign_name">{{ $pricingUsers[$case->assigned_to] ?? '' }}</span>
@endif
