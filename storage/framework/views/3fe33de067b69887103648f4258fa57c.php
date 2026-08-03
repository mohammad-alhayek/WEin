<?php $__env->startSection('title', __('messages.reservation') . ' #' . $reservation->id); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div>
        <h1><?php echo e(__('messages.reservation')); ?> #<?php echo e($reservation->id); ?></h1>
        <small class="text-muted"><?php echo e($reservation->instantOrder->title ?? ''); ?></small>
    </div>
    <a href="<?php echo e(route('instant-orders.index')); ?>" class="btn btn-secondary">← <?php echo e(__('messages.back')); ?></a>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;margin-bottom:1.5rem">
    <div class="card">
        <div class="card-header">Your Info</div>
        <div class="card-body" style="font-size:.9rem;display:flex;flex-direction:column;gap:.5rem">
            <div><strong><?php echo e(__('messages.customer_name')); ?>:</strong> <?php echo e($reservation->customer_name); ?></div>
            <div><strong><?php echo e(__('messages.phone_number')); ?>:</strong> <?php echo e($reservation->phone_number); ?></div>
            <div><strong><?php echo e(__('messages.quantity')); ?>:</strong> <?php echo e($reservation->quantity); ?></div>
            <div><strong>Reservation ID:</strong> #<?php echo e($reservation->id); ?></div>
            <div><strong><?php echo e(__('messages.created_at')); ?>:</strong> <?php echo e($reservation->created_at->format('d M Y H:i')); ?></div>
        </div>
    </div>
    <?php if($reservation->instantOrder): ?>
    <div class="card">
        <div class="card-header">Product</div>
        <div class="card-body" style="font-size:.9rem;display:flex;flex-direction:column;gap:.5rem">
            <div><strong><?php echo e(__('messages.title')); ?>:</strong> <?php echo e($reservation->instantOrder->title); ?></div>
            <div><strong><?php echo e(__('messages.price')); ?>:</strong> <?php echo e(number_format($reservation->instantOrder->price, 2)); ?></div>
            <div><strong><?php echo e(__('messages.delivery_price')); ?>:</strong> <?php echo e(number_format($reservation->instantOrder->delivery_price, 2)); ?></div>
            <div><strong>Total:</strong>
                <?php echo e(number_format(($reservation->instantOrder->price + $reservation->instantOrder->delivery_price) * $reservation->quantity, 2)); ?>

            </div>
        </div>
    </div>
    <?php endif; ?>
</div>


<div class="card">
    <div class="card-header"><?php echo e(__('messages.edit')); ?> <?php echo e(__('messages.reservation')); ?></div>
    <div class="card-body">
        <form method="POST" action="<?php echo e(route('reservations.update', $reservation)); ?>">
            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
            <div class="form-group">
                <label class="form-label"><?php echo e(__('messages.location')); ?></label>
                <input type="text" name="location" class="form-control" value="<?php echo e($reservation->location); ?>">
            </div>
            <div class="form-group">
                <label class="form-label"><?php echo e(__('messages.notes')); ?></label>
                <textarea name="notes" class="form-control"><?php echo e($reservation->notes); ?></textarea>
            </div>
            <div class="d-flex gap-1" style="margin-top:.75rem">
                <button type="submit" class="btn btn-primary"><?php echo e(__('messages.save')); ?></button>
                <form id="del-reservation" method="POST" action="<?php echo e(route('reservations.destroy', $reservation)); ?>" style="display:inline">
                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button type="button" class="btn btn-danger"
                        onclick="confirmDelete('del-reservation', '<?php echo e(__('messages.confirm_delete')); ?>')">
                        <?php echo e(__('messages.delete')); ?>

                    </button>
                </form>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\user\Downloads\wein-project\wein-project\resources\views/public/instant-orders/reservation.blade.php ENDPATH**/ ?>