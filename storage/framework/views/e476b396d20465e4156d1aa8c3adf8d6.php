

<?php $__env->startSection('title', 'Dashboard Pembeli'); ?>

<?php $__env->startSection('content'); ?>
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Main Content Col (2/3) -->
    <div class="lg:col-span-2 space-y-8">
        <!-- Welcome Banner -->
        <div class="bg-primary rounded-2xl p-6 text-white shadow-lg relative overflow-hidden">
            <div class="relative z-10">
                <h2 class="text-2xl font-bold mb-2">Selamat Datang, <?php echo e(auth()->user()->name); ?>!</h2>
                <p class="text-blue-100 mb-6 max-w-lg">Temukan barang unik dan menangkan lelang impianmu hari ini.</p>
                <a href="<?php echo e(route('auctions.index')); ?>" class="inline-block bg-white text-primary font-bold px-6 py-2.5 rounded-lg shadow-sm hover:bg-gray-50 transition-colors">
                    Mulai Belanja
                </a>
            </div>
            <div class="absolute right-0 bottom-0 w-32 h-32 bg-white opacity-10 rounded-full blur-2xl transform translate-x-10 translate-y-10"></div>
        </div>

        <!-- Recent Activity / Bids -->
        <div class="bg-surface rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 transition-colors duration-300">
            <h3 class="text-lg font-bold text-text-main mb-4 transition-colors">Aktivitas Terbaru</h3>
            <div class="space-y-4">
                <?php $__empty_1 = true; $__currentLoopData = $bidHistory ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bid): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="flex items-start p-4 bg-background rounded-xl border border-gray-100 dark:border-gray-700 transition-colors duration-300">
                    <div class="h-12 w-12 rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 flex-shrink-0 overflow-hidden">
                         <?php if($bid->auctionItem->images->first()): ?>
                            <img src="<?php echo e(asset('storage/' . $bid->auctionItem->images->first()->image_path)); ?>" class="h-full w-full object-cover">
                        <?php endif; ?>
                    </div>
                    <div class="ml-4 flex-1">
                        <p class="text-sm font-medium text-text-main transition-colors">Anda menawar pada <span class="font-bold text-primary"><?php echo e($bid->auctionItem->title); ?></span></p>
                        <p class="text-xs text-text-muted mt-1 transition-colors"><?php echo e($bid->created_at->diffForHumans()); ?></p>
                    </div>
                    <div class="text-right">
                        <span class="block text-primary font-bold">Rp <?php echo e(number_format($bid->bid_amount, 0, ',', '.')); ?></span>
                        <span class="text-xs text-text-muted transition-colors">Tawaran Anda</span>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="text-center py-6 text-text-muted transition-colors">
                    <p>Belum ada aktivitas penawaran.</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Sidebar Col (1/3) -->
    <div class="space-y-6">
        <!-- Stats Mini Cards -->
        <div class="grid grid-cols-2 gap-4">
            <div class="bg-surface p-4 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 text-center transition-colors duration-300">
                <h4 class="text-2xl font-bold text-primary"><?php echo e($stats['bids_count'] ?? 0); ?></h4>
                <p class="text-xs text-text-muted uppercase tracking-wide mt-1 transition-colors">Total Tawaran</p>
            </div>
            <div class="bg-surface p-4 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 text-center transition-colors duration-300">
                <h4 class="text-2xl font-bold text-green-600 dark:text-green-400"><?php echo e($stats['won_auctions'] ?? 0); ?></h4>
                <p class="text-xs text-text-muted uppercase tracking-wide mt-1 transition-colors">Lelang Dimenangkan</p>
            </div>
        </div>

        <!-- Followed Auctions Mini List -->
        <div class="bg-surface rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 transition-colors duration-300">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-bold text-text-main transition-colors">Lelang Diikuti</h3>
                <a href="<?php echo e(route('buyer.auctions.followed')); ?>" class="text-xs text-primary hover:underline">Lihat Semua</a>
            </div>
            <div class="space-y-3">
                 <?php $__empty_1 = true; $__currentLoopData = $followedAuctions ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $auction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                 <a href="<?php echo e(route('auctions.show', $auction)); ?>" class="flex items-center group">
                    <div class="h-10 w-10 rounded bg-gray-200 dark:bg-gray-700 overflow-hidden">
                         <?php if($auction->images->first()): ?>
                            <img src="<?php echo e(asset('storage/' . $auction->images->first()->image_path)); ?>" class="h-full w-full object-cover">
                        <?php endif; ?>
                    </div>
                    <div class="ml-3 overflow-hidden">
                        <p class="text-sm font-medium text-text-main group-hover:text-primary truncate transition-colors"><?php echo e($auction->title); ?></p>
                        <p class="text-xs text-red-500"><?php echo e($auction->time_remaining); ?> lagi</p>
                    </div>
                 </a>
                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                 <p class="text-xs text-text-muted transition-colors">Belum mengikuti lelang apapun.</p>
                 <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LENOVO\Desktop\TB\TB-PRAKWEB-SILEBAR\resources\views/buyer/dashboard.blade.php ENDPATH**/ ?>