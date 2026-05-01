@extends('admin.layouts.app')
@section('title', 'Settings')
@section('page_title', 'Settings')
@section('breadcrumb', 'Home / Settings')

@section('content')
<div class="grid-2" style="margin-bottom:20px;">

  {{-- Company Info --}}
  <div class="c-card">
    <div class="c-card-head"><div class="c-card-title">Company Info</div></div>
    <div class="c-card-body">
      <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf @method('PUT')
        <div class="form-group2" style="margin-bottom:14px;">
          <label>Company Name</label>
          <input type="text" name="company_name" value="{{ $settings['company_name'] ?? 'Shekhar Nirman Sewa' }}">
        </div>
        <div class="form-group2" style="margin-bottom:14px;">
          <label>Tagline</label>
          <input type="text" name="tagline" value="{{ $settings['tagline'] ?? 'Building Your Vision, Brick by Brick' }}">
        </div>
        <div class="form-group2" style="margin-bottom:14px;">
          <label>Phone</label>
          <input type="text" name="phone" value="{{ $settings['phone'] ?? '+977-9800000000' }}">
        </div>
        <div class="form-group2" style="margin-bottom:14px;">
          <label>Email</label>
          <input type="email" name="email" value="{{ $settings['email'] ?? 'info@shekharnirmansewa.com' }}">
        </div>
        <div class="form-group2" style="margin-bottom:14px;">
          <label>Address</label>
          <textarea name="address" rows="3">{{ $settings['address'] ?? 'Butwal-10, Rupandehi, Lumbini Province, Nepal' }}</textarea>
        </div>
        <div class="form-group2" style="margin-bottom:14px;">
          <label>Instagram URL</label>
          <input type="url" name="instagram" value="{{ $settings['instagram'] ?? '' }}">
        </div>
        <div class="form-group2" style="margin-bottom:20px;">
          <label>Facebook URL</label>
          <input type="url" name="facebook" value="{{ $settings['facebook'] ?? '' }}">
        </div>
        <button class="btn btn-primary2"><i class="fas fa-save"></i> Save Changes</button>
      </form>
    </div>
  </div>

  <div>
    {{-- Hero Section --}}
    <div class="c-card" style="margin-bottom:20px;">
      <div class="c-card-head"><div class="c-card-title">Hero Section</div></div>
      <div class="c-card-body">
        <form action="{{ route('admin.settings.hero') }}" method="POST">
          @csrf @method('PUT')
          <div class="form-group2" style="margin-bottom:14px;">
            <label>Hero Title</label>
            <input type="text" name="hero_title" value="{{ $settings['hero_title'] ?? 'Building Your' }}">
          </div>
          <div class="form-group2" style="margin-bottom:14px;">
            <label>Highlighted Word</label>
            <input type="text" name="hero_highlight" value="{{ $settings['hero_highlight'] ?? 'Vision,' }}">
          </div>
          <div class="form-group2" style="margin-bottom:20px;">
            <label>Subtitle</label>
            <textarea name="hero_subtitle" rows="3">{{ $settings['hero_subtitle'] ?? 'From foundations to finishing...' }}</textarea>
          </div>
          <button class="btn btn-primary2"><i class="fas fa-save"></i> Save</button>
        </form>
      </div>
    </div>

    {{-- Stats --}}
    <div class="c-card">
      <div class="c-card-head"><div class="c-card-title">Stats Counter</div></div>
      <div class="c-card-body">
        <form action="{{ route('admin.settings.stats') }}" method="POST">
          @csrf @method('PUT')
          <div class="form-grid" style="margin-bottom:16px;">
            <div class="form-group2"><label>Years Experience</label><input type="number" name="stat_years" value="{{ $settings['stat_years'] ?? 10 }}"></div>
            <div class="form-group2"><label>Projects</label><input type="number" name="stat_projects" value="{{ $settings['stat_projects'] ?? 250 }}"></div>
            <div class="form-group2"><label>Clients</label><input type="number" name="stat_clients" value="{{ $settings['stat_clients'] ?? 180 }}"></div>
            <div class="form-group2"><label>Workers</label><input type="number" name="stat_workers" value="{{ $settings['stat_workers'] ?? 40 }}"></div>
          </div>
          <button class="btn btn-primary2"><i class="fas fa-save"></i> Save Stats</button>
        </form>
      </div>
    </div>
  </div>

</div>

{{-- Admin Account --}}
<div class="c-card">
  <div class="c-card-head"><div class="c-card-title">Admin Account</div></div>
  <div class="c-card-body">
    <form action="{{ route('admin.settings.password') }}" method="POST">
      @csrf @method('PUT')
      <div class="form-grid" style="margin-bottom:16px;">
        <div class="form-group2"><label>Name</label><input type="text" name="name" value="{{ auth()->user()->name ?? '' }}"></div>
        <div class="form-group2"><label>Email</label><input type="email" name="email" value="{{ auth()->user()->email ?? '' }}"></div>
        <div class="form-group2"><label>New Password</label><input type="password" name="password" placeholder="Leave blank to keep current"></div>
        <div class="form-group2"><label>Confirm Password</label><input type="password" name="password_confirmation" placeholder="Confirm new password"></div>
      </div>
      <button class="btn btn-primary2"><i class="fas fa-save"></i> Update Account</button>
    </form>
  </div>
</div>
@endsection
