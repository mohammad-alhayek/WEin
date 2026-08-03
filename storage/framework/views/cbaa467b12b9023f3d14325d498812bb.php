<?php $__env->startSection('title', __('messages.instant_orders')); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h1><?php echo e(__('messages.instant_orders')); ?></h1>
    <a href="<?php echo e(route('admin.instant-orders.create')); ?>" class="btn btn-primary">+ <?php echo e(__('messages.add')); ?></a>
</div>

<div class="card">
    <div class="card-body" style="padding:0">
        <?php if($products->isEmpty()): ?>
            <div class="empty-state"><?php echo e(__('messages.no_data')); ?></div>
        <?php else: ?>
            <div class="table-wrapper">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><?php echo e(__('messages.title')); ?></th>
                            <th><?php echo e(__('messages.status')); ?></th>
                            <th><?php echo e(__('messages.price')); ?></th>
                            <th><?php echo e(__('messages.quantity')); ?></th>
                            <th>Reservations</th>
                            <th><?php echo e(__('messages.actions')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($product->id); ?></td>
                            <td><?php echo e($product->title); ?></td>
                            <td>
                                <span class="badge badge-<?php echo e(strtolower($product->status)); ?>">
                                    <?php echo e(__('messages.' . $product->status)); ?>

                                </span>
                            </td>
                            <td><?php echo e(number_format($product->price, 2)); ?></td>
                            <td><?php echo e($product->quantity); ?></td>
                            <td><?php echo e($product->reservations_count); ?></td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="<?php echo e(route('admin.instant-orders.show', $product)); ?>" class="btn btn-secondary btn-sm"><?php echo e(__('messages.view')); ?></a>
                                    <a href="<?php echo e(route('admin.instant-orders.edit', $product)); ?>" class="btn btn-warning btn-sm"><?php echo e(__('messages.edit')); ?></a>
                                    <a href="<?php echo e(route('admin.instant-orders.reservations', $product)); ?>" class="btn btn-secondary btn-sm"><?php echo e(__('messages.reservations')); ?></a>
                                    <form id="del-io-<?php echo e($product->id); ?>" method="POST" action="<?php echo e(route('admin.instant-orders.destroy', $product)); ?>">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button type="button" class="btn btn-danger btn-sm"
                                            onclick="confirmDelete('del-io-<?php echo e($product->id); ?>', '<?php echo e(__('messages.confirm_delete')); ?>')">
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

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\user\Downloads\wein-project\wein-project\resources\views/admin/instant-orders/index.blade.php ENDPATH**/ ?>