@extends('admin.layouts.app')
@section('title', 'Services')
@section('page_title', 'Services')
@section('breadcrumb', 'Home / Services')

@section('content')
<div class="grid-2" style="align-items:start;">

  {{-- Services List --}}
  <div class="c-card">
    <div class="c-card-head">
      <div class="c-card-title">All Services <span style="color:var(--muted);font-size:.75rem;margin-left:8px;">({{ $services->count() }})</span></div>
    </div>
    <div class="tbl-wrap">
      <table class="tbl">
        <thead>
          <tr><th>Icon</th><th>Title</th><th>Order</th><th>Actions</th></tr>
        </thead>
        <tbody>
          @forelse($services as $service)
          <tr>
            <td><i class="{{ $service->icon }}" style="color:var(--orange);font-size:1.1rem;"></i></td>
            <td>
              <strong>{{ $service->title }}</strong>
              <br><small style="color:var(--muted)">{{ Str::limit($service->description, 60) }}</small>
            </td>
            <td style="color:var(--muted)">{{ $service->sort_order }}</td>
            <td>
              <div style="display:flex;gap:4px;">
                <button class="act-btn" title="Edit" onclick="editService({{ $service->toJson() }})"><i class="fas fa-pen"></i></button>
                <form action="{{ route('admin.services.destroy', $service) }}" method="POST" onsubmit="return confirm('Delete this service?')">
                  @csrf @method('DELETE')
                  <button type="submit" class="act-btn del" title="Delete"><i class="fas fa-trash"></i></button>
                </form>
              </div>
            </td>
          </tr>
          @empty
          <tr><td colspan="4" style="text-align:center;padding:30px;color:var(--muted);">No services yet.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  {{-- Add/Edit Form --}}
  <div class="c-card" id="serviceFormCard">
    <div class="c-card-head">
      <div class="c-card-title" id="serviceFormTitle">Add Service</div>
    </div>
    <div class="c-card-body">
      <form id="serviceForm" action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="_method" id="serviceMethod" value="POST">
        <input type="hidden" name="service_id" id="serviceId">

        <div class="form-group2" style="margin-bottom:14px;">
          <label>Service Title *</label>
          <input type="text" name="title" id="sTitle" placeholder="e.g. Residential Construction" required>
          @error('title')<div class="field-error">{{ $message }}</div>@enderror
        </div>

        <div class="form-group2" style="margin-bottom:14px;">
          <label>Font Awesome Icon Class</label>
          <input type="text" name="icon" id="sIcon" placeholder="e.g. fas fa-home" value="fas fa-tools">
          <div style="margin-top:8px;font-size:.78rem;color:var(--muted);">
            Preview: <i id="iconPreview" class="fas fa-tools" style="color:var(--orange);margin-left:6px;font-size:1rem;"></i>
          </div>
        </div>

        <div class="form-group2" style="margin-bottom:14px;">
          <label>Description *</label>
          <textarea name="description" id="sDesc" rows="4" placeholder="Describe this service..." required></textarea>
          @error('description')<div class="field-error">{{ $message }}</div>@enderror
        </div>

        <div class="form-group2" style="margin-bottom:20px;">
          <label>Sort Order</label>
          <input type="number" name="sort_order" id="sSortOrder" value="{{ $services->count() + 1 }}" min="1">
        </div>

        <div class="btn-row">
          <button type="submit" class="btn btn-primary2"><i class="fas fa-save"></i> <span id="serviceSubmitText">Save Service</span></button>
          <button type="button" class="btn btn-ghost" onclick="resetServiceForm()">Reset</button>
        </div>
      </form>
    </div>
  </div>

</div>
@endsection

@push('scripts')
<script>
document.getElementById('sIcon').addEventListener('input', function() {
  document.getElementById('iconPreview').className = this.value;
});

function editService(service) {
  document.getElementById('serviceFormTitle').textContent = 'Edit Service';
  document.getElementById('serviceSubmitText').textContent = 'Update Service';
  document.getElementById('serviceMethod').value = 'PUT';
  document.getElementById('serviceId').value = service.id;
  document.getElementById('serviceForm').action = '/admin/services/' + service.id;
  document.getElementById('sTitle').value = service.title;
  document.getElementById('sIcon').value = service.icon;
  document.getElementById('iconPreview').className = service.icon;
  document.getElementById('sDesc').value = service.description;
  document.getElementById('sSortOrder').value = service.sort_order;
  document.getElementById('serviceFormCard').scrollIntoView({behavior:'smooth'});
}

function resetServiceForm() {
  document.getElementById('serviceFormTitle').textContent = 'Add Service';
  document.getElementById('serviceSubmitText').textContent = 'Save Service';
  document.getElementById('serviceMethod').value = 'POST';
  document.getElementById('serviceId').value = '';
  document.getElementById('serviceForm').reset();
}
</script>
@endpush
