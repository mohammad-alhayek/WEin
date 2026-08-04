<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>" dir="<?php echo e(app()->getLocale() === 'ar' ? 'rtl' : 'ltr'); ?>" data-theme="<?php echo e(request()->cookie('wein_theme', 'light')); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', __('messages.dashboard')); ?> — <?php echo e($siteSettings->site_name); ?></title>

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

    <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
    <?php echo $__env->yieldPushContent('styles'); ?>
    <?php echo $__env->yieldContent('styles'); ?>
</head>
<body>
<div class="admin-wrapper">

    
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <span>●</span> <?php echo e($siteSettings->site_name); ?>

        </div>

        <nav class="sidebar-nav">
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="<?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
                <span class="nav-icon">▦</span> <?php echo e(__('messages.dashboard')); ?>

            </a>

            <div class="nav-section"><?php echo e(__('messages.orders')); ?></div>

            <a href="<?php echo e(route('admin.orders.index')); ?>" class="<?php echo e(request()->routeIs('admin.orders*') ? 'active' : ''); ?>">
                <span class="nav-icon">📦</span> <?php echo e(__('messages.orders')); ?>

            </a>
            <a href="<?php echo e(route('admin.customer-orders.index')); ?>" class="<?php echo e(request()->routeIs('admin.customer-orders*') ? 'active' : ''); ?>">
                <span class="nav-icon">👤</span> <?php echo e(__('messages.customer_orders')); ?>

            </a>
            <a href="<?php echo e(route('admin.notifications.index')); ?>" class="<?php echo e(request()->routeIs('admin.notifications*') ? 'active' : ''); ?>">
                <span class="nav-icon">🔔</span> <?php echo e(__('messages.notifications')); ?>

            </a>

            <div class="nav-section"><?php echo e(__('messages.settings')); ?></div>

            <a href="<?php echo e(route('admin.delivery-areas.index')); ?>" class="<?php echo e(request()->routeIs('admin.delivery-areas*') ? 'active' : ''); ?>">
                <span class="nav-icon">🗺</span> <?php echo e(__('messages.delivery_areas')); ?>

            </a>
            <a href="<?php echo e(route('admin.instant-orders.index')); ?>" class="<?php echo e(request()->routeIs('admin.instant-orders*') ? 'active' : ''); ?>">
                <span class="nav-icon">⚡</span> <?php echo e(__('messages.instant_orders')); ?>

            </a>
            <a href="<?php echo e(route('admin.site-settings.index')); ?>" class="<?php echo e(request()->routeIs('admin.site-settings*') ? 'active' : ''); ?>">
                <span class="nav-icon">⚙</span> <?php echo e(__('messages.site_settings')); ?>

            </a>

            <div class="nav-section"><?php echo e(app()->getLocale() === 'ar' ? 'أخرى' : 'Other'); ?></div>

            <a href="<?php echo e(route('home')); ?>">
                <span class="nav-icon">🌐</span> <?php echo e(app()->getLocale() === 'ar' ? 'الموقع العام' : 'Public Site'); ?>

            </a>

            <form method="POST" action="<?php echo e(route('admin.logout')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit" style="all:unset;cursor:pointer;display:flex;align-items:center;gap:.75rem;padding:.7rem 1.25rem;color:var(--sidebar-txt);font-size:.875rem;font-weight:500;width:100%;transition:color .15s;">
                    <span class="nav-icon">🚪</span> <?php echo e(__('messages.logout')); ?>

                </button>
            </form>
        </nav>

        <div class="sidebar-footer">Made by Muhallabia · مهلبية</div>
    </aside>

    
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
                <span class="topbar-title"><?php echo $__env->yieldContent('title', __('messages.dashboard')); ?></span>
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

                <form method="POST" action="<?php echo e(route('language.switch')); ?>" style="margin:0">
                    <?php echo csrf_field(); ?>
                    <button name="lang" value="<?php echo e(app()->getLocale() === 'ar' ? 'en' : 'ar'); ?>" class="btn btn-secondary btn-sm">
                        <?php echo e(app()->getLocale() === 'ar' ? 'EN' : 'عربي'); ?>

                    </button>
                </form>

                <?php if(session('admin_name')): ?>
                    <span style="font-size:.8125rem;color:var(--text-3);max-width:100px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"><?php echo e(session('admin_name')); ?></span>
                <?php endif; ?>
            </div>
        </header>

        <div class="page-content">
            <?php if(session('success')): ?>
                <div class="alert alert-success">✓ <?php echo e(session('success')); ?></div>
            <?php endif; ?>
            <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                    <ul style="margin:0;padding-inline-start:1.2rem">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php echo $__env->yieldContent('content'); ?>
        </div>

        <footer style="text-align:center;padding:1.25rem 1rem;font-size:.72rem;color:var(--text-3);border-top:1px solid var(--border);">
            Made by <strong>Muhallabia · مهلبية</strong>
        </footer>
    </div>
</div>

<script src="<?php echo e(asset('js/app.js')); ?>"></script>
<?php echo $__env->yieldContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\user\Desktop\wein-project 0.9\wein-projectzip\resources\views/layouts/admin.blade.php ENDPATH**/ ?>