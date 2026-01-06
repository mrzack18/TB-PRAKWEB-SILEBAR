<?php $__env->startSection('title', 'Notifikasi - SILEBAR'); ?>
<?php $__env->startSection('header-title', 'Notifikasi Anda'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-surface shadow rounded-lg p-6 border border-gray-100 dark:border-gray-700 transition-colors duration-300">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-text-main transition-colors">Semua Notifikasi</h2>
            <form action="<?php echo e(route('notifications.markAllAsRead')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PATCH'); ?>
                <button type="submit" class="text-sm text-primary hover:text-blue-700 dark:hover:text-blue-400 transition-colors">
                    Tandai semua sudah dibaca
                </button>
            </form>
        </div>

        <div class="space-y-4">
            <?php $__empty_1 = true; $__currentLoopData = $notifications ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="flex items-start p-4 rounded-lg border <?php echo e($notification->read_at ? 'bg-background border-gray-100 dark:border-gray-800' : 'bg-blue-50 dark:bg-blue-900/20 border-blue-100 dark:border-blue-800'); ?> transition-colors duration-300">
                <div class="flex-shrink-0 mt-0.5">
                    <span class="inline-block h-2 w-2 rounded-full <?php echo e($notification->read_at ? 'bg-gray-400' : 'bg-blue-600'); ?>"></span>
                </div>
                <div class="ml-3 flex-1">
                    <p class="text-sm font-medium text-text-main transition-colors">
                        <?php echo e($notification->message ?? 'Notifikasi Baru'); ?>

                    </p>
                    <div class="mt-1 text-xs text-text-muted flex justify-between items-center transition-colors">
                        <span><?php echo e($notification->created_at->diffForHumans()); ?></span>
                        <?php if(!$notification->read_at): ?>
                        <form action="<?php echo e(route('notifications.markAsRead', $notification->id)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PATCH'); ?>
                            <button type="submit" class="text-primary hover:underline ml-4">Tandai dibaca</button>
                        </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-text-main">Tidak ada notifikasi</h3>
                <p class="mt-1 text-sm text-text-muted">Anda akan melihat update lelang di sini.</p>
            </div>
            <?php endif; ?>
        </div>

        <div class="mt-6">
            <?php echo e($notifications->links() ?? ''); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LENOVO\Desktop\SILEBAR\resources\views/notifications/index.blade.php ENDPATH**/ ?>