

<?php $__env->startSection('title', 'Cara Kerja - SILEBAR'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-background min-h-screen py-12 transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-3xl font-extrabold text-text-main sm:text-4xl transition-colors">
                Cara Kerja SILEBAR
            </h2>
            <p class="mt-4 text-xl text-text-muted transition-colors">
                Ikuti langkah mudah ini untuk mulai menawar dan menjual barang.
            </p>
        </div>

        <div class="mt-20">
            <div class="grid grid-cols-1 gap-12 lg:grid-cols-3">
                <!-- Step 1 -->
                <div class="bg-surface rounded-2xl p-8 shadow-sm border border-gray-100 dark:border-gray-700 text-center relative transition-colors duration-300">
                    <div class="absolute -top-10 left-1/2 transform -translate-x-1/2 bg-blue-600 text-white w-20 h-20 rounded-full flex items-center justify-center text-3xl font-bold shadow-lg">
                        1
                    </div>
                    <h3 class="mt-8 text-xl font-bold text-text-main transition-colors">Daftar Akun</h3>
                    <p class="mt-4 text-text-muted transition-colors">
                        Buat akun gratis sebagai pembeli atau penjual. Lengkapi profil Anda untuk mulai bertransaksi.
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="bg-surface rounded-2xl p-8 shadow-sm border border-gray-100 dark:border-gray-700 text-center relative transition-colors duration-300">
                    <div class="absolute -top-10 left-1/2 transform -translate-x-1/2 bg-blue-600 text-white w-20 h-20 rounded-full flex items-center justify-center text-3xl font-bold shadow-lg">
                        2
                    </div>
                    <h3 class="mt-8 text-xl font-bold text-text-main transition-colors">Mulai Menawar / Menjual</h3>
                    <p class="mt-4 text-text-muted transition-colors">
                        Cari barang impian dan ajukan tawaran, atau pasang barang Anda untuk dilelang ke ribuan pengguna.
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="bg-surface rounded-2xl p-8 shadow-sm border border-gray-100 dark:border-gray-700 text-center relative transition-colors duration-300">
                    <div class="absolute -top-10 left-1/2 transform -translate-x-1/2 bg-blue-600 text-white w-20 h-20 rounded-full flex items-center justify-center text-3xl font-bold shadow-lg">
                        3
                    </div>
                    <h3 class="mt-8 text-xl font-bold text-text-main transition-colors">Menang & Transaksi</h3>
                    <p class="mt-4 text-text-muted transition-colors">
                        Jika menang, selesaikan pembayaran dan penjual akan mengirimkan barang. Aman dan terpercaya.
                    </p>
                </div>
            </div>
        </div>

        <div class="mt-20 bg-primary rounded-3xl p-12 text-center relative overflow-hidden">
            <div class="relative z-10">
                <h3 class="text-3xl font-bold text-white mb-6">Siap untuk memulai?</h3>
                <div class="flex justify-center gap-4">
                    <a href="<?php echo e(route('register')); ?>" class="bg-white text-primary font-bold py-3 px-8 rounded-full hover:bg-gray-100 transition-colors">
                        Daftar Sekarang
                    </a>
                    <a href="<?php echo e(route('auctions.index')); ?>" class="bg-blue-700 text-white font-bold py-3 px-8 rounded-full hover:bg-blue-800 transition-colors border border-blue-500">
                        Lihat Lelang
                    </a>
                </div>
            </div>
            <!-- Decorative circles -->
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white opacity-10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-64 h-64 bg-secondary opacity-20 rounded-full blur-3xl"></div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LENOVO\Desktop\TB\TB-PRAKWEB-SILEBAR\resources\views/pages/how-it-works.blade.php ENDPATH**/ ?>