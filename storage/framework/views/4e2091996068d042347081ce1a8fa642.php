<?php $__env->startSection('title', __('messages.reservations') . ' — ' . $instantOrder->title); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div>
        <h1><?php echo e(__('messages.reservations')); ?></h1>
        <small class="text-muted"><?php echo e($instantOrder->title); ?></small>
    </div>
    <a href="<?php echo e(route('admin.instant-orders.show', $instantOrder)); ?>" class="btn btn-secondary">← <?php echo e(__('messages.back')); ?></a>
</div>

<div class="card">
    <div class="card-body" style="padding:0">
        <?php if($reservations->isEmpty()): ?>
            <div class="empty-state"><?php echo e(__('messages.no_data')); ?></div>
        <?php else: ?>
            <div class="table-wrapper">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><?php echo e(__('messages.customer_name')); ?></th>
                            <th><?php echo e(__('messages.phone_number')); ?></th>
                            <th><?php echo e(__('messages.location')); ?></th>
                            <th><?php echo e(__('messages.quantity')); ?></th>
                            <th><?php echo e(__('messages.notes')); ?></th>
                            <th><?php echo e(__('messages.created_at')); ?></th>
                            <th><?php echo e(__('messages.actions')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $reservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($r->id); ?></td>
                            <td><?php echo e($r->customer_name); ?></td>
                            <td><?php echo e($r->phone_number); ?></td>
                            <td><?php echo e($r->location ?? '—'); ?></td>
                            <td><?php echo e($r->quantity); ?></td>
                            <td><?php echo e(Str::limit($r->notes, 40) ?? '—'); ?></td>
                            <td><small><?php echo e($r->created_at->format('d M Y H:i')); ?></small></td>
                            <td>
                                <form id="del-r-<?php echo e($r->id); ?>" method="POST" action="<?php echo e(route('admin.instant-orders.reservations.destroy', $r)); ?>">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button type="button" class="btn btn-danger btn-sm"
                                        onclick="confirmDelete('del-r-<?php echo e($r->id); ?>', '<?php echo e(__('messages.confirm_delete')); ?>')">
                                        <?php echo e(__('messages.delete')); ?>

                                    </button>
                                </form>
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

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\user\Downloads\wein-project\wein-project\resources\views/admin/instant-orders/reservations.blade.php ENDPATH**/ ?>