@extends('layouts.dashboard')

@section('title', 'Notifikasi - SILEBAR')
@section('header-title', 'Notifikasi Anda')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-surface shadow rounded-lg p-6 border border-gray-100 dark:border-gray-700 transition-colors duration-300">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-text-main transition-colors">Semua Notifikasi</h2>
            <form action="{{ route('notifications.markAllAsRead') }}" method="POST">
                @csrf
                @method('PATCH')
                <button type="submit" class="text-sm text-primary hover:text-blue-700 dark:hover:text-blue-400 transition-colors">
                    Tandai semua sudah dibaca
                </button>
            </form>
        </div>

        <div class="space-y-4">
            @forelse($notifications ?? [] as $notification)
            <div class="flex items-start p-4 rounded-lg border {{ $notification->read_at ? 'bg-background border-gray-100 dark:border-gray-800' : 'bg-blue-50 dark:bg-blue-900/20 border-blue-100 dark:border-blue-800' }} transition-colors duration-300">
                <div class="flex-shrink-0 mt-0.5">
                    <span class="inline-block h-2 w-2 rounded-full {{ $notification->read_at ? 'bg-gray-400' : 'bg-blue-600' }}"></span>
                </div>
                <div class="ml-3 flex-1">
                    <p class="text-sm font-medium text-text-main transition-colors">
                        {{ $notification->message ?? 'Notifikasi Baru' }}
                    </p>
                    <div class="mt-1 text-xs text-text-muted flex justify-between items-center transition-colors">
                        <span>{{ $notification->created_at->diffForHumans() }}</span>
                        @if(!$notification->read_at)
                        <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="text-primary hover:underline ml-4">Tandai dibaca</button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-text-main">Tidak ada notifikasi</h3>
                <p class="mt-1 text-sm text-text-muted">Anda akan melihat update lelang di sini.</p>
            </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $notifications->links() ?? '' }}
        </div>
    </div>
</div>
@endsection