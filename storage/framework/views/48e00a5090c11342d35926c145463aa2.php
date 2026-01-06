

<?php $__env->startSection('title', 'Beranda - SILEBAR'); ?>

<?php $__env->startSection('content'); ?>
<!-- Hero Section -->
<div class="bg-gradient-to-br from-primary to-secondary text-white relative overflow-hidden transition-colors duration-300">
    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-32 relative z-10">
        <div class="text-center max-w-3xl mx-auto">
            <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight mb-6 leading-tight drop-shadow-sm">
                Temukan Barang Impian <br/>
                <span class="text-white/90">Harga Pas di Hati</span>
            </h1>
            <p class="text-lg md:text-xl text-blue-50 mb-10 max-w-2xl mx-auto font-medium">
                Platform lelang terpercaya dengan ribuan barang berkualitas. Tawar sekarang dan menangkan barang favoritmu.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="<?php echo e(route('auctions.index')); ?>" class="px-8 py-4 bg-surface text-primary font-bold rounded-full text-lg shadow-lg hover:bg-gray-50 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 transform">
                    Mulai Menawar
                </a>
                <a href="#" class="px-8 py-4 bg-white/20 backdrop-blur-md border border-white/30 text-white font-bold rounded-full text-lg hover:bg-white/30 transition-all">
                    Pelajari Cara Kerja
                </a>
            </div>
        </div>
    </div>
    
    <!-- Decorative blobs -->
    <div class="absolute top-0 -left-40 w-96 h-96 bg-white/20 rounded-full blur-3xl mix-blend-overlay filter opacity-50 animate-blob"></div>
    <div class="absolute bottom-0 -right-40 w-96 h-96 bg-blue-400/20 rounded-full blur-3xl mix-blend-overlay filter opacity-50 animate-blob animation-delay-2000"></div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 relative z-20">
    <!-- Categories Section -->
    <div class="bg-surface rounded-2xl shadow-xl p-8 mb-16 border border-gray-100 dark:border-gray-700 transition-colors duration-300">
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-text-main">Kategori Populer</h2>
            <div class="h-1 w-20 bg-secondary mx-auto mt-2 rounded-full"></div>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('auctions.index', ['category' => $category->id])); ?>" class="group block p-6 bg-background rounded-xl hover:bg-blue-50 dark:hover:bg-gray-800 hover:shadow-md transition-all duration-300 text-center border border-transparent hover:border-blue-100 dark:hover:border-gray-700 transform hover:-translate-y-1">
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 text-primary rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-primary group-hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
                <h3 class="text-text-main font-semibold group-hover:text-primary transition-colors"><?php echo e($category->name); ?></h3>
                <p class="text-xs text-text-muted mt-1">Lihat Barang</p>
            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    <!-- Active Auctions Section -->
    <div class="mb-16">
        <div class="flex justify-between items-end mb-8">
            <div>
                <h2 class="text-3xl font-bold text-text-main">Sedang Dilelang</h2>
                <div class="h-1 w-20 bg-primary mt-2 rounded-full"></div>
            </div>
            <a href="<?php echo e(route('auctions.index')); ?>" class="group flex items-center text-primary font-semibold hover:text-blue-700 transition-colors">
                Lihat Semua 
                <svg class="w-5 h-5 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
        </div>
        
        <?php if($auctions->count() > 0): ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            <?php $__currentLoopData = $auctions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $auction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-surface rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden hover:shadow-xl transition-all duration-300 group flex flex-col h-full">
                <!-- Image Wrapper -->
                <div class="relative overflow-hidden aspect-[4/3]">
                    <?php if($auction->images->first()): ?>
                    <img src="<?php echo e(asset('storage/' . $auction->images->first()->image_path)); ?>" alt="<?php echo e($auction->title); ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    <?php else: ?>
                    <div class="w-full h-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center group-hover:bg-gray-200 dark:group-hover:bg-gray-700 transition-colors">
                        <span class="text-gray-400 font-medium">No Image</span>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Overlay Gradient -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    
                    <!-- Category Badge -->
                    <span class="absolute top-3 left-3 bg-surface/90 backdrop-blur text-primary text-xs font-bold px-3 py-1.5 rounded-full shadow-sm">
                        <?php echo e($auction->category->name); ?>

                    </span>
                    
                    <!-- Timer Badge -->
                    <div class="absolute bottom-3 right-3 bg-red-500 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-sm flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <?php echo e($auction->time_remaining); ?>

                    </div>
                </div>

                <!-- Content -->
                <div class="p-5 flex-1 flex flex-col">
                    <h3 class="text-lg font-bold text-text-main mb-2 line-clamp-2 group-hover:text-primary transition-colors">
                        <a href="<?php echo e(route('auctions.show', $auction)); ?>">
                            <?php echo e($auction->title); ?>

                        </a>
                    </h3>
                    
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-6 h-6 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center overflow-hidden">
                            <!-- Placeholder avatar -->
                            <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 24 24"><path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 12 6.003z"/></svg>
                        </div>
                        <span class="text-sm text-text-muted truncate"><?php echo e($auction->seller->name); ?></span>
                    </div>
                    
                    <div class="mt-auto border-t border-gray-100 dark:border-gray-700 pt-4">
                        <div class="flex justify-between items-end mb-4">
                            <div>
                                <p class="text-xs text-text-muted mb-1">Penawaran saat ini</p>
                                <p class="text-lg font-bold text-primary">Rp <?php echo e(number_format($auction->current_price, 0, ',', '.')); ?></p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-text-muted mb-1"><?php echo e($auction->bids->count()); ?> bid</p>
                            </div>
                        </div>
                        
                        <a href="<?php echo e(route('auctions.show', $auction)); ?>" class="block w-full text-center py-2.5 bg-gray-900 dark:bg-primary dark:hover:bg-primary-dark text-white rounded-lg font-medium hover:bg-accent transition-colors shadow-lg shadow-gray-200 dark:shadow-none hover:shadow-orange-200">
                            Tawar Sekarang
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php else: ?>
        <div class="bg-surface rounded-2xl p-12 text-center shadow-sm border border-gray-100 dark:border-gray-700">
            <div class="w-24 h-24 bg-blue-50 dark:bg-blue-900/20 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-primary opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-text-main mb-2">Belum ada lelang aktif</h3>
            <p class="text-text-muted mb-6 max-w-md mx-auto">Saat ini belum ada barang yang sedang dilelang. Jadilah penjual pertama yang membuat lelang!</p>
            <?php if(auth()->guard()->check()): ?>
                <?php if(auth()->user()->role === 'seller'): ?>
                    <a href="<?php echo e(route('seller.auctions.create')); ?>" class="inline-flex items-center px-6 py-3 bg-primary text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Buat Lelang Baru
                    </a>
                <?php elseif(auth()->user()->role === 'buyer'): ?>
                    <a href="<?php echo e(route('auctions.index')); ?>" class="inline-flex items-center px-6 py-3 bg-primary text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                        Mulai Belanja
                    </a>
                <?php endif; ?>
            <?php else: ?>
                <a href="<?php echo e(route('login')); ?>" class="inline-flex items-center px-6 py-3 bg-primary text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Mulai Berjualan
                </a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>

    <!-- Features Section (New) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-20">
        <div class="bg-surface p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 text-center hover:shadow-lg transition-shadow">
            <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900/30 text-primary rounded-2xl flex items-center justify-center mx-auto mb-6 transform rotate-3">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-text-main mb-3">Terverifikasi & Aman</h3>
            <p class="text-text-muted">Setiap penjual dan barang telah melalui proses verifikasi ketat untuk keamanan transaksi.</p>
        </div>
        <div class="bg-surface p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 text-center hover:shadow-lg transition-shadow">
            <div class="w-16 h-16 bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 rounded-2xl flex items-center justify-center mx-auto mb-6 transform -rotate-3">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-text-main mb-3">Proses Cepat</h3>
            <p class="text-text-muted">Sistem lelang real-time memastikan Anda mendapatkan update penawaran secara instan.</p>
        </div>
        <div class="bg-surface p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 text-center hover:shadow-lg transition-shadow">
            <div class="w-16 h-16 bg-orange-100 dark:bg-orange-900/30 text-accent rounded-2xl flex items-center justify-center mx-auto mb-6 transform rotate-3">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-text-main mb-3">Pembayaran Mudah</h3>
            <p class="text-text-muted">Mendukung berbagai metode pembayaran digital yang memudahkan transaksi Anda.</p>
        </div>
    </div>
</div>

<style>
    .animate-blob {
        animation: blob 7s infinite;
    }
    .animation-delay-2000 {
        animation-delay: 2s;
    }
    @keyframes blob {
        0% { transform: translate(0px, 0px) scale(1); }
        33% { transform: translate(30px, -50px) scale(1.1); }
        66% { transform: translate(-20px, 20px) scale(0.9); }
        100% { transform: translate(0px, 0px) scale(1); }
    }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LENOVO\Desktop\TB\TB-PRAKWEB-SILEBAR\resources\views/home.blade.php ENDPATH**/ ?>