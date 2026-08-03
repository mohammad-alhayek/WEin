<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — WEIN</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body { display: flex; align-items: center; justify-content: center; min-height: 100vh; }
        .login-box { width: 380px; }
        .login-logo { text-align: center; font-size: 2.5rem; font-weight: 800; color: var(--accent); margin-bottom: 1.5rem; letter-spacing: 2px; }
        .login-sub  { text-align: center; color: var(--text-muted); font-size: .9rem; margin-bottom: 2rem; }
    </style>
</head>
<body>
<div class="login-box">
    <div class="login-logo">⚡ WEIN</div>
    <p class="login-sub">Admin Panel</p>

    <div class="card">
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger mb-2">{{ $errors->first() }}</div>
            @endif
            <form method="POST" action="{{ route('admin.login.submit') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label" for="email">{{ __('messages.email') }}</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                </div>
                <div class="form-group">
                    <label class="form-label" for="password">{{ __('messages.password') }}</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100" style="margin-top:.5rem">
                    {{ __('messages.login') }}
                </button>
            </form>
        </div>
    </div>
</div>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
