<div class="topbar">
  <div class="topbar-left">
    <div class="menu-toggle" id="menuToggle"><i class="fas fa-bars"></i></div>
    <div>
      <div class="page-title">@yield('page_title', 'Dashboard')</div>
      <div class="breadcrumb">@yield('breadcrumb', 'Home / Dashboard')</div>
    </div>
  </div>
  <div class="topbar-right">
    <div class="topbar-search">
      <i class="fas fa-search"></i>
      <input type="text" placeholder="Search..." id="globalSearch">
    </div>
    <div class="topbar-btn" title="Notifications">
      <i class="fas fa-bell"></i>
      @php $unread = \App\Models\Contact::where('is_read', false)->count(); @endphp
      @if($unread > 0)<span class="notif-dot"></span>@endif
    </div>
    <a href="{{ url('/') }}" target="_blank" class="topbar-btn" title="View Website">
      <i class="fas fa-external-link-alt"></i>
    </a>
  </div>
</div>
