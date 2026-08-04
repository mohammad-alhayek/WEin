<?php $__env->startSection('title', __('messages.site_settings')); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h1><?php echo e(__('messages.site_settings')); ?></h1>
</div>

<div class="card" style="max-width:540px">
    <div class="card-body">
        <form method="POST" action="<?php echo e(route('admin.site-settings.update')); ?>">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="form-group">
                <label class="form-label"><?php echo e(__('messages.site_name')); ?></label>
                <input type="text" name="site_name" class="form-control" value="<?php echo e(old('site_name', $settings->site_name)); ?>" required>
                <small class="text-muted" style="display:block;margin-top:.35rem">
                    <?php echo e(app()->getLocale() === 'ar' ? 'سيظهر هذا الاسم في جميع صفحات الموقع' : 'This name appears on all pages of the site'); ?>

                </small>
            </div>

            <div class="form-group">
                <label class="form-label"><?php echo e(__('messages.admin_name')); ?></label>
                <input type="text" name="admin_name" class="form-control" value="<?php echo e(old('admin_name', $settings->admin_name)); ?>" placeholder="<?php echo e(app()->getLocale() === 'ar' ? 'اسم المندوب' : 'Agent full name'); ?>">
            </div>

            <div class="form-group">
                <label class="form-label"><?php echo e(__('messages.admin_phone')); ?></label>
                <input type="text" name="admin_phone" class="form-control" value="<?php echo e(old('admin_phone', $settings->admin_phone)); ?>" placeholder="<?php echo e(app()->getLocale() === 'ar' ? 'مثال: 0501234567' : 'e.g. 0501234567'); ?>" dir="ltr">
                <small class="text-muted" style="display:block;margin-top:.35rem">
                    <?php echo e(app()->getLocale() === 'ar' ? 'سيُعرض هذا الرقم لعملائك عند الضغط على زر التواصل' : 'Shown to customers when they tap the Contact button'); ?>

                </small>
            </div>

            <button type="submit" class="btn btn-primary w-100" style="margin-top:.5rem">
                <?php echo e(__('messages.save')); ?>

            </button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\user\Desktop\wein-project 0.9\wein-projectzip\resources\views/admin/settings/index.blade.php ENDPATH**/ ?>