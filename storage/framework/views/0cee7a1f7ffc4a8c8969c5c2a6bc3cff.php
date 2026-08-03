<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>" dir="<?php echo e(app()->getLocale() === 'ar' ? 'rtl' : 'ltr'); ?>" data-theme="<?php echo e(request()->cookie('wein_theme', 'light')); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', __('messages.dashboard')); ?> — WEIN Admin</title>

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

    <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
    <?php echo $__env->yieldPushContent('styles'); ?>
    <?php echo $__env->yieldContent('styles'); ?>
</head>
<body>
<div class="admin-wrapper">
    
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">⚡ WEIN</div>
        <nav class="sidebar-nav">
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="<?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
                ◈ <?php echo e(__('messages.dashboard')); ?>

            </a>
            <div class="nav-section"><?php echo e(__('messages.orders')); ?></div>
            <a href="<?php echo e(route('admin.orders.index')); ?>" class="<?php echo e(request()->routeIs('admin.orders*') ? 'active' : ''); ?>">
                📦 <?php echo e(__('messages.orders')); ?>

            </a>
            <a href="<?php echo e(route('admin.customer-orders.index')); ?>" class="<?php echo e(request()->routeIs('admin.customer-orders*') ? 'active' : ''); ?>">
                👤 <?php echo e(__('messages.customer_orders')); ?>

            </a>
            <a href="<?php echo e(route('admin.notifications.index')); ?>" class="<?php echo e(request()->routeIs('admin.notifications*') ? 'active' : ''); ?>">
                🔔 <?php echo e(__('messages.notifications')); ?>

            </a>
            <div class="nav-section"><?php echo e(__('messages.settings')); ?></div>
            <a href="<?php echo e(route('admin.delivery-areas.index')); ?>" class="<?php echo e(request()->routeIs('admin.delivery-areas*') ? 'active' : ''); ?>">
                🗺 <?php echo e(__('messages.delivery_areas')); ?>

            </a>
            <a href="<?php echo e(route('admin.instant-orders.index')); ?>" class="<?php echo e(request()->routeIs('admin.instant-orders*') ? 'active' : ''); ?>">
                ⚡ <?php echo e(__('messages.instant_orders')); ?>

            </a>
            <div class="nav-section">Account</div>
            <a href="<?php echo e(route('home')); ?>">🌐 Public Site</a>
            <form method="POST" action="<?php echo e(route('admin.logout')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit" style="all:unset;cursor:pointer;display:flex;align-items:center;gap:.75rem;padding:.75rem 1.25rem;color:var(--sidebar-text);font-size:.9rem;width:100%;">
                    🚪 <?php echo e(__('messages.logout')); ?>

                </button>
            </form>
        </nav>
    </aside>

    
    <div class="main-content">
        <header class="topbar">
            <div class="d-flex align-center gap-1">
                <button onclick="toggleSidebar()" style="background:none;border:none;cursor:pointer;font-size:1.3rem;color:var(--text-secondary)">☰</button>
                <h1 style="font-size:1rem;font-weight:600;"><?php echo $__env->yieldContent('title', __('messages.dashboard')); ?></h1>
            </div>
            <div class="d-flex align-center gap-2">
                <!-- زر تبديل Dark / Light Mode -->
                <button type="button" onclick="toggleWeinTheme()" class="btn btn-secondary btn-sm" style="cursor:pointer">
                    🌙 / ☀️
                </button>

                <form method="POST" action="<?php echo e(route('language.switch')); ?>" style="margin:0">
                    <?php echo csrf_field(); ?>
                    <button name="lang" value="<?php echo e(app()->getLocale() === 'ar' ? 'en' : 'ar'); ?>" class="btn btn-secondary btn-sm">
                        <?php echo e(app()->getLocale() === 'ar' ? 'EN' : 'عربي'); ?>

                    </button>
                </form>
                <span style="font-size:.85rem;color:var(--text-muted)"><?php echo e(session('admin_name')); ?></span>
            </div>
        </header>

        <div class="page-content">
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible">✓ <?php echo e(session('success')); ?></div>
            <?php endif; ?>
            <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                    <ul style="margin:0;padding-left:1.2rem">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </div>
</div>

<script src="<?php echo e(asset('js/app.js')); ?>"></script>
<?php echo $__env->yieldContent('scripts'); ?>
</body>
</html><?php /**PATH C:\Users\user\Desktop\wein-project\wein-project\wein-project\resources\views/layouts/admin.blade.php ENDPATH**/ ?>