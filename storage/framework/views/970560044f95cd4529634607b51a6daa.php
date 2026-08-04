<?php $__env->startSection('title', 'Customer Order #' . $customerOrder->id); ?>

<?php $__env->startSection('content'); ?>

<div class="page-header" style="flex-wrap:wrap;gap:.75rem">
    <div>
        <h1 style="margin:0">Customer Order #<?php echo e($customerOrder->id); ?></h1>
        <span style="color:var(--text-secondary);font-size:.9rem"><?php echo e($customerOrder->order->title ?? ''); ?></span>
    </div>
    <a href="<?php echo e(url('/')); ?>" class="btn btn-secondary">← <?php echo e(__('messages.back')); ?></a>
</div>


<div class="co-public-grid">

    
    <div class="card">
        <div class="card-header" style="background:var(--bg-secondary);padding:.75rem 1rem;font-weight:700;border-bottom:1px solid var(--border)">
            👤 <?php echo e(__('messages.customer_name')); ?>

        </div>
        <div class="card-body" style="display:flex;flex-direction:column;gap:.6rem;font-size:.9rem">
            <div class="co-info-row"><span class="co-info-label"><?php echo e(__('messages.customer_name')); ?></span><span><?php echo e($customerOrder->customer_name); ?></span></div>
            <div class="co-info-row"><span class="co-info-label"><?php echo e(__('messages.phone_number')); ?></span><span><?php echo e($customerOrder->phone_number); ?></span></div>
            <div class="co-info-row"><span class="co-info-label"><?php echo e(__('messages.location')); ?></span><span><?php echo e($customerOrder->location ?? '—'); ?></span></div>
            <div class="co-info-row"><span class="co-info-label">Order ID</span><span>#<?php echo e($customerOrder->id); ?></span></div>
            <div class="co-info-row"><span class="co-info-label"><?php echo e(__('messages.created_at')); ?></span><span><?php echo e($customerOrder->created_at->format('d M Y')); ?></span></div>
        </div>
    </div>

    
    <div class="card">
        <div class="card-header" style="background:var(--bg-secondary);padding:.75rem 1rem;font-weight:700;border-bottom:1px solid var(--border)">
            💰 Pricing
        </div>
        <div class="card-body" style="display:flex;flex-direction:column;gap:.6rem;font-size:.9rem">
            <div class="co-info-row">
                <span class="co-info-label"><?php echo e(__('messages.price')); ?></span>
                <span style="<?php echo e($customerOrder->price > 0 ? 'color:var(--success,#22c55e);font-weight:700' : 'color:var(--text-muted);font-style:italic'); ?>">
                    <?php if($customerOrder->price > 0): ?>
                        <?php echo e(number_format($customerOrder->price, 2)); ?> ر.س
                    <?php else: ?>
                        <?php echo e(__('messages.price_not_set')); ?>

                    <?php endif; ?>
                </span>
            </div>
            <div class="co-info-row"><span class="co-info-label"><?php echo e(__('messages.delivery_price')); ?></span><span><?php echo e(number_format($customerOrder->delivery_price, 2)); ?> ر.س</span></div>
            <div class="co-info-row"><span class="co-info-label"><?php echo e(__('messages.tax')); ?></span><span><?php echo e(number_format($customerOrder->order->tax ?? 0, 2)); ?>%</span></div>
            <hr style="border-color:var(--border);margin:.25rem 0">
            <div class="co-info-row" style="font-size:1rem">
                <span style="font-weight:700"><?php echo e(__('messages.total_price')); ?></span>
                <span style="font-weight:800;color:var(--primary,#3b82f6)"><?php echo e(number_format($customerOrder->total_price, 2)); ?> ر.س</span>
            </div>
        </div>
    </div>

</div>


<?php if($customerOrder->cart_url || $customerOrder->notes): ?>
<div class="card" style="margin-top:1rem">
    <div class="card-header" style="background:var(--bg-secondary);padding:.75rem 1rem;font-weight:700;border-bottom:1px solid var(--border)">📋 Order Details</div>
    <div class="card-body" style="display:flex;flex-direction:column;gap:.75rem;font-size:.9rem">
        <?php if($customerOrder->cart_url): ?>
            <div>
                <strong><?php echo e(__('messages.cart_url')); ?>:</strong>
                <a href="<?php echo e($customerOrder->cart_url); ?>" target="_blank" style="color:var(--primary,#3b82f6);word-break:break-all"><?php echo e($customerOrder->cart_url); ?></a>
            </div>
        <?php endif; ?>
        <?php if($customerOrder->notes): ?>
            <div>
                <strong><?php echo e(__('messages.notes')); ?>:</strong>
                <p style="margin-top:.25rem;color:var(--text-secondary)"><?php echo e($customerOrder->notes); ?></p>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>


<?php if($customerOrder->order && $customerOrder->order->isOpen()): ?>
<div class="card" style="margin-top:1rem">
    <div class="card-header" style="background:var(--bg-secondary);padding:.75rem 1rem;font-weight:700;border-bottom:1px solid var(--border)">✏️ <?php echo e(__('messages.edit')); ?></div>
    <div class="card-body">
        <form method="POST" action="<?php echo e(route('customer-orders.update', $customerOrder->id)); ?>">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label"><?php echo e(__('messages.cart_url')); ?></label>
                    <input type="url" name="cart_url" class="form-control" value="<?php echo e(old('cart_url', $customerOrder->cart_url)); ?>" placeholder="https://...">
                </div>
                <div class="form-group">
                    <label class="form-label"><?php echo e(__('messages.location')); ?></label>
                    <input type="text" name="location" class="form-control" value="<?php echo e(old('location', $customerOrder->location)); ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label"><?php echo e(__('messages.notes')); ?></label>
                <textarea name="notes" class="form-control"><?php echo e(old('notes', $customerOrder->notes)); ?></textarea>
            </div>
            <div class="d-flex gap-1" style="flex-wrap:wrap">
                <button type="submit" class="btn btn-primary">💾 <?php echo e(__('messages.save')); ?></button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>


<div class="mb-3" style="margin-top:1.25rem">
    <button type="button" id="openChatBtn" class="btn btn-secondary" data-order-id="<?php echo e($customerOrder->id); ?>">
        💬 استفسر عن طلبيتي
    </button>
</div>


<div id="chatModal" class="chat-modal" style="display:none">
    <div class="chat-header">
        <span>🤖 مساعد WEIN الذكي</span>
        <button type="button" id="closeChatBtn">&times;</button>
    </div>
    <div class="chat-body" id="chatBody">
        <div class="bot-message">جاري جلب تفاصيل طلبيتك...</div>
    </div>
</div>


<?php if($customerOrder->order && $customerOrder->order->isOpen()): ?>
<div style="margin-top:1.5rem;padding-top:1rem;border-top:1px solid var(--border)">
    <form id="del-my-order" method="POST" action="<?php echo e(route('customer-orders.destroy', $customerOrder->id)); ?>">
        <?php echo csrf_field(); ?>
        <?php echo method_field('DELETE'); ?>
        <button type="button" class="btn btn-danger btn-sm"
            onclick="confirmDelete('del-my-order', '<?php echo e(__('messages.confirm_delete')); ?>')">
            🗑 <?php echo e(__('messages.delete')); ?>

        </button>
    </form>
</div>
<?php endif; ?>

<?php $__env->startPush('styles'); ?>
<style>
.co-public-grid{display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1rem}
.co-info-row{display:flex;justify-content:space-between;align-items:flex-start;gap:.5rem;flex-wrap:wrap}
.co-info-label{color:var(--text-muted);font-size:.82rem;flex-shrink:0}

.chat-modal{position:fixed;bottom:20px;inset-inline-end:20px;width:340px;background:var(--bg-secondary,#161b22);border:1px solid var(--border,#30363d);border-radius:16px;box-shadow:0 10px 30px rgba(0,0,0,.5);z-index:1050;overflow:hidden}
.chat-header{background:var(--bg-tertiary,#21262d);color:#fff;padding:10px 15px;display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid var(--border,#30363d);font-size:.9rem}
.chat-header button{background:none;border:none;color:#fff;font-size:1.2rem;cursor:pointer}
.chat-body{padding:15px;color:var(--text-secondary,#c9d1d9);font-size:.85rem;line-height:1.7;max-height:320px;overflow-y:auto;white-space:pre-line}
.bot-message{background:var(--bg-primary,#0d1117);border:1px solid var(--border,#30363d);padding:10px 12px;border-radius:10px}

@media(max-width:640px){
    .co-public-grid{grid-template-columns:1fr}
    .chat-modal{width:calc(100% - 2rem);inset-inline-end:1rem;inset-inline-start:1rem}
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const openChatBtn = document.getElementById('openChatBtn');
    const chatModal   = document.getElementById('chatModal');
    const closeChatBtn= document.getElementById('closeChatBtn');
    const chatBody    = document.getElementById('chatBody');

    if (openChatBtn && chatModal) {
        openChatBtn.addEventListener('click', function() {
            const orderId = this.getAttribute('data-order-id');
            chatModal.style.display = 'block';
            chatBody.innerHTML = '<div class="bot-message">مرحباً... جاري مراجعة تفاصيل طلبيتك ⏳</div>';

            const chatUrl = "<?php echo e(route('customer-orders.chat-status', ':id')); ?>".replace(':id', orderId);

            fetch(chatUrl, {
                method: 'GET',
                headers: {'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json'}
            })
            .then(r => { if (!r.ok) throw new Error('Server error'); return r.json(); })
            .then(data => {
                chatBody.innerHTML = data.success
                    ? `<div class="bot-message">${data.message}</div>`
                    : `<div class="bot-message" style="color:#f87171">عذراً، حدث خطأ أثناء جلب بيانات الطلب.</div>`;
            })
            .catch(() => {
                chatBody.innerHTML = `<div class="bot-message" style="color:#f87171">تعذر الاتصال بالخادم.</div>`;
            });
        });

        if (closeChatBtn) closeChatBtn.addEventListener('click', () => chatModal.style.display = 'none');
    }
});
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\user\Desktop\wein-project 0.9\wein-projectzip\resources\views/public/orders/customer-order.blade.php ENDPATH**/ ?>