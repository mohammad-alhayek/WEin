<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" data-theme="{{ request()->cookie('wein_theme', 'light') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', __('messages.dashboard')) — WEIN Admin</title>

    <!-- نظام إدارة الثيم الذكي -->
    <script>
        // 1. تطبيق القيمة الجديدة وتحديث التخزين
        function setWeinTheme(theme) {
            const validTheme = (theme === 'dark') ? 'dark' : 'light';
            document.documentElement.setAttribute('data-theme', validTheme);
            localStorage.setItem('wein_theme', validTheme);
            document.cookie = "wein_theme=" + validTheme + "; path=/; max-age=31536000; SameSite=Lax";
        }

        // 2. دالة التبديل عند الضغط على زر Topbar
        function toggleWeinTheme() {
            const currentTheme = document.documentElement.getAttribute('data-theme') || 'light';
            const newTheme = (currentTheme === 'dark') ? 'light' : 'dark';
            setWeinTheme(newTheme);
        }

        // 3. تطبيق الثيم فوراً قبل رسم عناصر الصفحة (منع الـ Flickering)
        (function() {
            function getCookie(name) {
                let value = `; ${document.cookie}`;
                let parts = value.split(`; ${name}=`);
                if (parts.length === 2) return parts.pop().split(';').shift();
            }

            const savedTheme = localStorage.getItem('wein_theme') || getCookie('wein_theme') || 'light';
            document.documentElement.setAttribute('data-theme', savedTheme);
        })();

        // 4. التأكد من إرسال الثيم الحالي مع أي Form يتم تسليمه (مثل Save أو Logout)
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('form').forEach(function(form) {
                form.addEventListener('submit', function() {
                    const currentTheme = document.documentElement.getAttribute('data-theme') || 'light';
                    setWeinTheme(currentTheme);
                });
            });
        });

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            if (sidebar) sidebar.classList.toggle('collapsed');
        }
    </script>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('styles')
</head>
<body>
<div class="admin-wrapper">
    {{-- Sidebar --}}
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">⚡ WEIN</div>
        <nav class="sidebar-nav">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                ◈ {{ __('messages.dashboard') }}
            </a>
            <div class="nav-section">{{ __('messages.orders') }}</div>
            <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
                📦 {{ __('messages.orders') }}
            </a>
            <a href="{{ route('admin.customer-orders.index') }}" class="{{ request()->routeIs('admin.customer-orders*') ? 'active' : '' }}">
                👤 {{ __('messages.customer_orders') }}
            </a>
            <a href="{{ route('admin.notifications.index') }}" class="{{ request()->routeIs('admin.notifications*') ? 'active' : '' }}">
                🔔 {{ __('messages.notifications') }}
            </a>
            <div class="nav-section">{{ __('messages.settings') }}</div>
            <a href="{{ route('admin.delivery-areas.index') }}" class="{{ request()->routeIs('admin.delivery-areas*') ? 'active' : '' }}">
                🗺 {{ __('messages.delivery_areas') }}
            </a>
            <a href="{{ route('admin.instant-orders.index') }}" class="{{ request()->routeIs('admin.instant-orders*') ? 'active' : '' }}">
                ⚡ {{ __('messages.instant_orders') }}
            </a>
            <div class="nav-section">Account</div>
            <a href="{{ route('home') }}">🌐 Public Site</a>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" style="all:unset;cursor:pointer;display:flex;align-items:center;gap:.75rem;padding:.75rem 1.25rem;color:var(--sidebar-text);font-size:.9rem;width:100%;">
                    🚪 {{ __('messages.logout') }}
                </button>
            </form>
        </nav>
    </aside>

    {{-- Main --}}
    <div class="main-content">
        <header class="topbar">
            <div class="d-flex align-center gap-1">
                <button onclick="toggleSidebar()" style="background:none;border:none;cursor:pointer;font-size:1.3rem;color:var(--text-secondary)">☰</button>
                <h1 style="font-size:1rem;font-weight:600;">@yield('title', __('messages.dashboard'))</h1>
            </div>
            <div class="d-flex align-center gap-2">
                <!-- زر تبديل Dark / Light Mode -->
                <button type="button" onclick="toggleWeinTheme()" class="btn btn-secondary btn-sm" style="cursor:pointer">
                    🌙 / ☀️
                </button>

                <form method="POST" action="{{ route('language.switch') }}" style="margin:0">
                    @csrf
                    <button name="lang" value="{{ app()->getLocale() === 'ar' ? 'en' : 'ar' }}" class="btn btn-secondary btn-sm">
                        {{ app()->getLocale() === 'ar' ? 'EN' : 'عربي' }}
                    </button>
                </form>
                <span style="font-size:.85rem;color:var(--text-muted)">{{ session('admin_name') }}</span>
            </div>
        </header>

        <div class="page-content">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible">✓ {{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul style="margin:0;padding-left:1.2rem">
                        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </div>
</div>

<script src="{{ asset('js/app.js') }}"></script>
@yield('scripts')
</body>
</html>