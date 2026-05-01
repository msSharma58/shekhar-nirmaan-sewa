<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login – Shekhar Nirman Sewa</title>
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Barlow:wght@300;400;500;600&family=Barlow+Condensed:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body class="login-page">
<div class="glow-blob"></div>

<div class="login-wrap">
  <div class="login-logo">
    <a href="{{ url('/') }}">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 62" aria-label="Shekhar Nirman Sewa">
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
    <p>Admin Portal</p>
  </div>

  <div class="login-card">
    <div class="login-title">Welcome Back</div>
    <div class="login-sub">Sign in to manage your website content</div>

    @if($errors->any())
      <div class="login-error show">
        <i class="fas fa-exclamation-triangle"></i> {{ $errors->first() }}
      </div>
    @endif

    <form action="{{ route('admin.login.post') }}" method="POST" novalidate>
      @csrf
      <div class="form-group">
        <label>Email Address</label>
        <div class="input-wrap">
          <i class="fas fa-envelope"></i>
          <input type="email" name="email" value="{{ old('email') }}"
            placeholder="admin@sekharnirmansewa.com" autocomplete="email" required>
        </div>
      </div>
      <div class="form-group">
        <label>Password</label>
        <div class="input-wrap">
          <i class="fas fa-lock"></i>
          <input type="password" name="password" id="loginPass"
            placeholder="Enter your password" autocomplete="current-password" required>
          <span class="eye" id="eyeToggle"><i class="fas fa-eye"></i></span>
        </div>
      </div>
      <div class="login-options">
        <label class="remember">
          <input type="checkbox" name="remember"> Remember me
        </label>
      </div>
      <button type="submit" class="login-btn">
        <span class="btn-text">Sign In</span>
        <i class="fas fa-arrow-right btn-icon"></i>
      </button>
    </form>
  </div>

  <a href="{{ url('/') }}" class="back-link">
    <i class="fas fa-arrow-left"></i> Back to Website
  </a>
</div>

<script>
document.getElementById('eyeToggle').addEventListener('click', function(){
  const inp = document.getElementById('loginPass');
  const icon = this.querySelector('i');
  inp.type = inp.type === 'password' ? 'text' : 'password';
  icon.className = inp.type === 'text' ? 'fas fa-eye-slash' : 'fas fa-eye';
});
</script>
</body>
</html>
