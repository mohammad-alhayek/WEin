<?php $__env->startSection('title', 'Customer Order — ' . $customerOrder->customer_name); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h1><?php echo e($customerOrder->customer_name); ?></h1>
    <a href="<?php echo e(route('admin.customer-orders.index')); ?>" class="btn btn-secondary">← <?php echo e(__('messages.back')); ?></a>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem">
    <div class="card">
        <div class="card-header">Customer Info</div>
        <div class="card-body">
            <div style="display:flex;flex-direction:column;gap:.6rem;font-size:.9rem">
                <div><strong><?php echo e(__('messages.customer_name')); ?>:</strong> <?php echo e($customerOrder->customer_name); ?></div>
                <div><strong><?php echo e(__('messages.phone_number')); ?>:</strong> <?php echo e($customerOrder->phone_number); ?></div>
                <div><strong><?php echo e(__('messages.location')); ?>:</strong> <?php echo e($customerOrder->location ?? '—'); ?></div>
                <div><strong>Order:</strong> <a href="<?php echo e(route('admin.orders.show', $customerOrder->orders_id)); ?>"><?php echo e($customerOrder->order->title ?? '—'); ?></a></div>
                <div><strong><?php echo e(__('messages.created_at')); ?>:</strong> <?php echo e($customerOrder->created_at->format('d M Y H:i')); ?></div>
                <?php if($customerOrder->is_updated): ?>
                    <div class="alert alert-warning" style="margin-top:.5rem">
                        ⚠ <?php echo e(__('messages.order_modified')); ?>: <?php echo e($customerOrder->updated_by_customer_at?->format('d M Y H:i')); ?>

                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Pricing</div>
        <div class="card-body">
            <div style="display:flex;flex-direction:column;gap:.6rem;font-size:.9rem">
                <div><strong><?php echo e(__('messages.price')); ?>:</strong> <?php echo e(number_format($customerOrder->price, 2)); ?></div>
                <div><strong><?php echo e(__('messages.delivery_price')); ?>:</strong> <?php echo e(number_format($customerOrder->delivery_price, 2)); ?></div>
                <div><strong><?php echo e(__('messages.tax')); ?>:</strong> <?php echo e($customerOrder->tax); ?>%</div>
                <hr style="border-color:var(--border)">
                <div style="font-size:1.1rem"><strong><?php echo e(__('messages.total_price')); ?>:</strong> <?php echo e(number_format($customerOrder->total_price, 2)); ?></div>
            </div>
        </div>
    </div>
</div>

<?php if($customerOrder->cart_url || $customerOrder->notes): ?>
<div class="card" style="margin-top:1.25rem">
    <div class="card-header">Order Details</div>
    <div class="card-body">
        <?php if($customerOrder->cart_url): ?>
            <div style="margin-bottom:.75rem">
                <strong><?php echo e(__('messages.cart_url')); ?>:</strong>
                <a href="<?php echo e($customerOrder->cart_url); ?>" target="_blank"><?php echo e($customerOrder->cart_url); ?></a>
            </div>
        <?php endif; ?>
        <?php if($customerOrder->notes): ?>
            <div>
                <strong><?php echo e(__('messages.notes')); ?>:</strong>
                <p style="margin-top:.3rem;color:var(--text-secondary)"><?php echo e($customerOrder->notes); ?></p>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\user\Downloads\wein-project\wein-project\resources\views/admin/customer-orders/show.blade.php ENDPATH**/ ?>