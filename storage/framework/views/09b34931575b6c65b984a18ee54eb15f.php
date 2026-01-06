

<?php $__env->startSection('title', 'Dashboard Penjual'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-8">
    <div class="bg-gradient-to-r from-primary to-blue-600 rounded-3xl p-8 text-white relative overflow-hidden shadow-lg shadow-blue-200 dark:shadow-none">
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-center">
            <div>
                <h2 class="text-3xl font-bold mb-2">Halo, <?php echo e(auth()->user()->name); ?>! 👋</h2>
                <p class="text-blue-100 text-lg opacity-90">Siap untuk menjual barang hari ini?</p>
            </div>
            <div class="mt-6 md:mt-0">
                <a href="<?php echo e(route('seller.auctions.create')); ?>" class="inline-flex items-center px-6 py-3 bg-white text-primary font-bold rounded-xl shadow-lg hover:shadow-xl hover:bg-gray-50 transform hover:-translate-y-1 transition-all">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Buat Lelang Baru
                </a>
            </div>
        </div>
        <!-- Decorative circles -->
        <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-white opacity-10 rounded-full blur-2xl"></div>
        <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-40 h-40 bg-secondary opacity-20 rounded-full blur-2xl"></div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Total Auctions -->
    <div class="bg-surface p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 hover:border-primary/30 transition-colors duration-300">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-text-muted font-medium text-sm transition-colors">Total Lelang</p>
                <h3 class="text-3xl font-bold text-text-main mt-1 transition-colors"><?php echo e($stats['total_auctions'] ?? 0); ?></h3>
            </div>
            <div class="p-3 bg-blue-50 dark:bg-blue-900/30 text-primary rounded-xl transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            </div>
        </div>
    </div>

    <!-- Active Auctions -->
    <div class="bg-surface p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 hover:border-green-500/30 transition-colors duration-300">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-text-muted font-medium text-sm transition-colors">Lelang Aktif</p>
                <h3 class="text-3xl font-bold text-text-main mt-1 transition-colors"><?php echo e($stats['active_auctions'] ?? 0); ?></h3>
            </div>
            <div class="p-3 bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400 rounded-xl transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
    </div>

    <!-- Revenue -->
    <div class="bg-surface p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 hover:border-accent/30 transition-colors duration-300">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-text-muted font-medium text-sm transition-colors">Estimasi Pendapatan</p>
                <h3 class="text-2xl font-bold text-text-main mt-1 transition-colors">Rp <?php echo e(number_format($stats['estimated_revenue'] ?? 0, 0, ',', '.')); ?></h3>
            </div>
            <div class="p-3 bg-orange-50 dark:bg-orange-900/30 text-accent rounded-xl transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
    </div>
</div>

<div class="bg-surface rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 transition-colors duration-300">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-bold text-text-main transition-colors">Lelang Anda</h3>
        <a href="<?php echo e(route('seller.auctions.index')); ?>" class="text-sm text-primary hover:text-blue-700 font-medium">Lihat Semua</a>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead>
                <tr class="bg-gray-50/50 dark:bg-gray-800/50 transition-colors">
                    <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase rounded-l-lg transition-colors">Barang</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase transition-colors">Harga Saat Ini</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase transition-colors">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase transition-colors">Tawaran</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold text-text-muted uppercase rounded-r-lg transition-colors">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 dark:divide-gray-700 transition-colors">
                <?php $__empty_1 = true; $__currentLoopData = $myAuctions ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $auction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="group hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                    <td class="px-4 py-4">
                        <div class="flex items-center">
                            <div class="h-10 w-10 rounded-lg bg-gray-200 dark:bg-gray-700 overflow-hidden flex-shrink-0 transition-colors">
                                <?php if($auction->images->first()): ?>
                                    <img src="<?php echo e(asset('storage/' . $auction->images->first()->image_path)); ?>" class="h-full w-full object-cover">
                                <?php endif; ?>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-text-main transition-colors"><?php echo e(Str::limit($auction->title, 30)); ?></p>
                                <p class="text-xs text-text-muted transition-colors"><?php echo e($auction->created_at->format('d M Y')); ?></p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-4 text-sm font-bold text-text-main transition-colors">Rp <?php echo e(number_format($auction->current_price, 0, ',', '.')); ?></td>
                    <td class="px-4 py-4">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full <?php echo e($auction->status == 'active' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-400'); ?>">
                            <?php echo e(ucfirst($auction->status)); ?>

                        </span>
                    </td>
                    <td class="px-4 py-4 text-sm text-text-muted transition-colors"><?php echo e($auction->bids_count ?? 0); ?></td>
                    <td class="px-4 py-4 text-right">
                        <a href="<?php echo e(route('seller.auctions.edit', $auction)); ?>" class="text-primary hover:text-blue-800 text-sm font-medium">Edit</a>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" class="px-4 py-8 text-center text-text-muted transition-colors">Anda belum memiliki lelang.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LENOVO\Desktop\TB\TB-PRAKWEB-SILEBAR\resources\views/seller/dashboard.blade.php ENDPATH**/ ?>