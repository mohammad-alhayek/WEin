<?php $__env->startSection('title', $order->title); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div>
        <h1><?php echo e($order->title); ?></h1>
        <span class="badge badge-<?php echo e(strtolower($order->status)); ?>"><?php echo e(__('messages.' . $order->status)); ?></span>
    </div>
    <div class="d-flex gap-1">
        <a href="<?php echo e(route('admin.orders.edit', $order)); ?>" class="btn btn-warning"><?php echo e(__('messages.edit')); ?></a>
        <a href="<?php echo e(route('admin.orders.index')); ?>" class="btn btn-secondary">← <?php echo e(__('messages.back')); ?></a>
    </div>
</div>


<div style="display:grid;grid-template-columns:2fr 1fr;gap:1.25rem;margin-bottom:1.5rem">
    <div class="card">
        <div class="card-header">Order Details</div>
        <div class="card-body">
            <?php if($order->description): ?>
                <p style="margin-bottom:.75rem;color:var(--text-secondary)"><?php echo e($order->description); ?></p>
            <?php endif; ?>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem;font-size:.9rem">
                <div><strong><?php echo e(__('messages.expected_arrival')); ?>:</strong> <?php echo e($order->expected_arrival_date?->format('d M Y') ?? '—'); ?></div>
                <div><strong><?php echo e(__('messages.tax')); ?>:</strong> <?php echo e($order->tax); ?>%</div>
                <div><strong>Created:</strong> <?php echo e($order->created_at->format('d M Y H:i')); ?></div>
            </div>
        </div>
    </div>

    
    <div class="card">
        <div class="card-header"><?php echo e(__('messages.change_status')); ?></div>
        <div class="card-body">
            <form method="POST" action="<?php echo e(route('admin.orders.status', $order)); ?>">
                <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                <div class="form-group">
                    <select name="status" class="form-control">
                        <?php $__currentLoopData = \App\Models\Order::STATUSES; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($s); ?>" <?php echo e($order->status === $s ? 'selected' : ''); ?>><?php echo e(__('messages.' . $s)); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary w-100"><?php echo e(__('messages.save')); ?></button>
            </form>
        </div>
    </div>
</div>


<?php if($notifications->count()): ?>
<div class="mb-3">
    <h3 style="margin-bottom:.75rem">🔔 <?php echo e(__('messages.notifications')); ?></h3>
    <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="notification-item">
            <strong><?php echo e($n->title); ?></strong>
            <p style="margin-top:.25rem;font-size:.9rem;color:var(--text-secondary)"><?php echo e($n->message); ?></p>
            <small class="text-muted"><?php echo e($n->created_at->format('d M Y H:i')); ?></small>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php endif; ?>


<div class="card">
    <div class="card-header">
        <span>👤 <?php echo e(__('messages.customer_orders')); ?> (<?php echo e($customerOrders->count()); ?>)</span>
    </div>
    <div class="card-body" style="padding:0">
        <?php if($customerOrders->isEmpty()): ?>
            <div class="empty-state"><?php echo e(__('messages.no_data')); ?></div>
        <?php else: ?>
            <div class="table-wrapper">
                <table class="table">
                    <thead>
                        <tr>
                            <th><?php echo e(__('messages.customer_name')); ?></th>
                            <th><?php echo e(__('messages.phone_number')); ?></th>
                            <th><?php echo e(__('messages.price')); ?></th>
                            <th><?php echo e(__('messages.delivery_price')); ?></th>
                            <th><?php echo e(__('messages.total_price')); ?></th>
                            <th><?php echo e(__('messages.location')); ?></th>
                            <th>Status</th>
                            <th><?php echo e(__('messages.actions')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $customerOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $co): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <?php echo e($co->customer_name); ?>

                                <?php if($co->is_updated): ?>
                                    <span class="badge badge-updated"><?php echo e(__('messages.order_modified')); ?></span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($co->phone_number); ?></td>
                            <td><?php echo e(number_format($co->price, 2)); ?></td>
                            <td><?php echo e(number_format($co->delivery_price, 2)); ?></td>
                            <td><strong><?php echo e(number_format($co->total_price, 2)); ?></strong></td>
                            <td><?php echo e($co->location ?? '—'); ?></td>
                            <td>
                                <?php if($co->cart_url): ?>
                                    <a href="<?php echo e($co->cart_url); ?>" target="_blank" class="btn btn-secondary btn-sm">Cart ↗</a>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="<?php echo e(route('admin.customer-orders.show', $co)); ?>" class="btn btn-secondary btn-sm"><?php echo e(__('messages.view')); ?></a>
                                    <form id="del-co-<?php echo e($co->id); ?>" method="POST" action="<?php echo e(route('admin.customer-orders.destroy', $co)); ?>">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button type="button" class="btn btn-danger btn-sm"
                                            onclick="confirmDelete('del-co-<?php echo e($co->id); ?>', '<?php echo e(__('messages.confirm_delete')); ?>')">
                                            <?php echo e(__('messages.delete')); ?>

                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\user\Desktop\wein-project 0.9\wein-projectzip\resources\views/admin/orders/show.blade.php ENDPATH**/ ?>