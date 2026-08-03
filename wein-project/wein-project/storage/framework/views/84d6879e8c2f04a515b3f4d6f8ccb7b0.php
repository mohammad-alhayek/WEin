<?php $__env->startSection('title', __('messages.delivery_areas')); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h1><?php echo e(__('messages.delivery_areas')); ?></h1>
    <a href="<?php echo e(route('admin.delivery-areas.create')); ?>" class="btn btn-primary">+ <?php echo e(__('messages.add')); ?></a>
</div>

<div class="card" style="max-width:640px">
    <div class="card-body" style="padding:0">
        <?php if($areas->isEmpty()): ?>
            <div class="empty-state"><?php echo e(__('messages.no_data')); ?></div>
        <?php else: ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th><?php echo e(__('messages.city_name')); ?></th>
                        <th><?php echo e(__('messages.delivery_price')); ?></th>
                        <th><?php echo e(__('messages.actions')); ?></th>
                    </tr>
                </thead>
                <tbody>
                <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($area->id); ?></td>
                        <td><?php echo e($area->city_name); ?></td>
                        <td><?php echo e(number_format($area->delivery_price, 2)); ?></td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="<?php echo e(route('admin.delivery-areas.edit', $area)); ?>" class="btn btn-warning btn-sm"><?php echo e(__('messages.edit')); ?></a>
                                <form id="del-da-<?php echo e($area->id); ?>" method="POST" action="<?php echo e(route('admin.delivery-areas.destroy', $area)); ?>">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button type="button" class="btn btn-danger btn-sm"
                                        onclick="confirmDelete('del-da-<?php echo e($area->id); ?>', '<?php echo e(__('messages.confirm_delete')); ?>')">
                                        <?php echo e(__('messages.delete')); ?>

                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\user\Downloads\wein-project\wein-project\resources\views/admin/delivery-areas/index.blade.php ENDPATH**/ ?>