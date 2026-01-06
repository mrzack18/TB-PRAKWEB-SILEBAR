@extends('layouts.app')

@section('title', 'Riwayat Pembayaran')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-text-main">Riwayat Pembayaran</h1>
        <p class="mt-2 text-text-muted">Lihat dan kelola riwayat pembayaran lelang Anda.</p>
    </div>

    <div class="bg-surface rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
        @if($transactions->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="bg-gray-50/50 dark:bg-gray-800/50">
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase tracking-wider">Barang</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase tracking-wider">Harga</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase tracking-wider">Komisi</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase tracking-wider">Untuk Penjual</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase tracking-wider">Status Pembayaran</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase tracking-wider">Status Pengiriman</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-text-muted uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-gray-700">
                    @foreach($transactions as $transaction)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                        <td class="px-4 py-4">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-lg bg-gray-200 dark:bg-gray-700 overflow-hidden flex-shrink-0">
                                    @if($transaction->auctionItem->images->first())
                                        <img src="{{ asset('storage/' . $transaction->auctionItem->images->first()->image_path) }}" class="h-full w-full object-cover">
                                    @endif
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-text-main">{{ Str::limit($transaction->auctionItem->title, 30) }}</p>
                                    <p class="text-xs text-text-muted">{{ $transaction->created_at->format('d M Y') }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-4 text-sm font-bold text-text-main">Rp {{ number_format($transaction->final_price, 0, ',', '.') }}</td>
                        <td class="px-4 py-4 text-sm font-bold text-red-600">Rp {{ number_format($transaction->commission_amount, 0, ',', '.') }}</td>
                        <td class="px-4 py-4 text-sm font-bold text-green-600">Rp {{ number_format($transaction->seller_amount, 0, ',', '.') }}</td>
                        <td class="px-4 py-4">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                @if($transaction->payment_status == 'verified') bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400
                                @elseif($transaction->payment_status == 'pending_verification') bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400
                                @elseif($transaction->payment_status == 'rejected') bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400
                                @else bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-400 @endif">
                                {{ ucfirst(str_replace('_', ' ', $transaction->payment_status)) }}
                            </span>
                        </td>
                        <td class="px-4 py-4">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                @if($transaction->shipping_status == 'delivered') bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400
                                @elseif($transaction->shipping_status == 'shipped') bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400
                                @elseif($transaction->shipping_status == 'waiting_shipment') bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400
                                @else bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-400 @endif">
                                {{ ucfirst(str_replace('_', ' ', $transaction->shipping_status)) }}
                            </span>
                        </td>
                        <td class="px-4 py-4 text-right">
                            <a href="{{ route('payments.show', $transaction) }}" class="text-primary hover:text-blue-700 text-sm font-medium">Lihat Detail</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $transactions->onEachSide(1)->links() }}
        </div>
        @else
        <div class="text-center py-12">
            <div class="w-16 h-16 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-text-main mb-2">Belum ada pembayaran</h3>
            <p class="text-text-muted mb-6">Anda belum memiliki riwayat pembayaran lelang.</p>
        </div>
        @endif
    </div>
</div>
@endsection