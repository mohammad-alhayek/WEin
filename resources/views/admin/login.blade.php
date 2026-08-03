<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" data-theme="{{ request()->cookie('wein_theme', 'light') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.login') }} — {{ $siteSettings->site_name }}</title>
    <script>
        (function(){
            function gc(n){ let v=`; ${document.cookie}`,p=v.split(`; ${n}=`); if(p.length===2) return p.pop().split(';').shift(); }
            document.documentElement.setAttribute('data-theme', localStorage.getItem('wein_theme') || gc('wein_theme') || 'light');
        })();
    </script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

<div class="login-wrap">
    <div class="login-card">
        <div class="login-logo">
            <em>{{ $siteSettings->site_name }}</em>
        </div>
        <p style="text-align:center;color:var(--text-3);font-size:.875rem;margin-bottom:1.75rem;margin-top:-.75rem;">
            {{ app()->getLocale() === 'ar' ? 'لوحة تحكم المندوب' : 'Admin Panel' }}
        </p>

        @if($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('admin.login.submit') }}">
            @csrf
            <div class="form-group">
                <label class="form-label" for="email">{{ __('messages.email') }}</label>
                <input type="email" id="email" name="email" class="form-control"
                       value="{{ old('email') }}" required autofocus autocomplete="email">
            </div>
            <div class="form-group">
                <label class="form-label" for="password">{{ __('messages.password') }}</label>
                <input type="password" id="password" name="password" class="form-control"
                       required autocomplete="current-password">
            </div>
            <button type="submit" class="btn btn-primary w-100" style="margin-top:.75rem;padding:.75rem;">
                {{ __('messages.login') }}
            </button>
        </form>

        <p style="text-align:center;margin-top:2rem;font-size:.72rem;color:var(--text-3);">
            Made by <strong>Muhallabia · مهلبية</strong>
        </p>
    </div>
</div>

</body>
</html>
