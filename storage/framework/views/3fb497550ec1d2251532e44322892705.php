

<?php $__env->startSection('title', 'Jelajahi Lelang - SILEBAR'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-end mb-10 gap-4">
        <div>
            <h1 class="text-3xl md:text-4xl font-bold text-text-main leading-tight transition-colors duration-300">
                Temukan Barang <br/>
                <span class="text-primary">Lelang Pilihan</span>
            </h1>
            <p class="mt-2 text-text-muted text-lg transition-colors duration-300">Ribuan barang unik menunggu tawaran terbaikmu.</p>
        </div>
        <div class="hidden md:block">
            <span class="inline-flex items-center px-4 py-2 rounded-full bg-blue-50 dark:bg-blue-900/30 text-primary text-sm font-medium transition-colors duration-300">
                <?php echo e($auctions->total()); ?> Barang
                <?php if(request()->has('status')): ?>
                    <?php if(request('status') == 'completed'): ?>
                        Selesai
                    <?php elseif(request('status') == 'active'): ?>
                        Aktif
                    <?php else: ?>
                        Semua
                    <?php endif; ?>
                <?php else: ?>
                    Aktif
                <?php endif; ?>
            </span>
        </div>
    </div>

    <!-- Layout Container -->
    <div class="flex flex-col lg:flex-row gap-8">
        
        <!-- Sidebar Filters -->
        <div class="w-full lg:w-1/4 flex-shrink-0">
            <div class="bg-surface rounded-2xl shadow-sm p-6 sticky top-24 border border-gray-100 dark:border-gray-700 transition-colors duration-300" x-data="{ showFilters: false }">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-bold text-lg text-text-main flex items-center transition-colors duration-300">
                        <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                        Filter
                    </h3>
                    <button @click="showFilters = !showFilters" class="lg:hidden text-text-muted hover:text-primary">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <a href="<?php echo e(route('auctions.index')); ?>" class="text-sm text-secondary hover:text-blue-600 font-medium">Reset</a>
                </div>

                <div class="lg:block" :class="showFilters ? 'block' : 'hidden'">
                    <form method="GET" action="<?php echo e(route('auctions.index')); ?>" class="space-y-6">
                        <!-- Search (Hidden but passed) -->
                        <?php if(request('search')): ?>
                            <input type="hidden" name="search" value="<?php echo e(request('search')); ?>">
                        <?php endif; ?>

                        <!-- Status (Hidden but passed) -->
                        <?php if(request('status')): ?>
                            <input type="hidden" name="status" value="<?php echo e(request('status')); ?>">
                        <?php endif; ?>

                        <!-- Sort -->
                        <div>
                            <label for="sort" class="block text-sm font-semibold text-text-main mb-2 transition-colors duration-300">Urutkan</label>
                            <div class="relative">
                                <select id="sort" name="sort" class="block w-full pl-3 pr-10 py-2.5 text-sm border-gray-200 dark:border-gray-600 focus:ring-primary focus:border-primary rounded-lg bg-gray-50 dark:bg-gray-800 text-text-main shadow-sm transition-all cursor-pointer hover:bg-white dark:hover:bg-gray-700" onchange="this.form.submit()">
                                    <option value="newest" <?php echo e(request('sort') == 'newest' ? 'selected' : ''); ?>>Terbaru</option>
                                    <option value="ending_soon" <?php echo e(request('sort') == 'ending_soon' ? 'selected' : ''); ?>>Segera Berakhir</option>
                                    <option value="price_low" <?php echo e(request('sort') == 'price_low' ? 'selected' : ''); ?>>Harga Terendah</option>
                                    <option value="price_high" <?php echo e(request('sort') == 'price_high' ? 'selected' : ''); ?>>Harga Tertinggi</option>
                                </select>
                            </div>
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="block text-sm font-semibold text-text-main mb-2 transition-colors duration-300">Status</label>
                            <div class="space-y-2">
                                <label class="flex items-center group cursor-pointer">
                                    <input type="radio" name="status" value="" <?php echo e(request('status') == '' ? 'checked' : ''); ?> class="h-4 w-4 text-primary focus:ring-primary border-gray-300 dark:border-gray-600 rounded-full cursor-pointer bg-white dark:bg-gray-800" onchange="this.form.submit()">
                                    <span class="ml-3 text-sm text-text-muted group-hover:text-primary transition-colors">Semua Status</span>
                                </label>
                                <label class="flex items-center group cursor-pointer">
                                    <input type="radio" name="status" value="active" <?php echo e(request('status') == 'active' ? 'checked' : ''); ?> class="h-4 w-4 text-primary focus:ring-primary border-gray-300 dark:border-gray-600 rounded-full cursor-pointer bg-white dark:bg-gray-800" onchange="this.form.submit()">
                                    <span class="ml-3 text-sm text-text-muted group-hover:text-primary transition-colors">Aktif</span>
                                </label>
                                <label class="flex items-center group cursor-pointer">
                                    <input type="radio" name="status" value="completed" <?php echo e(request('status') == 'completed' ? 'checked' : ''); ?> class="h-4 w-4 text-primary focus:ring-primary border-gray-300 dark:border-gray-600 rounded-full cursor-pointer bg-white dark:bg-gray-800" onchange="this.form.submit()">
                                    <span class="ml-3 text-sm text-text-muted group-hover:text-primary transition-colors">Selesai</span>
                                </label>
                            </div>
                        </div>

                        <!-- Kategori -->
                        <div>
                            <label class="block text-sm font-semibold text-text-main mb-2 transition-colors duration-300">Kategori</label>
                            <div class="space-y-2 max-h-60 overflow-y-auto custom-scrollbar">
                                <label class="flex items-center group cursor-pointer">
                                    <input type="radio" name="category" value="" <?php echo e(request('category') == '' ? 'checked' : ''); ?> class="h-4 w-4 text-primary focus:ring-primary border-gray-300 dark:border-gray-600 rounded-full cursor-pointer bg-white dark:bg-gray-800">
                                    <span class="ml-3 text-sm text-text-muted group-hover:text-primary transition-colors">Semua Kategori</span>
                                </label>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <label class="flex items-center group cursor-pointer">
                                    <input type="radio" name="category" value="<?php echo e($category->id); ?>" <?php echo e(request('category') == $category->id ? 'checked' : ''); ?> class="h-4 w-4 text-primary focus:ring-primary border-gray-300 dark:border-gray-600 rounded-full cursor-pointer bg-white dark:bg-gray-800">
                                    <span class="ml-3 text-sm text-text-muted group-hover:text-primary transition-colors flex justify-between w-full">
                                        <?php echo e($category->name); ?>

                                        
                                    </span>
                                </label>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>

                        <!-- Harga -->
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-semibold text-text-muted mb-1 transition-colors duration-300">Min Harga</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 text-xs">Rp</span>
                                    <input type="number" name="min_price" value="<?php echo e(request('min_price')); ?>" class="block w-full pl-8 pr-2 py-2 text-sm border-gray-200 dark:border-gray-600 rounded-lg focus:ring-primary focus:border-primary bg-gray-50 dark:bg-gray-800 text-text-main" placeholder="0">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-text-muted mb-1 transition-colors duration-300">Max Harga</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 text-xs">Rp</span>
                                    <input type="number" name="max_price" value="<?php echo e(request('max_price')); ?>" class="block w-full pl-8 pr-2 py-2 text-sm border-gray-200 dark:border-gray-600 rounded-lg focus:ring-primary focus:border-primary bg-gray-50 dark:bg-gray-800 text-text-main" placeholder="MAX">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-primary hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-all">
                            Terapkan Filter
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Auction Grid -->
        <div class="flex-1">
            <?php if(request('search')): ?>
            <div class="mb-6 flex items-center justify-between bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg border border-blue-100 dark:border-blue-800 transition-colors duration-300">
                <p class="text-sm text-blue-800 dark:text-blue-200">Menampilkan hasil pencarian untuk "<span class="font-bold"><?php echo e(request('search')); ?></span>"</p>
                <a href="<?php echo e(route('auctions.index')); ?>" class="text-xs text-blue-600 dark:text-blue-400 hover:text-blue-800 font-medium flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    Hapus Pencarian
                </a>
            </div>
            <?php endif; ?>

            <?php if($auctions->count() > 0): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                <?php $__currentLoopData = $auctions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $auction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-surface rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden hover:shadow-xl transition-all duration-300 group flex flex-col">
                    <!-- Image Area -->
                    <div class="relative overflow-hidden aspect-[4/3]">
                        <?php if($auction->images->first()): ?>
                            <img src="<?php echo e(asset('storage/' . $auction->images->first()->image_path)); ?>" alt="<?php echo e($auction->title); ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <?php else: ?>
                            <div class="w-full h-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center group-hover:bg-gray-200 dark:group-hover:bg-gray-700 transition-colors">
                                <span class="text-gray-400 font-medium">No Image</span>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Badges -->
                        <span class="absolute top-3 left-3 bg-surface/90 backdrop-blur text-primary text-xs font-bold px-3 py-1.5 rounded-full shadow-sm">
                            <?php echo e($auction->category->name); ?>

                        </span>

                        <?php if($auction->getSecondsRemainingAttribute() <= 3600): ?>
                        <span class="absolute top-3 right-3 bg-red-500/90 backdrop-blur text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-sm animate-pulse">
                            Segera Berakhir!
                        </span>
                        <?php endif; ?>
                    </div>

                    <!-- Content -->
                    <div class="p-5 flex-1 flex flex-col">
                        <div class="mb-3">
                            <h3 class="text-lg font-bold text-text-main leading-snug line-clamp-2 group-hover:text-primary transition-colors">
                                <a href="<?php echo e(route('auctions.show', $auction)); ?>">
                                    <?php echo e($auction->title); ?>

                                </a>
                            </h3>
                            <p class="text-sm text-text-muted mt-1 flex items-center transition-colors">
                                <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                <?php echo e($auction->seller->name); ?>

                            </p>
                        </div>

                        <div class="mt-auto pt-4 border-t border-gray-50 dark:border-gray-800">
                            <div class="flex justify-between items-end mb-4">
                                <div>
                                    <p class="text-xs text-gray-400 font-medium mb-1">Penawaran Tertinggi</p>
                                    <p class="text-lg font-bold text-primary">Rp <?php echo e(number_format($auction->current_price, 0, ',', '.')); ?></p>
                                </div>
                                <div class="text-right" x-data="{ seconds: <?php echo e($auction->getSecondsRemainingAttribute()); ?> }" x-init="setInterval(() => { if (seconds > 0) seconds--; }, 1000)">
                                    <p class="text-xs text-gray-400 font-medium mb-1">Sisa Waktu</p>
                                    <p class="text-sm font-mono font-medium text-red-500 bg-red-50 dark:bg-red-900/20 px-2 py-1 rounded" x-text="Math.floor(seconds / 3600).toString().padStart(2, '0') + ':' + Math.floor((seconds % 3600) / 60).toString().padStart(2, '0') + ':' + (seconds % 60).toString().padStart(2, '0')"></p>
                                </div>
                            </div>
                            
                            <a href="<?php echo e(route('auctions.show', $auction)); ?>" class="block w-full text-center py-2.5 bg-gray-900 dark:bg-primary dark:hover:bg-primary-dark text-white text-sm font-bold rounded-lg hover:bg-accent transition-all shadow-lg shadow-gray-200 dark:shadow-none hover:shadow-orange-200 transform hover:-translate-y-0.5">
                                Tawar Sekarang
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <!-- Pagination -->
            <div class="mt-10">
                <?php echo e($auctions->onEachSide(1)->links()); ?>

            </div>

            <?php else: ?>
            <!-- Empty State -->
            <div class="bg-surface rounded-2xl shadow-sm p-12 text-center border border-gray-100 dark:border-gray-700 transition-colors duration-300">
                <div class="w-20 h-20 bg-gray-50 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4 transition-colors">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-text-main mb-2 transition-colors">Tidak ada barang ditemukan</h3>
                <p class="text-text-muted mb-6 transition-colors">Coba ubah filter atau kata kunci pencarian Anda.</p>
                <a href="<?php echo e(route('auctions.index')); ?>" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-text-main bg-surface hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    Reset Semua Filter
                </a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    /* Custom Scrollbar for Filters */
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1;
    }
    .dark .custom-scrollbar::-webkit-scrollbar-track {
        background: #1e293b;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #ddd;
        border-radius: 4px;
    }
    .dark .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #475569;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #ccc;
    }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LENOVO\Desktop\TB\TB-PRAKWEB-SILEBAR\resources\views/auctions/index.blade.php ENDPATH**/ ?>