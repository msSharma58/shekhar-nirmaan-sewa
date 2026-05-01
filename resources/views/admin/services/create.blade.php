@extends('admin.layouts.app')
@section('title', 'Add Service')
@section('page_title', 'Add Service')
@section('breadcrumb', 'Home / Services / New')

@section('content')
<div style="max-width:700px;">
  <form action="{{ route('admin.services.store') }}" method="POST">
    @csrf

    <div class="c-card" style="margin-bottom:20px;">
      <div class="c-card-head"><div class="c-card-title">Service Details</div></div>
      <div class="c-card-body">

        <div class="form-group2" style="margin-bottom:16px;">
          <label>Service Title *</label>
          <input type="text" name="title" value="{{ old('title') }}" placeholder="e.g. Residential Construction" required>
          @error('title')<div class="field-error">{{ $message }}</div>@enderror
        </div>

        <div class="form-group2" style="margin-bottom:16px;">
          <label>Font Awesome Icon Class *</label>
          <div style="display:flex;gap:10px;align-items:center;">
            <input type="text" name="icon" id="iconInput" value="{{ old('icon','fas fa-tools') }}"
              placeholder="e.g. fas fa-home" style="flex:1;" oninput="updateIcon(this.value)">
            <div style="width:48px;height:48px;background:var(--orange-dim);border:1px solid var(--border2);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
              <i id="iconPreview" class="{{ old('icon','fas fa-tools') }}" style="color:var(--orange);font-size:1.3rem;"></i>
            </div>
          </div>
          <div style="margin-top:8px;font-size:.75rem;color:var(--muted);">
            Common: <code style="color:var(--orange);">fas fa-home</code> &nbsp;·&nbsp; <code style="color:var(--orange);">fas fa-building</code> &nbsp;·&nbsp; <code style="color:var(--orange);">fas fa-tools</code> &nbsp;·&nbsp; <code style="color:var(--orange);">fas fa-couch</code> &nbsp;·&nbsp; <code style="color:var(--orange);">fas fa-road</code>
          </div>
          @error('icon')<div class="field-error">{{ $message }}</div>@enderror
        </div>

        <div class="form-group2" style="margin-bottom:16px;">
          <label>Description *</label>
          <textarea name="description" rows="5" placeholder="Describe this service in detail...">{{ old('description') }}</textarea>
          @error('description')<div class="field-error">{{ $message }}</div>@enderror
        </div>

        <div class="form-group2" style="margin-bottom:8px;">
          <label>Sort Order <span style="color:var(--muted);font-weight:300;">(lower = appears first)</span></label>
          <input type="number" name="sort_order" value="{{ old('sort_order', 1) }}" min="1" style="max-width:120px;">
        </div>

      </div>
    </div>

    <div class="btn-row">
      <button type="submit" class="btn btn-primary2"><i class="fas fa-save"></i> Save Service</button>
      <a href="{{ route('admin.services.index') }}" class="btn btn-ghost">Cancel</a>
    </div>
  </form>
</div>
@endsection

@push('scripts')
<script>
function updateIcon(val) {
  document.getElementById('iconPreview').className = val;
}
</script>
@endpush
