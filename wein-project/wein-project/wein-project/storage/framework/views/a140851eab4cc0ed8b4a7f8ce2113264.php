<?php $__env->startSection('title', 'Customer Order — ' . $customerOrder->customer_name); ?>

<?php $__env->startSection('content'); ?>

<div class="co-show-wrap">

    
    <div class="co-header">
        <div>
            <h1 class="co-title"><?php echo e($customerOrder->customer_name); ?></h1>
            <span class="co-sub">#<?php echo e($customerOrder->id); ?></span>
            <?php if($customerOrder->is_updated): ?>
                <span class="co-badge updated"><?php echo e(__('messages.order_modified')); ?></span>
            <?php endif; ?>
        </div>
        <a href="<?php echo e(route('admin.customer-orders.index')); ?>" class="btn btn-secondary">← <?php echo e(__('messages.back')); ?></a>
    </div>

    
    <div class="co-top-grid">

        
        <div class="co-card">
            <div class="co-card-head">👤 <?php echo e(__('messages.customer_name')); ?></div>
            <div class="co-card-body">
                <div class="co-row"><span class="co-lbl"><?php echo e(__('messages.customer_name')); ?></span><span class="co-val"><?php echo e($customerOrder->customer_name); ?></span></div>
                <div class="co-row"><span class="co-lbl"><?php echo e(__('messages.phone_number')); ?></span><span class="co-val"><?php echo e($customerOrder->phone_number); ?></span></div>
                <div class="co-row"><span class="co-lbl"><?php echo e(__('messages.location')); ?></span><span class="co-val"><?php echo e($customerOrder->location ?? '—'); ?></span></div>
                <div class="co-row">
                    <span class="co-lbl"><?php echo e(__('messages.order')); ?></span>
                    <span class="co-val">
                        <a href="<?php echo e(route('admin.orders.show', $customerOrder->orders_id)); ?>" style="color:#60a5fa">
                            <?php echo e($customerOrder->order->title ?? '—'); ?>

                        </a>
                    </span>
                </div>
                <div class="co-row"><span class="co-lbl"><?php echo e(__('messages.created_at')); ?></span><span class="co-val"><?php echo e($customerOrder->created_at->format('d M Y H:i')); ?></span></div>
                <?php if($customerOrder->is_updated): ?>
                    <div class="co-row">
                        <span class="co-lbl">Modified</span>
                        <span class="co-val"><?php echo e($customerOrder->updated_by_customer_at?->format('d M Y H:i')); ?></span>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        
        <div class="co-card">
            <div class="co-card-head">💰 Pricing Summary</div>
            <div class="co-card-body">
                <div class="co-row">
                    <span class="co-lbl"><?php echo e(__('messages.price')); ?></span>
                    <span class="co-val <?php echo e($customerOrder->price > 0 ? 'price-set' : 'price-pending'); ?>">
                        <?php if($customerOrder->price > 0): ?>
                            <?php echo e(number_format($customerOrder->price, 2)); ?> ر.س
                        <?php else: ?>
                            <?php echo e(__('messages.price_not_set')); ?>

                        <?php endif; ?>
                    </span>
                </div>
                <div class="co-row"><span class="co-lbl"><?php echo e(__('messages.delivery_price')); ?></span><span class="co-val"><?php echo e(number_format($customerOrder->delivery_price, 2)); ?> ر.س</span></div>
                <div class="co-row"><span class="co-lbl"><?php echo e(__('messages.tax')); ?></span><span class="co-val"><?php echo e($customerOrder->tax); ?>%</span></div>
                <hr class="co-divider">
                <div class="co-row co-total-row">
                    <span class="co-lbl"><?php echo e(__('messages.total_price')); ?></span>
                    <span class="co-val co-total-val"><?php echo e(number_format($customerOrder->total_price, 2)); ?> ر.س</span>
                </div>
            </div>
        </div>

    </div>

    
    <div class="co-card co-price-form-card">
        <div class="co-card-head">✏️ <?php echo e(__('messages.set_customer_price')); ?></div>
        <div class="co-card-body">
            <?php if(session('success')): ?>
                <div class="alert alert-success mb-3">✓ <?php echo e(session('success')); ?></div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('admin.customer-orders.update-price', $customerOrder->id)); ?>">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PATCH'); ?>
                <div class="price-form-row">
                    <div class="price-input-wrap">
                        <label class="price-label"><?php echo e(__('messages.price')); ?> (ر.س)</label>
                        <input
                            type="number"
                            name="price"
                            class="form-control price-input <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            value="<?php echo e(old('price', number_format($customerOrder->price, 2, '.', ''))); ?>"
                            step="0.01"
                            min="0"
                            placeholder="0.00"
                            required
                        >
                        <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="price-preview">
                        <div class="preview-row">
                            <span><?php echo e(__('messages.delivery_price')); ?></span>
                            <span><?php echo e(number_format($customerOrder->delivery_price, 2)); ?> ر.س</span>
                        </div>
                        <div class="preview-row">
                            <span><?php echo e(__('messages.tax')); ?></span>
                            <span><?php echo e($customerOrder->tax); ?>%</span>
                        </div>
                        <div class="preview-row preview-total">
                            <span><?php echo e(__('messages.total_price')); ?></span>
                            <span id="calc-total">—</span>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary price-submit-btn">
                        💾 <?php echo e(__('messages.set_price')); ?>

                    </button>
                </div>
            </form>
        </div>
    </div>

    
    <?php if($customerOrder->cart_url || $customerOrder->notes): ?>
    <div class="co-card">
        <div class="co-card-head">📋 Order Details</div>
        <div class="co-card-body">
            <?php if($customerOrder->cart_url): ?>
                <div class="co-row">
                    <span class="co-lbl"><?php echo e(__('messages.cart_url')); ?></span>
                    <span class="co-val"><a href="<?php echo e($customerOrder->cart_url); ?>" target="_blank" style="color:#60a5fa;word-break:break-all"><?php echo e($customerOrder->cart_url); ?></a></span>
                </div>
            <?php endif; ?>
            <?php if($customerOrder->notes): ?>
                <div class="co-row" style="flex-direction:column;gap:.4rem">
                    <span class="co-lbl"><?php echo e(__('messages.notes')); ?></span>
                    <p style="color:var(--text-secondary);margin:0"><?php echo e($customerOrder->notes); ?></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
.co-show-wrap{display:flex;flex-direction:column;gap:1.5rem}

.co-header{
    display:flex;justify-content:space-between;align-items:flex-start;
    flex-wrap:wrap;gap:1rem;
    background:linear-gradient(135deg,#161b22,#1c2128);
    border:1px solid #30363d;border-radius:20px;padding:1.5rem 2rem;
}
.co-title{color:#fff;font-size:1.6rem;font-weight:800;margin:0}
.co-sub{color:#8b949e;font-size:.9rem;display:block;margin-top:.2rem}
.co-badge{display:inline-block;padding:.3rem .8rem;border-radius:999px;font-size:.75rem;font-weight:700;margin-inline-start:.5rem}
.co-badge.updated{background:rgba(234,179,8,.15);color:#facc15}

.co-top-grid{display:grid;grid-template-columns:1fr 1fr;gap:1.5rem}

.co-card{background:linear-gradient(180deg,#161b22,#11161c);border:1px solid #30363d;border-radius:20px;overflow:hidden}
.co-card-head{background:#0d1117;border-bottom:1px solid #30363d;padding:1rem 1.5rem;color:#c9d1d9;font-weight:700;font-size:.95rem}
.co-card-body{padding:1.25rem 1.5rem;display:flex;flex-direction:column;gap:.75rem}

.co-row{display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:.5rem}
.co-lbl{color:#8b949e;font-size:.85rem}
.co-val{color:#e6edf3;font-weight:600;font-size:.9rem;text-align:end}

.co-divider{border-color:#30363d;margin:.25rem 0}
.co-total-row{margin-top:.25rem}
.co-total-val{color:#34d399;font-size:1.1rem;font-weight:800}
.price-set{color:#34d399}
.price-pending{color:#f59e0b;font-style:italic}

/* Price form */
.co-price-form-card{}
.price-form-row{display:flex;gap:1.25rem;align-items:flex-end;flex-wrap:wrap}
.price-input-wrap{flex:0 0 180px}
.price-label{display:block;color:#8b949e;font-size:.85rem;margin-bottom:.5rem;font-weight:600}
.price-input{font-size:1.1rem;font-weight:700;text-align:center}
.price-preview{flex:1;background:#0d1117;border:1px solid #30363d;border-radius:14px;padding:1rem;min-width:200px}
.preview-row{display:flex;justify-content:space-between;color:#8b949e;font-size:.85rem;padding:.25rem 0}
.preview-total{color:#e6edf3;font-weight:700;border-top:1px solid #30363d;margin-top:.5rem;padding-top:.5rem}
.price-submit-btn{white-space:nowrap;padding:.75rem 1.5rem}

@media(max-width:768px){
    .co-top-grid{grid-template-columns:1fr}
    .co-header{flex-direction:column}
    .price-form-row{flex-direction:column}
    .price-input-wrap{flex:none;width:100%}
    .price-preview{width:100%}
    .price-submit-btn{width:100%}
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const priceInput = document.querySelector('input[name="price"]');
    const calcTotal  = document.getElementById('calc-total');
    const delivery   = <?php echo e((float)$customerOrder->delivery_price); ?>;
    const tax        = <?php echo e((float)$customerOrder->tax); ?>;

    function recalc() {
        const price    = parseFloat(priceInput.value) || 0;
        const subtotal = price + delivery;
        const total    = subtotal + (subtotal * tax / 100);
        calcTotal.textContent = total.toFixed(2) + ' ر.س';
    }

    priceInput.addEventListener('input', recalc);
    recalc();
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\user\Desktop\wein-project\wein-project\wein-project\resources\views/admin/customer-orders/show.blade.php ENDPATH**/ ?>