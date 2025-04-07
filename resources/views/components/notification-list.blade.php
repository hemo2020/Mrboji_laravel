@foreach($notifications as $notification)
    <a href="{{route('admin.call.show', [$notification->data['id']])}}" class="dropdown-item">
        <i class="fas fa-circle mr-2 text-{{\App\Models\Call::statusColour[$notification->data['status']]}}"></i> {{$notification->data['description']}}
        <span class="float-right text-muted text-sm">{{\Carbon\Carbon::parse($notification->created_at)->diffForHumans()}}</span>
    </a>
@endforeach
