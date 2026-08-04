<?php $__env->startSection('title', __('messages.dashboard')); ?>

<?php $__env->startSection('content'); ?>
<div style="display: flex; flex-direction: column; gap: 1.25rem; padding-bottom: 2rem;">
    
    
    <div style="background: rgba(59, 130, 246, 0.08); border: 1px solid rgba(255, 255, 255, 0.05); border-radius: 12px; padding: 1.25rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h1 style="font-size: 1.25rem; font-weight: bold; margin: 0 0 0.25rem 0; color: #fff;"><?php echo e(__('messages.dashboard')); ?></h1>
            <p style="font-size: 0.8rem; color: #9ca3af; margin: 0;">مرحباً بك مجدداً، إليك نظرة عامة على أحدث العمليات.</p>
        </div>
        <div style="background: rgba(16, 185, 129, 0.15); color: #34d399; padding: 0.3rem 0.7rem; border-radius: 20px; font-size: 0.75rem; font-weight: bold;">
            ● النظام فعال
        </div>
    </div>

    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 0.75rem;">
        
        <?php
            $statsList = [
                ['num' => $stats['total_orders'], 'label' => __('messages.total_orders'), 'color' => '#60a5fa'],
                ['num' => $stats['open_orders'], 'label' => __('messages.open_orders'), 'color' => '#34d399'],
                ['num' => $stats['delivered_orders'], 'label' => __('messages.delivered_orders'), 'color' => '#c084fc'],
                ['num' => $stats['total_customer_orders'], 'label' => __('messages.customer_orders'), 'color' => '#fbbf24'],
                ['num' => $stats['updated_customer_orders'], 'label' => __('messages.updated_customer_orders'), 'color' => '#f87171'],
                ['num' => $stats['total_instant_products'], 'label' => __('messages.total_instant'), 'color' => '#22d3ee'],
                ['num' => $stats['instant_reservations'], 'label' => __('messages.instant_reservations'), 'color' => '#f472b6'],
                ['num' => $stats['notifications_count'], 'label' => __('messages.notifications_count'), 'color' => '#818cf8'],
            ];
        ?>

        <?php $__currentLoopData = $statsList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div style="background: #1e1e2f; border: 1px solid rgba(255, 255, 255, 0.05); border-radius: 10px; padding: 0.85rem; display: flex; flex-direction: column; justify-content: space-between;">
                <div style="font-size: 1.4rem; font-weight: bold; color: <?php echo e($stat['color']); ?>; line-height: 1.2;">
                    <?php echo e($stat['num']); ?>

                </div>
                <div style="font-size: 0.75rem; color: #9ca3af; margin-top: 0.3rem;">
                    <?php echo e($stat['label']); ?>

                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    
    <div style="display: grid; grid-template-columns: 1fr; gap: 1.25rem;">
        
        
        <div class="card" style="border-radius: 12px; overflow: hidden; background: #1e1e2f; border: 1px solid rgba(255, 255, 255, 0.05);">
            <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; border-bottom: 1px solid rgba(255, 255, 255, 0.05);">
                <span style="font-weight: bold; color: #fff;">Recent Orders</span>
                <a href="<?php echo e(route('admin.orders.index')); ?>" class="btn btn-secondary btn-sm">View All</a>
            </div>
            <div class="card-body" style="padding: 0;">
                <?php if($recentOrders->isEmpty()): ?>
                    <div class="empty-state" style="padding: 1rem; text-align: center; color: #9ca3af;"><?php echo e(__('messages.no_data')); ?></div>
                <?php else: ?>
                    <div style="width: 100%; overflow-x: auto;">
                        <table class="table" style="width: 100%; margin: 0; white-space: nowrap;">
                            <thead>
                                <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                                    <th style="padding: 0.75rem; text-align: right;"><?php echo e(__('messages.title')); ?></th>
                                    <th style="padding: 0.75rem; text-align: right;"><?php echo e(__('messages.status')); ?></th>
                                    <th style="padding: 0.75rem; text-align: right;"><?php echo e(__('messages.created_at')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr style="border-bottom: 1px solid rgba(255,255,255,0.03);">
                                    <td style="padding: 0.75rem;"><a href="<?php echo e(route('admin.orders.show', $order)); ?>" style="color: #60a5fa; text-decoration: none;"><?php echo e($order->title); ?></a></td>
                                    <td style="padding: 0.75rem;"><span class="badge badge-<?php echo e(strtolower($order->status)); ?>"><?php echo e(__('messages.' . $order->status)); ?></span></td>
                                    <td style="padding: 0.75rem;"><small style="color: #9ca3af;"><?php echo e($order->created_at->format('d M Y')); ?></small></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        
        <div class="card" style="border-radius: 12px; overflow: hidden; background: #1e1e2f; border: 1px solid rgba(255, 255, 255, 0.05);">
            <div class="card-header" style="padding: 1rem; border-bottom: 1px solid rgba(255, 255, 255, 0.05);">
                <span style="font-weight: bold; color: #fbbf24;">⚠ <?php echo e(__('messages.updated_customer_orders')); ?></span>
            </div>
            <div class="card-body" style="padding: 0;">
                <?php if($updatedOrders->isEmpty()): ?>
                    <div class="empty-state" style="padding: 1rem; text-align: center; color: #9ca3af;"><?php echo e(__('messages.no_data')); ?></div>
                <?php else: ?>
                    <div style="width: 100%; overflow-x: auto;">
                        <table class="table" style="width: 100%; margin: 0; white-space: nowrap;">
                            <thead>
                                <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                                    <th style="padding: 0.75rem; text-align: right;">Customer</th>
                                    <th style="padding: 0.75rem; text-align: right;">Order</th>
                                    <th style="padding: 0.75rem; text-align: right;">Modified</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $updatedOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $co): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr style="border-bottom: 1px solid rgba(255,255,255,0.03);">
                                    <td style="padding: 0.75rem;">
                                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                                            <a href="<?php echo e(route('admin.customer-orders.show', $co)); ?>" style="color: #60a5fa; text-decoration: none;"><?php echo e($co->customer_name); ?></a>
                                            <span class="badge badge-updated" style="font-size: 0.65rem;"><?php echo e(__('messages.order_modified')); ?></span>
                                        </div>
                                    </td>
                                    <td style="padding: 0.75rem;"><small style="color: #ccc;"><?php echo e($co->order->title ?? '—'); ?></small></td>
                                    <td style="padding: 0.75rem;"><small style="color: #9ca3af;"><?php echo e($co->updated_by_customer_at?->format('d M H:i')); ?></small></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\user\Desktop\wein-project 0.9\wein-projectzip\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>