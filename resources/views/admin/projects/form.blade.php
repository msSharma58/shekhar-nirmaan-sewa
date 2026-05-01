@extends('admin.layouts.app')
@section('title', isset($project) ? 'Edit Project' : 'Add Project')
@section('page_title', isset($project) ? 'Edit Project' : 'Add Project')
@section('breadcrumb', 'Home / Projects / ' . (isset($project) ? 'Edit' : 'New'))

@section('content')
<div style="max-width:860px;">
  <form
    action="{{ isset($project) ? route('admin.projects.update', $project) : route('admin.projects.store') }}"
    method="POST"
    enctype="multipart/form-data"
  >
    @csrf
    @if(isset($project)) @method('PUT') @endif

    <div class="c-card" style="margin-bottom:20px;">
      <div class="c-card-head"><div class="c-card-title">Project Details</div></div>
      <div class="c-card-body">

        <div class="form-grid" style="margin-bottom:16px;">
          <div class="form-group2">
            <label>Project Title *</label>
            <input type="text" name="title" value="{{ old('title', $project->title ?? '') }}" placeholder="e.g. Modern Family Villa" required>
            @error('title')<div class="field-error">{{ $message }}</div>@enderror
          </div>
          <div class="form-group2">
            <label>Location</label>
            <input type="text" name="location" value="{{ old('location', $project->location ?? '') }}" placeholder="e.g. Butwal, Rupandehi">
          </div>
        </div>

        <div class="form-grid" style="margin-bottom:16px;">
          <div class="form-group2">
            <label>Category *</label>
            <select name="category" required>
              @foreach(['residential','commercial','renovation','civil'] as $cat)
                <option value="{{ $cat }}" {{ old('category', $project->category ?? '') == $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
              @endforeach
            </select>
            @error('category')<div class="field-error">{{ $message }}</div>@enderror
          </div>
          <div class="form-group2">
            <label>Status</label>
            <select name="status">
              @foreach(['completed','ongoing','planning'] as $st)
                <option value="{{ $st }}" {{ old('status', $project->status ?? 'completed') == $st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="form-group2" style="margin-bottom:16px;">
          <label>Description</label>
          <textarea name="description" rows="4" placeholder="Describe this project...">{{ old('description', $project->description ?? '') }}</textarea>
        </div>

        <div class="form-group2" style="margin-bottom:16px;">
          <label>
            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $project->is_featured ?? false) ? 'checked' : '' }} style="accent-color:var(--orange);margin-right:6px;">
            Feature this project on homepage
          </label>
        </div>

      </div>
    </div>

    {{-- IMAGE UPLOAD --}}
    <div class="c-card" style="margin-bottom:20px;">
      <div class="c-card-head"><div class="c-card-title">Project Image</div></div>
      <div class="c-card-body">

        {{-- Current image --}}
        @if(isset($project) && $project->image_url)
        <div style="margin-bottom:16px;">
          <div style="font-family:var(--font-c);font-size:.7rem;letter-spacing:2px;color:var(--muted);text-transform:uppercase;margin-bottom:8px;">Current Image</div>
          <div style="position:relative;display:inline-block;">
            <img id="currentImg"
              src="{{ Storage::url($project->image_url) }}"
              onerror="this.src='{{ $project->image_url }}'"
              style="width:200px;height:140px;object-fit:cover;border:1px solid var(--border2);"
            >
          </div>
        </div>
        @endif

        {{-- Upload new --}}
        <div class="img-upload" id="dropZone" onclick="document.getElementById('imageFile').click()">
          <i class="fas fa-cloud-upload-alt"></i>
          <p>Click to upload or drag &amp; drop</p>
          <p style="font-size:.75rem;margin-top:4px;color:var(--muted);">JPG, PNG, WEBP · Max 5MB</p>
        </div>
        <input type="file" name="image" id="imageFile" accept="image/*" style="display:none;" onchange="previewImg(this)">
        <div id="imgPreviewWrap" style="margin-top:14px;display:none;">
          <div style="font-family:var(--font-c);font-size:.7rem;letter-spacing:2px;color:var(--orange);text-transform:uppercase;margin-bottom:8px;">New Image Preview</div>
          <img id="imgPreview" style="width:200px;height:140px;object-fit:cover;border:1px solid var(--orange);">
        </div>

        {{-- Or use URL --}}
        <div style="margin-top:16px;">
          <div style="font-family:var(--font-c);font-size:.7rem;letter-spacing:2px;color:var(--muted);text-transform:uppercase;margin-bottom:8px;">Or Use Image URL</div>
          <input type="text" name="image_url_external" class="form-group2" style="width:100%;background:var(--card2);border:1px solid var(--border2);color:var(--white);padding:11px 14px;font-family:var(--font-b);font-size:.88rem;outline:none;"
            value="{{ old('image_url_external') }}"
            placeholder="https://example.com/image.jpg"
            oninput="previewUrlImg(this.value)">
        </div>

        @error('image')<div class="field-error" style="margin-top:8px;">{{ $message }}</div>@enderror
      </div>
    </div>

    <div class="btn-row">
      <button type="submit" class="btn btn-primary2">
        <i class="fas fa-save"></i> {{ isset($project) ? 'Update Project' : 'Save Project' }}
      </button>
      <a href="{{ route('admin.projects.index') }}" class="btn btn-ghost">Cancel</a>
    </div>
  </form>
</div>
@endsection

@push('scripts')
<script>
function previewImg(input) {
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = e => {
      document.getElementById('imgPreview').src = e.target.result;
      document.getElementById('imgPreviewWrap').style.display = 'block';
    };
    reader.readAsDataURL(input.files[0]);
  }
}
function previewUrlImg(url) {
  if (url) {
    document.getElementById('imgPreview').src = url;
    document.getElementById('imgPreviewWrap').style.display = 'block';
  }
}

// Drag & Drop
const dropZone = document.getElementById('dropZone');
['dragenter','dragover'].forEach(e => dropZone.addEventListener(e, ev => { ev.preventDefault(); dropZone.style.borderColor = 'var(--orange)'; }));
['dragleave','drop'].forEach(e => dropZone.addEventListener(e, ev => { ev.preventDefault(); dropZone.style.borderColor = ''; }));
dropZone.addEventListener('drop', ev => {
  const file = ev.dataTransfer.files[0];
  if (file) {
    document.getElementById('imageFile').files = ev.dataTransfer.files;
    previewImg(document.getElementById('imageFile'));
  }
});
</script>
@endpush
