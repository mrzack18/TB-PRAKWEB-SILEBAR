@extends('layouts.app')

@section('title', 'Detail Pembayaran')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-text-main">Detail Pembayaran</h1>
        <p class="mt-2 text-text-muted">Informasi lengkap tentang pembayaran lelang Anda.</p>
    </div>

    <div class="bg-surface rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 mb-8">
        <div class="flex flex-col md:flex-row gap-6">
            <div class="md:w-1/3">
                @if($transaction->auctionItem->images->first())
                    <img src="{{ asset('storage/' . $transaction->auctionItem->images->first()->image_path) }}" 
                         alt="{{ $transaction->auctionItem->title }}" 
                         class="w-full h-64 object-cover rounded-xl">
                @else
                    <div class="w-full h-64 bg-gray-100 dark:bg-gray-800 rounded-xl flex items-center justify-center">
                        <span class="text-gray-400">No Image</span>
                    </div>
                @endif
            </div>
            <div class="md:w-2/3">
                <h2 class="text-2xl font-bold text-text-main">{{ $transaction->auctionItem->title }}</h2>
                <p class="text-text-muted mt-2">{{ $transaction->auctionItem->description }}</p>
                
                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-text-muted">Harga Akhir</p>
                        <p class="text-lg font-bold text-primary">Rp {{ number_format($transaction->final_price, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-text-muted">Komisi (10%)</p>
                        <p class="text-lg font-bold text-red-600">Rp {{ number_format($transaction->commission_amount, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-text-muted">Untuk Penjual (90%)</p>
                        <p class="text-lg font-bold text-green-600">Rp {{ number_format($transaction->seller_amount, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-text-muted">Tanggal Pembayaran</p>
                        <p class="text-lg font-bold text-text-main">{{ $transaction->created_at->format('d M Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-text-muted">Status Pembayaran</p>
                        <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full 
                            @if($transaction->payment_status == 'verified') bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400
                            @elseif($transaction->payment_status == 'pending_verification') bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400
                            @elseif($transaction->payment_status == 'rejected') bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400
                            @else bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-400 @endif">
                            {{ ucfirst(str_replace('_', ' ', $transaction->payment_status)) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-sm text-text-muted">Status Pengiriman</p>
                        <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full 
                            @if($transaction->shipping_status == 'delivered') bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400
                            @elseif($transaction->shipping_status == 'shipped') bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400
                            @elseif($transaction->shipping_status == 'waiting_shipment') bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400
                            @else bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-400 @endif">
                            {{ ucfirst(str_replace('_', ' ', $transaction->shipping_status)) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Processing Section -->
    @if($transaction->payment_status == 'pending' && auth()->id() == $transaction->winner_id)
    <div class="bg-surface rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 mb-8">
        <h3 class="text-xl font-bold text-text-main mb-4">Proses Pembayaran</h3>
        
        <form action="{{ route('payments.process', $transaction) }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-4">
                <label for="payment_method" class="block text-sm font-medium text-text-main mb-2">Metode Pembayaran</label>
                <select name="payment_method" id="payment_method" class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-800 text-text-main shadow-sm focus:ring-primary focus:border-primary">
                    <option value="">Pilih Metode Pembayaran</option>
                    <option value="bank_transfer">Transfer Bank</option>
                    <option value="credit_card">Kartu Kredit</option>
                    <option value="e_wallet">E-Wallet</option>
                </select>
            </div>
            
            <div class="mb-4">
                <label for="payment_proof" class="block text-sm font-medium text-text-main mb-2">Bukti Pembayaran (Opsional)</label>
                <input type="file" name="payment_proof" id="payment_proof" class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-800 text-text-main shadow-sm focus:ring-primary focus:border-primary">
                <p class="mt-1 text-xs text-text-muted">Format: JPG, PNG. Maksimal 2MB</p>
            </div>
            
            <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-primary hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-all">
                Proses Pembayaran
            </button>
        </form>
    </div>
    @endif

    <!-- Payment Proof Section -->
    @if($transaction->payment_proof)
    <div class="bg-surface rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
        <h3 class="text-xl font-bold text-text-main mb-4">Bukti Pembayaran</h3>
        <div class="flex items-center">
            <div class="h-16 w-16 rounded-lg bg-gray-200 dark:bg-gray-700 overflow-hidden">
                <img src="{{ asset('storage/' . $transaction->payment_proof) }}" class="h-full w-full object-cover">
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-text-main">Bukti Pembayaran</p>
                <p class="text-xs text-text-muted">{{ $transaction->payment_method ? ucfirst(str_replace('_', ' ', $transaction->payment_method)) : 'Metode Tidak Ditentukan' }}</p>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection