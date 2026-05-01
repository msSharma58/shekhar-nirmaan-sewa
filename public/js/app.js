/* ── NAVBAR ── */
const nav = document.getElementById('navbar');
window.addEventListener('scroll', () => {
  nav.classList.toggle('scrolled', window.scrollY > 60);
  document.getElementById('btt').classList.toggle('show', window.scrollY > 400);
});

/* ── HAMBURGER ── */
const ham = document.getElementById('ham');
const mm = document.getElementById('mobileMenu');
ham.addEventListener('click', () => {
  ham.classList.toggle('open');
  mm.classList.toggle('open');
});
document.querySelectorAll('.mm-link').forEach(l => {
  l.addEventListener('click', () => {
    ham.classList.remove('open');
    mm.classList.remove('open');
  });
});

/* ── BACK TO TOP ── */
document.getElementById('btt').addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));

/* ── COUNTER ── */
function animateCounter(el) {
  const target = +el.dataset.target;
  const dur = 1800;
  const step = target / (dur / 16);
  let cur = 0;
  const timer = setInterval(() => {
    cur += step;
    if (cur >= target) { cur = target; clearInterval(timer); }
    el.textContent = Math.floor(cur) + (target >= 10 ? '+' : '');
  }, 16);
}
const statsEl = document.getElementById('stats');
if (statsEl) {
  const statsObs = new IntersectionObserver((entries) => {
    entries.forEach(e => {
      if (e.isIntersecting) {
        document.querySelectorAll('.stat-num').forEach(animateCounter);
        statsObs.disconnect();
      }
    });
  }, { threshold: .5 });
  statsObs.observe(statsEl);
}

/* ── SCROLL REVEAL ── */
const revObs = new IntersectionObserver((entries) => {
  entries.forEach((e, i) => {
    if (e.isIntersecting) {
      setTimeout(() => e.target.classList.add('visible'), i * 80);
      revObs.unobserve(e.target);
    }
  });
}, { threshold: .12 });
document.querySelectorAll('.reveal').forEach(el => revObs.observe(el));

/* ── PROJECT FILTER ── */
document.querySelectorAll('.filter-btn').forEach(btn => {
  btn.addEventListener('click', function() {
    document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
    this.classList.add('active');
    const f = this.dataset.filter;
    document.querySelectorAll('.project-card').forEach(card => {
      const show = f === 'all' || card.dataset.cat === f;
      card.style.display = show ? '' : 'none';
    });
  });
});

/* ── TESTIMONIAL SLIDER ── */
const track = document.getElementById('testiTrack');
if (track) {
  let tIdx = 0;
  const dots = document.querySelectorAll('.testi-dot');

  function goTo(i) {
    const cards = document.querySelectorAll('.testi-card');
    tIdx = (i + cards.length) % cards.length;
    track.style.transform = `translateX(-${tIdx * 100}%)`;
    dots.forEach((d, j) => d.classList.toggle('active', j === tIdx));
  }

  const prevBtn = document.getElementById('tPrev');
  const nextBtn = document.getElementById('tNext');
  if (prevBtn) prevBtn.addEventListener('click', () => goTo(tIdx - 1));
  if (nextBtn) nextBtn.addEventListener('click', () => goTo(tIdx + 1));
  dots.forEach(d => d.addEventListener('click', () => goTo(+d.dataset.i)));
  setInterval(() => goTo(tIdx + 1), 5000);
}
