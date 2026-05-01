@extends('admin.layouts.app')
@section('title', 'Messages')
@section('page_title', 'Messages')
@section('breadcrumb', 'Home / Messages')

@section('content')
<div class="stats-row" style="grid-template-columns:repeat(3,1fr);margin-bottom:20px;">
  <div class="stat-card" data-accent="blue">
    <div class="stat-top"><div class="stat-label2">Total Messages</div><div class="stat-icon blue"><i class="fas fa-envelope"></i></div></div>
    <div class="stat-num2">{{ $total }}</div>
  </div>
  <div class="stat-card" data-accent="orange">
    <div class="stat-top"><div class="stat-label2">Unread</div><div class="stat-icon orange"><i class="fas fa-envelope-open"></i></div></div>
    <div class="stat-num2">{{ $unread }}</div>
  </div>
  <div class="stat-card" data-accent="green">
    <div class="stat-top"><div class="stat-label2">Read</div><div class="stat-icon green"><i class="fas fa-check-double"></i></div></div>
    <div class="stat-num2">{{ $total - $unread }}</div>
  </div>
</div>

<div class="c-card">
  <div class="c-card-head">
    <div class="c-card-title">Inbox <span style="color:var(--muted);font-size:.75rem;margin-left:8px;">({{ $unread }} unread)</span></div>
    @if($unread > 0)
    <form action="{{ route('admin.contacts.readAll') }}" method="POST">
      @csrf
      <button type="submit" class="btn btn-ghost" style="font-size:.72rem;padding:6px 14px;">Mark All Read</button>
    </form>
    @endif
  </div>
  <div class="c-card-body" style="padding:0;">
    @forelse($contacts as $msg)
    <div class="msg-item {{ !$msg->is_read ? 'unread' : '' }}" style="padding:16px 20px;">
      <div class="msg-avatar" style="{{ !$msg->is_read ? '' : 'background:rgba(61,186,111,0.1);border-color:var(--success);color:var(--success);' }}">
        {{ strtoupper(substr($msg->name, 0, 1)) }}
      </div>
      <div style="flex:1;min-width:0;">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:4px;">
          <div>
            <span class="msg-name">{{ $msg->name }}</span>
            @if($msg->service)
              <span class="badge orange" style="margin-left:8px;font-size:.62rem;">{{ $msg->service }}</span>
            @endif
          </div>
          <div class="msg-meta">
            <div class="msg-time">{{ $msg->created_at->format('M d, Y') }}</div>
            @if(!$msg->is_read)<div class="msg-unread-dot"></div>@endif
          </div>
        </div>
        <div style="font-size:.82rem;color:var(--muted);margin-bottom:8px;">
          @if($msg->phone) <i class="fas fa-phone" style="color:var(--orange);font-size:.72rem;margin-right:4px;"></i> {{ $msg->phone }} @endif
          @if($msg->email) &nbsp;·&nbsp; <i class="fas fa-envelope" style="color:var(--orange);font-size:.72rem;margin-right:4px;"></i> {{ $msg->email }} @endif
        </div>
        <div class="msg-preview" style="margin-bottom:10px;">{{ $msg->message }}</div>
        <div style="display:flex;gap:8px;">
          @if($msg->phone)
          <a href="tel:{{ $msg->phone }}" class="btn btn-primary2" style="padding:6px 14px;font-size:.72rem;text-decoration:none;"><i class="fas fa-phone"></i> Call</a>
          @endif
          @if($msg->email)
          <a href="mailto:{{ $msg->email }}" class="btn btn-ghost" style="padding:6px 14px;font-size:.72rem;text-decoration:none;"><i class="fas fa-reply"></i> Reply</a>
          @endif
          @if(!$msg->is_read)
          <form action="{{ route('admin.contacts.read', $msg) }}" method="POST">
            @csrf @method('PATCH')
            <button type="submit" class="btn btn-ghost" style="padding:6px 14px;font-size:.72rem;">Mark Read</button>
          </form>
          @endif
          <form action="{{ route('admin.contacts.destroy', $msg) }}" method="POST" onsubmit="return confirm('Delete this message?')">
            @csrf @method('DELETE')
            <button type="submit" class="act-btn del" title="Delete"><i class="fas fa-trash"></i></button>
          </form>
        </div>
      </div>
    </div>
    @empty
    <div style="text-align:center;padding:60px;color:var(--muted);">
      <i class="fas fa-inbox" style="font-size:2.5rem;margin-bottom:12px;display:block;"></i>
      No messages yet.
    </div>
    @endforelse
  </div>
  @if($contacts->hasPages())
  <div style="padding:16px 20px;border-top:1px solid var(--border);">
    {{ $contacts->links() }}
  </div>
  @endif
</div>
@endsection
