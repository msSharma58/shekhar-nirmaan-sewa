@extends('admin.layouts.app')
@section('title', 'Edit Testimonial')
@section('page_title', 'Edit Testimonial')
@section('breadcrumb', 'Home / Testimonials / Edit')

@section('content')
<div style="max-width:700px;">
  <form action="{{ route('admin.testimonials.update', $testimonial) }}" method="POST">
    @csrf @method('PUT')

    <div class="c-card" style="margin-bottom:20px;">
      <div class="c-card-head"><div class="c-card-title">Edit Testimonial</div></div>
      <div class="c-card-body">

        <div class="form-grid" style="margin-bottom:16px;">
          <div class="form-group2">
            <label>Client Name *</label>
            <input type="text" name="name" value="{{ old('name', $testimonial->name) }}" placeholder="e.g. Ram Prasad Sharma" required>
            @error('name')<div class="field-error">{{ $message }}</div>@enderror
          </div>
          <div class="form-group2">
            <label>Location</label>
            <input type="text" name="location" value="{{ old('location', $testimonial->location) }}" placeholder="e.g. Butwal, Rupandehi">
          </div>
        </div>

        <div class="form-group2" style="margin-bottom:16px;">
          <label>Rating *</label>
          <div id="starPicker" style="display:flex;gap:8px;margin-top:6px;">
            @for($i = 1; $i <= 5; $i++)
              <i class="fas fa-star star-pick" data-val="{{ $i }}"
                style="font-size:1.8rem;cursor:pointer;transition:color .15s;"></i>
            @endfor
          </div>
          <input type="hidden" name="rating" id="ratingVal" value="{{ old('rating', $testimonial->rating) }}">
          <div style="font-size:.75rem;color:var(--muted);margin-top:6px;">Click stars to change rating</div>
        </div>

        <div class="form-group2" style="margin-bottom:16px;">
          <label>Testimonial Message *</label>
          <textarea name="message" rows="5" placeholder="What did the client say about the project?">{{ old('message', $testimonial->message) }}</textarea>
          @error('message')<div class="field-error">{{ $message }}</div>@enderror
        </div>

        <div class="form-group2">
          <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $testimonial->is_active) ? 'checked' : '' }} style="accent-color:var(--orange);width:15px;height:15px;">
            Show this testimonial on the website
          </label>
        </div>

      </div>
    </div>

    <div class="btn-row">
      <button type="submit" class="btn btn-primary2"><i class="fas fa-save"></i> Update Testimonial</button>
      <a href="{{ route('admin.testimonials.index') }}" class="btn btn-ghost">Cancel</a>
      <form action="{{ route('admin.testimonials.destroy', $testimonial) }}" method="POST" style="margin-left:auto;" onsubmit="return confirm('Delete this testimonial?')">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-danger2"><i class="fas fa-trash"></i> Delete</button>
      </form>
    </div>
  </form>
</div>
@endsection

@push('scripts')
<script>
let rating = {{ old('rating', $testimonial->rating) }};
const stars = document.querySelectorAll('.star-pick');

function setStars(val) {
  rating = val;
  document.getElementById('ratingVal').value = val;
  stars.forEach((s, i) => s.style.color = i < val ? 'var(--orange)' : 'var(--muted)');
}

stars.forEach(s => {
  s.addEventListener('click',      () => setStars(+s.dataset.val));
  s.addEventListener('mouseover',  () => stars.forEach((x, i) => x.style.color = i < +s.dataset.val ? 'var(--orange-light)' : 'var(--muted)'));
  s.addEventListener('mouseout',   () => setStars(rating));
});
setStars(rating);
</script>
@endpush
