@extends('admin.layouts.app')
@section('title', 'Add Testimonial')
@section('page_title', 'Add Testimonial')
@section('breadcrumb', 'Home / Testimonials / New')

@section('content')
<div style="max-width:700px;">
  <form action="{{ route('admin.testimonials.store') }}" method="POST">
    @csrf

    <div class="c-card" style="margin-bottom:20px;">
      <div class="c-card-head"><div class="c-card-title">Testimonial Details</div></div>
      <div class="c-card-body">

        <div class="form-grid" style="margin-bottom:16px;">
          <div class="form-group2">
            <label>Client Name *</label>
            <input type="text" name="name" value="{{ old('name') }}" placeholder="e.g. Ram Prasad Sharma" required>
            @error('name')<div class="field-error">{{ $message }}</div>@enderror
          </div>
          <div class="form-group2">
            <label>Location</label>
            <input type="text" name="location" value="{{ old('location') }}" placeholder="e.g. Butwal, Rupandehi">
          </div>
        </div>

        <div class="form-group2" style="margin-bottom:16px;">
          <label>Rating *</label>
          <div id="starPicker" style="display:flex;gap:8px;margin-top:6px;">
            @for($i = 1; $i <= 5; $i++)
              <i class="fas fa-star star-pick" data-val="{{ $i }}"
                style="font-size:1.8rem;cursor:pointer;color:{{ $i <= 5 ? 'var(--orange)' : 'var(--muted)' }};transition:color .15s;"></i>
            @endfor
          </div>
          <input type="hidden" name="rating" id="ratingVal" value="{{ old('rating', 5) }}">
          <div style="font-size:.75rem;color:var(--muted);margin-top:6px;">Click stars to set rating</div>
        </div>

        <div class="form-group2" style="margin-bottom:16px;">
          <label>Testimonial Message *</label>
          <textarea name="message" rows="5" placeholder="What did the client say about the project?">{{ old('message') }}</textarea>
          @error('message')<div class="field-error">{{ $message }}</div>@enderror
        </div>

        <div class="form-group2">
          <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
            <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} style="accent-color:var(--orange);width:15px;height:15px;">
            Show this testimonial on the website
          </label>
        </div>

      </div>
    </div>

    <div class="btn-row">
      <button type="submit" class="btn btn-primary2"><i class="fas fa-save"></i> Save Testimonial</button>
      <a href="{{ route('admin.testimonials.index') }}" class="btn btn-ghost">Cancel</a>
    </div>
  </form>
</div>
@endsection

@push('scripts')
<script>
let rating = {{ old('rating', 5) }};
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
