<?php $__env->startSection('title', __('messages.notifications')); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h1><?php echo e(__('messages.notifications')); ?></h1>
    <a href="<?php echo e(route('admin.notifications.create')); ?>" class="btn btn-primary">+ <?php echo e(__('messages.create')); ?></a>
</div>

<div class="card">
    <div class="card-body" style="padding:0">
        <?php if($notifications->isEmpty()): ?>
            <div class="empty-state"><?php echo e(__('messages.no_data')); ?></div>
        <?php else: ?>
            <div class="table-wrapper">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><?php echo e(__('messages.title')); ?></th>
                            <th><?php echo e(__('messages.message')); ?></th>
                            <th>Order</th>
                            <th><?php echo e(__('messages.created_at')); ?></th>
                            <th><?php echo e(__('messages.actions')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($n->id); ?></td>
                            <td><?php echo e($n->title); ?></td>
                            <td><?php echo e(Str::limit($n->message, 60)); ?></td>
                            <td><?php echo e($n->order->title ?? '—'); ?></td>
                            <td><small><?php echo e($n->created_at->format('d M Y')); ?></small></td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="<?php echo e(route('admin.notifications.edit', $n)); ?>" class="btn btn-warning btn-sm"><?php echo e(__('messages.edit')); ?></a>
                                    <form id="del-n-<?php echo e($n->id); ?>" method="POST" action="<?php echo e(route('admin.notifications.destroy', $n)); ?>">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button type="button" class="btn btn-danger btn-sm"
                                            onclick="confirmDelete('del-n-<?php echo e($n->id); ?>', '<?php echo e(__('messages.confirm_delete')); ?>')">
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
            <div style="padding:1rem"><?php echo e($notifications->links()); ?></div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\user\Desktop\wein-project 0.9\wein-projectzip\resources\views/admin/notifications/index.blade.php ENDPATH**/ ?>