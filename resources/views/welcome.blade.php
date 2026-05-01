<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Shekhar Nirman Sewa – Building Your Vision, Brick by Brick</title>
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Barlow:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300&family=Barlow+Condensed:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
<link rel="stylesheet" href="{{ asset('assets/css/variables.css') }}">
<style>
  :root {
    --black: #0d0d0d;
    --dark: #141414;
    --card: #1a1a1a;
    --orange: #e8742a;
    --orange-light: #f0913e;
    --orange-glow: rgba(232,116,42,0.15);
    --white: #f5f0eb;
    --muted: #8a8a8a;
    --border: rgba(255,255,255,0.07);
    --font-display: 'Bebas Neue', sans-serif;
    --font-cond: 'Barlow Condensed', sans-serif;
    --font-body: 'Barlow', sans-serif;
  }

  *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

  html { scroll-behavior: smooth; }

  body {
    background: var(--black);
    color: var(--white);
    font-family: var(--font-body);
    font-weight: 300;
    overflow-x: hidden;
  }

  /* ── SCROLLBAR ── */
  ::-webkit-scrollbar { width: 4px; }
  ::-webkit-scrollbar-track { background: var(--black); }
  ::-webkit-scrollbar-thumb { background: var(--orange); border-radius: 2px; }

  /* ── NAVBAR ── */
  nav {
    position: fixed; top: 0; left: 0; right: 0; z-index: 1000;
    display: flex; align-items: center; justify-content: space-between;
    padding: 10px 6vw;
    background: rgba(13,13,13,0.97);
    backdrop-filter: blur(18px);
    border-bottom: 1px solid var(--border);
    transition: padding .4s ease, box-shadow .4s ease;
  }
  nav.scrolled {
    padding: 7px 6vw;
    box-shadow: 0 4px 32px rgba(0,0,0,0.5);
    border-bottom: 1px solid rgba(232,116,42,0.18);
  }

  /* SVG logo in navbar */
  .nav-logo {
    display: flex; align-items: center;
    text-decoration: none;
    flex-shrink: 0;
  }
  .nav-logo svg { height: 54px; width: auto; transition: height .3s; }
  nav.scrolled .nav-logo svg { height: 44px; }

  .nav-links {
    display: flex; gap: 32px; list-style: none; align-items: center;
  }
  .nav-links a {
    font-family: var(--font-cond);
    font-size: .88rem;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: rgba(245,240,235,0.75);
    text-decoration: none;
    transition: color .25s;
    white-space: nowrap;
  }
  .nav-links a:hover { color: var(--white); }
  .nav-cta {
    background: var(--orange);
    color: var(--black) !important;
    padding: 9px 22px;
    font-weight: 700 !important;
    clip-path: polygon(8px 0%, 100% 0%, calc(100% - 8px) 100%, 0% 100%);
  }
  .nav-cta:hover { background: var(--orange-light); color: var(--black) !important; }

  /* hamburger */
  .hamburger { display: none; flex-direction: column; gap: 5px; cursor: pointer; z-index: 1001; }
  .hamburger span { display: block; width: 26px; height: 2px; background: var(--white); transition: all .3s; }
  .hamburger.open span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
  .hamburger.open span:nth-child(2) { opacity: 0; }
  .hamburger.open span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

  .mobile-menu {
    display: none; position: fixed; inset: 0; background: var(--black);
    flex-direction: column; align-items: center; justify-content: center;
    gap: 36px; z-index: 999;
  }
  .mobile-menu.open { display: flex; }
  .mobile-menu a {
    font-family: var(--font-display);
    font-size: 2.4rem;
    letter-spacing: 3px;
    color: var(--white);
    text-decoration: none;
    transition: color .2s;
  }
  .mobile-menu a:hover { color: var(--orange); }
  .mobile-menu .m-cta {
    background: var(--orange);
    color: var(--black);
    padding: 12px 40px;
    font-size: 1.4rem;
  }

  /* ── HERO ── */
  #hero {
    position: relative;
    height: 100vh; min-height: 640px;
    display: flex; align-items: flex-end;
    padding: 80px 6vw 80px;
    overflow: hidden;
  }
  .hero-bg {
    position: absolute; inset: 0;
    background: url('https://images.unsplash.com/photo-1504307651254-35680f356dfd?w=1600&q=80') center/cover no-repeat;
  }
  .hero-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(to top, rgba(13,13,13,1) 0%, rgba(13,13,13,.6) 50%, rgba(13,13,13,.2) 100%);
  }
  /* diagonal accent */
  .hero-accent {
    position: absolute; right: 0; top: 0; bottom: 0;
    width: 38%;
    background: linear-gradient(135deg, transparent 30%, rgba(232,116,42,0.08) 100%);
    pointer-events: none;
  }
  .hero-content { position: relative; z-index: 1; max-width: 780px; }
  .hero-tag {
    display: inline-flex; align-items: center; gap: 10px;
    font-family: var(--font-cond);
    font-size: .75rem; letter-spacing: 4px; text-transform: uppercase;
    color: var(--orange); margin-bottom: 20px;
  }
  .hero-tag::before {
    content: ''; display: block;
    width: 32px; height: 1px; background: var(--orange);
  }
  h1.hero-title {
    font-family: var(--font-display);
    font-size: clamp(3.2rem, 8vw, 7.5rem);
    line-height: .95;
    letter-spacing: 2px;
    text-transform: uppercase;
    margin-bottom: 26px;
  }
  h1.hero-title span { color: var(--orange); }
  .hero-sub {
    font-size: 1.05rem;
    color: rgba(245,240,235,.65);
    max-width: 480px;
    line-height: 1.7;
    margin-bottom: 40px;
  }
  .hero-btns { display: flex; gap: 16px; flex-wrap: wrap; }
  .btn-primary {
    background: var(--orange);
    color: var(--black);
    padding: 14px 34px;
    font-family: var(--font-cond);
    font-size: .9rem;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    text-decoration: none;
    clip-path: polygon(10px 0%, 100% 0%, calc(100% - 10px) 100%, 0% 100%);
    transition: background .25s, transform .2s;
    display: inline-block;
  }
  .btn-primary:hover { background: var(--orange-light); transform: translateY(-2px); }
  .btn-outline {
    border: 1px solid rgba(245,240,235,.3);
    color: var(--white);
    padding: 14px 34px;
    font-family: var(--font-cond);
    font-size: .9rem;
    font-weight: 600;
    letter-spacing: 2px;
    text-transform: uppercase;
    text-decoration: none;
    transition: border-color .25s, color .25s;
    display: inline-block;
  }
  .btn-outline:hover { border-color: var(--orange); color: var(--orange); }

  /* scroll indicator */
  .scroll-hint {
    position: absolute; bottom: 30px; right: 6vw;
    display: flex; flex-direction: column; align-items: center; gap: 8px;
    font-family: var(--font-cond); font-size: .65rem; letter-spacing: 3px;
    text-transform: uppercase; color: var(--muted);
    writing-mode: vertical-rl;
  }
  .scroll-hint::after {
    content: ''; width: 1px; height: 50px;
    background: linear-gradient(to bottom, var(--orange), transparent);
    animation: scrollLine 1.8s ease-in-out infinite;
  }
  @keyframes scrollLine { 0%,100%{opacity:0;transform:scaleY(0);transform-origin:top} 50%{opacity:1;transform:scaleY(1)} }

  /* ── STATS ── */
  #stats {
    background: var(--orange);
    padding: 28px 6vw;
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1px;
  }
  .stat-item {
    display: flex; flex-direction: column; align-items: center;
    padding: 20px 10px;
    background: var(--orange);
    border-right: 1px solid rgba(0,0,0,.15);
  }
  .stat-item:last-child { border-right: none; }
  .stat-num {
    font-family: var(--font-display);
    font-size: 3rem;
    color: var(--black);
    line-height: 1;
  }
  .stat-label {
    font-family: var(--font-cond);
    font-size: .72rem;
    letter-spacing: 3px;
    text-transform: uppercase;
    color: rgba(0,0,0,.6);
    margin-top: 4px;
  }

  /* ── SECTION COMMONS ── */
  section { padding: 100px 6vw; }
  .sec-tag {
    display: inline-flex; align-items: center; gap: 12px;
    font-family: var(--font-cond);
    font-size: .75rem; letter-spacing: 4px; text-transform: uppercase;
    color: var(--orange); margin-bottom: 18px;
  }
  .sec-tag::before { content:''; width:24px; height:1px; background:var(--orange); }
  h2.sec-title {
    font-family: var(--font-display);
    font-size: clamp(2.4rem, 5vw, 4.2rem);
    line-height: 1;
    letter-spacing: 1px;
    text-transform: uppercase;
    margin-bottom: 24px;
  }
  h2.sec-title span { color: var(--orange); }

  /* ── ABOUT ── */
  #about { background: var(--dark); }
  .about-grid {
    display: grid; grid-template-columns: 1fr 1fr; gap: 70px; align-items: center;
  }
  .about-img-wrap {
    position: relative;
  }
  .about-img-wrap img {
    width: 100%; height: 520px; object-fit: cover;
    filter: grayscale(20%);
  }
  .about-img-badge {
    position: absolute; bottom: -24px; right: -24px;
    background: var(--orange);
    padding: 28px 32px;
    clip-path: polygon(10px 0%, 100% 0%, calc(100% - 10px) 100%, 0% 100%);
  }
  .about-img-badge .bnum {
    font-family: var(--font-display);
    font-size: 3.4rem;
    color: var(--black);
    line-height: 1;
  }
  .about-img-badge .btxt {
    font-family: var(--font-cond);
    font-size: .72rem;
    letter-spacing: 2px;
    color: rgba(0,0,0,.7);
    text-transform: uppercase;
  }
  .about-text p {
    color: rgba(245,240,235,.65);
    line-height: 1.8;
    margin-bottom: 20px;
    font-size: 1.02rem;
  }
  .why-list { margin-top: 32px; display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
  .why-item {
    display: flex; align-items: flex-start; gap: 14px;
    padding: 18px;
    border: 1px solid var(--border);
    background: var(--card);
    transition: border-color .3s;
  }
  .why-item:hover { border-color: var(--orange); }
  .why-icon { color: var(--orange); font-size: 1.2rem; margin-top: 2px; flex-shrink: 0; }
  .why-title { font-family: var(--font-cond); font-size: .85rem; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 3px; }
  .why-desc { font-size: .82rem; color: var(--muted); }

  /* ── SERVICES ── */
  #services { background: var(--black); }
  .services-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1px;
    background: var(--border);
    border: 1px solid var(--border);
    margin-top: 56px;
  }
  .service-card {
    background: var(--dark);
    padding: 42px 36px;
    position: relative;
    overflow: hidden;
    transition: background .3s;
    cursor: default;
  }
  .service-card::after {
    content: '';
    position: absolute; bottom: 0; left: 0;
    width: 100%; height: 3px;
    background: var(--orange);
    transform: scaleX(0); transform-origin: left;
    transition: transform .4s ease;
  }
  .service-card:hover { background: var(--card); }
  .service-card:hover::after { transform: scaleX(1); }
  .service-num {
    font-family: var(--font-display);
    font-size: 4rem;
    color: rgba(232,116,42,.12);
    line-height: 1;
    margin-bottom: 20px;
    transition: color .3s;
  }
  .service-card:hover .service-num { color: rgba(232,116,42,.25); }
  .service-icon { font-size: 2rem; color: var(--orange); margin-bottom: 18px; }
  .service-title {
    font-family: var(--font-cond);
    font-size: 1.15rem;
    letter-spacing: 2px;
    text-transform: uppercase;
    margin-bottom: 12px;
  }
  .service-desc { font-size: .88rem; color: var(--muted); line-height: 1.7; }

  /* ── PROJECTS ── */
  #projects { background: var(--dark); }
  .filter-bar {
    display: flex; gap: 12px; flex-wrap: wrap; margin: 40px 0 32px;
  }
  .filter-btn {
    font-family: var(--font-cond);
    font-size: .78rem; letter-spacing: 2px; text-transform: uppercase;
    padding: 9px 22px;
    border: 1px solid var(--border);
    background: transparent;
    color: var(--muted);
    cursor: pointer;
    transition: all .25s;
  }
  .filter-btn.active, .filter-btn:hover {
    background: var(--orange);
    border-color: var(--orange);
    color: var(--black);
  }
  .projects-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 3px;
  }
  .project-card {
    position: relative; overflow: hidden;
    height: 280px; cursor: pointer;
  }
  .project-card img {
    width: 100%; height: 100%; object-fit: cover;
    transition: transform .5s ease, filter .5s;
    filter: grayscale(30%);
  }
  .project-card:hover img { transform: scale(1.08); filter: grayscale(0%); }
  .project-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(to top, rgba(13,13,13,.9) 0%, transparent 55%);
    display: flex; flex-direction: column; justify-content: flex-end;
    padding: 24px 22px;
    opacity: 0; transition: opacity .35s;
  }
  .project-card:hover .project-overlay { opacity: 1; }
  .proj-cat {
    font-family: var(--font-cond);
    font-size: .68rem; letter-spacing: 3px; text-transform: uppercase;
    color: var(--orange); margin-bottom: 6px;
  }
  .proj-name {
    font-family: var(--font-cond);
    font-size: 1.1rem; letter-spacing: 1px; text-transform: uppercase;
  }

  /* ── PROCESS ── */
  #process { background: var(--black); }
  .process-steps {
    display: grid; grid-template-columns: repeat(4, 1fr);
    gap: 0;
    margin-top: 60px;
    position: relative;
  }
  .process-steps::before {
    content: '';
    position: absolute;
    top: 36px; left: 12.5%; right: 12.5%;
    height: 1px;
    background: linear-gradient(to right, var(--orange) 0%, rgba(232,116,42,0.2) 100%);
    z-index: 0;
  }
  .step {
    display: flex; flex-direction: column; align-items: center;
    text-align: center; padding: 0 20px; position: relative; z-index: 1;
  }
  .step-circle {
    width: 72px; height: 72px;
    border: 1px solid var(--orange);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    background: var(--black);
    font-family: var(--font-display);
    font-size: 1.8rem;
    color: var(--orange);
    margin-bottom: 28px;
    transition: background .3s, color .3s;
  }
  .step:hover .step-circle { background: var(--orange); color: var(--black); }
  .step-title {
    font-family: var(--font-cond);
    font-size: 1rem; letter-spacing: 2px; text-transform: uppercase;
    margin-bottom: 12px;
  }
  .step-desc { font-size: .85rem; color: var(--muted); line-height: 1.7; }

  /* ── TESTIMONIALS ── */
  #testimonials { background: var(--dark); overflow: hidden; }
  .testi-slider { position: relative; }
  .testi-track {
    display: flex;
    transition: transform .5s cubic-bezier(.25,.46,.45,.94);
  }
  .testi-card {
    min-width: 100%;
    padding: 0 10vw;
    display: flex; flex-direction: column; align-items: center; text-align: center;
  }
  .quote-icon { font-size: 3rem; color: var(--orange); opacity: .4; margin-bottom: 24px; }
  .testi-text {
    font-size: 1.2rem;
    color: rgba(245,240,235,.8);
    line-height: 1.8;
    font-style: italic;
    max-width: 700px;
    margin-bottom: 32px;
  }
  .stars { color: var(--orange); font-size: 1rem; letter-spacing: 3px; margin-bottom: 14px; }
  .testi-author {
    font-family: var(--font-cond);
    font-size: .9rem; letter-spacing: 2px; text-transform: uppercase;
  }
  .testi-loc { font-size: .8rem; color: var(--muted); margin-top: 4px; }
  .testi-nav {
    display: flex; justify-content: center; align-items: center; gap: 14px; margin-top: 42px;
  }
  .testi-dot {
    width: 8px; height: 8px;
    border-radius: 50%;
    background: var(--border);
    cursor: pointer; transition: background .2s, transform .2s;
    border: none;
  }
  .testi-dot.active { background: var(--orange); transform: scale(1.3); }
  .testi-arrow {
    background: none; border: 1px solid var(--border);
    color: var(--muted); width: 40px; height: 40px;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; transition: all .2s; font-size: .9rem;
  }
  .testi-arrow:hover { border-color: var(--orange); color: var(--orange); }

  /* ── CTA BANNER ── */
  #cta-banner {
    padding: 80px 6vw;
    background: var(--orange);
    display: flex; align-items: center; justify-content: space-between;
    gap: 30px; flex-wrap: wrap;
    clip-path: polygon(0 0, 100% 0, 100% 85%, 97% 100%, 0 100%);
  }
  .cta-text h2 {
    font-family: var(--font-display);
    font-size: clamp(2rem, 4vw, 3.4rem);
    color: var(--black);
    line-height: 1;
    letter-spacing: 1px;
    text-transform: uppercase;
  }
  .cta-text p {
    color: rgba(0,0,0,.55);
    margin-top: 10px;
    font-size: 1rem;
  }
  .btn-dark {
    background: var(--black);
    color: var(--white);
    padding: 16px 40px;
    font-family: var(--font-cond);
    font-size: .9rem;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    text-decoration: none;
    clip-path: polygon(10px 0%, 100% 0%, calc(100% - 10px) 100%, 0% 100%);
    transition: opacity .2s;
    display: inline-block;
    flex-shrink: 0;
  }
  .btn-dark:hover { opacity: .85; }

  /* ── CONTACT ── */
  #contact { background: var(--black); }
  .contact-grid {
    display: grid; grid-template-columns: 1fr 1fr; gap: 70px; margin-top: 60px;
  }
  .contact-info { display: flex; flex-direction: column; gap: 28px; }
  .contact-item {
    display: flex; gap: 20px; align-items: flex-start;
    padding: 24px;
    border: 1px solid var(--border);
    background: var(--card);
    transition: border-color .3s;
  }
  .contact-item:hover { border-color: var(--orange); }
  .ci-icon {
    width: 44px; height: 44px; flex-shrink: 0;
    background: var(--orange-glow);
    display: flex; align-items: center; justify-content: center;
    color: var(--orange); font-size: 1rem;
  }
  .ci-label {
    font-family: var(--font-cond);
    font-size: .68rem; letter-spacing: 3px; text-transform: uppercase;
    color: var(--muted); margin-bottom: 5px;
  }
  .ci-val { font-size: .95rem; }
  .ci-val a { color: var(--white); text-decoration: none; }
  .ci-val a:hover { color: var(--orange); }

  .social-row { display: flex; gap: 12px; margin-top: 10px; }
  .social-btn {
    width: 42px; height: 42px;
    border: 1px solid var(--border);
    display: flex; align-items: center; justify-content: center;
    color: var(--muted);
    text-decoration: none;
    font-size: .9rem;
    transition: all .25s;
  }
  .social-btn:hover { border-color: var(--orange); color: var(--orange); background: var(--orange-glow); }

  /* Form */
  .contact-form { display: flex; flex-direction: column; gap: 16px; }
  .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
  .form-group { display: flex; flex-direction: column; gap: 7px; }
  .form-group label {
    font-family: var(--font-cond);
    font-size: .72rem; letter-spacing: 2px; text-transform: uppercase;
    color: var(--muted);
  }
  .form-group input,
  .form-group textarea,
  .form-group select {
    background: var(--card);
    border: 1px solid var(--border);
    color: var(--white);
    padding: 13px 16px;
    font-family: var(--font-body);
    font-size: .9rem;
    outline: none;
    transition: border-color .25s;
    -webkit-appearance: none;
  }
  .form-group input:focus,
  .form-group textarea:focus,
  .form-group select:focus { border-color: var(--orange); }
  .form-group textarea { resize: vertical; min-height: 130px; }
  .form-group select option { background: var(--card); }
  .form-msg {
    margin-top: 6px;
    padding: 12px 16px;
    font-size: .88rem;
    display: none;
  }
  .form-msg.success { background: rgba(50,200,100,.1); border: 1px solid rgba(50,200,100,.3); color: #5dd98a; display: block; }
  .form-msg.error { background: rgba(232,116,42,.1); border: 1px solid rgba(232,116,42,.3); color: var(--orange); display: block; }

  /* map placeholder */
  .map-placeholder {
    margin-top: 32px;
    height: 180px;
    background: var(--card);
    border: 1px solid var(--border);
    display: flex; align-items: center; justify-content: center;
    flex-direction: column; gap: 10px;
    color: var(--muted); font-family: var(--font-cond); letter-spacing: 2px; text-transform: uppercase; font-size: .78rem;
  }
  .map-placeholder i { font-size: 2rem; color: var(--orange); }

  /* ── FOOTER ── */
  footer {
    background: var(--dark);
    border-top: 1px solid var(--border);
    padding: 60px 6vw 30px;
  }
  .footer-grid {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr 1fr;
    gap: 50px;
    margin-bottom: 48px;
  }
  .footer-brand p {
    font-size: .88rem; color: var(--muted); line-height: 1.8; margin: 18px 0 24px;
    max-width: 280px;
  }
  .footer-col h4 {
    font-family: var(--font-cond);
    font-size: .78rem; letter-spacing: 3px; text-transform: uppercase;
    color: var(--orange); margin-bottom: 20px;
  }
  .footer-col ul { list-style: none; display: flex; flex-direction: column; gap: 10px; }
  .footer-col ul li a {
    font-size: .88rem; color: var(--muted); text-decoration: none;
    transition: color .2s; display: flex; align-items: center; gap: 8px;
  }
  .footer-col ul li a:hover { color: var(--orange); }
  .footer-col ul li a::before { content: '→'; font-size: .7rem; color: var(--orange); opacity: 0; transition: opacity .2s; }
  .footer-col ul li a:hover::before { opacity: 1; }
  .footer-bottom {
    border-top: 1px solid var(--border);
    padding-top: 24px;
    display: flex; justify-content: space-between; align-items: center;
    font-size: .8rem; color: var(--muted); flex-wrap: wrap; gap: 12px;
  }
  .footer-bottom span i { color: var(--orange); }

  /* ── BACK TO TOP ── */
  #btt {
    position: fixed; bottom: 32px; right: 32px; z-index: 900;
    width: 46px; height: 46px;
    background: var(--orange);
    color: var(--black);
    display: flex; align-items: center; justify-content: center;
    font-size: .9rem;
    cursor: pointer;
    opacity: 0; pointer-events: none;
    transition: opacity .3s, transform .3s;
    clip-path: polygon(6px 0%, 100% 0%, calc(100% - 6px) 100%, 0% 100%);
  }
  #btt.show { opacity: 1; pointer-events: all; }
  #btt:hover { transform: translateY(-4px); }

  /* ── ANIMATIONS ── */
  .reveal {
    opacity: 0; transform: translateY(36px);
    transition: opacity .7s ease, transform .7s ease;
  }
  .reveal.visible { opacity: 1; transform: none; }

  /* ── RESPONSIVE ── */
  @media(max-width: 960px) {
    .about-grid, .contact-grid { grid-template-columns: 1fr; gap: 40px; }
    .about-img-badge { right: 0; }
    .services-grid { grid-template-columns: repeat(2,1fr); }
    .projects-grid { grid-template-columns: repeat(2,1fr); }
    .process-steps { grid-template-columns: repeat(2,1fr); gap: 40px; }
    .process-steps::before { display: none; }
    .footer-grid { grid-template-columns: 1fr 1fr; gap: 36px; }
    #stats { grid-template-columns: repeat(2,1fr); }
    .stat-item { border-right: none; border-bottom: 1px solid rgba(0,0,0,.15); }
  }
  @media(max-width: 640px) {
    .nav-links { display: none; }
    .hamburger { display: flex; }
    .nav-logo svg { height: 42px; }
    .services-grid { grid-template-columns: 1fr; }
    .projects-grid { grid-template-columns: 1fr; }
    .process-steps { grid-template-columns: 1fr; }
    .form-row { grid-template-columns: 1fr; }
    .footer-grid { grid-template-columns: 1fr; }
    #cta-banner { flex-direction: column; clip-path: none; }
    .testi-card { padding: 0 5vw; }
    #stats { grid-template-columns: repeat(2,1fr); }
    .why-list { grid-template-columns: 1fr; }
  }
</style>
</head>
<body>

<!-- NAVBAR -->
<nav id="navbar">
  <a href="#hero" class="nav-logo" aria-label="Shekhar Nirman Sewa Home">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 62" role="img" aria-label="Shekhar Nirman Sewa logo">
      <rect x="4" y="20" width="5" height="36" fill="#E8742A"/>
      <rect x="38" y="20" width="5" height="36" fill="#E8742A"/>
      <rect x="4" y="20" width="39" height="4" fill="#E8742A"/>
      <rect x="12" y="28" width="7" height="7" rx="0.5" fill="#E8742A" opacity="0.35"/>
      <rect x="24" y="28" width="7" height="7" rx="0.5" fill="#E8742A" opacity="0.35"/>
      <rect x="12" y="40" width="7" height="7" rx="0.5" fill="#E8742A" opacity="0.35"/>
      <rect x="24" y="40" width="7" height="7" rx="0.5" fill="#E8742A" opacity="0.35"/>
      <rect x="16" y="14" width="15" height="4" rx="0.5" fill="#F5F0EB"/>
      <ellipse cx="23.5" cy="10" rx="8" ry="5.5" fill="#F5F0EB"/>
      <rect x="19.5" y="4" width="8" height="4" rx="0.5" fill="#F5F0EB"/>
      <rect x="22.5" y="1" width="2" height="4" fill="#E8742A"/>
      <ellipse cx="23.5" cy="1" rx="4" ry="1.2" fill="#E8742A"/>
      <rect x="4" y="56" width="39" height="1.5" fill="#E8742A"/>
      <rect x="52" y="6" width="1.2" height="50" fill="#E8742A" opacity="0.4"/>
      <text x="60" y="33" font-family="'Bebas Neue',sans-serif" font-size="22" letter-spacing="1.5" fill="#F5F0EB">SHEKHAR</text>
      <text x="60" y="52" font-family="'Bebas Neue',sans-serif" font-size="22" letter-spacing="1.5" fill="#E8742A">NIRMAN SEWA</text>
      <text x="60" y="61" font-family="'Barlow Condensed',sans-serif" font-size="6" letter-spacing="2.5" fill="#777777">CONSTRUCTION · EST. LUMBINI · NEPAL</text>
    </svg>
  </a>
  <ul class="nav-links">
    <li><a href="#about">About</a></li>
    <li><a href="#services">Services</a></li>
    <li><a href="#projects">Projects</a></li>
    <li><a href="#testimonials">Reviews</a></li>
    <li><a href="#contact" class="nav-cta">Get a Quote</a></li>
  </ul>
  <div class="hamburger" id="ham">
    <span></span><span></span><span></span>
  </div>
</nav>

<!-- MOBILE MENU -->
<div class="mobile-menu" id="mobileMenu">
  <a href="#about" class="mm-link">About</a>
  <a href="#services" class="mm-link">Services</a>
  <a href="#projects" class="mm-link">Projects</a>
  <a href="#testimonials" class="mm-link">Reviews</a>
  <a href="#contact" class="mm-link m-cta">Get a Quote</a>
</div>

<!-- HERO -->
<section id="hero">
  <div class="hero-bg"></div>
  <div class="hero-overlay"></div>
  <div class="hero-accent"></div>
  <div class="hero-content">
    <div class="hero-tag">Trusted Construction Partner</div>
    <h1 class="hero-title">Building Your<br><span>Vision,</span><br>Brick by Brick.</h1>
    <p class="hero-sub">From foundations to finishing — we deliver precision-crafted construction solutions across Nepal with quality you can count on.</p>
    <div class="hero-btns">
      <a href="#services" class="btn-primary">Our Services</a>
      <a href="#contact" class="btn-outline">Contact Us</a>
    </div>
  </div>
  <div class="scroll-hint">Scroll</div>
</section>

<!-- STATS -->
<div id="stats">
  <div class="stat-item">
    <div class="stat-num" data-target="10">0</div>
    <div class="stat-label">Years Experience</div>
  </div>
  <div class="stat-item">
    <div class="stat-num" data-target="250">0</div>
    <div class="stat-label">Projects Completed</div>
  </div>
  <div class="stat-item">
    <div class="stat-num" data-target="180">0</div>
    <div class="stat-label">Happy Clients</div>
  </div>
  <div class="stat-item">
    <div class="stat-num" data-target="40">0</div>
    <div class="stat-label">Expert Workers</div>
  </div>
</div>

<!-- ABOUT -->
<section id="about">
  <div class="about-grid">
    <div class="about-img-wrap reveal">
      <img src="https://images.unsplash.com/photo-1541888946425-d81bb19240f5?w=800&q=80" alt="Construction work">
      <div class="about-img-badge">
        <div class="bnum">10+</div>
        <div class="btxt">Years of<br>Excellence</div>
      </div>
    </div>
    <div class="about-text reveal">
      <div class="sec-tag">Who We Are</div>
      <h2 class="sec-title">Nepal's Trusted <span>Builders</span></h2>
      <p>Shekhar Nirman Sewa is a premier construction company based in Nepal, dedicated to transforming architectural visions into enduring structures. From residential homes to large-scale commercial complexes, we bring technical expertise, transparency, and craftsmanship to every project.</p>
      <p>Our commitment to quality, on-time delivery, and client satisfaction has made us one of the most trusted names in the construction industry across Lumbini Province and beyond.</p>
      <div class="why-list">
        <div class="why-item">
          <i class="fas fa-medal why-icon"></i>
          <div>
            <div class="why-title">Quality Guaranteed</div>
            <div class="why-desc">Premium materials, skilled craftsmen, zero compromise.</div>
          </div>
        </div>
        <div class="why-item">
          <i class="fas fa-clock why-icon"></i>
          <div>
            <div class="why-title">On-Time Delivery</div>
            <div class="why-desc">We respect your time with structured project timelines.</div>
          </div>
        </div>
        <div class="why-item">
          <i class="fas fa-wallet why-icon"></i>
          <div>
            <div class="why-title">Budget-Friendly</div>
            <div class="why-desc">Transparent pricing with no hidden surprises.</div>
          </div>
        </div>
        <div class="why-item">
          <i class="fas fa-users why-icon"></i>
          <div>
            <div class="why-title">Expert Team</div>
            <div class="why-desc">Experienced engineers, architects, and site supervisors.</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- SERVICES -->
<section id="services">
  <div class="reveal">
    <div class="sec-tag">What We Offer</div>
    <h2 class="sec-title">Our <span>Services</span></h2>
  </div>
  <div class="services-grid">
    <div class="service-card reveal">
      <div class="service-num">01</div>
      <div class="service-icon"><i class="fas fa-home"></i></div>
      <div class="service-title">Residential Construction</div>
      <p class="service-desc">Custom homes, villas, and apartments built to your exact vision with highest quality materials and finishing.</p>
    </div>
    <div class="service-card reveal">
      <div class="service-num">02</div>
      <div class="service-icon"><i class="fas fa-building"></i></div>
      <div class="service-title">Commercial Construction</div>
      <p class="service-desc">Office buildings, shopping complexes, and industrial structures constructed for longevity and performance.</p>
    </div>
    <div class="service-card reveal">
      <div class="service-num">03</div>
      <div class="service-icon"><i class="fas fa-tools"></i></div>
      <div class="service-title">Renovation & Remodeling</div>
      <p class="service-desc">Breathing new life into existing structures — from simple repairs to complete overhauls.</p>
    </div>
    <div class="service-card reveal">
      <div class="service-num">04</div>
      <div class="service-icon"><i class="fas fa-couch"></i></div>
      <div class="service-title">Interior Design</div>
      <p class="service-desc">Elegant, functional interiors tailored to your lifestyle, blending aesthetics with practicality.</p>
    </div>
    <div class="service-card reveal">
      <div class="service-num">05</div>
      <div class="service-icon"><i class="fas fa-hard-hat"></i></div>
      <div class="service-title">Civil Works</div>
      <p class="service-desc">Roads, drainage, retaining walls, and civil infrastructure executed with technical precision.</p>
    </div>
    <div class="service-card reveal">
      <div class="service-num">06</div>
      <div class="service-icon"><i class="fas fa-drafting-compass"></i></div>
      <div class="service-title">Project Consultation</div>
      <p class="service-desc">Expert guidance on design, budgeting, regulatory compliance, and project management from day one.</p>
    </div>
  </div>
</section>

<!-- PROJECTS -->
<section id="projects">
  <div class="reveal">
    <div class="sec-tag">Our Work</div>
    <h2 class="sec-title">Featured <span>Projects</span></h2>
  </div>
  <div class="filter-bar reveal">
    <button class="filter-btn active" data-filter="all">All</button>
    <button class="filter-btn" data-filter="residential">Residential</button>
    <button class="filter-btn" data-filter="commercial">Commercial</button>
    <button class="filter-btn" data-filter="renovation">Renovation</button>
    <button class="filter-btn" data-filter="civil">Civil Works</button>
  </div>
  <div class="projects-grid reveal">
    <div class="project-card" data-cat="residential">
      <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=600&q=80" alt="Residential">
      <div class="project-overlay">
        <div class="proj-cat">Residential</div>
        <div class="proj-name">Modern Family Villa – Butwal</div>
      </div>
    </div>
    <div class="project-card" data-cat="commercial">
      <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=600&q=80" alt="Commercial">
      <div class="project-overlay">
        <div class="proj-cat">Commercial</div>
        <div class="proj-name">Office Complex – Bhairahawa</div>
      </div>
    </div>
    <div class="project-card" data-cat="renovation">
      <img src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=600&q=80" alt="Renovation">
      <div class="project-overlay">
        <div class="proj-cat">Renovation</div>
        <div class="proj-name">Heritage Building Restoration</div>
      </div>
    </div>
    <div class="project-card" data-cat="civil">
      <img src="https://images.unsplash.com/photo-1565008447742-97f6f38c985c?w=600&q=80" alt="Civil">
      <div class="project-overlay">
        <div class="proj-cat">Civil Works</div>
        <div class="proj-name">Rural Road Infrastructure</div>
      </div>
    </div>
    <div class="project-card" data-cat="residential">
      <img src="https://images.unsplash.com/photo-1568605114967-8130f3a36994?w=600&q=80" alt="Residential">
      <div class="project-overlay">
        <div class="proj-cat">Residential</div>
        <div class="proj-name">Luxury Apartment – Rupandehi</div>
      </div>
    </div>
    <div class="project-card" data-cat="commercial">
      <img src="https://images.unsplash.com/photo-1497366754035-f200968a6e72?w=600&q=80" alt="Commercial">
      <div class="project-overlay">
        <div class="proj-cat">Commercial</div>
        <div class="proj-name">Shopping Plaza – Butwal</div>
      </div>
    </div>
  </div>
</section>

<!-- PROCESS -->
<section id="process">
  <div class="reveal" style="text-align:center;">
    <div class="sec-tag" style="justify-content:center;">How We Work</div>
    <h2 class="sec-title">Our <span>Process</span></h2>
  </div>
  <div class="process-steps">
    <div class="step reveal">
      <div class="step-circle">01</div>
      <div class="step-title">Consultation</div>
      <p class="step-desc">We listen to your vision, goals, and budget to understand your project inside out.</p>
    </div>
    <div class="step reveal">
      <div class="step-circle">02</div>
      <div class="step-title">Planning & Design</div>
      <p class="step-desc">Architects and engineers draft detailed plans, 3D layouts, and cost estimates.</p>
    </div>
    <div class="step reveal">
      <div class="step-circle">03</div>
      <div class="step-title">Construction</div>
      <p class="step-desc">Our skilled team executes the plan with precision, quality checks at every phase.</p>
    </div>
    <div class="step reveal">
      <div class="step-circle">04</div>
      <div class="step-title">Handover</div>
      <p class="step-desc">Final inspection, finishing, and complete handover — on time, every time.</p>
    </div>
  </div>
</section>

<!-- TESTIMONIALS -->
<section id="testimonials">
  <div class="reveal" style="text-align:center; margin-bottom:56px;">
    <div class="sec-tag" style="justify-content:center;">What Clients Say</div>
    <h2 class="sec-title">Client <span>Reviews</span></h2>
  </div>
  <div class="testi-slider reveal">
    <div class="testi-track" id="testiTrack">
      <div class="testi-card">
        <div class="quote-icon"><i class="fas fa-quote-left"></i></div>
        <p class="testi-text">"Shekhar Nirman Sewa built our dream home exactly as we envisioned. The team was professional, transparent, and delivered on time. Highly recommended to anyone looking for quality construction in Nepal."</p>
        <div class="stars">★★★★★</div>
        <div class="testi-author">Ram Prasad Sharma</div>
        <div class="testi-loc">Butwal, Rupandehi</div>
      </div>
      <div class="testi-card">
        <div class="quote-icon"><i class="fas fa-quote-left"></i></div>
        <p class="testi-text">"We hired them for our commercial building project and were blown away by the attention to detail. The project was finished within budget and the quality is top-notch. Will definitely work with them again."</p>
        <div class="stars">★★★★★</div>
        <div class="testi-author">Sunita Thapa</div>
        <div class="testi-loc">Bhairahawa, Rupandehi</div>
      </div>
      <div class="testi-card">
        <div class="quote-icon"><i class="fas fa-quote-left"></i></div>
        <p class="testi-text">"The renovation they did on our old building was outstanding. They respected our timeline and budget completely. I'm very happy with the outcome and would recommend them without hesitation."</p>
        <div class="stars">★★★★★</div>
        <div class="testi-author">Bikram Gurung</div>
        <div class="testi-loc">Palpa, Lumbini Province</div>
      </div>
      <div class="testi-card">
        <div class="quote-icon"><i class="fas fa-quote-left"></i></div>
        <p class="testi-text">"From consultation to handover, the experience was seamless. The team is knowledgeable, courteous, and truly cares about client satisfaction. Our office space turned out better than expected!"</p>
        <div class="stars">★★★★★</div>
        <div class="testi-author">Priya Acharya</div>
        <div class="testi-loc">Kapilvastu, Lumbini Province</div>
      </div>
    </div>
    <div class="testi-nav">
      <button class="testi-arrow" id="tPrev"><i class="fas fa-arrow-left"></i></button>
      <button class="testi-dot active" data-i="0"></button>
      <button class="testi-dot" data-i="1"></button>
      <button class="testi-dot" data-i="2"></button>
      <button class="testi-dot" data-i="3"></button>
      <button class="testi-arrow" id="tNext"><i class="fas fa-arrow-right"></i></button>
    </div>
  </div>
</section>

<!-- CTA BANNER -->
<div id="cta-banner">
  <div class="cta-text">
    <h2>Ready to Start Your Dream Project?</h2>
    <p>Get a free consultation and custom quote from our experts today.</p>
  </div>
  <a href="#contact" class="btn-dark">Get a Free Quote</a>
</div>

<!-- CONTACT -->
<section id="contact">
  <div class="reveal">
    <div class="sec-tag">Get In Touch</div>
    <h2 class="sec-title">Contact <span>Us</span></h2>
  </div>
  <div class="contact-grid">
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
      <div class="map-placeholder">
        <i class="fas fa-map-marked-alt"></i>
        <span>Butwal, Rupandehi, Nepal</span>
      </div>
    </div>
    <div class="reveal">
      <form class="contact-form" id="contactForm" novalidate>
        <div class="form-row">
          <div class="form-group">
            <label>Full Name *</label>
            <input type="text" id="fname" placeholder="Your name" required>
          </div>
          <div class="form-group">
            <label>Phone Number *</label>
            <input type="tel" id="fphone" placeholder="+977 98XXXXXXXX" required>
          </div>
        </div>
        <div class="form-group">
          <label>Email Address</label>
          <input type="email" id="femail" placeholder="your@email.com">
        </div>
        <div class="form-group">
          <label>Service Required</label>
          <select id="fservice">
            <option value="">Select a service</option>
            <option>Residential Construction</option>
            <option>Commercial Construction</option>
            <option>Renovation & Remodeling</option>
            <option>Interior Design</option>
            <option>Civil Works</option>
            <option>Project Consultation</option>
          </select>
        </div>
        <div class="form-group">
          <label>Your Message *</label>
          <textarea id="fmessage" placeholder="Tell us about your project..." required></textarea>
        </div>
        <button type="submit" class="btn-primary" style="align-self:flex-start; cursor:pointer; border:none;">Send Message <i class="fas fa-arrow-right" style="margin-left:8px;"></i></button>
        <div class="form-msg" id="formMsg"></div>
      </form>
    </div>
  </div>
</section>

<!-- FOOTER -->
<footer>
  <div class="footer-grid">
    <div class="footer-brand">
      <a href="#hero" class="nav-logo" aria-label="Shekhar Nirman Sewa">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 62" style="height:58px;width:auto;">
          <rect x="4" y="20" width="5" height="36" fill="#E8742A"/>
          <rect x="38" y="20" width="5" height="36" fill="#E8742A"/>
          <rect x="4" y="20" width="39" height="4" fill="#E8742A"/>
          <rect x="12" y="28" width="7" height="7" rx="0.5" fill="#E8742A" opacity="0.35"/>
          <rect x="24" y="28" width="7" height="7" rx="0.5" fill="#E8742A" opacity="0.35"/>
          <rect x="12" y="40" width="7" height="7" rx="0.5" fill="#E8742A" opacity="0.35"/>
          <rect x="24" y="40" width="7" height="7" rx="0.5" fill="#E8742A" opacity="0.35"/>
          <rect x="16" y="14" width="15" height="4" rx="0.5" fill="#F5F0EB"/>
          <ellipse cx="23.5" cy="10" rx="8" ry="5.5" fill="#F5F0EB"/>
          <rect x="19.5" y="4" width="8" height="4" rx="0.5" fill="#F5F0EB"/>
          <rect x="22.5" y="1" width="2" height="4" fill="#E8742A"/>
          <ellipse cx="23.5" cy="1" rx="4" ry="1.2" fill="#E8742A"/>
          <rect x="4" y="56" width="39" height="1.5" fill="#E8742A"/>
          <rect x="52" y="6" width="1.2" height="50" fill="#E8742A" opacity="0.4"/>
          <text x="60" y="33" font-family="'Bebas Neue',sans-serif" font-size="22" letter-spacing="1.5" fill="#F5F0EB">SHEKHAR</text>
          <text x="60" y="52" font-family="'Bebas Neue',sans-serif" font-size="22" letter-spacing="1.5" fill="#E8742A">NIRMAN SEWA</text>
          <text x="60" y="61" font-family="'Barlow Condensed',sans-serif" font-size="6" letter-spacing="2.5" fill="#777777">CONSTRUCTION · EST. LUMBINI · NEPAL</text>
        </svg>
      </a>
      <p>Building Nepal's future with integrity, precision, and passion. Your trusted construction partner since 2015.</p>
      <div class="social-row">
        <a href="https://www.instagram.com/shekharnirmansewa_233/" target="_blank" class="social-btn"><i class="fab fa-instagram"></i></a>
        <a href="#" class="social-btn"><i class="fab fa-facebook-f"></i></a>
        <a href="#" class="social-btn"><i class="fab fa-whatsapp"></i></a>
      </div>
    </div>
    <div class="footer-col">
      <h4>Quick Links</h4>
      <ul>
        <li><a href="#about">About Us</a></li>
        <li><a href="#services">Services</a></li>
        <li><a href="#projects">Projects</a></li>
        <li><a href="#process">Our Process</a></li>
        <li><a href="#contact">Contact</a></li>
      </ul>
    </div>
    <div class="footer-col">
      <h4>Services</h4>
      <ul>
        <li><a href="#services">Residential</a></li>
        <li><a href="#services">Commercial</a></li>
        <li><a href="#services">Renovation</a></li>
        <li><a href="#services">Interior Design</a></li>
        <li><a href="#services">Civil Works</a></li>
      </ul>
    </div>
    <div class="footer-col">
      <h4>Contact</h4>
      <ul>
        <li><a href="tel:+977-9800000000"><i class="fas fa-phone" style="color:var(--orange)"></i> +977-9800000000</a></li>
        <li><a href="mailto:info@shekharnirmansewa.com"><i class="fas fa-envelope" style="color:var(--orange)"></i> Email Us</a></li>
        <li><a href="#contact"><i class="fas fa-map-marker-alt" style="color:var(--orange)"></i> Butwal, Rupandehi</a></li>
      </ul>
    </div>
  </div>
  <div class="footer-bottom">
    <span>© 2025 Shekhar Nirman Sewa. All Rights Reserved.</span>
    <span>Made with <i class="fas fa-heart"></i> in Nepal</span>
    <a href="admin/login.html" style="font-family:var(--font-cond);font-size:.72rem;letter-spacing:2px;text-transform:uppercase;color:var(--muted);text-decoration:none;display:flex;align-items:center;gap:6px;transition:color .2s;" onmouseover="this.style.color='var(--orange)'" onmouseout="this.style.color='var(--muted)'"><i class="fas fa-lock" style="font-size:.65rem;"></i> Admin</a>
  </div>
</footer>

<!-- BACK TO TOP -->
<div id="btt" title="Back to top"><i class="fas fa-arrow-up"></i></div>

<script src="{{ asset('assets/js/main.js') }}"></script>
</body>
</html>
