<?php $__env->startSection('title', __('messages.instant_orders')); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h1>⚡ <?php echo e(__('messages.instant_orders')); ?></h1>
    <div class="view-toggle">
        <button data-view="card" class="active" title="Card View">⊞</button>
        <button data-view="list" title="List View">☰</button>
    </div>
</div>

<?php if($products->isEmpty()): ?>
    <div class="empty-state">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
        <p><?php echo e(__('messages.no_data')); ?></p>
    </div>
<?php else: ?>
    <div id="products-container" class="products-grid">
        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="product-card">
            <?php if($product->image_url): ?>
                <img src="<?php echo e($product->image_url); ?>" alt="<?php echo e($product->title); ?>" loading="lazy">
            <?php else: ?>
                <div style="height:180px;background:var(--bg-primary);display:flex;align-items:center;justify-content:center;font-size:3rem;color:var(--text-muted)">📦</div>
            <?php endif; ?>
            <div class="product-body">
                <div class="product-title"><?php echo e($product->title); ?></div>
                <?php if($product->description): ?>
                    <p style="font-size:.85rem;color:var(--text-muted);margin:.4rem 0"><?php echo e(Str::limit($product->description, 80)); ?></p>
                <?php endif; ?>
                <div class="d-flex align-center" style="justify-content:space-between;margin-top:.75rem;flex-wrap:wrap;gap:.5rem">
                    <div>
                        <div class="product-price"><?php echo e(number_format($product->price, 2)); ?></div>
                        <small class="text-muted">+<?php echo e(number_format($product->delivery_price, 2)); ?> delivery · <?php echo e($product->quantity); ?> left</small>
                    </div>
                    <button class="btn btn-primary btn-sm" onclick="openReserveModal(<?php echo e($product->id); ?>, '<?php echo e(addslashes($product->title)); ?>', <?php echo e($product->quantity); ?>)">
                        <?php echo e(__('messages.reserve')); ?>

                    </button>
                </div>
                <?php if($product->product_url): ?>
                    <a href="<?php echo e($product->product_url); ?>" target="_blank" class="btn btn-secondary btn-sm" style="margin-top:.5rem;width:100%">View Product ↗</a>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php endif; ?>


<div class="modal-overlay" id="reserve-modal">
    <div class="modal" style="max-width:500px">
        <div class="modal-header">
            <span><?php echo e(__('messages.reserve')); ?>: <span id="modal-product-title"></span></span>
            <button class="modal-close" onclick="closeModal('reserve-modal')">✕</button>
        </div>
        <form method="POST" id="reserve-form" action="">
            <?php echo csrf_field(); ?>
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label"><?php echo e(__('messages.customer_name')); ?> *</label>
                        <input type="text" name="customer_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label"><?php echo e(__('messages.phone_number')); ?> *</label>
                        <input type="text" name="phone_number" class="form-control" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label"><?php echo e(__('messages.quantity')); ?> *</label>
                        <input type="number" name="quantity" id="reserve-qty" class="form-control" value="1" min="1" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label"><?php echo e(__('messages.location')); ?></label>
                        <input type="text" name="location" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label"><?php echo e(__('messages.notes')); ?></label>
                    <textarea name="notes" class="form-control" rows="2"></textarea>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label"><?php echo e(__('messages.password')); ?> *</label>
                        <input type="password" name="password" class="form-control" required minlength="4" placeholder="Min 4 chars">
                    </div>
                    <div class="form-group">
                        <label class="form-label"><?php echo e(__('messages.password_confirm')); ?> *</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                </div>
                <div class="alert alert-info" style="font-size:.85rem">
                    💡 Save your phone and password — you'll need them to manage your reservation.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('reserve-modal')"><?php echo e(__('messages.cancel')); ?></button>
                <button type="submit" class="btn btn-primary"><?php echo e(__('messages.submit')); ?></button>
            </div>
        </form>
    </div>
</div>


<div style="margin-top:2rem;text-align:center">
    <button class="btn btn-secondary" onclick="openModal('access-reservation-modal')">
        🔑 <?php echo e(__('messages.view_my_order')); ?>

    </button>
</div>

<div class="modal-overlay" id="access-reservation-modal">
    <div class="modal" style="max-width:440px">
        <div class="modal-header">
            <span><?php echo e(__('messages.my_order_access')); ?></span>
            <button class="modal-close" onclick="closeModal('access-reservation-modal')">✕</button>
        </div>
        <form method="POST" action="<?php echo e(route('reservations.authenticate')); ?>">
            <?php echo csrf_field(); ?>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label"><?php echo e(__('messages.phone_number')); ?></label>
                    <input type="text" name="phone_number" class="form-control" value="<?php echo e(old('phone_number')); ?>" required placeholder="أدخل رقم هاتفك">
                </div>
                <div class="form-group">
                    <label class="form-label"><?php echo e(__('messages.password')); ?></label>
                    <input type="password" name="password" class="form-control" required placeholder="كلمة المرور">
                </div>
                <?php $__errorArgs = ['auth'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="alert alert-danger" style="font-size:.85rem; margin-top:.5rem;"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('access-reservation-modal')"><?php echo e(__('messages.cancel')); ?></button>
                <button type="submit" class="btn btn-primary"><?php echo e(__('messages.submit')); ?></button>
            </div>
        </form>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
function openReserveModal(productId, productTitle, maxQty) {
    document.getElementById('modal-product-title').textContent = productTitle;
    document.getElementById('reserve-form').action = '/instant-orders/' + productId + '/reserve';
    const qtyInput = document.getElementById('reserve-qty');
    qtyInput.max = maxQty;
    qtyInput.value = 1;
    openModal('reserve-modal');
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\user\Downloads\wein-project\wein-project\resources\views/public/instant-orders/index.blade.php ENDPATH**/ ?>