@extends('layouts.app')

@section('content')
<section style="padding-top:140px;">
  <div class="sec-tag">Project Detail</div>
  <h2 class="sec-title">{{ $project->title }}</h2>

  <div style="display:flex;gap:10px;flex-wrap:wrap;margin-bottom:20px;">
    <span class="filter-btn active" style="cursor:default;">{{ ucfirst($project->category) }}</span>
    <span class="filter-btn active" style="cursor:default;">{{ ucfirst($project->status ?? 'planning') }}</span>
    @if($project->location)
      <span class="filter-btn active" style="cursor:default;">{{ $project->location }}</span>
    @endif
  </div>

  @if($project->image_url)
    @php
      $mainThumbPath = pathinfo($project->image_url, PATHINFO_DIRNAME) === '.'
        ? pathinfo($project->image_url, PATHINFO_FILENAME).'_thumb.webp'
        : pathinfo($project->image_url, PATHINFO_DIRNAME).'/'.pathinfo($project->image_url, PATHINFO_FILENAME).'_thumb.webp';
    @endphp
    <div style="margin-bottom:26px;">
      <img
        src="{{ str_starts_with($project->image_url, 'http') ? $project->image_url : Storage::url($mainThumbPath) }}"
        alt="{{ $project->title }} thumbnail"
        style="width:100%;max-height:520px;object-fit:cover;border:1px solid var(--border);"
        onerror="this.onerror=null;this.src='{{ str_starts_with($project->image_url, 'http') ? $project->image_url : Storage::url($project->image_url) }}'"
      >
    </div>
  @endif

  @if($project->description)
    <p style="color:rgba(245,240,235,.75);line-height:1.8;max-width:980px;">{{ $project->description }}</p>
  @endif

  @if(!empty($project->gallery_images))
    <div style="margin-top:40px;">
      <div class="sec-tag">Gallery</div>
      <div class="projects-grid" style="grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:10px;">
        @foreach($project->gallery_images as $galleryImage)
          @php
            $galleryThumbPath = pathinfo($galleryImage, PATHINFO_DIRNAME) === '.'
              ? pathinfo($galleryImage, PATHINFO_FILENAME).'_thumb.webp'
              : pathinfo($galleryImage, PATHINFO_DIRNAME).'/'.pathinfo($galleryImage, PATHINFO_FILENAME).'_thumb.webp';
          @endphp
          <div class="project-card" style="height:220px;cursor:default;">
            <img
              src="{{ str_starts_with($galleryImage, 'http') ? $galleryImage : Storage::url($galleryThumbPath) }}"
              alt="{{ $project->title }} gallery"
              onerror="this.onerror=null;this.src='{{ str_starts_with($galleryImage, 'http') ? $galleryImage : Storage::url($galleryImage) }}'"
            >
          </div>
        @endforeach
      </div>
    </div>
  @endif

  @if($relatedProjects->isNotEmpty())
    <div style="margin-top:50px;">
      <div class="sec-tag">Related Projects</div>
      <div class="projects-grid">
        @foreach($relatedProjects as $relatedProject)
          @php
            $relatedThumbPath = $relatedProject->image_url
              ? (pathinfo($relatedProject->image_url, PATHINFO_DIRNAME) === '.'
                  ? pathinfo($relatedProject->image_url, PATHINFO_FILENAME).'_thumb.webp'
                  : pathinfo($relatedProject->image_url, PATHINFO_DIRNAME).'/'.pathinfo($relatedProject->image_url, PATHINFO_FILENAME).'_thumb.webp')
              : null;
          @endphp
          <a class="project-card" href="{{ route('projects.show', $relatedProject) }}">
            <img
              src="{{ $relatedProject->image_url ? (str_starts_with($relatedProject->image_url, 'http') ? $relatedProject->image_url : Storage::url($relatedThumbPath)) : 'https://via.placeholder.com/1200x800?text=Project' }}"
              alt="{{ $relatedProject->title }}"
              onerror="this.onerror=null;this.src='{{ $relatedProject->image_url ? (str_starts_with($relatedProject->image_url, 'http') ? $relatedProject->image_url : Storage::url($relatedProject->image_url)) : 'https://via.placeholder.com/1200x800?text=Project' }}'"
            >
            <div class="project-overlay" style="opacity:1;">
              <div class="proj-cat">{{ ucfirst($relatedProject->category) }}</div>
              <div class="proj-name">{{ $relatedProject->title }}</div>
            </div>
          </a>
        @endforeach
      </div>
    </div>
  @endif
</section>
@endsection
