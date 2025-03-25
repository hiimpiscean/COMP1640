<div class="notifications-container">
  <h3>Thông báo của bạn</h3>

  @forelse(auth()->user()->notifications as $notification)
    <div class="notification-item {{ $notification->read_at ? 'read' : 'unread' }}">
      <div class="notification-content">
        <p>{{ $notification->data['message'] }}</p>
        <small>{{ $notification->created_at->diffForHumans() }}</small>
      </div>

      @if(!$notification->read_at)
        <form action="{{ route('notifications.mark-as-read', $notification->id) }}" method="POST">
          @csrf
          <button type="submit" class="btn btn-sm btn-secondary">Đánh dấu đã đọc</button>
        </form>
      @endif

      @if($notification->data['type'] === 'class_assigned' && !isset($notification->data['confirmed']))
        <form action="{{ route('student.confirm-assignment', $notification->data['assignment_id']) }}" method="POST">
          @csrf
          <button type="submit" class="btn btn-sm btn-primary">Xác nhận tham gia</button>
        </form>
      @endif
    </div>
  @empty
    <p>Bạn không có thông báo nào.</p>
  @endforelse
</div>
