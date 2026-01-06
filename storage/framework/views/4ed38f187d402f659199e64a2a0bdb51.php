<?php $__env->startSection('title', 'Barang Saya - SILEBAR'); ?>
<?php $__env->startSection('header-title', 'Barang Lelang Saya'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-text-main transition-colors">Barang Lelang Saya</h2>
        <a href="<?php echo e(route('seller.auctions.create')); ?>" class="px-4 py-2 bg-primary text-white rounded-md hover:bg-blue-700 transition-colors">Tambah Barang</a>
    </div>
    
    <div class="bg-surface shadow rounded-lg p-6 border border-gray-100 dark:border-gray-700 transition-colors duration-300">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 transition-colors">
                <thead class="bg-background transition-colors duration-300">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-text-muted uppercase tracking-wider transition-colors">
                            Barang
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-text-muted uppercase tracking-wider transition-colors">
                            Kategori
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-text-muted uppercase tracking-wider transition-colors">
                            Harga Awal
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-text-muted uppercase tracking-wider transition-colors">
                            Harga Saat Ini
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-text-muted uppercase tracking-wider transition-colors">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-text-muted uppercase tracking-wider transition-colors">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-surface divide-y divide-gray-200 dark:divide-gray-700 transition-colors duration-300">
                    <?php $__currentLoopData = $auctions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $auction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-text-main transition-colors"><?php echo e($auction->title); ?></div>
                            <div class="text-sm text-text-muted transition-colors"><?php echo e(Str::limit($auction->description, 50)); ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-text-muted transition-colors"><?php echo e($auction->category->name); ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-text-muted transition-colors">Rp <?php echo e(number_format($auction->starting_price, 0, ',', '.')); ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-semibold text-primary transition-colors">Rp <?php echo e(number_format($auction->current_price, 0, ',', '.')); ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php if($auction->status === 'pending'): ?>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">
                                    Menunggu Verifikasi
                                </span>
                            <?php elseif($auction->status === 'active'): ?>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                    Aktif
                                </span>
                            <?php elseif($auction->status === 'completed'): ?>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                    Selesai
                                </span>
                            <?php elseif($auction->status === 'rejected'): ?>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                    Ditolak
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <?php if(in_array($auction->status, ['pending', 'rejected'])): ?>
                                <a href="<?php echo e(route('seller.auctions.edit', $auction)); ?>" class="text-primary hover:text-blue-700 dark:hover:text-blue-400 mr-2 transition-colors">Edit</a>
                                <form action="<?php echo e(route('seller.auctions.destroy', $auction)); ?>" method="POST" class="inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 transition-colors" onclick="return confirm('Apakah Anda yakin ingin menghapus barang ini?')">Hapus</button>
                                </form>
                            <?php elseif($auction->status === 'active'): ?>
                                <a href="<?php echo e(route('seller.auctions.edit', $auction)); ?>" class="text-primary hover:text-blue-700 dark:hover:text-blue-400 mr-2 transition-colors">Edit</a>
                                <form action="<?php echo e(route('seller.auctions.endEarly', $auction)); ?>" method="POST" class="inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PATCH'); ?>
                                    <button type="submit" class="text-orange-600 hover:text-orange-800 dark:text-orange-400 dark:hover:text-orange-300 transition-colors" onclick="return confirm('Apakah Anda yakin ingin mengakhiri lelang ini lebih awal?')">Akhiri</button>
                                </form>
                            <?php elseif($auction->status === 'completed'): ?>
                                <a href="<?php echo e(route('seller.auctions.edit', $auction)); ?>" class="text-primary hover:text-blue-700 dark:hover:text-blue-400 mr-2 transition-colors">Edit</a>
                            <?php endif; ?>
                            <a href="<?php echo e(route('auctions.show', $auction)); ?>" class="text-primary hover:text-blue-700 dark:hover:text-blue-400 ml-2 transition-colors">Lihat</a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        
        <div class="mt-6">
            <?php echo e($auctions->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LENOVO\Desktop\SILEBAR\resources\views/seller/auctions/index.blade.php ENDPATH**/ ?>