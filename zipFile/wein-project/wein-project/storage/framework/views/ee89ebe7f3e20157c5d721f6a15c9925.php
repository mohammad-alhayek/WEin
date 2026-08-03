<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>"
      dir="<?php echo e(app()->getLocale() === 'ar' ? 'rtl' : 'ltr'); ?>"
      data-theme="<?php echo e(request()->cookie('wein_theme', 'light')); ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        <?php echo $__env->yieldContent('title', 'WEIN'); ?> — WEIN
    </title>

    
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
        href="<?php echo e(asset('css/app.css')); ?>">

    
    <?php echo $__env->yieldPushContent('styles'); ?>
    <?php echo $__env->yieldContent('styles'); ?>

</head>

<body>


<nav class="public-nav">

    <a
        href="<?php echo e(route('home')); ?>"
        class="nav-brand">

        ⚡ WEIN

    </a>


    <div class="nav-links">

        <a
            href="<?php echo e(route('home')); ?>"
            class="<?php echo e(request()->routeIs('home') ? 'fw-600' : ''); ?>">

            <?php echo e(__('messages.orders')); ?>


        </a>


        <a
            href="<?php echo e(route('instant-orders.index')); ?>"
            class="<?php echo e(request()->routeIs('instant-orders*') ? 'fw-600' : ''); ?>">

            <?php echo e(__('messages.instant_orders')); ?>


        </a>


        <a
            href="<?php echo e(route('settings')); ?>">

            ⚙ <?php echo e(__('messages.settings')); ?>


        </a>


        
        <button
            type="button"
            onclick="toggleWeinTheme()"
            class="btn btn-secondary btn-sm"
            style="cursor:pointer">

            🌙 / ☀️

        </button>


        
        <form
            method="POST"
            action="<?php echo e(route('language.switch')); ?>"
            style="margin:0">

            <?php echo csrf_field(); ?>

            <button
                name="lang"
                value="<?php echo e(app()->getLocale() === 'ar' ? 'en' : 'ar'); ?>"
                class="btn btn-secondary btn-sm">

                <?php echo e(app()->getLocale() === 'ar' ? 'EN' : 'عربي'); ?>


            </button>

        </form>

    </div>

</nav>



<div class="public-content">

    <?php if(session('success')): ?>

        <div class="alert alert-success alert-dismissible">

            ✓ <?php echo e(session('success')); ?>


        </div>

    <?php endif; ?>


    <?php if($errors->any()): ?>

        <div class="alert alert-danger">

            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <div>

                    • <?php echo e($e); ?>


                </div>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </div>

    <?php endif; ?>


    <?php echo $__env->yieldContent('content'); ?>

</div>



<script src="<?php echo e(asset('js/app.js')); ?>"></script>


<?php echo $__env->yieldPushContent('scripts'); ?>
<?php echo $__env->yieldContent('scripts'); ?>

</body>
</html><?php /**PATH C:\Users\user\Downloads\wein-project\wein-project\resources\views/layouts/public.blade.php ENDPATH**/ ?>