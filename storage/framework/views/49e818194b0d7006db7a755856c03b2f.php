<?php $__env->startSection('title', __('messages.orders')); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h1><?php echo e(__('messages.orders')); ?></h1>
    <a href="<?php echo e(route('admin.orders.create')); ?>" class="btn btn-primary">+ <?php echo e(__('messages.create')); ?></a>
</div>

<div class="card">
    <div class="card-body" style="padding:0">
        <?php if($orders->isEmpty()): ?>
            <div class="empty-state"><?php echo e(__('messages.no_data')); ?></div>
        <?php else: ?>
            <div class="table-wrapper">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><?php echo e(__('messages.title')); ?></th>
                            <th><?php echo e(__('messages.status')); ?></th>
                            <th><?php echo e(__('messages.expected_arrival')); ?></th>
                            <th><?php echo e(__('messages.tax')); ?></th>
                            <th>Customers</th>
                            <th><?php echo e(__('messages.actions')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($order->id); ?></td>
                            <td><a href="<?php echo e(route('admin.orders.show', $order)); ?>"><?php echo e($order->title); ?></a></td>
                            <td>
                                <span class="badge badge-<?php echo e(strtolower($order->status)); ?>">
                                    <?php echo e(__('messages.' . $order->status)); ?>

                                </span>
                            </td>
                            <td><?php echo e($order->expected_arrival_date?->format('d M Y') ?? '—'); ?></td>
                            <td><?php echo e($order->tax); ?>%</td>
                            <td><?php echo e($order->customer_orders_count); ?></td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="<?php echo e(route('admin.orders.show', $order)); ?>" class="btn btn-secondary btn-sm"><?php echo e(__('messages.view')); ?></a>
                                    <a href="<?php echo e(route('admin.orders.edit', $order)); ?>" class="btn btn-warning btn-sm"><?php echo e(__('messages.edit')); ?></a>
                                    <form id="del-order-<?php echo e($order->id); ?>" method="POST" action="<?php echo e(route('admin.orders.destroy', $order)); ?>">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button type="button" class="btn btn-danger btn-sm"
                                            onclick="confirmDelete('del-order-<?php echo e($order->id); ?>', '<?php echo e(__('messages.confirm_delete')); ?>')">
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

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\user\Downloads\wein-project\wein-project\resources\views/admin/orders/index.blade.php ENDPATH**/ ?>