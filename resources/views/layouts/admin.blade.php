<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" data-theme="{{ request()->cookie('wein_theme', 'light') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', __('messages.dashboard')) — {{ $siteSettings->site_name }}</title>

    <script>
        function setWeinTheme(t) {
            const v = t === 'dark' ? 'dark' : 'light';
            document.documentElement.setAttribute('data-theme', v);
            localStorage.setItem('wein_theme', v);
            document.cookie = "wein_theme=" + v + "; path=/; max-age=31536000; SameSite=Lax";
        }
        function toggleWeinTheme() {
            const c = document.documentElement.getAttribute('data-theme') || 'light';
            setWeinTheme(c === 'dark' ? 'light' : 'dark');
        }
        (function(){
            function gc(n){ let v=`; ${document.cookie}`,p=v.split(`; ${n}=`); if(p.length===2) return p.pop().split(';').shift(); }
            document.documentElement.setAttribute('data-theme', localStorage.getItem('wein_theme') || gc('wein_theme') || 'light');
        })();
        function toggleSidebar() {
            const s = document.getElementById('sidebar');
            const o = document.getElementById('sidebarOverlay');
            s.classList.toggle('open');
            o.classList.toggle('open');
        }
    </script>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')
    @yield('styles')
</head>
<body>
<div class="admin-wrapper">

    {{-- Sidebar overlay (mobile) --}}
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    {{-- Sidebar --}}
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <span>●</span> {{ $siteSettings->site_name }}
        </div>

        <nav class="sidebar-nav">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <span class="nav-icon">▦</span> {{ __('messages.dashboard') }}
            </a>

            <div class="nav-section">{{ __('messages.orders') }}</div>

            <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
                <span class="nav-icon">📦</span> {{ __('messages.orders') }}
            </a>
            <a href="{{ route('admin.customer-orders.index') }}" class="{{ request()->routeIs('admin.customer-orders*') ? 'active' : '' }}">
                <span class="nav-icon">👤</span> {{ __('messages.customer_orders') }}
            </a>
            <a href="{{ route('admin.notifications.index') }}" class="{{ request()->routeIs('admin.notifications*') ? 'active' : '' }}">
                <span class="nav-icon">🔔</span> {{ __('messages.notifications') }}
            </a>

            <div class="nav-section">{{ __('messages.settings') }}</div>

            <a href="{{ route('admin.delivery-areas.index') }}" class="{{ request()->routeIs('admin.delivery-areas*') ? 'active' : '' }}">
                <span class="nav-icon">🗺</span> {{ __('messages.delivery_areas') }}
            </a>
            <a href="{{ route('admin.instant-orders.index') }}" class="{{ request()->routeIs('admin.instant-orders*') ? 'active' : '' }}">
                <span class="nav-icon">⚡</span> {{ __('messages.instant_orders') }}
            </a>
            <a href="{{ route('admin.site-settings.index') }}" class="{{ request()->routeIs('admin.site-settings*') ? 'active' : '' }}">
                <span class="nav-icon">⚙</span> {{ __('messages.site_settings') }}
            </a>

            <div class="nav-section">{{ app()->getLocale() === 'ar' ? 'أخرى' : 'Other' }}</div>

            <a href="{{ route('home') }}">
                <span class="nav-icon">🌐</span> {{ app()->getLocale() === 'ar' ? 'الموقع العام' : 'Public Site' }}
            </a>

            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" style="all:unset;cursor:pointer;display:flex;align-items:center;gap:.75rem;padding:.7rem 1.25rem;color:var(--sidebar-txt);font-size:.875rem;font-weight:500;width:100%;transition:color .15s;">
                    <span class="nav-icon">🚪</span> {{ __('messages.logout') }}
                </button>
            </form>
        </nav>

        <div class="sidebar-footer">Made by Muhallabia · مهلبية</div>
    </aside>

    {{-- Main --}}
    <div class="main-content">
        <header class="topbar">
            <div class="d-flex align-center gap-1">
                <button onclick="toggleSidebar()" class="btn btn-ghost btn-icon" aria-label="Menu">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                        <line x1="3" y1="6"  x2="21" y2="6"/>
                        <line x1="3" y1="12" x2="21" y2="12"/>
                        <line x1="3" y1="18" x2="21" y2="18"/>
                    </svg>
                </button>
                <span class="topbar-title">@yield('title', __('messages.dashboard'))</span>
            </div>

            <div class="topbar-actions">
                <button type="button" onclick="toggleWeinTheme()" class="btn btn-ghost btn-icon" title="Toggle theme" aria-label="Toggle theme">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/>
                        <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/>
                        <line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/>
                        <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>
                    </svg>
                </button>

                <form method="POST" action="{{ route('language.switch') }}" style="margin:0">
                    @csrf
                    <button name="lang" value="{{ app()->getLocale() === 'ar' ? 'en' : 'ar' }}" class="btn btn-secondary btn-sm">
                        {{ app()->getLocale() === 'ar' ? 'EN' : 'عربي' }}
                    </button>
                </form>

                @if(session('admin_name'))
                    <span style="font-size:.8125rem;color:var(--text-3);max-width:100px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ session('admin_name') }}</span>
                @endif
            </div>
        </header>

        <div class="page-content">
            @if(session('success'))
                <div class="alert alert-success">✓ {{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul style="margin:0;padding-inline-start:1.2rem">
                        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>

        <footer style="text-align:center;padding:1.25rem 1rem;font-size:.72rem;color:var(--text-3);border-top:1px solid var(--border);">
            Made by <strong>Muhallabia · مهلبية</strong>
        </footer>
    </div>
</div>

<script src="{{ asset('js/app.js') }}"></script>
@yield('scripts')
</body>
</html>
