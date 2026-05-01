<aside class="sidebar" id="sidebar">
  <div class="sidebar-header">
    <div class="sidebar-logo">
      <div class="logo-icon">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <rect x="1" y="10" width="2.5" height="13" fill="#0d0d0d"/>
          <rect x="20.5" y="10" width="2.5" height="13" fill="#0d0d0d"/>
          <rect x="1" y="10" width="22" height="2" fill="#0d0d0d"/>
          <rect x="8" y="6" width="8" height="2" rx="0.3" fill="#0d0d0d" opacity="0.6"/>
          <ellipse cx="12" cy="5" rx="5" ry="3" fill="#0d0d0d" opacity="0.6"/>
          <rect x="11" y="0" width="2" height="3" fill="#0d0d0d"/>
        </svg>
      </div>
      <div class="logo-text">
        <strong>Shekhar</strong>
        <span>Nirman Sewa</span>
      </div>
    </div>
  </div>

  <nav class="sidebar-nav">
    <div class="nav-section">
      <span class="nav-section-label">Main</span>
      <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="fas fa-th-large"></i> Dashboard
      </a>
    </div>
    <div class="nav-section">
      <span class="nav-section-label">Content</span>
      <a href="{{ route('admin.projects.index') }}" class="nav-item {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}">
        <i class="fas fa-hard-hat"></i> Projects
      </a>
      <a href="{{ route('admin.services.index') }}" class="nav-item {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
        <i class="fas fa-tools"></i> Services
      </a>
      <a href="{{ route('admin.testimonials.index') }}" class="nav-item {{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}">
        <i class="fas fa-star"></i> Testimonials
      </a>
    </div>
    <div class="nav-section">
      <span class="nav-section-label">Enquiries</span>
      <a href="{{ route('admin.contacts.index') }}" class="nav-item {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
        <i class="fas fa-envelope"></i> Messages
        @php $unread = \App\Models\Contact::where('is_read', false)->count(); @endphp
        @if($unread > 0)
          <span class="nav-badge">{{ $unread }}</span>
        @endif
      </a>
    </div>
    <div class="nav-section">
      <span class="nav-section-label">System</span>
      <a href="{{ route('admin.settings') }}" class="nav-item {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
        <i class="fas fa-cog"></i> Settings
      </a>
      <a href="{{ route('admin.media') }}" class="nav-item {{ request()->routeIs('admin.media') ? 'active' : '' }}">
        <i class="fas fa-images"></i> Media Library
      </a>
    </div>
  </nav>

  <div class="sidebar-footer">
    <div class="avatar">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</div>
    <div class="user-info">
      <strong>{{ auth()->user()->name ?? 'Admin' }}</strong>
      <span>Super Admin</span>
    </div>
    <form action="{{ route('admin.logout') }}" method="POST" style="display:inline;">
      @csrf
      <button type="submit" class="logout-btn" title="Logout"><i class="fas fa-sign-out-alt"></i></button>
    </form>
  </div>
</aside>
