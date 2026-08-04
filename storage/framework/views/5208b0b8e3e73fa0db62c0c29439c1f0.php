<?php $__env->startSection('title', $instantOrder->title); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div>
        <h1><?php echo e($instantOrder->title); ?></h1>
        <span class="badge badge-<?php echo e(strtolower($instantOrder->status)); ?>"><?php echo e(__('messages.' . $instantOrder->status)); ?></span>
    </div>
    <div class="d-flex gap-1">
        <a href="<?php echo e(route('admin.instant-orders.edit', $instantOrder)); ?>" class="btn btn-warning"><?php echo e(__('messages.edit')); ?></a>
        <a href="<?php echo e(route('admin.instant-orders.index')); ?>" class="btn btn-secondary">← <?php echo e(__('messages.back')); ?></a>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;margin-bottom:1.5rem">
    <div class="card">
        <div class="card-header">Product Info</div>
        <div class="card-body">
            <?php if($instantOrder->image_url): ?>
                <img src="<?php echo e($instantOrder->image_url); ?>" alt="<?php echo e($instantOrder->title); ?>" style="width:100%;max-height:200px;object-fit:cover;border-radius:8px;margin-bottom:1rem">
            <?php endif; ?>
            <p style="color:var(--text-secondary);margin-bottom:.75rem"><?php echo e($instantOrder->description); ?></p>
            <div style="font-size:.9rem;display:flex;flex-direction:column;gap:.5rem">
                <div><strong><?php echo e(__('messages.price')); ?>:</strong> <?php echo e(number_format($instantOrder->price, 2)); ?></div>
                <div><strong><?php echo e(__('messages.delivery_price')); ?>:</strong> <?php echo e(number_format($instantOrder->delivery_price, 2)); ?></div>
                <div><strong><?php echo e(__('messages.quantity')); ?>:</strong> <?php echo e($instantOrder->quantity); ?></div>
                <?php if($instantOrder->product_url): ?>
                    <div><a href="<?php echo e($instantOrder->product_url); ?>" target="_blank" class="btn btn-secondary btn-sm" style="margin-top:.5rem">Product Link ↗</a></div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php if($instantOrder->specifications): ?>
    <div class="card">
        <div class="card-header"><?php echo e(__('messages.specifications')); ?></div>
        <div class="card-body">
            <p style="font-size:.9rem;color:var(--text-secondary);white-space:pre-line"><?php echo e($instantOrder->specifications); ?></p>
        </div>
    </div>
    <?php endif; ?>
</div>

<div class="d-flex gap-1">
    <a href="<?php echo e(route('admin.instant-orders.reservations', $instantOrder)); ?>" class="btn btn-primary">
        <?php echo e(__('messages.reservations')); ?> (<?php echo e($instantOrder->reservations->count()); ?>)
    </a>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\user\Desktop\wein-project 0.9\wein-projectzip\resources\views/admin/instant-orders/show.blade.php ENDPATH**/ ?>