<?php $__env->startSection('title', __('messages.settings')); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h1>⚙ <?php echo e(__('messages.settings')); ?></h1>
</div>

<div class="card" style="max-width:520px">
    <div class="card-body">
        <form method="POST" action="<?php echo e(route('settings.update')); ?>">
            <?php echo csrf_field(); ?>

            
            <div class="form-group">
                <label class="form-label"><?php echo e(__('messages.language')); ?></label>
                <select name="language" class="form-control">
                    <option value="en" <?php echo e(app()->getLocale() === 'en' ? 'selected' : ''); ?>><?php echo e(__('messages.english')); ?> (English)</option>
                    <option value="ar" <?php echo e(app()->getLocale() === 'ar' ? 'selected' : ''); ?>><?php echo e(__('messages.arabic')); ?> (العربية)</option>
                </select>
            </div>

          

            
            <div class="form-group">
                <label class="form-label"><?php echo e(__('messages.view_mode')); ?></label>
                <select name="view" class="form-control">
                    <option value="card" <?php echo e(request()->cookie('wein_view', 'card') === 'card' ? 'selected' : ''); ?>>⊞ <?php echo e(__('messages.card_view')); ?></option>
                    <option value="list" <?php echo e(request()->cookie('wein_view') === 'list' ? 'selected' : ''); ?>>☰ <?php echo e(__('messages.list_view')); ?></option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary w-100" style="margin-top:.5rem"><?php echo e(__('messages.save')); ?></button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
// Live theme preview
document.getElementById('theme-select').addEventListener('change', function() {
    document.documentElement.setAttribute('data-theme', this.value);
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\user\Downloads\wein-project\wein-project\resources\views/public/settings.blade.php ENDPATH**/ ?>