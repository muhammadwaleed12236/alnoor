<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Staff Login - Al-Noor Clinic Management</title>
  
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <style>
    body {
      background: radial-gradient(circle at top right, #e0f2fe 0%, #f0fdfa 45%, #e2e8f0 100%);
      min-height: 100vh;
      display: grid;
      place-items: center;
      padding: 1.5rem;
    }
    .login-card {
      background: #ffffff;
      width: 100%;
      max-width: 440px;
      border-radius: var(--radius-lg);
      box-shadow: var(--shadow-xl);
      border: 1px solid rgba(0, 119, 145, 0.12);
      padding: 2.5rem 2rem;
      position: relative;
    }
    .login-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 6px;
      background: linear-gradient(90deg, var(--accent-pink), var(--primary), var(--secondary));
      border-radius: var(--radius-lg) var(--radius-lg) 0 0;
    }
    .login-header {
      text-align: center;
      margin-bottom: 2rem;
    }
    .login-header h2 {
      font-size: 1.45rem;
      font-weight: 800;
      color: var(--dark);
      margin-top: 0.75rem;
    }
    .login-header p {
      font-size: 0.85rem;
      color: var(--gray-500);
    }
  </style>
</head>
<body>

  <div class="login-card">
    <div class="login-header">
      <div class="logo-icon-box" style="margin: 0 auto; width: 50px; height: 50px; font-size: 1.5rem;">
        <i class="fa-solid fa-hand-holding-medical"></i>
      </div>
      <h2>Al-Noor Clinic Portal</h2>
      <p>Staff & Doctor Secure Management Login</p>
    </div>

    @if($errors->any())
      <div style="background: #fee2e2; color: #991b1b; padding: 0.75rem 1rem; border-radius: 8px; font-size: 0.82rem; margin-bottom: 1.25rem;">
        {{ $errors->first() }}
      </div>
    @endif

    <form action="{{ route('admin.login.submit') }}" method="POST" class="quick-form">
      @csrf

      <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" class="form-control" value="{{ old('email', 'admin@alnoorclinic.com') }}" required autofocus placeholder="admin@alnoorclinic.com">
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" class="form-control" required placeholder="admin123" value="admin123">
      </div>

      <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.8rem; color: var(--gray-500); margin: 0.25rem 0;">
        <label style="display: flex; align-items: center; gap: 0.4rem; cursor: pointer;">
          <input type="checkbox" name="remember"> Remember Me
        </label>
        <span>Demo: <strong>admin123</strong></span>
      </div>

      <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 0.75rem; padding: 0.75rem;">
        <i class="fa-solid fa-right-to-bracket"></i> Sign In to Dashboard
      </button>
    </form>

    <div style="text-align: center; margin-top: 1.75rem; font-size: 0.82rem;">
      <a href="{{ route('home') }}" style="color: var(--primary); font-weight: 600;">
        <i class="fa-solid fa-arrow-left"></i> Return to Public Patient Site
      </a>
    </div>
  </div>

</body>
</html>
