<section id="contact">
  <div class="reveal">
    <div class="sec-tag">Get In Touch</div>
    <h2 class="sec-title">Contact <span>Us</span></h2>
  </div>
  <div class="contact-grid">

    {{-- Contact Info --}}
    <div class="contact-info reveal">
      <div class="contact-item">
        <div class="ci-icon"><i class="fas fa-phone"></i></div>
        <div>
          <div class="ci-label">Phone</div>
          <div class="ci-val"><a href="tel:+977-9800000000">+977-9800000000</a></div>
        </div>
      </div>
      <div class="contact-item">
        <div class="ci-icon"><i class="fas fa-envelope"></i></div>
        <div>
          <div class="ci-label">Email</div>
          <div class="ci-val"><a href="mailto:info@shekharnirmansewa.com">info@shekharnirmansewa.com</a></div>
        </div>
      </div>
      <div class="contact-item">
        <div class="ci-icon"><i class="fas fa-map-marker-alt"></i></div>
        <div>
          <div class="ci-label">Address</div>
          <div class="ci-val">Butwal-10, Rupandehi,<br>Lumbini Province, Nepal</div>
        </div>
      </div>
      <div>
        <div class="ci-label" style="margin-bottom:12px;">Follow Us</div>
        <div class="social-row">
          <a href="https://www.instagram.com/shekharnirmansewa_233/" target="_blank" class="social-btn" title="Instagram"><i class="fab fa-instagram"></i></a>
          <a href="#" class="social-btn" title="Facebook"><i class="fab fa-facebook-f"></i></a>
          <a href="#" class="social-btn" title="WhatsApp"><i class="fab fa-whatsapp"></i></a>
          <a href="#" class="social-btn" title="YouTube"><i class="fab fa-youtube"></i></a>
        </div>
      </div>
      <!-- <div class="map-placeholder">
        <i class="fas fa-map-marked-alt"></i>
        <span>Butwal, Rupandehi, Nepal</span>
      </div> -->
    </div>

    {{-- Contact Form --}}
    <div class="reveal">
      @if(session('success'))
        <div class="form-msg success" style="display:block; margin-bottom:16px;">{{ session('success') }}</div>
      @endif

      <form class="contact-form" action="{{ route('contact.store') }}" method="POST" novalidate>
        @csrf
        <div class="form-row">
          <div class="form-group">
            <label>Full Name *</label>
            <input
              type="text"
              name="name"
              value="{{ old('name') }}"
              placeholder="Your name"
              required
            >
            @error('name')
              <div class="form-msg error" style="display:block;">{{ $message }}</div>
            @enderror
          </div>
          <div class="form-group">
            <label>Phone Number *</label>
            <input
              type="tel"
              name="phone"
              value="{{ old('phone') }}"
              placeholder="+977 98XXXXXXXX"
              required
            >
            @error('phone')
              <div class="form-msg error" style="display:block;">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <div class="form-group">
          <label>Email Address</label>
          <input
            type="email"
            name="email"
            value="{{ old('email') }}"
            placeholder="your@email.com"
          >
          @error('email')
            <div class="form-msg error" style="display:block;">{{ $message }}</div>
          @enderror
        </div>

        <div class="form-group">
          <label>Service Required</label>
          <select name="service">
            <option value="">Select a service</option>
            @foreach(['Residential Construction','Commercial Construction','Renovation & Remodeling','Interior Design','Civil Works','Project Consultation'] as $svc)
              <option value="{{ $svc }}" {{ old('service') == $svc ? 'selected' : '' }}>{{ $svc }}</option>
            @endforeach
          </select>
        </div>

        <div class="form-group">
          <label>Your Message *</label>
          <textarea
            name="message"
            placeholder="Tell us about your project..."
            required
          >{{ old('message') }}</textarea>
          @error('message')
            <div class="form-msg error" style="display:block;">{{ $message }}</div>
          @enderror
        </div>

        <button type="submit" class="btn-primary" style="align-self:flex-start; cursor:pointer; border:none;">
          Send Message <i class="fas fa-arrow-right" style="margin-left:8px;"></i>
        </button>
      </form>
    </div>

  </div>
</section>
