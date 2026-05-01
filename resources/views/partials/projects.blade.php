<section id="projects">
  <div class="reveal">
    <div class="sec-tag">Our Work</div>
    <h2 class="sec-title">Featured <span>Projects</span></h2>
  </div>

  <div class="filter-bar">
    <button class="filter-btn active" data-filter="all">All</button>
    <button class="filter-btn" data-filter="residential">Residential</button>
    <button class="filter-btn" data-filter="commercial">Commercial</button>
    <button class="filter-btn" data-filter="renovation">Renovation</button>
    <button class="filter-btn" data-filter="civil">Civil Works</button>
  </div>

  <div class="projects-grid">
    @foreach($projects as $project)
    @php
      $thumbPath = $project->image_url
        ? (pathinfo($project->image_url, PATHINFO_DIRNAME) === '.'
            ? pathinfo($project->image_url, PATHINFO_FILENAME).'_thumb.webp'
            : pathinfo($project->image_url, PATHINFO_DIRNAME).'/'.pathinfo($project->image_url, PATHINFO_FILENAME).'_thumb.webp')
        : null;
    @endphp
    <a class="project-card" data-cat="{{ $project->category }}" href="{{ route('projects.show', $project) }}">
      <img
        src="{{ $project->image_url ? (str_starts_with($project->image_url, 'http') ? $project->image_url : Storage::url($thumbPath)) : 'https://via.placeholder.com/1200x800?text=Project' }}"
        alt="{{ $project->title }}"
        onerror="this.onerror=null;this.src='{{ $project->image_url ? (str_starts_with($project->image_url, 'http') ? $project->image_url : Storage::url($project->image_url)) : 'https://via.placeholder.com/1200x800?text=Project' }}'"
      >
      <div class="project-overlay">
        <div class="proj-cat">{{ ucfirst($project->category) }}</div>
        <div class="proj-name">{{ $project->title }}</div>
      </div>
    </a>
    @endforeach
  </div>
</section>
