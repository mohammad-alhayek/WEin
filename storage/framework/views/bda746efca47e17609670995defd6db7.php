<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>" dir="<?php echo e(app()->getLocale() === 'ar' ? 'rtl' : 'ltr'); ?>" data-theme="<?php echo e(request()->cookie('wein_theme', 'light')); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', $siteSettings->site_name); ?> — <?php echo e($siteSettings->site_name); ?></title>

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
    </script>

    <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
    <?php echo $__env->yieldPushContent('styles'); ?>
    <?php echo $__env->yieldContent('styles'); ?>
</head>

<body>


<nav class="public-nav">
    <a href="<?php echo e(route('home')); ?>" class="nav-brand">
        <?php echo e($siteSettings->site_name); ?>

    </a>

    <div class="nav-links">
        <a href="<?php echo e(route('home')); ?>" class="<?php echo e(request()->routeIs('home') ? 'fw-600' : ''); ?>">
            <?php echo e(__('messages.orders')); ?>

        </a>
        <a href="<?php echo e(route('instant-orders.index')); ?>" class="<?php echo e(request()->routeIs('instant-orders*') ? 'fw-600' : ''); ?>">
            <?php echo e(__('messages.instant_orders')); ?>

        </a>
        <a href="<?php echo e(route('settings')); ?>">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:middle"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
        </a>
        <button type="button" onclick="toggleWeinTheme()" class="btn btn-ghost btn-icon" style="width:32px;height:32px;padding:.3rem;" aria-label="Toggle theme">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
    </div>
</nav>


<div class="public-content">
    <?php if(session('success')): ?>
        <div class="alert alert-success">✓ <?php echo e(session('success')); ?></div>
    <?php endif; ?>
    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><div>• <?php echo e($e); ?></div><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>

    <?php echo $__env->yieldContent('content'); ?>
</div>


<footer class="public-footer">
    Made by <strong>Muhallabia · مهلبية</strong>
</footer>


<?php if(!empty($siteSettings->admin_phone)): ?>
<div class="contact-fab" id="contactFab">
    <button class="contact-fab-btn" onclick="document.getElementById('contactModal').classList.add('open')" aria-label="<?php echo e(__('messages.contact_agent')); ?>">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.99 12 19.79 19.79 0 0 1 1.93 3.49 2 2 0 0 1 3.92 1h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 8.91a16 16 0 0 0 5.61 5.61l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>
        </svg>
    </button>
</div>


<div class="contact-modal-overlay" id="contactModal" onclick="if(event.target===this) this.classList.remove('open')">
    <div class="contact-modal">
        <div class="contact-modal-handle"></div>
        <h3><?php echo e(__('messages.contact_agent')); ?></h3>

        <?php if(!empty($siteSettings->admin_name)): ?>
        <div class="contact-row">
            <div class="contact-row-icon">👤</div>
            <div>
                <div class="contact-row-label"><?php echo e(__('messages.admin_name')); ?></div>
                <div class="contact-row-value"><?php echo e($siteSettings->admin_name); ?></div>
            </div>
        </div>
        <?php endif; ?>

        <div class="contact-row">
            <div class="contact-row-icon">📞</div>
            <div>
                <div class="contact-row-label"><?php echo e(__('messages.admin_phone')); ?></div>
                <div class="contact-row-value" dir="ltr"><?php echo e($siteSettings->admin_phone); ?></div>
            </div>
        </div>

        <a href="tel:<?php echo e($siteSettings->admin_phone); ?>" class="contact-call-btn">
            <?php echo e(app()->getLocale() === 'ar' ? 'اتصل الآن' : 'Call Now'); ?>

        </a>
    </div>
</div>
<?php endif; ?>

<script src="<?php echo e(asset('js/app.js')); ?>"></script>
<?php echo $__env->yieldPushContent('scripts'); ?>
<?php echo $__env->yieldContent('scripts'); ?>

</body>
</html>
<?php /**PATH C:\Users\user\Desktop\wein-project 0.9\wein-projectzip\resources\views/layouts/public.blade.php ENDPATH**/ ?>