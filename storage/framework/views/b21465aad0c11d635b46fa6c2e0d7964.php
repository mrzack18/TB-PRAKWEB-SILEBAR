<?php $__env->startSection('title', $auction->title . ' - SILEBAR'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <a href="<?php echo e(route('auctions.index')); ?>" class="text-primary hover:text-blue-800 dark:hover:text-blue-400 font-medium transition-colors">&larr; Kembali ke daftar lelang</a>
    </div>

    <div class="px-4 py-6 sm:px-0">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Left Column - Images -->
            <div>
                <div class="bg-surface rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-4 transition-colors duration-300">
                    <!-- Main Image -->
                    <div class="aspect-w-1 aspect-h-1 w-full rounded-lg overflow-hidden bg-background">
                        <?php if($auction->images->first()): ?>
                        <img src="<?php echo e(asset('storage/' . $auction->images->first()->image_path)); ?>" alt="<?php echo e($auction->title); ?>" class="w-full h-96 object-contain">
                        <?php else: ?>
                        <div class="bg-gray-200 dark:bg-gray-700 w-full h-96 flex items-center justify-center transition-colors">
                            <span class="text-text-muted">No Image</span>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- Thumbnails -->
                    <?php if($auction->images->count() > 1): ?>
                    <div class="mt-4 grid grid-cols-4 gap-2">
                        <?php $__currentLoopData = $auction->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <img src="<?php echo e(asset('storage/' . $image->image_path)); ?>" alt="<?php echo e($auction->title); ?>" class="w-full h-24 object-cover cursor-pointer rounded-lg border-2 border-transparent hover:border-primary transition-colors bg-background">
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Right Column - Details -->
            <div>
                <div class="bg-surface rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 transition-colors duration-300">
                    <h1 class="text-2xl font-bold text-text-main mb-2"><?php echo e($auction->title); ?></h1>
                    
                    <div class="flex items-center mb-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 border border-blue-100 dark:border-blue-800">
                            <?php echo e($auction->category->name); ?>

                        </span>
                        <span class="ml-2 text-sm text-text-muted">oleh <?php echo e($auction->seller->name); ?></span>
                    </div>

                    <!-- Countdown Timer -->
                    <div class="bg-red-50 dark:bg-red-900/10 border-2 border-red-100 dark:border-red-900/30 rounded-xl p-4 mb-6 transition-colors" x-data="{ seconds: <?php echo e($auction->getSecondsRemainingAttribute()); ?> }" x-init="setInterval(() => { if (seconds > 0) seconds--; }, 1000)">
                        <p class="text-sm text-red-600 dark:text-red-400 font-medium">Berakhir dalam:</p>
                        <div class="flex gap-2 text-3xl font-bold text-red-600 dark:text-red-400 mt-1">
                            <div>
                                <span x-text="Math.floor(seconds / 3600).toString().padStart(2, '0')"></span>
                                <span class="text-sm font-medium">jam</span>
                            </div>
                            <div>
                                <span x-text="Math.floor((seconds % 3600) / 60).toString().padStart(2, '0')"></span>
                                <span class="text-sm font-medium">menit</span>
                            </div>
                            <div>
                                <span x-text="(seconds % 60).toString().padStart(2, '0')"></span>
                                <span class="text-sm font-medium">detik</span>
                            </div>
                        </div>
                    </div>

                    <!-- Price Information -->
                    <div class="mb-6 p-4 bg-background rounded-xl border border-gray-100 dark:border-gray-700">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-text-muted">Harga saat ini:</span>
                            <span class="text-3xl font-bold text-primary" id="current-price">Rp <?php echo e(number_format($auction->current_price, 0, ',', '.')); ?></span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-text-muted text-sm">Harga awal:</span>
                            <span class="text-lg text-text-muted line-through">Rp <?php echo e(number_format($auction->starting_price, 0, ',', '.')); ?></span>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-8">
                        <h3 class="text-lg font-bold text-text-main mb-3">Deskripsi Barang</h3>
                        <div class="prose dark:prose-invert max-w-none text-text-muted leading-relaxed">
                            <p class="whitespace-pre-line"><?php echo e($auction->description); ?></p>
                        </div>
                    </div>

                    <!-- Bidding Form -->
                    <?php if(auth()->guard()->check()): ?>
                    <?php if(auth()->user()->role === 'buyer' && $auction->status === 'active' && !$auction->isExpired): ?>
                    <div class="border-t border-gray-100 dark:border-gray-700 pt-6">
                        <h3 class="text-lg font-bold text-text-main mb-4">Ajukan Penawaran</h3>
                        <form id="bid-form" method="POST" action="<?php echo e(route('bids.store', $auction)); ?>">
                            <?php echo csrf_field(); ?>
                            <div class="flex flex-col sm:flex-row gap-4">
                                <div class="flex-1">
                                    <label for="bid_amount" class="block text-sm font-medium text-text-muted mb-2">
                                        Nominal Penawaran (Minimal: Rp <?php echo e(number_format($auction->current_price + 10000, 0, ',', '.')); ?>)
                                    </label>
                                    <div class="relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-text-muted sm:text-sm font-bold">Rp</span>
                                        </div>
                                        <input type="number" name="bid_amount" id="bid_amount" required min="<?php echo e($auction->current_price + 10000); ?>" class="block w-full pl-12 py-3 sm:text-sm border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-text-main placeholder-gray-400 focus:ring-primary focus:border-primary transition-colors">
                                    </div>
                                </div>
                                <div class="flex items-end">
                                    <button type="submit" class="w-full sm:w-auto inline-flex justify-center items-center px-8 py-3 border border-transparent text-base font-bold rounded-xl text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors shadow-lg shadow-blue-500/30">
                                        Ajukan Penawaran
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <?php elseif($auction->status !== 'active'): ?>
                    <div class="border-t border-gray-100 dark:border-gray-700 pt-6">
                        <div class="bg-red-50 dark:bg-red-900/10 border border-red-100 dark:border-red-900/30 text-red-600 dark:text-red-400 px-4 py-3 rounded-xl font-medium flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Lelang ini telah berakhir.
                        </div>
                    </div>
                    <?php elseif($auction->isExpired): ?>
                    <div class="border-t border-gray-100 dark:border-gray-700 pt-6">
                        <?php if($auction->status === 'completed'): ?>
                            <?php
                                $highestBid = $auction->bids()->orderBy('bid_amount', 'desc')->first();
                            ?>
                            <?php if($highestBid && $highestBid->user_id === auth()->id()): ?>
                                <!-- Winner can proceed to payment -->
                                <div class="bg-green-50 dark:bg-green-900/10 border border-green-100 dark:border-green-900/30 text-green-600 dark:text-green-400 px-4 py-3 rounded-xl font-medium flex items-center mb-4">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Selamat! Anda memenangkan lelang ini.
                                </div>
                                <form action="<?php echo e(route('payments.create', $auction)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="w-full inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-bold rounded-xl text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors shadow-lg shadow-blue-500/30">
                                        Lanjutkan ke Pembayaran
                                    </button>
                                </form>
                            <?php else: ?>
                                <div class="bg-red-50 dark:bg-red-900/10 border border-red-100 dark:border-red-900/30 text-red-600 dark:text-red-400 px-4 py-3 rounded-xl font-medium flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Waktu lelang telah habis.
                                </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <div class="bg-red-50 dark:bg-red-900/10 border border-red-100 dark:border-red-900/30 text-red-600 dark:text-red-400 px-4 py-3 rounded-xl font-medium flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Waktu lelang telah habis.
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php else: ?>
                    <div class="border-t border-gray-100 dark:border-gray-700 pt-6">
                        <div class="bg-gray-50 dark:bg-gray-800/50 border border-gray-100 dark:border-gray-700 text-text-muted px-4 py-3 rounded-xl flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Hanya pembeli yang dapat melakukan penawaran.
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php else: ?>
                    <div class="border-t border-gray-100 dark:border-gray-700 pt-6">
                        <p class="text-text-muted mb-4">Silakan login sebagai pembeli untuk melakukan penawaran.</p>
                        <a href="<?php echo e(route('login')); ?>" class="inline-flex justify-center items-center px-6 py-3 border border-transparent shadow-sm text-base font-medium rounded-xl text-white bg-primary hover:bg-primary-dark transition-colors">
                            Login untuk Menawar
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Bid History Section -->
        <div class="mt-8 bg-surface rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 transition-colors duration-300">
            <h2 class="text-xl font-bold text-text-main mb-6">Riwayat Penawaran</h2>
            <div class="space-y-3">
                <?php if($bidHistory->count() > 0): ?>
                    <?php $__currentLoopData = $bidHistory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bid): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex items-center justify-between p-4 bg-background rounded-xl border border-gray-100 dark:border-gray-800 transition-colors">
                        <div class="flex items-center gap-4">
                            <div class="flex-shrink-0">
                                <div class="h-10 w-10 rounded-full bg-primary/10 flex items-center justify-center border border-primary/20">
                                    <span class="text-sm font-bold text-primary"><?php echo e(substr($bid->user->name, 0, 1)); ?></span>
                                </div>
                            </div>
                            <div>
                                <p class="font-bold text-text-main"><?php echo e($bid->user->name); ?></p>
                                <p class="text-xs text-text-muted"><?php echo e($bid->created_at->diffForHumans()); ?></p>
                            </div>
                        </div>
                        <p class="font-bold text-primary">Rp <?php echo e(number_format($bid->bid_amount, 0, ',', '.')); ?></p>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-text-muted opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <p class="text-text-muted mt-2">Belum ada penawaran untuk barang ini.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <!-- Include Echo JS -->
    <script src="<?php echo e(asset('js/echo.js')); ?>"></script>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <!-- Set auction ID for real-time updates -->
    <div id="auction-id" data-auction-id="<?php echo e($auction->id); ?>" style="display: none;"></div>

    <!-- Set user name for bid comparison -->
    <?php if(auth()->guard()->check()): ?>
    <meta name="user-name" content="<?php echo e(auth()->user()->name); ?>">
    <?php endif; ?>

    <script>
        // Handle bid form submission
        document.addEventListener('DOMContentLoaded', function() {
            const bidForm = document.getElementById('bid-form');
            if (bidForm) {
                bidForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(bidForm);
                    const bidAmount = document.getElementById('bid_amount').value;

                    fetch('<?php echo e(route('bids.store', ['auction' => $auction->id])); ?>', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.message);
                            // Reset form
                            bidForm.reset();
                            // Update price display - though it will also update via Echo
                            document.getElementById('current-price').textContent = 'Rp ' + data.new_price.toLocaleString('id-ID');
                        } else {
                            alert('Error: ' + (data.message || 'Bid gagal'));
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat mengirim penawaran');
                    });
                });
            }
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LENOVO\Desktop\SILEBAR\resources\views/auctions/show.blade.php ENDPATH**/ ?>