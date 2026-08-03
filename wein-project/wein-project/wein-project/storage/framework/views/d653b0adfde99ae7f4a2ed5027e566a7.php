<?php $__env->startSection('title', __('messages.instant_orders')); ?>

<?php $__env->startSection('content'); ?>

<div class="idx-header">
    <h1 class="idx-title">⚡ <?php echo e(__('messages.instant_orders')); ?></h1>
    <a href="<?php echo e(route('admin.instant-orders.create')); ?>" class="btn btn-primary">+ <?php echo e(__('messages.add')); ?></a>
</div>


<div class="filter-bar">
    <div class="filter-search-wrap">
        <span class="filter-icon">🔍</span>
        <input type="text" id="searchInput" class="filter-input" placeholder="<?php echo e(__('messages.search')); ?>...">
    </div>
    <select id="statusFilter" class="filter-select">
        <option value=""><?php echo e(__('messages.all_statuses')); ?></option>
        <option value="Available"><?php echo e(__('messages.Available')); ?></option>
        <option value="SoldOut"><?php echo e(__('messages.SoldOut')); ?></option>
        <option value="Hidden"><?php echo e(__('messages.Hidden')); ?></option>
    </select>
</div>

<div class="card">
    <div class="card-body" style="padding:0">
        <?php if($products->isEmpty()): ?>
            <div class="empty-state"><?php echo e(__('messages.no_data')); ?></div>
        <?php else: ?>
            <div class="table-wrapper">
                <table class="table" id="instantTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><?php echo e(__('messages.title')); ?></th>
                            <th><?php echo e(__('messages.status')); ?></th>
                            <th><?php echo e(__('messages.price')); ?></th>
                            <th><?php echo e(__('messages.quantity')); ?></th>
                            <th>Reservations</th>
                            <th><?php echo e(__('messages.actions')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr data-status="<?php echo e($product->status); ?>">
                            <td><?php echo e($product->id); ?></td>
                            <td><?php echo e($product->title); ?></td>
                            <td>
                                <span class="badge badge-<?php echo e(strtolower($product->status)); ?>">
                                    <?php echo e(__('messages.' . $product->status)); ?>

                                </span>
                            </td>
                            <td><?php echo e(number_format($product->price, 2)); ?></td>
                            <td><?php echo e($product->quantity); ?></td>
                            <td><?php echo e($product->reservations_count); ?></td>
                            <td>
                                <div class="d-flex gap-1" style="flex-wrap:wrap">
                                    <a href="<?php echo e(route('admin.instant-orders.show', $product)); ?>" class="btn btn-secondary btn-sm"><?php echo e(__('messages.view')); ?></a>
                                    <a href="<?php echo e(route('admin.instant-orders.edit', $product)); ?>" class="btn btn-warning btn-sm"><?php echo e(__('messages.edit')); ?></a>
                                    <a href="<?php echo e(route('admin.instant-orders.reservations', $product)); ?>" class="btn btn-secondary btn-sm"><?php echo e(__('messages.reservations')); ?></a>
                                    <form id="del-io-<?php echo e($product->id); ?>" method="POST" action="<?php echo e(route('admin.instant-orders.destroy', $product)); ?>">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button type="button" class="btn btn-danger btn-sm"
                                            onclick="confirmDelete('del-io-<?php echo e($product->id); ?>', '<?php echo e(__('messages.confirm_delete')); ?>')">
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
    .table th:nth-child(4),.table td:nth-child(4){display:none}
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
(function(){
    const search = document.getElementById('searchInput');
    const status = document.getElementById('statusFilter');
    const rows   = document.querySelectorAll('#instantTable tbody tr');
    const noRows = document.getElementById('noResultsRow');

    function filterRows(){
        const kw  = search.value.toLowerCase();
        const st  = status.value;
        let visible = 0;
        rows.forEach(row => {
            const matchKw = !kw || row.innerText.toLowerCase().includes(kw);
            const matchSt = !st || row.getAttribute('data-status') === st;
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

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\user\Desktop\wein-project\wein-project\wein-project\resources\views/admin/instant-orders/index.blade.php ENDPATH**/ ?>