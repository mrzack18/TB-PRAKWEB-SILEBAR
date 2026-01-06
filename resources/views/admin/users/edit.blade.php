@extends('layouts.dashboard')

@section('title', 'Edit Pengguna - SILEBAR')
@section('header-title', 'Edit Pengguna')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-6">Edit Pengguna</h2>
        
        <form method="POST" action="{{ route('admin.users.update', $user) }}">
            @csrf
            @method('PUT')
            
            <div class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                </div>
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                </div>
                
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700">Peran</label>
                    <select name="role" id="role" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="seller" {{ $user->role === 'seller' ? 'selected' : '' }}>Penjual</option>
                        <option value="buyer" {{ $user->role === 'buyer' ? 'selected' : '' }}>Pembeli</option>
                    </select>
                </div>
                
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">Telepon</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                </div>
                
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700">Alamat</label>
                    <textarea name="address" id="address" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">{{ old('address', $user->address) }}</textarea>
                </div>
            </div>
            
            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('admin.users.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Batal</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection