<?php $__env->startSection('title', __('messages.delivery_areas')); ?>

<?php $__env->startSection('content'); ?>

<div class="idx-header">
    <h1 class="idx-title">🗺 <?php echo e(__('messages.delivery_areas')); ?></h1>
    <a href="<?php echo e(route('admin.delivery-areas.create')); ?>" class="btn btn-primary">+ <?php echo e(__('messages.add')); ?></a>
</div>


<div class="filter-bar" style="margin-bottom:1rem">
    <div class="filter-search-wrap" style="max-width:400px">
        <span class="filter-icon">🔍</span>
        <input type="text" id="searchInput" class="filter-input" placeholder="<?php echo e(__('messages.search')); ?>...">
    </div>
</div>

<div class="card" style="max-width:720px">
    <div class="card-body" style="padding:0">
        <?php if($areas->isEmpty()): ?>
            <div class="empty-state"><?php echo e(__('messages.no_data')); ?></div>
        <?php else: ?>
            <table class="table" id="areasTable">
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
                            <div class="d-flex gap-1" style="flex-wrap:wrap">
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
            <div id="noResultsRow" style="display:none" class="empty-state"><?php echo e(__('messages.no_data')); ?></div>
        <?php endif; ?>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
.idx-header{display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:1rem;margin-bottom:1.5rem}
.idx-title{margin:0;font-size:1.4rem;font-weight:800}

.filter-bar{display:flex;gap:.75rem;align-items:center;flex-wrap:wrap}
.filter-search-wrap{position:relative;flex:1}
.filter-icon{position:absolute;inset-inline-start:.9rem;top:50%;transform:translateY(-50%);pointer-events:none}
.filter-input{width:100%;padding:.6rem .9rem .6rem 2.4rem;border-radius:12px;border:1px solid var(--border);background:var(--bg-secondary);color:var(--text-primary);font-size:.9rem}

@media(max-width:600px){
    .filter-search-wrap{max-width:100%!important;width:100%}
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
(function(){
    const search = document.getElementById('searchInput');
    const rows   = document.querySelectorAll('#areasTable tbody tr');
    const noRows = document.getElementById('noResultsRow');

    search.addEventListener('input', function(){
        const kw = this.value.toLowerCase();
        let visible = 0;
        rows.forEach(row => {
            const show = !kw || row.innerText.toLowerCase().includes(kw);
            row.style.display = show ? '' : 'none';
            if(show) visible++;
        });
        if(noRows) noRows.style.display = visible === 0 ? '' : 'none';
    });
})();
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\user\Desktop\wein-project\wein-project\wein-project\resources\views/admin/delivery-areas/index.blade.php ENDPATH**/ ?>