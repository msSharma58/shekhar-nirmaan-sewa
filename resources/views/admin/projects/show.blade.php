@extends('admin.layouts.app')
@section('title', 'Project Details')
@section('page_title', 'Project Details')
@section('breadcrumb', 'Home / Projects / View')

@section('content')
<div style="display:flex;justify-content:flex-end;margin-bottom:20px;gap:10px;">
  <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-primary2"><i class="fas fa-pen"></i> Edit</a>
  <a href="{{ route('admin.projects.index') }}" class="btn btn-ghost">Back</a>
</div>

<div class="c-card" style="margin-bottom:20px;">
  <div class="c-card-head"><div class="c-card-title">{{ $project->title }}</div></div>
  <div class="c-card-body">
    <div class="form-grid" style="margin-bottom:16px;">
      <div class="form-group2">
        <label>Location</label>
        <div>{{ $project->location ?: '-' }}</div>
      </div>
      <div class="form-group2">
        <label>Category</label>
        <div>{{ ucfirst($project->category) }}</div>
      </div>
    </div>

    <div class="form-grid" style="margin-bottom:16px;">
      <div class="form-group2">
        <label>Status</label>
        <div>{{ ucfirst($project->status ?? 'planning') }}</div>
      </div>
      <div class="form-group2">
        <label>Featured</label>
        <div>{{ $project->is_featured ? 'Yes' : 'No' }}</div>
      </div>
    </div>

    <div class="form-group2">
      <label>Description</label>
      <div>{{ $project->description ?: '-' }}</div>
    </div>
  </div>
</div>

<div class="c-card" style="margin-bottom:20px;">
  <div class="c-card-head"><div class="c-card-title">Thumbnail</div></div>
  <div class="c-card-body">
    @if($project->image_url)
      @php
        $mainThumbPath = pathinfo($project->image_url, PATHINFO_DIRNAME) === '.'
          ? pathinfo($project->image_url, PATHINFO_FILENAME).'_thumb.webp'
          : pathinfo($project->image_url, PATHINFO_DIRNAME).'/'.pathinfo($project->image_url, PATHINFO_FILENAME).'_thumb.webp';
      @endphp
      <img
        src="{{ str_starts_with($project->image_url, 'http') ? $project->image_url : Storage::url($mainThumbPath) }}"
        alt="{{ $project->title }} thumbnail"
        style="width:280px;height:180px;object-fit:cover;border:1px solid var(--border2);"
        onerror="this.onerror=null;this.src='{{ str_starts_with($project->image_url, 'http') ? $project->image_url : Storage::url($project->image_url) }}'"
      >
    @else
      <div style="color:var(--muted);">No thumbnail image uploaded.</div>
    @endif
  </div>
</div>

<div class="c-card">
  <div class="c-card-head"><div class="c-card-title">Gallery Images</div></div>
  <div class="c-card-body">
    @if(!empty($project->gallery_images))
      <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:12px;">
        @foreach($project->gallery_images as $galleryImage)
          @php
            $galleryThumbPath = pathinfo($galleryImage, PATHINFO_DIRNAME) === '.'
              ? pathinfo($galleryImage, PATHINFO_FILENAME).'_thumb.webp'
              : pathinfo($galleryImage, PATHINFO_DIRNAME).'/'.pathinfo($galleryImage, PATHINFO_FILENAME).'_thumb.webp';
          @endphp
          <img
            src="{{ str_starts_with($galleryImage, 'http') ? $galleryImage : Storage::url($galleryThumbPath) }}"
            alt="{{ $project->title }} gallery image"
            style="width:100%;height:140px;object-fit:cover;border:1px solid var(--border2);"
            onerror="this.onerror=null;this.src='{{ str_starts_with($galleryImage, 'http') ? $galleryImage : Storage::url($galleryImage) }}'"
          >
        @endforeach
      </div>
    @else
      <div style="color:var(--muted);">No gallery images uploaded for this project.</div>
    @endif
  </div>
</div>
@endsection
