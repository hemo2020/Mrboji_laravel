@php use App\Models\Cases; @endphp
{!! Cases::getStatusLabel($case->status) !!}
<span>{{$case->closing_date ?? ''}}</span>
