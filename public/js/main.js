/**
 * SHEKHAR NIRMAN SEWA — Shared JS Utilities
 * Used by both index.html and admin/
 */

/* ── SCROLL REVEAL ── */
function initReveal() {
  const obs = new IntersectionObserver((entries) => {
    entries.forEach((e, i) => {
      if (e.isIntersecting) {
        setTimeout(() => e.target.classList.add('visible'), i * 80);
        obs.unobserve(e.target);
      }
    });
  }, { threshold: .12 });
  document.querySelectorAll('.reveal').forEach(el => obs.observe(el));
}

/* ── COUNTER ANIMATION ── */
function animateCounter(el) {
  const target = +el.dataset.target;
  const dur = 1800;
  const step = target / (dur / 16);
  let cur = 0;
  const timer = setInterval(() => {
    cur += step;
    if (cur >= target) { cur = target; clearInterval(timer); }
    el.textContent = Math.floor(cur) + '+';
  }, 16);
}
function initCounters(containerId) {
  const el = document.getElementById(containerId);
  if (!el) return;
  const obs = new IntersectionObserver((entries) => {
    entries.forEach(e => {
      if (e.isIntersecting) {
        el.querySelectorAll('[data-target]').forEach(animateCounter);
        obs.disconnect();
      }
    });
  }, { threshold: .5 });
  obs.observe(el);
}

/* ── STICKY NAVBAR ── */
function initNavbar(navId, scrollClass = 'scrolled') {
  const nav = document.getElementById(navId);
  if (!nav) return;
  window.addEventListener('scroll', () => {
    nav.classList.toggle(scrollClass, window.scrollY > 60);
  });
}

/* ── BACK TO TOP ── */
function initBTT(bttId) {
  const btn = document.getElementById(bttId);
  if (!btn) return;
  window.addEventListener('scroll', () => btn.classList.toggle('show', window.scrollY > 400));
  btn.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
}

/* ── HAMBURGER MENU ── */
function initHamburger(hamId, menuId, linkClass) {
  const ham = document.getElementById(hamId);
  const menu = document.getElementById(menuId);
  if (!ham || !menu) return;
  ham.addEventListener('click', () => {
    ham.classList.toggle('open');
    menu.classList.toggle('open');
  });
  document.querySelectorAll('.' + linkClass).forEach(l => {
    l.addEventListener('click', () => {
      ham.classList.remove('open');
      menu.classList.remove('open');
    });
  });
}

/* ── TESTIMONIAL SLIDER ── */
function initSlider(trackId, dotClass, prevId, nextId) {
  let idx = 0;
  const track = document.getElementById(trackId);
  const dots  = document.querySelectorAll('.' + dotClass);
  if (!track) return;
  function goTo(i) {
    const cards = track.querySelectorAll('.testi-card');
    idx = (i + cards.length) % cards.length;
    track.style.transform = `translateX(-${idx * 100}%)`;
    dots.forEach((d, j) => d.classList.toggle('active', j === idx));
  }
  document.getElementById(prevId)?.addEventListener('click', () => goTo(idx - 1));
  document.getElementById(nextId)?.addEventListener('click', () => goTo(idx + 1));
  dots.forEach(d => d.addEventListener('click', () => goTo(+d.dataset.i)));
  setInterval(() => goTo(idx + 1), 5000);
}

/* ── PROJECT FILTER ── */
function initFilter(btnClass, cardClass, filterAttr) {
  document.querySelectorAll('.' + btnClass).forEach(btn => {
    btn.addEventListener('click', function () {
      document.querySelectorAll('.' + btnClass).forEach(b => b.classList.remove('active'));
      this.classList.add('active');
      const f = this.dataset.filter;
      document.querySelectorAll('.' + cardClass).forEach(card => {
        card.style.display = (f === 'all' || card.dataset[filterAttr] === f) ? '' : 'none';
      });
    });
  });
}

/* ── CONTACT FORM ── */
function initContactForm(formId, msgId) {
  const form = document.getElementById(formId);
  if (!form) return;
  form.addEventListener('submit', function (e) {
    e.preventDefault();
    const n = document.getElementById('fname')?.value.trim();
    const p = document.getElementById('fphone')?.value.trim();
    const m = document.getElementById('fmessage')?.value.trim();
    const msg = document.getElementById(msgId);
    if (!n || !p || !m) {
      msg.className = 'form-msg error';
      msg.textContent = '⚠ Please fill in all required fields (Name, Phone, Message).';
      return;
    }
    msg.className = 'form-msg success';
    msg.textContent = '✓ Thank you! Your message has been sent. We will contact you shortly.';
    this.reset();
    setTimeout(() => { msg.className = 'form-msg'; msg.textContent = ''; }, 5000);
  });
}

/* ── AUTO-INIT ON DOMCONTENTLOADED ── */
document.addEventListener('DOMContentLoaded', () => {
  initReveal();
  initCounters('stats');
  initNavbar('navbar');
  initBTT('btt');
  initHamburger('ham', 'mobileMenu', 'mm-link');
  initSlider('testiTrack', 'testi-dot', 'tPrev', 'tNext');
  initFilter('filter-btn', 'project-card', 'cat');
  initContactForm('contactForm', 'formMsg');
});
