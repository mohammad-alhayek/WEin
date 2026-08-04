<?php $__env->startSection('title', __('messages.orders')); ?>

<?php $__env->startSection('content'); ?>

<div class="pub-idx-header">
    <div>
        <h1 style="margin:0;font-size:1.6rem;font-weight:800">📦 <?php echo e(__('messages.orders')); ?></h1>
        <p style="color:var(--text-muted);margin:.25rem 0 0"><?php echo e(__('messages.manage_orders')); ?></p>
    </div>
</div>


<div class="pub-filter-bar">
    <div class="pub-search-wrap">
        <span class="pub-filter-icon">🔍</span>
        <input type="text" id="searchInput" class="pub-filter-input" placeholder="<?php echo e(__('messages.search')); ?>...">
    </div>
    <select id="statusFilter" class="pub-filter-select">
        <option value=""><?php echo e(__('messages.all_statuses')); ?></option>
        <option value="Open"><?php echo e(__('messages.Open')); ?></option>
        <option value="Sorting"><?php echo e(__('messages.Sorting')); ?></option>
        <option value="Sent"><?php echo e(__('messages.Sent')); ?></option>
        <option value="Shipping"><?php echo e(__('messages.Shipping')); ?></option>
        <option value="Delivery"><?php echo e(__('messages.Delivery')); ?></option>
        <option value="Delivered"><?php echo e(__('messages.Delivered')); ?></option>
        <option value="Closed"><?php echo e(__('messages.Closed')); ?></option>
    </select>
</div>

<?php if($orders->isEmpty()): ?>
    <div class="empty-state">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
        <p><?php echo e(__('messages.no_data')); ?></p>
    </div>
<?php else: ?>
    <div id="ordersContainer" style="display:flex;flex-direction:column;gap:1rem">
        <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="card pub-order-card" data-status="<?php echo e($order->status); ?>" data-title="<?php echo e(strtolower($order->title)); ?> <?php echo e(strtolower($order->description ?? '')); ?>">
            <div class="card-body">
                <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:1rem;flex-wrap:wrap">
                    <div style="flex:1;min-width:0">
                        <div class="d-flex align-center gap-1" style="margin-bottom:.5rem;flex-wrap:wrap">
                            <h3 style="font-size:1.1rem;margin:0"><?php echo e($order->title); ?></h3>
                            <span class="badge badge-<?php echo e(strtolower($order->status)); ?>"><?php echo e(__('messages.' . $order->status)); ?></span>
                        </div>
                        <?php if($order->description): ?>
                            <p style="color:var(--text-secondary);font-size:.9rem;margin-bottom:.5rem"><?php echo e(Str::limit($order->description, 120)); ?></p>
                        <?php endif; ?>
                        <div style="font-size:.8rem;color:var(--text-muted);display:flex;gap:1.25rem;flex-wrap:wrap">
                            <?php if($order->expected_arrival_date): ?>
                                <span>📅 <?php echo e(__('messages.expected_arrival')); ?>: <?php echo e($order->expected_arrival_date->format('d M Y')); ?></span>
                            <?php endif; ?>
                            <span>👥 <?php echo e($order->customer_orders_count); ?> <?php echo e(__('messages.customer_orders')); ?></span>
                            <span>🧾 <?php echo e(__('messages.tax')); ?>: <?php echo e($order->tax); ?>%</span>
                        </div>
                    </div>
                    <div style="flex-shrink:0">
                        <a href="<?php echo e(route('orders.show', $order)); ?>" class="btn btn-primary">
                            <?php echo e(__('messages.view')); ?> →
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <div id="noResults" style="display:none" class="empty-state">
        <p><?php echo e(__('messages.no_orders_found')); ?></p>
    </div>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
.pub-idx-header{margin-bottom:1.25rem}
.pub-filter-bar{display:flex;gap:.75rem;align-items:center;flex-wrap:wrap;margin-bottom:1.25rem}
.pub-search-wrap{position:relative;flex:1;min-width:180px}
.pub-filter-icon{position:absolute;inset-inline-start:.85rem;top:50%;transform:translateY(-50%);pointer-events:none;font-size:.9rem}
.pub-filter-input{width:100%;padding:.6rem .9rem .6rem 2.2rem;border-radius:14px;border:1px solid var(--border);background:var(--bg-secondary);color:var(--text-primary);font-size:.9rem}
.pub-filter-select{padding:.6rem .9rem;border-radius:14px;border:1px solid var(--border);background:var(--bg-secondary);color:var(--text-primary);font-size:.9rem;min-width:150px}

.pub-order-card{transition:.2s}
.pub-order-card:hover{border-color:var(--primary,#3b82f6)}

@media(max-width:540px){
    .pub-filter-bar{flex-direction:column}
    .pub-filter-input,.pub-filter-select{width:100%}
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
(function(){
    const search   = document.getElementById('searchInput');
    const status   = document.getElementById('statusFilter');
    const cards    = document.querySelectorAll('.pub-order-card');
    const noResult = document.getElementById('noResults');

    function filterCards(){
        const kw  = search.value.toLowerCase();
        const st  = status.value;
        let visible = 0;
        cards.forEach(card => {
            const matchKw = !kw || card.getAttribute('data-title').includes(kw) || card.innerText.toLowerCase().includes(kw);
            const matchSt = !st || card.getAttribute('data-status') === st;
            const show    = matchKw && matchSt;
            card.style.display = show ? '' : 'none';
            if(show) visible++;
        });
        if(noResult) noResult.style.display = visible === 0 ? '' : 'none';
    }

    if(search) search.addEventListener('input', filterCards);
    if(status) status.addEventListener('change', filterCards);
})();
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\user\Desktop\wein-project 0.9\wein-projectzip\resources\views/public/orders/index.blade.php ENDPATH**/ ?>