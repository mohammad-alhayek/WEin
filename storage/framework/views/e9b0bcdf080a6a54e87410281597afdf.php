<?php $__env->startSection('title', __('messages.edit') . ' ' . __('messages.delivery_area')); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h1><?php echo e(__('messages.edit')); ?> <?php echo e(__('messages.delivery_area')); ?></h1>
    <a href="<?php echo e(route('admin.delivery-areas.index')); ?>" class="btn btn-secondary">← <?php echo e(__('messages.back')); ?></a>
</div>

<div class="card" style="max-width:480px">
    <div class="card-body">
        <form method="POST" action="<?php echo e(route('admin.delivery-areas.update', $deliveryArea)); ?>">
            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
            <div class="form-group">
                <label class="form-label"><?php echo e(__('messages.city_name')); ?></label>
                <input type="text" name="city_name" class="form-control" value="<?php echo e(old('city_name', $deliveryArea->city_name)); ?>" required>
            </div>
            <div class="form-group">
                <label class="form-label"><?php echo e(__('messages.delivery_price')); ?></label>
                <input type="number" name="delivery_price" class="form-control" value="<?php echo e(old('delivery_price', $deliveryArea->delivery_price)); ?>" step="0.01" min="0" required>
            </div>
            <div class="d-flex gap-1">
                <button type="submit" class="btn btn-primary"><?php echo e(__('messages.save')); ?></button>
                <a href="<?php echo e(route('admin.delivery-areas.index')); ?>" class="btn btn-secondary"><?php echo e(__('messages.cancel')); ?></a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\user\Downloads\wein-project\wein-project\resources\views/admin/delivery-areas/edit.blade.php ENDPATH**/ ?>