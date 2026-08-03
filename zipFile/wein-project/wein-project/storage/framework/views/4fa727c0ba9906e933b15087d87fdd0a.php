<?php $__env->startSection('title', __('messages.create') . ' ' . __('messages.notification')); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h1><?php echo e(__('messages.create')); ?> <?php echo e(__('messages.notification')); ?></h1>
    <a href="<?php echo e(route('admin.notifications.index')); ?>" class="btn btn-secondary">← <?php echo e(__('messages.back')); ?></a>
</div>

<div class="card" style="max-width:600px">
    <div class="card-body">
        <form method="POST" action="<?php echo e(route('admin.notifications.store')); ?>">
            <?php echo csrf_field(); ?>
            <div class="form-group">
                <label class="form-label">Order</label>
                <select name="order_id" class="form-control" required>
                    <option value="">— Select Order —</option>
                    <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $o): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($o->id); ?>" <?php echo e(old('order_id') == $o->id ? 'selected' : ''); ?>><?php echo e($o->title); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['order_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="form-error"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="form-group">
                <label class="form-label"><?php echo e(__('messages.title')); ?></label>
                <input type="text" name="title" class="form-control" value="<?php echo e(old('title')); ?>" required>
                <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="form-error"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="form-group">
                <label class="form-label"><?php echo e(__('messages.message')); ?></label>
                <textarea name="message" class="form-control" required><?php echo e(old('message')); ?></textarea>
                <?php $__errorArgs = ['message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="form-error"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="d-flex gap-1">
                <button type="submit" class="btn btn-primary"><?php echo e(__('messages.save')); ?></button>
                <a href="<?php echo e(route('admin.notifications.index')); ?>" class="btn btn-secondary"><?php echo e(__('messages.cancel')); ?></a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\user\Downloads\wein-project\wein-project\resources\views/admin/notifications/create.blade.php ENDPATH**/ ?>