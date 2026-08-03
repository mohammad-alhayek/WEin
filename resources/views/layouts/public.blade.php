<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}"
      dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}"
      data-theme="{{ request()->cookie('wein_theme', 'light') }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'WEIN') — WEIN
    </title>

    {{-- Theme System --}}
    <script>

        function setWeinTheme(theme)
        {
            const validTheme =
                theme === 'dark'
                    ? 'dark'
                    : 'light';

            document.documentElement
                .setAttribute(
                    'data-theme',
                    validTheme
                );

            localStorage.setItem(
                'wein_theme',
                validTheme
            );

            document.cookie =
                "wein_theme=" +
                validTheme +
                "; path=/; max-age=31536000; SameSite=Lax";
        }


        function toggleWeinTheme()
        {
            const currentTheme =
                document.documentElement
                    .getAttribute('data-theme')
                    || 'light';

            const newTheme =
                currentTheme === 'dark'
                    ? 'light'
                    : 'dark';

            setWeinTheme(newTheme);
        }


        (function () {

            function getCookie(name)
            {
                let value =
                    `; ${document.cookie}`;

                let parts =
                    value.split(
                        `; ${name}=`
                    );

                if (parts.length === 2)
                {
                    return parts
                        .pop()
                        .split(';')
                        .shift();
                }
            }

            const savedTheme =
                localStorage.getItem('wein_theme')
                || getCookie('wein_theme')
                || 'light';

            document.documentElement
                .setAttribute(
                    'data-theme',
                    savedTheme
                );

        })();


        document.addEventListener(
            'DOMContentLoaded',
            function () {

                document
                    .querySelectorAll('form')
                    .forEach(function (form) {

                        form.addEventListener(
                            'submit',
                            function () {

                                const currentTheme =
                                    document.documentElement
                                        .getAttribute(
                                            'data-theme'
                                        ) || 'light';

                                setWeinTheme(
                                    currentTheme
                                );

                            }
                        );

                    });

            }
        );

    </script>


    <link
        rel="stylesheet"
        href="{{ asset('css/app.css') }}">

    {{-- IMPORTANT --}}
    @stack('styles')
    @yield('styles')

</head>

<body>


<nav class="public-nav">

    <a
        href="{{ route('home') }}"
        class="nav-brand">

        ⚡ WEIN

    </a>


    <div class="nav-links">

        <a
            href="{{ route('home') }}"
            class="{{ request()->routeIs('home') ? 'fw-600' : '' }}">

            {{ __('messages.orders') }}

        </a>


        <a
            href="{{ route('instant-orders.index') }}"
            class="{{ request()->routeIs('instant-orders*') ? 'fw-600' : '' }}">

            {{ __('messages.instant_orders') }}

        </a>


        <a
            href="{{ route('settings') }}">

            ⚙ {{ __('messages.settings') }}

        </a>


        {{-- Theme Button --}}
        <button
            type="button"
            onclick="toggleWeinTheme()"
            class="btn btn-secondary btn-sm"
            style="cursor:pointer">

            🌙 / ☀️

        </button>


        {{-- Language --}}
        <form
            method="POST"
            action="{{ route('language.switch') }}"
            style="margin:0">

            @csrf

            <button
                name="lang"
                value="{{ app()->getLocale() === 'ar' ? 'en' : 'ar' }}"
                class="btn btn-secondary btn-sm">

                {{ app()->getLocale() === 'ar' ? 'EN' : 'عربي' }}

            </button>

        </form>

    </div>

</nav>



<div class="public-content">

    @if(session('success'))

        <div class="alert alert-success alert-dismissible">

            ✓ {{ session('success') }}

        </div>

    @endif


    @if($errors->any())

        <div class="alert alert-danger">

            @foreach($errors->all() as $e)

                <div>

                    • {{ $e }}

                </div>

            @endforeach

        </div>

    @endif


    @yield('content')

</div>



<script src="{{ asset('js/app.js') }}"></script>

{{-- IMPORTANT --}}
@stack('scripts')
@yield('scripts')

</body>
</html>