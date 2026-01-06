@extends('layouts.dashboard')

@section('title', 'Lelang Diikuti - SILEBAR')
@section('header-title', 'Lelang yang Saya Ikuti')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-surface shadow rounded-lg p-6 border border-gray-100 dark:border-gray-700 transition-colors duration-300">
        <h2 class="text-xl font-semibold text-text-main mb-6 transition-colors">Barang Lelang yang Saya Ikuti</h2>
        
        @if($followedAuctions->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($followedAuctions as $auction)
            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 bg-background transition-colors duration-300 hover:shadow-md">
                @if($auction->images->first())
                    <img src="{{ asset('storage/' . $auction->images->first()->image_path) }}" alt="{{ $auction->title }}" class="w-full h-40 object-cover rounded">
                @else
                    <div class="bg-gray-200 dark:bg-gray-700 w-full h-40 flex items-center justify-center rounded transition-colors">
                        <span class="text-gray-500 dark:text-gray-400">No Image</span>
                    </div>
                @endif
                
                <h3 class="font-semibold text-text-main mt-2 text-lg line-clamp-2 transition-colors">{{ Str::limit($auction->title, 40) }}</h3>
                
                <div class="mt-2">
                    <p class="text-sm text-text-muted transition-colors">Oleh: {{ $auction->seller->name }}</p>
                    <p class="text-sm font-bold text-primary mt-1">Rp {{ number_format($auction->current_price, 0, ',', '.') }}</p>
                    <p class="text-xs text-text-muted mt-1 transition-colors">{{ $auction->bids->count() }} tawaran</p>
                </div>
                
                <div class="mt-3">
                    @php
                        $highestBid = $auction->bids()->orderBy('bid_amount', 'desc')->first();
                        $isWinner = $highestBid && $highestBid->user_id === auth()->id();
                        $hasTransaction = $auction->transaction;
                    @endphp

                    @if($auction->status === 'completed' && $isWinner && !$hasTransaction)
                        <form action="{{ route('payments.create', $auction) }}" method="POST" class="mb-2">
                            @csrf
                            <button type="submit" class="block w-full bg-green-600 text-white text-center py-2 px-4 rounded-md hover:bg-green-700 transition-colors">
                                Bayar Sekarang
                            </button>
                        </form>
                        <a href="{{ route('auctions.show', $auction) }}" class="block w-full bg-primary text-white text-center py-2 px-4 rounded-md hover:bg-blue-700 transition-colors">
                            Lihat Detail
                        </a>
                    @elseif($auction->status === 'completed' && $isWinner && $hasTransaction)
                        <a href="{{ route('payments.show', $hasTransaction) }}" class="block w-full bg-blue-600 text-white text-center py-2 px-4 rounded-md hover:bg-blue-700 transition-colors mb-2">
                            Lihat Pembayaran
                        </a>
                        <a href="{{ route('auctions.show', $auction) }}" class="block w-full bg-primary text-white text-center py-2 px-4 rounded-md hover:bg-blue-700 transition-colors">
                            Lihat Detail
                        </a>
                    @else
                        <a href="{{ route('auctions.show', $auction) }}" class="block w-full bg-primary text-white text-center py-2 px-4 rounded-md hover:bg-blue-700 transition-colors">
                            Lihat Detail
                        </a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="mt-6">
            {{ $followedAuctions->links() }}
        </div>
        @else
        <div class="text-center py-8">
            <p class="text-text-muted transition-colors">Anda belum mengikuti lelang manapun</p>
        </div>
        @endif
    </div>
</div>
@endsection