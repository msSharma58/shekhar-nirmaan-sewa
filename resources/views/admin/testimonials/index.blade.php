@extends('admin.layouts.app')
@section('title', 'Testimonials')
@section('page_title', 'Testimonials')
@section('breadcrumb', 'Home / Testimonials')

@section('content')
<div class="grid-2" style="align-items:start;">

  {{-- Testimonials List --}}
  <div class="c-card">
    <div class="c-card-head">
      <div class="c-card-title">All Testimonials</div>
    </div>
    <div class="tbl-wrap">
      <table class="tbl">
        <thead>
          <tr><th>Name</th><th>Location</th><th>Rating</th><th>Active</th><th>Actions</th></tr>
        </thead>
        <tbody>
          @forelse($testimonials as $t)
          <tr>
            <td>
              <strong>{{ $t->name }}</strong>
              <br><small style="color:var(--muted)">{{ Str::limit($t->message, 50) }}</small>
            </td>
            <td style="color:var(--muted)">{{ $t->location }}</td>
            <td><span style="color:var(--orange)">{{ str_repeat('★', $t->rating) }}</span></td>
            <td>
              <form action="{{ route('admin.testimonials.toggle', $t) }}" method="POST">
                @csrf @method('PATCH')
                <label class="toggle">
                  <input type="checkbox" {{ $t->is_active ? 'checked' : '' }} onchange="this.form.submit()">
                  <span class="toggle-slider"></span>
                </label>
              </form>
            </td>
            <td>
              <div style="display:flex;gap:4px;">
                <button class="act-btn" onclick="editTestimonial({{ $t->toJson() }})"><i class="fas fa-pen"></i></button>
                <form action="{{ route('admin.testimonials.destroy', $t) }}" method="POST" onsubmit="return confirm('Delete?')">
                  @csrf @method('DELETE')
                  <button type="submit" class="act-btn del"><i class="fas fa-trash"></i></button>
                </form>
              </div>
            </td>
          </tr>
          @empty
          <tr><td colspan="5" style="text-align:center;padding:30px;color:var(--muted);">No testimonials yet.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  {{-- Add/Edit Form --}}
  <div class="c-card" id="testiFormCard">
    <div class="c-card-head"><div class="c-card-title" id="testiFormTitle">Add Testimonial</div></div>
    <div class="c-card-body">
      <form id="testiForm" action="{{ route('admin.testimonials.store') }}" method="POST">
        @csrf
        <input type="hidden" name="_method" id="testiMethod" value="POST">

        <div class="form-group2" style="margin-bottom:14px;">
          <label>Client Name *</label>
          <input type="text" name="name" id="tName" placeholder="e.g. Ram Prasad Sharma" required>
        </div>

        <div class="form-group2" style="margin-bottom:14px;">
          <label>Location</label>
          <input type="text" name="location" id="tLocation" placeholder="e.g. Butwal, Rupandehi">
        </div>

        <div class="form-group2" style="margin-bottom:14px;">
          <label>Rating</label>
          <div id="starPicker" style="display:flex;gap:6px;margin-top:4px;">
            @for($i=1;$i<=5;$i++)
            <i class="fas fa-star star-pick {{ $i <= 5 ? 'active' : '' }}" data-val="{{ $i }}"
              style="font-size:1.4rem;cursor:pointer;color:{{ $i<=5 ? 'var(--orange)' : 'var(--muted)' }};transition:color .15s;"
            ></i>
            @endfor
          </div>
          <input type="hidden" name="rating" id="tRating" value="5">
        </div>

        <div class="form-group2" style="margin-bottom:14px;">
          <label>Testimonial Message *</label>
          <textarea name="message" id="tMessage" rows="5" placeholder="What did the client say?" required></textarea>
        </div>

        <div class="form-group2" style="margin-bottom:20px;">
          <label>
            <input type="checkbox" name="is_active" value="1" id="tActive" checked style="accent-color:var(--orange);margin-right:6px;">
            Show on website
          </label>
        </div>

        <div class="btn-row">
          <button type="submit" class="btn btn-primary2"><i class="fas fa-save"></i> <span id="testiSubmitText">Save</span></button>
          <button type="button" class="btn btn-ghost" onclick="resetTestiForm()">Reset</button>
        </div>
      </form>
    </div>
  </div>

</div>
@endsection

@push('scripts')
<script>
// Star picker
let currentRating = 5;
document.querySelectorAll('.star-pick').forEach(star => {
  star.addEventListener('click', function() {
    currentRating = +this.dataset.val;
    document.getElementById('tRating').value = currentRating;
    document.querySelectorAll('.star-pick').forEach((s,i) => {
      s.style.color = i < currentRating ? 'var(--orange)' : 'var(--muted)';
    });
  });
  star.addEventListener('mouseover', function() {
    const val = +this.dataset.val;
    document.querySelectorAll('.star-pick').forEach((s,i) => {
      s.style.color = i < val ? 'var(--orange-light)' : 'var(--muted)';
    });
  });
  star.addEventListener('mouseout', () => {
    document.querySelectorAll('.star-pick').forEach((s,i) => {
      s.style.color = i < currentRating ? 'var(--orange)' : 'var(--muted)';
    });
  });
});

function editTestimonial(t) {
  document.getElementById('testiFormTitle').textContent = 'Edit Testimonial';
  document.getElementById('testiSubmitText').textContent = 'Update';
  document.getElementById('testiMethod').value = 'PUT';
  document.getElementById('testiForm').action = '/admin/testimonials/' + t.id;
  document.getElementById('tName').value = t.name;
  document.getElementById('tLocation').value = t.location || '';
  document.getElementById('tMessage').value = t.message;
  document.getElementById('tActive').checked = !!t.is_active;
  currentRating = t.rating;
  document.getElementById('tRating').value = currentRating;
  document.querySelectorAll('.star-pick').forEach((s,i) => {
    s.style.color = i < currentRating ? 'var(--orange)' : 'var(--muted)';
  });
  document.getElementById('testiFormCard').scrollIntoView({behavior:'smooth'});
}

function resetTestiForm() {
  document.getElementById('testiFormTitle').textContent = 'Add Testimonial';
  document.getElementById('testiSubmitText').textContent = 'Save';
  document.getElementById('testiMethod').value = 'POST';
  document.getElementById('testiForm').action = '{{ route('admin.testimonials.store') }}';
  document.getElementById('testiForm').reset();
  currentRating = 5;
  document.getElementById('tRating').value = 5;
  document.querySelectorAll('.star-pick').forEach(s => s.style.color = 'var(--orange)');
}
</script>
@endpush
