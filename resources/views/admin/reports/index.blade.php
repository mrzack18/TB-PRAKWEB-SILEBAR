@extends('layouts.dashboard')

@section('title', 'Laporan Transaksi - SILEBAR')
@section('header-title', 'Laporan Transaksi')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-surface shadow rounded-lg p-6 border border-gray-100 dark:border-gray-700 transition-colors duration-300">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-text-main transition-colors">Laporan Transaksi</h2>
            <a href="{{ route('admin.reports.export') }}" class="px-4 py-2 bg-green-600 dark:bg-green-700 text-white rounded-md hover:bg-green-700 dark:hover:bg-green-600 transition-colors">Export ke Excel</a>
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
                    @foreach($transactions as $transaction)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-text-main transition-colors">{{ $transaction->auctionItem->title }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-text-muted transition-colors">{{ $transaction->winner->name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-text-muted transition-colors">{{ $transaction->seller->name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-bold text-primary transition-colors">Rp {{ number_format($transaction->final_price, 0, ',', '.') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-text-muted transition-colors">{{ $transaction->created_at->format('d M Y H:i') }}</div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="mt-6">
            {{ $transactions->links() }}
        </div>
    </div>
</div>
@endsection