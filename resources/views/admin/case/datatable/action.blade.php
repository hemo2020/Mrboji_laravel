@php use App\Models\Cases; @endphp
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
