

<?php $__env->startSection('title', 'Edit Barang - SILEBAR'); ?>
<?php $__env->startSection('header-title', 'Edit Barang Lelang'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-surface shadow rounded-lg p-6 border border-gray-100 dark:border-gray-700 transition-colors duration-300">
        <h2 class="text-xl font-semibold text-text-main mb-6 transition-colors">Edit Barang Lelang</h2>
        
        <form method="POST" action="<?php echo e(route('seller.auctions.update', $auction)); ?>" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            
            <div class="space-y-4">
                <div>
                    <label for="title" class="block text-sm font-medium text-text-muted transition-colors">Judul Barang</label>
                    <input type="text" name="title" id="title" value="<?php echo e(old('title', $auction->title)); ?>" required class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm p-2 bg-white dark:bg-gray-800 text-text-main focus:ring-primary focus:border-primary transition-colors">
                </div>
                
                <div>
                    <label for="description" class="block text-sm font-medium text-text-muted transition-colors">Deskripsi Barang</label>
                    <textarea name="description" id="description" rows="4" required class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm p-2 bg-white dark:bg-gray-800 text-text-main focus:ring-primary focus:border-primary transition-colors"><?php echo e(old('description', $auction->description)); ?></textarea>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-text-muted transition-colors">Kategori</label>
                        <select name="category_id" id="category_id" required class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm p-2 bg-white dark:bg-gray-800 text-text-main focus:ring-primary focus:border-primary transition-colors">
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($category->id); ?>" <?php echo e(old('category_id', $auction->category_id) == $category->id ? 'selected' : ''); ?>><?php echo e($category->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div>
                        <label for="starting_price" class="block text-sm font-medium text-text-muted transition-colors">Harga Awal (Rp)</label>
                        <input type="number" name="starting_price" id="starting_price" value="<?php echo e(old('starting_price', $auction->starting_price)); ?>" required min="0" class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm p-2 bg-white dark:bg-gray-800 text-text-main focus:ring-primary focus:border-primary transition-colors">
                    </div>
                </div>

                <!-- Current Images -->
                <div class="mt-4">
                    <label class="block text-sm font-medium text-text-muted transition-colors">Gambar Saat Ini</label>
                    <div class="mt-2 grid grid-cols-2 md:grid-cols-4 gap-2">
                        <?php $__empty_1 = true; $__currentLoopData = $auction->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="relative">
                                <img src="<?php echo e(asset('storage/' . $image->image_path)); ?>" alt="Auction image" class="w-full h-32 object-cover rounded border border-gray-200 dark:border-gray-700">
                                <?php if($image->is_primary): ?>
                                    <span class="absolute top-0 left-0 bg-green-500 text-white text-xs px-2 py-1 rounded-tl">Utama</span>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <p class="text-text-muted col-span-4 transition-colors">Tidak ada gambar</p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Duration Selection -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="duration_value" class="block text-sm font-medium text-text-muted transition-colors">Durasi Lelang</label>
                        <input type="number" name="duration_value" id="duration_value" value="<?php echo e(old('duration_value', $durationValue ?? 7)); ?>" required min="1" max="30" class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm p-2 bg-white dark:bg-gray-800 text-text-main focus:ring-primary focus:border-primary transition-colors">
                        <p class="mt-1 text-sm text-text-muted">Masukkan jumlah durasi</p>
                    </div>
                    <div>
                        <label for="duration_unit" class="block text-sm font-medium text-text-muted transition-colors">Satuan Waktu</label>
                        <select name="duration_unit" id="duration_unit" required class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm p-2 bg-white dark:bg-gray-800 text-text-main focus:ring-primary focus:border-primary transition-colors">
                            <option value="minutes" <?php echo e(old('duration_unit') == 'minutes' || ($durationUnit ?? 'days') == 'minutes' ? 'selected' : ''); ?>>Menit</option>
                            <option value="hours" <?php echo e(old('duration_unit') == 'hours' || ($durationUnit ?? 'days') == 'hours' ? 'selected' : ''); ?>>Jam</option>
                            <option value="days" <?php echo e(old('duration_unit') == 'days' || ($durationUnit ?? 'days') == 'days' ? 'selected' : ''); ?>>Hari</option>
                        </select>
                        <p class="mt-1 text-sm text-text-muted">Pilih satuan waktu durasi lelang</p>
                    </div>
                </div>

                <!-- Add New Images -->
                <div class="mt-4">
                    <label for="images" class="block text-sm font-medium text-text-muted transition-colors">Tambah Gambar Barang</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-md transition-colors hover:border-gray-400 dark:hover:border-gray-500">
                        <div class="space-y-1 text-center">
                            <div class="flex text-sm text-text-muted transition-colors">
                            <label for="images" class="relative cursor-pointer bg-transparent rounded-md font-medium text-primary hover:text-blue-500 focus-within:outline-none focus:ring-none">
                                    <span>Upload file</span>
                                    <input id="images" name="images[]" type="file" multiple class="sr-only" onchange="previewImages(this)">
                                </label>
                                <p class="pl-1 text-text-muted">or drag and drop</p>
                            </div>
                            <p class="text-xs text-text-muted">
                                PNG, JPG, GIF sampai 5 file
                            </p>
                        </div>
                    </div>
                    <!-- New Image Preview Container -->
                    <div id="image-preview" class="mt-4 grid grid-cols-2 md:grid-cols-5 gap-2"></div>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="<?php echo e(route('seller.auctions.index')); ?>" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-text-muted hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">Batal</a>
                <button type="submit" class="px-4 py-2 bg-primary text-white rounded-md hover:bg-blue-700 transition-colors">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
function previewImages(input) {
    const previewContainer = document.getElementById('image-preview');
    previewContainer.innerHTML = ''; // Clear previous previews

    if (input.files) {
        const filesArray = Array.from(input.files);

        filesArray.forEach((file, index) => {
            const reader = new FileReader();

            reader.onload = function(e) {
                const imgContainer = document.createElement('div');
                imgContainer.className = 'relative';

                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'w-full h-32 object-cover rounded border border-gray-300 dark:border-gray-700';
                img.alt = `Preview ${index + 1}`;

                imgContainer.appendChild(img);
                previewContainer.appendChild(imgContainer);
            }

            reader.readAsDataURL(file);
        });
    }
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LENOVO\Desktop\TB\TB-PRAKWEB-SILEBAR\resources\views/seller/auctions/edit.blade.php ENDPATH**/ ?>