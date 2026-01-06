@extends('layouts.dashboard')

@section('title', 'Edit Barang - SILEBAR')
@section('header-title', 'Edit Barang Lelang')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-surface shadow rounded-lg p-6 border border-gray-100 dark:border-gray-700 transition-colors duration-300">
        <h2 class="text-xl font-semibold text-text-main mb-6 transition-colors">Edit Barang Lelang</h2>
        
        <form method="POST" action="{{ route('seller.auctions.update', $auction) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="space-y-4">
                <div>
                    <label for="title" class="block text-sm font-medium text-text-muted transition-colors">Judul Barang</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $auction->title) }}" required class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm p-2 bg-white dark:bg-gray-800 text-text-main focus:ring-primary focus:border-primary transition-colors">
                </div>
                
                <div>
                    <label for="description" class="block text-sm font-medium text-text-muted transition-colors">Deskripsi Barang</label>
                    <textarea name="description" id="description" rows="4" required class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm p-2 bg-white dark:bg-gray-800 text-text-main focus:ring-primary focus:border-primary transition-colors">{{ old('description', $auction->description) }}</textarea>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-text-muted transition-colors">Kategori</label>
                        <select name="category_id" id="category_id" required class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm p-2 bg-white dark:bg-gray-800 text-text-main focus:ring-primary focus:border-primary transition-colors">
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $auction->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="starting_price" class="block text-sm font-medium text-text-muted transition-colors">Harga Awal (Rp)</label>
                        <input type="number" name="starting_price" id="starting_price" value="{{ old('starting_price', $auction->starting_price) }}" required min="0" class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm p-2 bg-white dark:bg-gray-800 text-text-main focus:ring-primary focus:border-primary transition-colors">
                    </div>
                </div>

                <!-- Current Images -->
                <div class="mt-4">
                    <label class="block text-sm font-medium text-text-muted transition-colors">Gambar Saat Ini</label>
                    <div class="mt-2 grid grid-cols-2 md:grid-cols-4 gap-2">
                        @forelse($auction->images as $image)
                            <div class="relative">
                                <img src="{{ asset('storage/' . $image->image_path) }}" alt="Auction image" class="w-full h-32 object-cover rounded border border-gray-200 dark:border-gray-700">
                                @if($image->is_primary)
                                    <span class="absolute top-0 left-0 bg-green-500 text-white text-xs px-2 py-1 rounded-tl">Utama</span>
                                @endif
                            </div>
                        @empty
                            <p class="text-text-muted col-span-4 transition-colors">Tidak ada gambar</p>
                        @endforelse
                    </div>
                </div>

                <!-- Duration Selection -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="duration_value" class="block text-sm font-medium text-text-muted transition-colors">Durasi Lelang</label>
                        <input type="number" name="duration_value" id="duration_value" value="{{ old('duration_value', $durationValue ?? 7) }}" required min="1" max="30" class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm p-2 bg-white dark:bg-gray-800 text-text-main focus:ring-primary focus:border-primary transition-colors">
                        <p class="mt-1 text-sm text-text-muted">Masukkan jumlah durasi</p>
                    </div>
                    <div>
                        <label for="duration_unit" class="block text-sm font-medium text-text-muted transition-colors">Satuan Waktu</label>
                        <select name="duration_unit" id="duration_unit" required class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm p-2 bg-white dark:bg-gray-800 text-text-main focus:ring-primary focus:border-primary transition-colors">
                            <option value="minutes" {{ old('duration_unit') == 'minutes' || ($durationUnit ?? 'days') == 'minutes' ? 'selected' : '' }}>Menit</option>
                            <option value="hours" {{ old('duration_unit') == 'hours' || ($durationUnit ?? 'days') == 'hours' ? 'selected' : '' }}>Jam</option>
                            <option value="days" {{ old('duration_unit') == 'days' || ($durationUnit ?? 'days') == 'days' ? 'selected' : '' }}>Hari</option>
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
                <a href="{{ route('seller.auctions.index') }}" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-text-muted hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">Batal</a>
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
@endsection