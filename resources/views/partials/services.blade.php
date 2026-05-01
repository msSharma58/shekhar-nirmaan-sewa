<section id="services">
  <div class="reveal">
    <div class="sec-tag">What We Offer</div>
    <h2 class="sec-title">Our <span>Services</span></h2>
  </div>
  <div class="services-grid">
    @foreach($services as $service)
    <div class="service-card reveal">
      <div class="service-num">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</div>
      <div class="service-icon"><i class="{{ $service->icon }}"></i></div>
      <div class="service-title">{{ $service->title }}</div>
      <p class="service-desc">{{ $service->description }}</p>
    </div>
    @endforeach
  </div>
</section>
