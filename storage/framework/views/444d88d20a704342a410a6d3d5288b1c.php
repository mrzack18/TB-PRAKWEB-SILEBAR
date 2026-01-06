

<?php $__env->startSection('title', 'Laporan Transaksi - SILEBAR'); ?>
<?php $__env->startSection('header-title', 'Laporan Transaksi'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-surface shadow rounded-lg p-6 border border-gray-100 dark:border-gray-700 transition-colors duration-300">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-text-main transition-colors">Laporan Transaksi</h2>
            <a href="<?php echo e(route('admin.reports.export')); ?>" class="px-4 py-2 bg-green-600 dark:bg-green-700 text-white rounded-md hover:bg-green-700 dark:hover:bg-green-600 transition-colors">Export ke Excel</a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 transition-colors">
                <thead class="bg-background transition-colors duration-300">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-text-muted uppercase tracking-wider transition-colors">
                            Barang
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-text-muted uppercase tracking-wider transition-colors">
                            Pemenang
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-text-muted uppercase tracking-wider transition-colors">
                            Penjual
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-text-muted uppercase tracking-wider transition-colors">
                            Harga Final
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-text-muted uppercase tracking-wider transition-colors">
                            Tanggal
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-surface divide-y divide-gray-200 dark:divide-gray-700 transition-colors duration-300">
                    <?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-text-main transition-colors"><?php echo e($transaction->auctionItem->title); ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-text-muted transition-colors"><?php echo e($transaction->winner->name); ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-text-muted transition-colors"><?php echo e($transaction->seller->name); ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-bold text-primary transition-colors">Rp <?php echo e(number_format($transaction->final_price, 0, ',', '.')); ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-text-muted transition-colors"><?php echo e($transaction->created_at->format('d M Y H:i')); ?></div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        
        <div class="mt-6">
            <?php echo e($transactions->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LENOVO\Desktop\TB\TB-PRAKWEB-SILEBAR\resources\views/admin/reports/index.blade.php ENDPATH**/ ?>