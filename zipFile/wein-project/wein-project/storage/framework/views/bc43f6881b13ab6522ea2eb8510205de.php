<?php $__env->startSection('title', __('messages.add') . ' ' . __('messages.instant_order')); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h1><?php echo e(__('messages.add')); ?> <?php echo e(__('messages.instant_order')); ?></h1>
    <a href="<?php echo e(route('admin.instant-orders.index')); ?>" class="btn btn-secondary">← <?php echo e(__('messages.back')); ?></a>
</div>

<div class="card" style="max-width:700px">
    <div class="card-body">
        <form method="POST" action="<?php echo e(route('admin.instant-orders.store')); ?>">
            <?php echo csrf_field(); ?>
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
                <label class="form-label"><?php echo e(__('messages.description')); ?></label>
                <textarea name="description" class="form-control"><?php echo e(old('description')); ?></textarea>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label"><?php echo e(__('messages.product_url')); ?></label>
                    <input type="url" name="product_url" class="form-control" value="<?php echo e(old('product_url')); ?>">
                </div>
                <div class="form-group">
                    <label class="form-label"><?php echo e(__('messages.image_url')); ?></label>
                    <input type="url" name="image_url" class="form-control" value="<?php echo e(old('image_url')); ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label"><?php echo e(__('messages.price')); ?></label>
                    <input type="number" name="price" class="form-control" value="<?php echo e(old('price', 0)); ?>" step="0.01" min="0" required>
                    <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="form-error"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="form-group">
                    <label class="form-label"><?php echo e(__('messages.delivery_price')); ?></label>
                    <input type="number" name="delivery_price" class="form-control" value="<?php echo e(old('delivery_price', 0)); ?>" step="0.01" min="0" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label"><?php echo e(__('messages.quantity')); ?></label>
                    <input type="number" name="quantity" class="form-control" value="<?php echo e(old('quantity', 1)); ?>" min="0" required>
                    <?php $__errorArgs = ['quantity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="form-error"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="form-group">
                    <label class="form-label"><?php echo e(__('messages.status')); ?></label>
                    <select name="status" class="form-control">
                        <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($s); ?>" <?php echo e(old('status') === $s ? 'selected' : ''); ?>><?php echo e(__('messages.' . $s)); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label"><?php echo e(__('messages.specifications')); ?></label>
                <textarea name="specifications" class="form-control"><?php echo e(old('specifications')); ?></textarea>
            </div>
            <div class="d-flex gap-1">
                <button type="submit" class="btn btn-primary"><?php echo e(__('messages.save')); ?></button>
                <a href="<?php echo e(route('admin.instant-orders.index')); ?>" class="btn btn-secondary"><?php echo e(__('messages.cancel')); ?></a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\user\Downloads\wein-project\wein-project\resources\views/admin/instant-orders/create.blade.php ENDPATH**/ ?>