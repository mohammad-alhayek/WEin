<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <title>{{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    
    <!-- 1. السماح بالـ Dark Mode و الـ Light Mode معاً -->
    <meta name="color-scheme" content="light dark">

    <!-- 2. سكربت فوري يقرأ الخيار المحفوظ في الـ Cookie أو LocalStorage قبل تحميل الصفحة -->
    <script>
        (function() {
            // قراءة الثيم من الـ Cookie أو LocalStorage
            function getCookie(name) {
                let value = `; ${document.cookie}`;
                let parts = value.split(`; ${name}=`);
                if (parts.length === 2) return parts.pop().split(';').shift();
            }

            const savedTheme = localStorage.getItem('theme') || getCookie('theme');
            
            if (savedTheme === 'dark' || (!savedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>

    <style>
        /* تنسيقات أساسية للـ Dark Mode */
        html.dark body {
            background-color: #0f172a !important;
            color: #f8fafc !important;
        }
        html.dark .content-cell, 
        html.dark .inner-body {
            background-color: #1e293b !important;
            color: #f8fafc !important;
        }

        @media only screen and (max-width: 600px) {
            .inner-body, .footer {
                width: 100% !important;
            }
        }

        @media only screen and (max-width: 500px) {
            .button {
                width: 100% !important;
            }
        }
    </style>
    {!! $head ?? '' !!}
</head>
<body class="bg-gray-100 dark:bg-slate-900 dark:text-white transition-colors duration-200">

<table class="wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td align="center">
<table class="content" width="100%" cellpadding="0" cellspacing="0" role="presentation">
{!! $header ?? '' !!}

<!-- Email Body -->
<tr>
<td class="body" width="100%" cellpadding="0" cellspacing="0" style="border: hidden !important;">
<table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
<!-- Body content -->
<tr>
<td class="content-cell">
{!! Illuminate\Mail\Markdown::parse($slot) !!}

{!! $subcopy ?? '' !!}
</td>
</tr>
</table>
</td>
</tr>

{!! $footer ?? '' !!}
</table>
</td>
</tr>
</table>
</body>
</html>