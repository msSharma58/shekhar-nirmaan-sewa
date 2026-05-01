@extends('admin.layouts.app')
@section('title', 'Dashboard')
@section('page_title', 'Dashboard')
@section('breadcrumb', 'Home / Dashboard')

@section('content')
<div class="stats-row">
  <div class="stat-card" data-accent="orange">
    <div class="stat-top">
      <div class="stat-label2">Total Projects</div>
      <div class="stat-icon orange"><i class="fas fa-hard-hat"></i></div>
    </div>
    <div class="stat-num2">{{ $totalProjects }}</div>
    <div class="stat-change up"><i class="fas fa-arrow-up"></i> All time</div>
  </div>
  <div class="stat-card" data-accent="green">
    <div class="stat-top">
      <div class="stat-label2">Services</div>
      <div class="stat-icon green"><i class="fas fa-tools"></i></div>
    </div>
    <div class="stat-num2">{{ $totalServices }}</div>
    <div class="stat-change up"><i class="fas fa-circle"></i> Active</div>
  </div>
  <div class="stat-card" data-accent="blue">
    <div class="stat-top">
      <div class="stat-label2">Testimonials</div>
      <div class="stat-icon blue"><i class="fas fa-star"></i></div>
    </div>
    <div class="stat-num2">{{ $totalTestimonials }}</div>
    <div class="stat-change up"><i class="fas fa-circle"></i> Published</div>
  </div>
  <div class="stat-card" data-accent="red">
    <div class="stat-top">
      <div class="stat-label2">Unread Messages</div>
      <div class="stat-icon red"><i class="fas fa-envelope"></i></div>
    </div>
    <div class="stat-num2">{{ $unreadMessages }}</div>
    <div class="stat-change {{ $unreadMessages > 0 ? 'down' : 'up' }}">
      <i class="fas fa-{{ $unreadMessages > 0 ? 'exclamation' : 'check' }}"></i>
      {{ $unreadMessages > 0 ? 'Needs attention' : 'All read' }}
    </div>
  </div>
</div>

<div class="grid-3-1">
  {{-- Recent Projects --}}
  <div class="c-card">
    <div class="c-card-head">
      <div class="c-card-title">Recent Projects</div>
      <a href="{{ route('admin.projects.index') }}" class="c-card-action">View All →</a>
    </div>
    <div class="c-card-body" style="padding:0;">
      <div class="tbl-wrap">
        <table class="tbl">
          <thead>
            <tr><th>Project</th><th>Category</th><th>Status</th><th>Date</th><th></th></tr>
          </thead>
          <tbody>
            @forelse($recentProjects as $project)
            <tr>
              <td>
                <strong>{{ $project->title }}</strong>
                <br><small style="color:var(--muted)">{{ $project->location }}</small>
              </td>
              <td><span class="badge orange">{{ ucfirst($project->category) }}</span></td>
              <td>
                <span class="badge {{ $project->status === 'completed' ? 'green' : ($project->status === 'ongoing' ? 'orange' : 'gray') }}">
                  {{ ucfirst($project->status ?? 'completed') }}
                </span>
              </td>
              <td style="color:var(--muted);font-size:.8rem">{{ $project->created_at->format('M Y') }}</td>
              <td>
                <a href="{{ route('admin.projects.edit', $project) }}" class="act-btn"><i class="fas fa-pen"></i></a>
              </td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center;color:var(--muted);padding:30px;">No projects yet.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  {{-- Recent Messages --}}
  <div class="c-card">
    <div class="c-card-head">
      <div class="c-card-title">Recent Messages</div>
      <a href="{{ route('admin.contacts.index') }}" class="c-card-action">View All →</a>
    </div>
    <div class="c-card-body">
      @forelse($recentMessages as $msg)
      <div class="activity-item">
        <div class="activity-dot" style="background:{{ $msg->is_read ? 'var(--muted)' : 'var(--orange)' }}"></div>
        <div>
          <div class="activity-text"><strong>{{ $msg->name }}</strong> – {{ Str::limit($msg->message, 50) }}</div>
          <div class="activity-time">{{ $msg->created_at->diffForHumans() }}</div>
        </div>
      </div>
      @empty
      <div style="color:var(--muted);font-size:.85rem;text-align:center;padding:20px;">No messages yet.</div>
      @endforelse
    </div>
  </div>
</div>

{{-- Monthly Chart --}}
<div class="c-card">
  <div class="c-card-head">
    <div class="c-card-title">Monthly Enquiries</div>
    <div style="font-family:var(--font-c);font-size:.72rem;color:var(--muted);letter-spacing:1px;">{{ date('Y') }}</div>
  </div>
  <div class="c-card-body">
    <div style="display:flex;gap:5px;align-items:flex-end;height:100px;">
      @foreach($monthlyStats as $month => $count)
      @php $maxCount = max(array_values($monthlyStats)) ?: 1; $pct = round(($count/$maxCount)*100); @endphp
      <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:4px;">
        <div title="{{ $count }} enquiries" style="flex:1;width:100%;background:var(--orange-dim);border-top:2px solid {{ $pct > 0 ? 'var(--orange)' : 'var(--border2)' }};min-height:{{ max($pct, 5) }}%;"></div>
        <span style="font-size:.6rem;color:var(--muted);font-family:var(--font-c);">{{ substr($month, 0, 3) }}</span>
      </div>
      @endforeach
    </div>
  </div>
</div>
@endsection
