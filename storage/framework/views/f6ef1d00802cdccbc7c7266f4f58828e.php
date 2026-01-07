

<?php $__env->startSection('title', 'Edit Pengguna - SILEBAR'); ?>
<?php $__env->startSection('header-title', 'Edit Pengguna'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-6">Edit Pengguna</h2>
        
        <form method="POST" action="<?php echo e(route('admin.users.update', $user)); ?>">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            
            <div class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                    <input type="text" name="name" id="name" value="<?php echo e(old('name', $user->name)); ?>" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                </div>
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" value="<?php echo e(old('email', $user->email)); ?>" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                </div>
                
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700">Peran</label>
                    <select name="role" id="role" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                        <option value="admin" <?php echo e($user->role === 'admin' ? 'selected' : ''); ?>>Admin</option>
                        <option value="seller" <?php echo e($user->role === 'seller' ? 'selected' : ''); ?>>Penjual</option>
                        <option value="buyer" <?php echo e($user->role === 'buyer' ? 'selected' : ''); ?>>Pembeli</option>
                    </select>
                </div>
                
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">Telepon</label>
                    <input type="text" name="phone" id="phone" value="<?php echo e(old('phone', $user->phone)); ?>" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                </div>
                
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700">Alamat</label>
                    <textarea name="address" id="address" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2"><?php echo e(old('address', $user->address)); ?></textarea>
                </div>
            </div>
            
            <div class="mt-6 flex justify-end space-x-3">
                <a href="<?php echo e(route('admin.users.index')); ?>" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Batal</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Simpan</button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LENOVO\Desktop\TB\TB-PRAKWEB-SILEBAR\resources\views/admin/users/edit.blade.php ENDPATH**/ ?>