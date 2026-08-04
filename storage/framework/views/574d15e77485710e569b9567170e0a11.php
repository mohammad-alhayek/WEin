<?php $__env->startSection('title', __('messages.orders')); ?>

<?php $__env->startSection('content'); ?>

<div class="idx-header">
    <h1 class="idx-title">📦 <?php echo e(__('messages.orders')); ?></h1>
    <a href="<?php echo e(route('admin.orders.create')); ?>" class="btn btn-primary">+ <?php echo e(__('messages.create')); ?></a>
</div>


<div class="filter-bar">
    <div class="filter-search-wrap">
        <span class="filter-icon">🔍</span>
        <input type="text" id="searchInput" class="filter-input" placeholder="<?php echo e(__('messages.search')); ?>...">
    </div>
    <select id="statusFilter" class="filter-select">
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

<div class="card">
    <div class="card-body" style="padding:0">
        <?php if($orders->isEmpty()): ?>
            <div class="empty-state"><?php echo e(__('messages.no_data')); ?></div>
        <?php else: ?>
            <div class="table-wrapper">
                <table class="table" id="ordersTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><?php echo e(__('messages.title')); ?></th>
                            <th><?php echo e(__('messages.status')); ?></th>
                            <th><?php echo e(__('messages.expected_arrival')); ?></th>
                            <th><?php echo e(__('messages.tax')); ?></th>
                            <th>Customers</th>
                            <th><?php echo e(__('messages.actions')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr data-status="<?php echo e($order->status); ?>">
                            <td><?php echo e($order->id); ?></td>
                            <td><a href="<?php echo e(route('admin.orders.show', $order)); ?>"><?php echo e($order->title); ?></a></td>
                            <td>
                                <span class="badge badge-<?php echo e(strtolower($order->status)); ?>">
                                    <?php echo e(__('messages.' . $order->status)); ?>

                                </span>
                            </td>
                            <td><?php echo e($order->expected_arrival_date?->format('d M Y') ?? '—'); ?></td>
                            <td><?php echo e($order->tax); ?>%</td>
                            <td><?php echo e($order->customer_orders_count); ?></td>
                            <td>
                                <div class="d-flex gap-1" style="flex-wrap:wrap">
                                    <a href="<?php echo e(route('admin.orders.show', $order)); ?>" class="btn btn-secondary btn-sm"><?php echo e(__('messages.view')); ?></a>
                                    <a href="<?php echo e(route('admin.orders.edit', $order)); ?>" class="btn btn-warning btn-sm"><?php echo e(__('messages.edit')); ?></a>
                                    <form id="del-order-<?php echo e($order->id); ?>" method="POST" action="<?php echo e(route('admin.orders.destroy', $order)); ?>">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button type="button" class="btn btn-danger btn-sm"
                                            onclick="confirmDelete('del-order-<?php echo e($order->id); ?>', '<?php echo e(__('messages.confirm_delete')); ?>')">
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
            <div id="noResultsRow" style="display:none" class="empty-state"><?php echo e(__('messages.no_data')); ?></div>
        <?php endif; ?>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
.idx-header{display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:1rem;margin-bottom:1.5rem}
.idx-title{margin:0;font-size:1.4rem;font-weight:800}

.filter-bar{display:flex;gap:.75rem;align-items:center;flex-wrap:wrap;margin-bottom:1rem}
.filter-search-wrap{position:relative;flex:1;min-width:180px}
.filter-icon{position:absolute;inset-inline-start:.9rem;top:50%;transform:translateY(-50%);pointer-events:none}
.filter-input{width:100%;padding:.6rem .9rem .6rem 2.4rem;border-radius:12px;border:1px solid var(--border);background:var(--bg-secondary);color:var(--text-primary);font-size:.9rem}
.filter-select{padding:.6rem .9rem;border-radius:12px;border:1px solid var(--border);background:var(--bg-secondary);color:var(--text-primary);font-size:.9rem;min-width:160px}

@media(max-width:600px){
    .filter-bar{flex-direction:column}
    .filter-input,.filter-select{width:100%}
    .table th:nth-child(4),.table td:nth-child(4),
    .table th:nth-child(5),.table td:nth-child(5){display:none}
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
(function(){
    const search  = document.getElementById('searchInput');
    const status  = document.getElementById('statusFilter');
    const rows    = document.querySelectorAll('#ordersTable tbody tr');
    const noRows  = document.getElementById('noResultsRow');

    function filterRows(){
        const kw  = search.value.toLowerCase();
        const st  = status.value;
        let visible = 0;
        rows.forEach(row => {
            const matchKw = !kw  || row.innerText.toLowerCase().includes(kw);
            const matchSt = !st  || row.getAttribute('data-status') === st;
            const show    = matchKw && matchSt;
            row.style.display = show ? '' : 'none';
            if(show) visible++;
        });
        if(noRows) noRows.style.display = visible === 0 ? '' : 'none';
    }

    search.addEventListener('input', filterRows);
    status.addEventListener('change', filterRows);
})();
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\user\Desktop\wein-project 0.9\wein-projectzip\resources\views/admin/orders/index.blade.php ENDPATH**/ ?>