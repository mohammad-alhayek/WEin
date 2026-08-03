<?php $__env->startSection('title', __('messages.edit') . ' — ' . $order->title); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h1><?php echo e(__('messages.edit')); ?>: <?php echo e($order->title); ?></h1>
    <a href="<?php echo e(route('admin.orders.show', $order)); ?>" class="btn btn-secondary">← <?php echo e(__('messages.back')); ?></a>
</div>

<div class="card" style="max-width:680px">
    <div class="card-body">
        <form method="POST" action="<?php echo e(route('admin.orders.update', $order)); ?>">
            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
            <div class="form-group">
                <label class="form-label"><?php echo e(__('messages.title')); ?></label>
                <input type="text" name="title" class="form-control" value="<?php echo e(old('title', $order->title)); ?>" required>
            </div>
            <div class="form-group">
                <label class="form-label"><?php echo e(__('messages.description')); ?></label>
                <textarea name="description" class="form-control"><?php echo e(old('description', $order->description)); ?></textarea>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label"><?php echo e(__('messages.expected_arrival')); ?></label>
                    <input type="date" name="expected_arrival_date" class="form-control"
                        value="<?php echo e(old('expected_arrival_date', $order->expected_arrival_date?->format('Y-m-d'))); ?>">
                </div>
                <div class="form-group">
                    <label class="form-label"><?php echo e(__('messages.tax')); ?></label>
                    <input type="number" name="tax" class="form-control" value="<?php echo e(old('tax', $order->tax)); ?>" step="0.01" min="0">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label"><?php echo e(__('messages.status')); ?></label>
                <select name="status" class="form-control">
                    <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($s); ?>" <?php echo e(old('status', $order->status) === $s ? 'selected' : ''); ?>><?php echo e(__('messages.' . $s)); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="d-flex gap-1" style="margin-top:1rem">
                <button type="submit" class="btn btn-primary"><?php echo e(__('messages.save')); ?></button>
                <a href="<?php echo e(route('admin.orders.show', $order)); ?>" class="btn btn-secondary"><?php echo e(__('messages.cancel')); ?></a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\user\Downloads\wein-project\wein-project\resources\views/admin/orders/edit.blade.php ENDPATH**/ ?>