<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>" dir="<?php echo e(app()->getLocale() === 'ar' ? 'rtl' : 'ltr'); ?>" data-theme="<?php echo e(request()->cookie('wein_theme', 'light')); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e(__('messages.login')); ?> — <?php echo e($siteSettings->site_name); ?></title>
    <script>
        (function(){
            function gc(n){ let v=`; ${document.cookie}`,p=v.split(`; ${n}=`); if(p.length===2) return p.pop().split(';').shift(); }
            document.documentElement.setAttribute('data-theme', localStorage.getItem('wein_theme') || gc('wein_theme') || 'light');
        })();
    </script>
    <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
</head>
<body>

<div class="login-wrap">
    <div class="login-card">
        <div class="login-logo">
            <em><?php echo e($siteSettings->site_name); ?></em>
        </div>
        <p style="text-align:center;color:var(--text-3);font-size:.875rem;margin-bottom:1.75rem;margin-top:-.75rem;">
            <?php echo e(app()->getLocale() === 'ar' ? 'لوحة تحكم المندوب' : 'Admin Panel'); ?>

        </p>

        <?php if($errors->any()): ?>
            <div class="alert alert-danger"><?php echo e($errors->first()); ?></div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('admin.login.submit')); ?>">
            <?php echo csrf_field(); ?>
            <div class="form-group">
                <label class="form-label" for="email"><?php echo e(__('messages.email')); ?></label>
                <input type="email" id="email" name="email" class="form-control"
                       value="<?php echo e(old('email')); ?>" required autofocus autocomplete="email">
            </div>
            <div class="form-group">
                <label class="form-label" for="password"><?php echo e(__('messages.password')); ?></label>
                <input type="password" id="password" name="password" class="form-control"
                       required autocomplete="current-password">
            </div>
            <button type="submit" class="btn btn-primary w-100" style="margin-top:.75rem;padding:.75rem;">
                <?php echo e(__('messages.login')); ?>

            </button>
        </form>

        <p style="text-align:center;margin-top:2rem;font-size:.72rem;color:var(--text-3);">
            Made by <strong>Muhallabia</strong>
        </p>
    </div>
</div>

</body>
</html>
<?php /**PATH C:\Users\user\Desktop\wein-project 0.9\wein-projectzip\resources\views/admin/login.blade.php ENDPATH**/ ?>