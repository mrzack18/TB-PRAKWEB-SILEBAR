<?php $__env->startSection('title', 'Lelang Diikuti - SILEBAR'); ?>
<?php $__env->startSection('header-title', 'Lelang yang Saya Ikuti'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-surface shadow rounded-lg p-6 border border-gray-100 dark:border-gray-700 transition-colors duration-300">
        <h2 class="text-xl font-semibold text-text-main mb-6 transition-colors">Barang Lelang yang Saya Ikuti</h2>
        
        <?php if($followedAuctions->count() > 0): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php $__currentLoopData = $followedAuctions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $auction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 bg-background transition-colors duration-300 hover:shadow-md">
                <?php if($auction->images->first()): ?>
                    <img src="<?php echo e(asset('storage/' . $auction->images->first()->image_path)); ?>" alt="<?php echo e($auction->title); ?>" class="w-full h-40 object-cover rounded">
                <?php else: ?>
                    <div class="bg-gray-200 dark:bg-gray-700 w-full h-40 flex items-center justify-center rounded transition-colors">
                        <span class="text-gray-500 dark:text-gray-400">No Image</span>
                    </div>
                <?php endif; ?>
                
                <h3 class="font-semibold text-text-main mt-2 text-lg line-clamp-2 transition-colors"><?php echo e(Str::limit($auction->title, 40)); ?></h3>
                
                <div class="mt-2">
                    <p class="text-sm text-text-muted transition-colors">Oleh: <?php echo e($auction->seller->name); ?></p>
                    <p class="text-sm font-bold text-primary mt-1">Rp <?php echo e(number_format($auction->current_price, 0, ',', '.')); ?></p>
                    <p class="text-xs text-text-muted mt-1 transition-colors"><?php echo e($auction->bids->count()); ?> tawaran</p>
                </div>
                
                <div class="mt-3">
                    <?php
                        $highestBid = $auction->bids()->orderBy('bid_amount', 'desc')->first();
                        $isWinner = $highestBid && $highestBid->user_id === auth()->id();
                        $transaction = $auction->transaction;
                    ?>

                    <?php if($auction->status === 'completed' && $isWinner && (!$transaction || $transaction->payment_status === 'pending')): ?>
                        <form action="<?php echo e(route('payments.create', $auction)); ?>" method="POST" class="mb-2">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="block w-full bg-green-600 text-white text-center py-2 px-4 rounded-md hover:bg-green-700 transition-colors">
                                Bayar Sekarang
                            </button>
                        </form>
                        <a href="<?php echo e(route('auctions.show', $auction)); ?>" class="block w-full bg-primary text-white text-center py-2 px-4 rounded-md hover:bg-blue-700 transition-colors">
                            Lihat Detail
                        </a>
                    <?php elseif($auction->status === 'completed' && $isWinner && $transaction && $transaction->payment_status !== 'pending'): ?>
                        <a href="<?php echo e(route('payments.show', $transaction)); ?>" class="block w-full bg-blue-600 text-white text-center py-2 px-4 rounded-md hover:bg-blue-700 transition-colors mb-2">
                            Lihat Pembayaran
                        </a>
                        <a href="<?php echo e(route('auctions.show', $auction)); ?>" class="block w-full bg-primary text-white text-center py-2 px-4 rounded-md hover:bg-blue-700 transition-colors">
                            Lihat Detail
                        </a>
                    <?php else: ?>
                        <a href="<?php echo e(route('auctions.show', $auction)); ?>" class="block w-full bg-primary text-white text-center py-2 px-4 rounded-md hover:bg-blue-700 transition-colors">
                            Lihat Detail
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        
        <div class="mt-6">
            <?php echo e($followedAuctions->links()); ?>

        </div>
        <?php else: ?>
        <div class="text-center py-8">
            <p class="text-text-muted transition-colors">Anda belum mengikuti lelang manapun</p>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LENOVO\Desktop\TB\TB-PRAKWEB-SILEBAR\resources\views/buyer/auctions/followed.blade.php ENDPATH**/ ?>