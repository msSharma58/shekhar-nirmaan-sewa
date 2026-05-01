@extends('admin.layouts.app')
@section('title', 'Projects')
@section('page_title', 'Projects')
@section('breadcrumb', 'Home / Projects')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;flex-wrap:wrap;gap:12px;">
  <div style="display:flex;gap:10px;flex-wrap:wrap;">
    <form method="GET" style="display:flex;gap:10px;flex-wrap:wrap;">
      <select name="category" onchange="this.form.submit()" style="background:var(--card);border:1px solid var(--border2);color:var(--white);padding:8px 14px;font-family:var(--font-c);font-size:.8rem;letter-spacing:1px;outline:none;">
        <option value="">All Categories</option>
        @foreach(['residential','commercial','renovation','civil'] as $cat)
          <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
        @endforeach
      </select>
      <select name="status" onchange="this.form.submit()" style="background:var(--card);border:1px solid var(--border2);color:var(--white);padding:8px 14px;font-family:var(--font-c);font-size:.8rem;letter-spacing:1px;outline:none;">
        <option value="">All Status</option>
        @foreach(['completed','ongoing','planning'] as $st)
          <option value="{{ $st }}" {{ request('status') == $st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
        @endforeach
      </select>
    </form>
  </div>
  <a href="{{ route('admin.projects.create') }}" class="btn btn-primary2">
    <i class="fas fa-plus"></i> Add Project
  </a>
</div>

<div class="c-card">
  <div class="c-card-head">
    <div class="c-card-title">All Projects <span style="color:var(--muted);font-size:.75rem;margin-left:8px;">({{ $projects->total() }})</span></div>
  </div>
  <div class="tbl-wrap">
    <table class="tbl">
      <thead>
        <tr>
          <th>Image</th><th>Project Name</th><th>Location</th><th>Category</th><th>Status</th><th>Featured</th><th>Date</th><th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($projects as $project)
        <tr>
          <td>
            @if($project->image_url)
              @php
                $thumbPath = pathinfo($project->image_url, PATHINFO_DIRNAME) === '.'
                  ? pathinfo($project->image_url, PATHINFO_FILENAME).'_thumb.webp'
                  : pathinfo($project->image_url, PATHINFO_DIRNAME).'/'.pathinfo($project->image_url, PATHINFO_FILENAME).'_thumb.webp';
              @endphp
              <img
                src="{{ str_starts_with($project->image_url, 'http') ? $project->image_url : Storage::url($thumbPath) }}"
                style="width:60px;height:44px;object-fit:cover;border:1px solid var(--border);"
                onerror="this.onerror=null;this.src='{{ str_starts_with($project->image_url, 'http') ? $project->image_url : Storage::url($project->image_url) }}'"
              >
            @else
              <div style="width:60px;height:44px;background:var(--card2);display:flex;align-items:center;justify-content:center;border:1px dashed var(--border2);">
                <i class="fas fa-image" style="color:var(--muted);font-size:.8rem;"></i>
              </div>
            @endif
          </td>
          <td><strong>{{ $project->title }}</strong></td>
          <td style="color:var(--muted)">{{ $project->location }}</td>
          <td>
            @php $catColors = ['residential'=>'orange','commercial'=>'blue','renovation'=>'gray','civil'=>'red']; @endphp
            <span class="badge {{ $catColors[$project->category] ?? 'gray' }}">{{ ucfirst($project->category) }}</span>
          </td>
          <td>
            @php $stColors = ['completed'=>'green','ongoing'=>'orange','planning'=>'blue']; @endphp
            <span class="badge {{ $stColors[$project->status ?? 'completed'] ?? 'gray' }}">{{ ucfirst($project->status ?? 'completed') }}</span>
          </td>
          <td>
            <form action="{{ route('admin.projects.toggle', $project) }}" method="POST">
              @csrf @method('PATCH')
              <label class="toggle">
                <input type="checkbox" {{ $project->is_featured ? 'checked' : '' }} onchange="this.form.submit()">
                <span class="toggle-slider"></span>
              </label>
            </form>
          </td>
          <td style="color:var(--muted);font-size:.8rem">{{ $project->created_at->format('M Y') }}</td>
          <td>
            <div style="display:flex;gap:4px;">
              <a href="{{ route('admin.projects.show', $project) }}" class="act-btn" title="View"><i class="fas fa-eye"></i></a>
              <a href="{{ route('admin.projects.edit', $project) }}" class="act-btn" title="Edit"><i class="fas fa-pen"></i></a>
              <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" onsubmit="return confirm('Delete this project?')">
                @csrf @method('DELETE')
                <button type="submit" class="act-btn del" title="Delete"><i class="fas fa-trash"></i></button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr><td colspan="8" style="text-align:center;padding:40px;color:var(--muted);">No projects found. <a href="{{ route('admin.projects.create') }}" style="color:var(--orange);">Add one →</a></td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  @if($projects->hasPages())
  <div style="padding:16px 20px;border-top:1px solid var(--border);">
    {{ $projects->links() }}
  </div>
  @endif
</div>
@endsection
