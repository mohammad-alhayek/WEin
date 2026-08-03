<?php $__env->startSection('title', __('messages.customer_orders')); ?>

<?php $__env->startSection('content'); ?>

<div class="customer-header-card mb-4">
    <div class="d-flex justify-content-between align-items-lg-center flex-column flex-lg-row gap-4">
        <div>
            <h1 class="customer-page-title"><?php echo e(__('messages.customer_orders')); ?></h1>
            <p class="customer-page-subtitle mb-0">Manage and monitor customer orders</p>
        </div>
        
        <form method="GET" action="<?php echo e(route('admin.customer-orders.index')); ?>" class="co-search-form">
            <div class="filter-search-wrap">
                <span class="filter-icon">🔍</span>
                <input
                    type="text"
                    name="search"
                    class="filter-input"
                    placeholder="<?php echo e(__('messages.search')); ?>..."
                    value="<?php echo e(request('search')); ?>"
                >
            </div>
            <button type="submit" class="btn btn-secondary btn-sm" style="white-space:nowrap"><?php echo e(__('messages.search')); ?></button>
            <?php if(request('search')): ?>
                <a href="<?php echo e(route('admin.customer-orders.index')); ?>" class="btn btn-secondary btn-sm">✕</a>
            <?php endif; ?>
        </form>
    </div>
</div>


<?php if($customerOrders->isEmpty()): ?>

    <div class="empty-state-card">
        <div class="empty-icon">📦</div>
        <h4><?php echo e(__('messages.no_data')); ?></h4>
        <p class="text-muted mb-0">No customer orders found.</p>
    </div>

<?php else: ?>

    <div class="customer-grid">
        <?php $__currentLoopData = $customerOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $co): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="customer-card">
            <div class="customer-card-body">

                
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                        <div class="customer-name"><?php echo e($co->customer_name); ?></div>
                        <div class="customer-id">#<?php echo e($co->id); ?></div>
                    </div>
                    <?php if($co->is_updated): ?>
                        <span class="status-badge updated"><?php echo e(__('messages.order_modified')); ?></span>
                    <?php endif; ?>
                </div>

                
                <div class="customer-info-grid">
                    <div class="info-box">
                        <span class="info-label"><?php echo e(__('messages.phone_number')); ?></span>
                        <span class="info-value"><?php echo e($co->phone_number); ?></span>
                    </div>
                    <div class="info-box">
                        <span class="info-label"><?php echo e(__('messages.order')); ?></span>
                        <span class="info-value"><?php echo e($co->order->title ?? '—'); ?></span>
                    </div>
                    <div class="info-box">
                        <span class="info-label"><?php echo e(__('messages.price')); ?></span>
                        <span class="info-value <?php echo e($co->price > 0 ? 'price-set' : 'price-pending'); ?>">
                            <?php if($co->price > 0): ?>
                                <?php echo e(number_format($co->price, 2)); ?>

                            <?php else: ?>
                                <?php echo e(__('messages.price_not_set')); ?>

                            <?php endif; ?>
                        </span>
                    </div>
                    <div class="info-box">
                        <span class="info-label"><?php echo e(__('messages.total_price')); ?></span>
                        <span class="info-value"><?php echo e(number_format($co->total_price, 2)); ?></span>
                    </div>
                </div>

                
                <div class="meta-section">
                    <div>
                        <small class="text-muted"><?php echo e(__('messages.created_at')); ?></small>
                        <div><?php echo e($co->created_at->format('d M Y')); ?></div>
                    </div>
                    <div>
                        <small class="text-muted">Modified</small>
                        <div>
                            <?php if($co->is_updated): ?>
                                <?php echo e($co->updated_by_customer_at?->format('d M H:i')); ?>

                            <?php else: ?>
                                —
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                
                <div class="actions-wrapper">
                    <a href="<?php echo e(route('admin.customer-orders.show', $co->id)); ?>" class="btn-view">
                        <?php echo e(__('messages.view')); ?>

                    </a>
                    <form id="del-co-<?php echo e($co->id); ?>" method="POST" action="<?php echo e(route('admin.customer-orders.destroy', $co->id)); ?>">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="button" class="btn-delete"
                            onclick="confirmDelete('del-co-<?php echo e($co->id); ?>', '<?php echo e(__('messages.confirm_delete')); ?>')">
                            <?php echo e(__('messages.delete')); ?>

                        </button>
                    </form>
                </div>

            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <div class="mt-4">
        <?php echo e($customerOrders->withQueryString()->links()); ?>

    </div>

<?php endif; ?>

<?php $__env->stopSection(); ?>


<?php $__env->startPush('styles'); ?>
<style>
.customer-header-card{
    background:linear-gradient(135deg,#161b22,#1c2128);
    border:1px solid #30363d;border-radius:30px;padding:2rem;
    box-shadow:0 20px 50px rgba(0,0,0,.25);
}
.customer-page-title{color:white;font-size:2rem;font-weight:800}
.customer-page-subtitle{color:#8b949e}

.co-search-form{display:flex;align-items:center;gap:.5rem;flex-wrap:wrap}
.filter-search-wrap{position:relative;flex:1;min-width:200px}
.filter-icon{position:absolute;inset-inline-start:.9rem;top:50%;transform:translateY(-50%);pointer-events:none}
.filter-input{width:100%;background:#0d1117;border:1px solid #30363d;color:white;border-radius:16px;padding:.7rem .9rem .7rem 2.4rem;font-size:.9rem}
.filter-input::placeholder{color:#8b949e}

.customer-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(340px,1fr));gap:1.8rem}

.customer-card{background:linear-gradient(180deg,#161b22,#11161c);border:1px solid #30363d;border-radius:28px;overflow:hidden;transition:.35s}
.customer-card:hover{transform:translateY(-8px);border-color:#2563eb;box-shadow:0 30px 60px rgba(0,0,0,.45)}
.customer-card-body{padding:1.8rem}
.customer-name{color:white;font-size:1.25rem;font-weight:700}
.customer-id{color:#8b949e;margin-top:.35rem}

.customer-info-grid{display:grid;grid-template-columns:1fr 1fr;gap:.75rem;margin-bottom:1.5rem}
.info-box{background:#0d1117;border:1px solid #30363d;border-radius:14px;padding:.85rem}
.info-label{display:block;color:#8b949e;font-size:.78rem;margin-bottom:.25rem}
.info-value{color:white;font-weight:600;font-size:.88rem}
.price-set{color:#34d399}
.price-pending{color:#f59e0b;font-style:italic;font-size:.8rem}

.meta-section{display:flex;justify-content:space-between;margin-bottom:1.5rem;color:white;font-size:.85rem}
.status-badge{padding:.4rem .85rem;border-radius:999px;font-size:.73rem;font-weight:700}
.status-badge.updated{background:rgba(234,179,8,.15);color:#facc15}

.actions-wrapper{display:flex;gap:.75rem}
.btn-view,.btn-delete{flex:1;border:none;border-radius:14px;padding:.85rem;text-align:center;text-decoration:none;font-weight:700;cursor:pointer}
.btn-view{background:linear-gradient(135deg,#2563eb,#1d4ed8);color:white}
.btn-delete{background:rgba(239,68,68,.15);color:#f87171}

.empty-state-card{background:#161b22;border:1px solid #30363d;border-radius:30px;padding:5rem 2rem;text-align:center}
.empty-icon{font-size:4rem;margin-bottom:1rem}

@media(max-width:992px){
    .customer-grid{grid-template-columns:1fr}
    .co-search-form{width:100%}
}
@media(max-width:480px){
    .customer-info-grid{grid-template-columns:1fr}
}
</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\user\Desktop\wein-project\wein-project\wein-project\resources\views/admin/customer-orders/index.blade.php ENDPATH**/ ?>