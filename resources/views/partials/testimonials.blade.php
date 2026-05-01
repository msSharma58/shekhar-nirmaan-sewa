<section id="testimonials">
  <div class="reveal" style="text-align:center; margin-bottom:56px;">
    <div class="sec-tag" style="justify-content:center;">What Clients Say</div>
    <h2 class="sec-title">Client <span>Reviews</span></h2>
  </div>
  <div class="testi-slider reveal">
    <div class="testi-track" id="testiTrack">
      @foreach($testimonials as $testimonial)
      <div class="testi-card">
        <div class="quote-icon"><i class="fas fa-quote-left"></i></div>
        <p class="testi-text">"{{ $testimonial->message }}"</p>
        <div class="stars">
          @for($i = 0; $i < $testimonial->rating; $i++)★@endfor
        </div>
        <div class="testi-author">{{ $testimonial->name }}</div>
        <div class="testi-loc">{{ $testimonial->location }}</div>
      </div>
      @endforeach
    </div>
    <div class="testi-nav">
      <button class="testi-arrow" id="tPrev"><i class="fas fa-arrow-left"></i></button>
      @foreach($testimonials as $i => $testimonial)
      <button class="testi-dot {{ $i === 0 ? 'active' : '' }}" data-i="{{ $i }}"></button>
      @endforeach
      <button class="testi-arrow" id="tNext"><i class="fas fa-arrow-right"></i></button>
    </div>
  </div>
</section>
