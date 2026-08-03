<?php $__env->startSection('title', $order->title); ?>

<?php $__env->startSection('content'); ?>

<div class="page-header">
    <div>
        <h1><?php echo e($order->title); ?></h1>
        <span class="badge badge-<?php echo e(strtolower($order->status)); ?>"><?php echo e(__('messages.' . $order->status)); ?></span>
    </div>
    <a href="<?php echo e(route('home')); ?>" class="btn btn-secondary">← <?php echo e(__('messages.back')); ?></a>
</div>


<div class="card mb-3">
    <div class="card-body">
        <?php if($order->description): ?>
            <p style="color:var(--text-secondary);margin-bottom:.75rem"><?php echo e($order->description); ?></p>
        <?php endif; ?>
        <div style="font-size:.85rem;color:var(--text-muted);display:flex;gap:1.5rem;flex-wrap:wrap">
            <?php if($order->expected_arrival_date): ?>
                <span>📅 <?php echo e(__('messages.expected_arrival')); ?>: <?php echo e($order->expected_arrival_date->format('d M Y')); ?></span>
            <?php endif; ?>
            <span>🧾 <?php echo e(__('messages.tax')); ?>: <?php echo e($order->tax); ?>%</span>
        </div>
    </div>
</div>


<?php if($notifications->count()): ?>
<div class="mb-3">
    <h3 style="margin-bottom:.75rem;font-size:1rem">🔔 <?php echo e(__('messages.notifications')); ?></h3>
    <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="notification-item">
            <strong><?php echo e($n->title); ?></strong>
            <p style="margin-top:.2rem;font-size:.9rem"><?php echo e($n->message); ?></p>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php endif; ?>


<div class="d-flex gap-1 mb-3" style="flex-wrap:wrap">
    <?php if($order->isOpen()): ?>
        <button class="btn btn-primary" onclick="openModal('add-order-modal')">
            + <?php echo e(__('messages.add_customer_order')); ?>

        </button>
    <?php endif; ?>
    <button class="btn btn-secondary" onclick="openModal('access-order-modal')">
        🔑 <?php echo e(__('messages.view_my_order')); ?>

    </button>
</div>


<div class="modal-overlay" id="add-order-modal">
    <div class="modal">
        <div class="modal-header">
            <span><?php echo e(__('messages.add_customer_order')); ?></span>
            <button class="modal-close" onclick="closeModal('add-order-modal')">✕</button>
        </div>
        <form method="POST" action="<?php echo e(route('customer-orders.store', $order->id)); ?>">
            <?php echo csrf_field(); ?>
            <div class="modal-body">
                
                <?php if($errors->any() && !$errors->has('auth')): ?>
                    <div class="alert alert-danger mb-3" style="font-size:.85rem;">
                        <ul style="margin:0; padding-inline-start: 1rem;">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label"><?php echo e(__('messages.customer_name')); ?> *</label>
                        <input type="text" name="customer_name" class="form-control" value="<?php echo e(old('customer_name')); ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label"><?php echo e(__('messages.phone_number')); ?> *</label>
                        <input type="text" name="phone_number" class="form-control" value="<?php echo e(old('phone_number')); ?>" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label"><?php echo e(__('messages.cart_url')); ?></label>
                    <input type="url" name="cart_url" class="form-control" value="<?php echo e(old('cart_url')); ?>" placeholder="https://...">
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label"><?php echo e(__('messages.price')); ?> *</label>
                        <input type="number" id="price_input" name="price" class="form-control" value="<?php echo e(old('price', 0)); ?>" step="0.01" min="0" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label"><?php echo e(__('messages.select_city')); ?></label>
                        <select id="delivery_area_id" name="delivery_area_id" class="form-control">
                            <option value="" data-price="0">— <?php echo e(__('messages.select_city')); ?> —</option>
                            <?php $__currentLoopData = $deliveryAreas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($area->id); ?>" data-price="<?php echo e($area->delivery_price); ?>" <?php echo e(old('delivery_area_id') == $area->id ? 'selected' : ''); ?>>
                                    <?php echo e($area->city_name); ?> (<?php echo e(number_format($area->delivery_price, 2)); ?>)
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="d-flex align-center gap-1 mb-2" style="font-size:.85rem;color:var(--text-muted)">
                    <span><?php echo e(__('messages.delivery_price')); ?>: <strong id="delivery-price-display">0.00</strong></span>
                    <span style="margin-inline-start:1rem"><?php echo e(__('messages.total_price')); ?>: <strong id="total-display">0.00</strong></span>
                    <input type="hidden" id="tax_pct" value="<?php echo e($order->tax); ?>">
                </div>
                <div class="form-group">
                    <label class="form-label"><?php echo e(__('messages.location')); ?></label>
                    <input type="text" name="location" class="form-control" value="<?php echo e(old('location')); ?>">
                </div>
                <div class="form-group">
                    <label class="form-label"><?php echo e(__('messages.notes')); ?></label>
                    <textarea name="notes" class="form-control"><?php echo e(old('notes')); ?></textarea>
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
                <div class="alert alert-info" style="font-size:.85rem;margin-top:.5rem">
                    💡 Save your phone and password — you'll need them to access your order later.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('add-order-modal')"><?php echo e(__('messages.cancel')); ?></button>
                <button type="submit" class="btn btn-primary"><?php echo e(__('messages.submit')); ?></button>
            </div>
        </form>
    </div>
</div>


<div class="modal-overlay" id="access-order-modal">
    <div class="modal" style="max-width:440px">
        <div class="modal-header">
            <span><?php echo e(__('messages.my_order_access')); ?></span>
            <button class="modal-close" onclick="closeModal('access-order-modal')">✕</button>
        </div>
        
        <form method="POST" action="<?php echo e(route('customer-orders.authenticate', $order->id)); ?>">
            <?php echo csrf_field(); ?>
            
            <div class="modal-body">
                
                <?php if($errors->has('auth')): ?>
                    <div class="alert alert-danger mb-3" style="font-size:.85rem; padding:.6rem .8rem;">
                        ⚠️ <?php echo e($errors->first('auth')); ?>

                    </div>
                <?php endif; ?>

                <div class="form-group">
                    <label class="form-label"><?php echo e(__('messages.phone_number')); ?> *</label>
                    <input type="text" name="phone_number" class="form-control" required placeholder="07xxxxxxxx" value="<?php echo e(old('phone_number')); ?>">
                </div>

                <div class="form-group">
                    <label class="form-label"><?php echo e(__('messages.password')); ?> *</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('access-order-modal')"><?php echo e(__('messages.cancel')); ?></button>
                <button type="submit" class="btn btn-primary"><?php echo e(__('messages.submit')); ?></button>
            </div>
        </form>
    </div>
</div>


<script>
  
    document.addEventListener('DOMContentLoaded', function() {
        // 1. التكفل بفتح المودال المناسب عند وجود أخطاء بعد الـ Refresh
        <?php if($errors->has('auth') || $errors->has('order')): ?>
            openModal('access-order-modal');
        <?php elseif($errors->any()): ?>
            openModal('add-order-modal');
        <?php endif; ?>

        // 2. احتساب الإجمالي والتوصيل أثناء إدخال الطلب الجديد
        const priceInput = document.getElementById('price_input');
        const citySelect = document.getElementById('delivery_area_id');
        const deliveryDisplay = document.getElementById('delivery-price-display');
        const totalDisplay = document.getElementById('total-display');
        const taxPct = parseFloat(document.getElementById('tax_pct')?.value || 0);

        function calculateTotals() {
            if (!priceInput || !citySelect) return;

            const price = parseFloat(priceInput.value) || 0;
            const selectedOption = citySelect.options[citySelect.selectedIndex];
            const deliveryPrice = parseFloat(selectedOption?.getAttribute('data-price') || 0);

            const subtotal = price + deliveryPrice;
            const total = subtotal + (subtotal * taxPct / 100);

            deliveryDisplay.textContent = deliveryPrice.toFixed(2);
            totalDisplay.textContent = total.toFixed(2);
        }

        if (priceInput && citySelect) {
            priceInput.addEventListener('input', calculateTotals);
            citySelect.addEventListener('change', calculateTotals);
            calculateTotals(); // تشغيل أولي للحسابات
        }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\user\Downloads\wein-project\wein-project\resources\views/public/orders/show.blade.php ENDPATH**/ ?>