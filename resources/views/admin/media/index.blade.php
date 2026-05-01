@extends('admin.layouts.app')
@section('title', 'Media Library')
@section('page_title', 'Media Library')
@section('breadcrumb', 'Home / Media')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;flex-wrap:wrap;gap:12px;">
  <div style="font-family:var(--font-c);font-size:.78rem;letter-spacing:1px;color:var(--muted);">
    {{ $media->total() }} files
  </div>
  <button class="btn btn-primary2" onclick="document.getElementById('mediaUpload').click()">
    <i class="fas fa-upload"></i> Upload Files
  </button>
</div>

{{-- Upload Form (hidden trigger) --}}
<form action="{{ route('admin.media.store') }}" method="POST" enctype="multipart/form-data" id="mediaUploadForm">
  @csrf
  <input type="file" name="files[]" id="mediaUpload" multiple accept="image/*" style="display:none;" onchange="this.form.submit()">
</form>

{{-- Upload Drop Zone --}}
<div class="img-upload" id="mediaDropZone" style="margin-bottom:20px;" onclick="document.getElementById('mediaUpload').click()">
  <i class="fas fa-cloud-upload-alt"></i>
  <p>Click to upload or drag &amp; drop images here</p>
  <p style="font-size:.75rem;margin-top:4px;color:var(--muted);">JPG, PNG, WEBP, GIF · Max 5MB each · Multiple files supported</p>
</div>

<div class="c-card">
  <div class="c-card-body">
    @if($media->count() > 0)
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(140px,1fr));gap:14px;">
      @foreach($media as $file)
      <div class="media-thumb" style="position:relative;cursor:pointer;border:1px solid var(--border);" title="{{ $file->file_name }}">
        <img src="{{ Storage::url($file->file_path) }}" style="width:100%;height:110px;object-fit:cover;display:block;">
        <div style="padding:8px;background:var(--card2);border-top:1px solid var(--border);">
          <div style="font-size:.72rem;color:var(--muted);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $file->file_name }}</div>
          <div style="font-size:.66rem;color:var(--muted);margin-top:2px;">{{ round($file->file_size / 1024) }} KB</div>
        </div>
        {{-- Actions overlay --}}
        <div class="media-actions" style="position:absolute;top:6px;right:6px;display:flex;gap:4px;opacity:0;transition:opacity .2s;">
          <button class="act-btn" style="background:rgba(13,13,13,.8);" onclick="copyUrl('{{ Storage::url($file->file_path) }}')" title="Copy URL">
            <i class="fas fa-link"></i>
          </button>
          <form action="{{ route('admin.media.destroy', $file) }}" method="POST" onsubmit="return confirm('Delete this file?')">
            @csrf @method('DELETE')
            <button type="submit" class="act-btn del" style="background:rgba(13,13,13,.8);" title="Delete"><i class="fas fa-trash"></i></button>
          </form>
        </div>
      </div>
      @endforeach
    </div>
    @if($media->hasPages())
    <div style="margin-top:20px;">{{ $media->links() }}</div>
    @endif
    @else
    <div style="text-align:center;padding:60px;color:var(--muted);">
      <i class="fas fa-images" style="font-size:3rem;display:block;margin-bottom:14px;"></i>
      No media uploaded yet. Click above to upload your first image.
    </div>
    @endif
  </div>
</div>

{{-- Toast --}}
<div id="copyToast" style="position:fixed;bottom:32px;left:50%;transform:translateX(-50%) translateY(80px);background:var(--orange);color:var(--black);padding:10px 22px;font-family:var(--font-c);font-size:.8rem;letter-spacing:2px;text-transform:uppercase;opacity:0;transition:all .3s;z-index:999;">
  URL Copied!
</div>
@endsection

@push('scripts')
<script>
// Hover to show media actions
document.querySelectorAll('.media-thumb').forEach(t => {
  t.addEventListener('mouseenter', () => t.querySelector('.media-actions').style.opacity = '1');
  t.addEventListener('mouseleave', () => t.querySelector('.media-actions').style.opacity = '0');
});

// Copy URL
function copyUrl(url) {
  navigator.clipboard.writeText(url).then(() => {
    const toast = document.getElementById('copyToast');
    toast.style.opacity = '1';
    toast.style.transform = 'translateX(-50%) translateY(0)';
    setTimeout(() => {
      toast.style.opacity = '0';
      toast.style.transform = 'translateX(-50%) translateY(80px)';
    }, 2000);
  });
}

// Drag & Drop upload
const dz = document.getElementById('mediaDropZone');
['dragenter','dragover'].forEach(e => dz.addEventListener(e, ev => { ev.preventDefault(); dz.style.borderColor = 'var(--orange)'; }));
['dragleave','drop'].forEach(e => dz.addEventListener(e, ev => { ev.preventDefault(); dz.style.borderColor = ''; }));
dz.addEventListener('drop', ev => {
  const dt = ev.dataTransfer;
  const input = document.getElementById('mediaUpload');
  input.files = dt.files;
  document.getElementById('mediaUploadForm').submit();
});
</script>
@endpush
