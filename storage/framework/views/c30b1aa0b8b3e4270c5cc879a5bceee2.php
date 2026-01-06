

<?php $__env->startSection('title', 'Verifikasi Barang - SILEBAR'); ?>
<?php $__env->startSection('header-title', 'Verifikasi Barang'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-6">Barang Menunggu Verifikasi</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php $__currentLoopData = $pendingAuctions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $auction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="border rounded-lg p-4">
                <div class="flex justify-between items-start">
                    <h3 class="font-semibold text-gray-800"><?php echo e($auction->title); ?></h3>
                    <span class="text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded">Pending</span>
                </div>
                
                <p class="text-sm text-gray-600 mt-2"><?php echo e(Str::limit($auction->description, 100)); ?></p>
                
                <div class="mt-4">
                    <p class="text-xs text-gray-500">Oleh: <?php echo e($auction->seller->name); ?></p>
                    <p class="text-xs text-gray-500">Kategori: <?php echo e($auction->category->name); ?></p>
                    <p class="text-sm font-semibold mt-1">Rp <?php echo e(number_format($auction->starting_price, 0, ',', '.')); ?></p>
                </div>
                
                <div class="mt-4 flex space-x-2">
                    <form action="<?php echo e(route('admin.verifications.approve', $auction)); ?>" method="POST" class="inline">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PATCH'); ?>
                        <button type="submit" class="px-3 py-1 bg-green-600 text-white text-sm rounded hover:bg-green-700">Setujui</button>
                    </form>
                    
                    <button onclick="openRejectModal(<?php echo e($auction->id); ?>)" class="px-3 py-1 bg-red-600 text-white text-sm rounded hover:bg-red-700">Tolak</button>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        
        <?php if($pendingAuctions->count() === 0): ?>
        <div class="text-center py-8">
            <p class="text-gray-500">Tidak ada barang menunggu verifikasi</p>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Reject Modal -->
<div id="reject-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-800">Tolak Barang</h3>
                <button onclick="closeRejectModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form id="reject-form" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PATCH'); ?>
                <div class="mt-4">
                    <label for="verification_note" class="block text-sm font-medium text-gray-700">Alasan Penolakan</label>
                    <textarea id="verification_note" name="verification_note" rows="4" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2"></textarea>
                </div>
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="closeRejectModal()" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">Tolak</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openRejectModal(auctionId) {
        document.getElementById('reject-form').action = '/admin/verifications/' + auctionId + '/reject';
        document.getElementById('reject-modal').classList.remove('hidden');
    }
    
    function closeRejectModal() {
        document.getElementById('reject-modal').classList.add('hidden');
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LENOVO\Desktop\TB\TB-PRAKWEB-SILEBAR\resources\views/admin/verifications/index.blade.php ENDPATH**/ ?>