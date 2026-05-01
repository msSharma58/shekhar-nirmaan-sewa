@extends('admin.layouts.app')
@section('title', 'Add Project')
@section('page_title', 'Add Project')
@section('breadcrumb', 'Home / Projects / New')

@section('content')
<div style="max-width:860px;">
  <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data" id="projectForm">
    @csrf

    <div class="c-card" style="margin-bottom:20px;">
      <div class="c-card-head"><div class="c-card-title">Project Details</div></div>
      <div class="c-card-body">

        <div class="form-grid" style="margin-bottom:16px;">
          <div class="form-group2">
            <label>Project Title *</label>
            <input type="text" name="title" value="{{ old('title') }}" placeholder="e.g. Modern Family Villa" required>
            @error('title')<div class="field-error">{{ $message }}</div>@enderror
          </div>
          <div class="form-group2">
            <label>Location</label>
            <input type="text" name="location" value="{{ old('location') }}" placeholder="e.g. Butwal, Rupandehi">
          </div>
        </div>

        <div class="form-grid" style="margin-bottom:16px;">
          <div class="form-group2">
            <label>Category *</label>
            <select name="category" required>
              <option value="">Select category</option>
              @foreach(['residential','commercial','renovation','civil'] as $cat)
                <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
              @endforeach
            </select>
            @error('category')<div class="field-error">{{ $message }}</div>@enderror
          </div>
          <div class="form-group2">
            <label>Status</label>
            <select name="status">
              @foreach(['completed','ongoing','planning'] as $st)
                <option value="{{ $st }}" {{ old('status','completed') == $st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="form-group2" style="margin-bottom:16px;">
          <label>Description</label>
          <textarea name="description" rows="4" placeholder="Describe this project...">{{ old('description') }}</textarea>
        </div>

        <div class="form-group2">
          <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} style="accent-color:var(--orange);width:15px;height:15px;">
            Feature this project on the homepage
          </label>
        </div>

      </div>
    </div>

    <div class="c-card" style="margin-bottom:20px;">
      <div class="c-card-head"><div class="c-card-title">Project Thumbnail</div></div>
      <div class="c-card-body">

        <div class="img-upload" id="dropZone" onclick="document.getElementById('imageFile').click()">
          <i class="fas fa-cloud-upload-alt"></i>
          <p>Click to upload or drag &amp; drop</p>
          <p style="font-size:.75rem;margin-top:4px;color:var(--muted);">JPG, PNG, WEBP · Max 5MB</p>
        </div>
        <input type="file" name="image" id="imageFile" accept="image/*" style="display:none;" onchange="previewImg(this)">

        <div id="imgPreviewWrap" style="margin-top:14px;display:none;">
          <div style="font-family:var(--font-c);font-size:.7rem;letter-spacing:2px;color:var(--orange);text-transform:uppercase;margin-bottom:8px;">Preview</div>
          <img id="imgPreview" style="width:220px;height:150px;object-fit:cover;border:2px solid var(--orange);">
          <div id="imgFileName" style="font-size:.75rem;color:var(--muted);margin-top:6px;"></div>
        </div>

        <div style="margin-top:18px;">
          <div style="font-family:var(--font-c);font-size:.7rem;letter-spacing:2px;color:var(--muted);text-transform:uppercase;margin-bottom:8px;">— Or Use Image URL —</div>
          <input type="text" name="image_url_external" value="{{ old('image_url_external') }}"
            placeholder="https://example.com/image.jpg"
            style="width:100%;background:var(--card2);border:1px solid var(--border2);color:var(--white);padding:11px 14px;font-family:var(--font-b);font-size:.88rem;outline:none;"
            oninput="previewUrlImg(this.value)">
        </div>

        @error('image')<div class="field-error" style="margin-top:8px;">{{ $message }}</div>@enderror
      </div>
    </div>

    <div class="c-card" style="margin-bottom:20px;">
      <div class="c-card-head"><div class="c-card-title">Project Gallery Images</div></div>
      <div class="c-card-body">
        <div class="form-group2">
          <label>Upload Multiple Images</label>
          <input type="file" name="gallery_images[]" id="galleryImages" accept="image/*" multiple>
          <small style="display:block;margin-top:8px;color:var(--muted);">You can select multiple images. These will appear on the project detail page.</small>
          <small style="display:block;margin-top:6px;color:var(--muted);">Images are optimized in the background after save. Thumbnails may take a short time to appear.</small>
          @error('gallery_images')<div class="field-error" style="margin-top:8px;">{{ $message }}</div>@enderror
          @error('gallery_images.*')<div class="field-error" style="margin-top:8px;">{{ $message }}</div>@enderror
        </div>
      </div>
    </div>

    <div class="btn-row">
      <button type="submit" class="btn btn-primary2"><i class="fas fa-save"></i> Save Project</button>
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
      document.getElementById('imgFileName').textContent = input.files[0].name;
    };
    reader.readAsDataURL(input.files[0]);
  }
}
function previewUrlImg(url) {
  if (url.startsWith('http')) {
    document.getElementById('imgPreview').src = url;
    document.getElementById('imgPreviewWrap').style.display = 'block';
    document.getElementById('imgFileName').textContent = 'External URL';
  }
}
const dz = document.getElementById('dropZone');
['dragenter','dragover'].forEach(ev => dz.addEventListener(ev, e => { e.preventDefault(); dz.style.borderColor='var(--orange)'; }));
['dragleave','drop'].forEach(ev => dz.addEventListener(ev, e => { e.preventDefault(); dz.style.borderColor=''; }));
dz.addEventListener('drop', e => {
  document.getElementById('imageFile').files = e.dataTransfer.files;
  previewImg(document.getElementById('imageFile'));
});

const projectForm = document.getElementById('projectForm');
projectForm.addEventListener('submit', function () {
  const submitBtn = projectForm.querySelector('button[type="submit"]');
  submitBtn.disabled = true;
  submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Creating...';
});
</script>
@endpush
