<?php $__env->startSection('title', __('messages.customer_orders')); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h1><?php echo e(__('messages.customer_orders')); ?></h1>
</div>

<div class="card">
    <div class="card-body" style="padding:0">
        <?php if($customerOrders->isEmpty()): ?>
            <div class="empty-state"><?php echo e(__('messages.no_data')); ?></div>
        <?php else: ?>
            <div class="table-wrapper">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><?php echo e(__('messages.customer_name')); ?></th>
                            <th><?php echo e(__('messages.phone_number')); ?></th>
                            <th>Order</th>
                            <th><?php echo e(__('messages.total_price')); ?></th>
                            <th>Modified</th>
                            <th><?php echo e(__('messages.created_at')); ?></th>
                            <th><?php echo e(__('messages.actions')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $customerOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $co): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($co->id); ?></td>
                            <td>
                                <?php echo e($co->customer_name); ?>

                                <?php if($co->is_updated): ?>
                                    <span class="badge badge-updated"><?php echo e(__('messages.order_modified')); ?></span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($co->phone_number); ?></td>
                            <td><?php echo e($co->order->title ?? '—'); ?></td>
                            <td><strong><?php echo e(number_format($co->total_price, 2)); ?></strong></td>
                            <td>
                                <?php if($co->is_updated): ?>
                                    <small><?php echo e($co->updated_by_customer_at?->format('d M H:i')); ?></small>
                                <?php else: ?>
                                    <small class="text-muted">—</small>
                                <?php endif; ?>
                            </td>
                            <td><small><?php echo e($co->created_at->format('d M Y')); ?></small></td>
                            <td>
                                <div class="d-flex gap-1">
                                    
                                    <a href="<?php echo e(route('admin.customer-orders.show', $co->id)); ?>" class="btn btn-secondary btn-sm"><?php echo e(__('messages.view')); ?></a>
                                    
                                    <form id="del-co-<?php echo e($co->id); ?>" method="POST" action="<?php echo e(route('admin.customer-orders.destroy', $co->id)); ?>">
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
            
            
            <div style="padding:1rem"><?php echo e($customerOrders->withQueryString()->links()); ?></div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\user\Downloads\wein-project\wein-project\resources\views/admin/customer-orders/index.blade.php ENDPATH**/ ?>