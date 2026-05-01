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
    <a class="project-card" data-cat="{{ $project->category }}" href="{{ route('projects.show', $project) }}">
      <img
        src="{{ $project->image_url ? (Str::startsWith($project->image_url, 'http') ? $project->image_url : Storage::url($project->image_url)) : 'https://via.placeholder.com/1200x800?text=Project' }}"
        alt="{{ $project->title }}"
      >
      <div class="project-overlay">
        <div class="proj-cat">{{ ucfirst($project->category) }}</div>
        <div class="proj-name">{{ $project->title }}</div>
      </div>
    </a>
    @endforeach
  </div>
</section>
