@extends('layouts.dashboard')

@section('title', 'Admin Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Users -->
    <div class="bg-surface p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 relative overflow-hidden group hover:shadow-lg transition-all duration-300">
        <div class="relative z-10">
            <p class="text-sm font-medium text-text-muted mb-1 transition-colors">Total Pengguna</p>
            <h3 class="text-3xl font-bold text-text-main transition-colors">{{ $stats['total_users'] ?? 0 }}</h3>
        </div>
        <div class="absolute right-0 top-0 h-full w-20 bg-gradient-to-l from-blue-50 dark:from-blue-900/20 to-transparent opacity-50 group-hover:w-24 transition-all"></div>
        <div class="absolute bottom-4 right-4 text-primary bg-blue-100 dark:bg-blue-900/30 p-2 rounded-lg transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
        </div>
    </div>

    <!-- Active Auctions -->
    <div class="bg-surface p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 relative overflow-hidden group hover:shadow-lg transition-all duration-300">
        <div class="relative z-10">
            <p class="text-sm font-medium text-text-muted mb-1 transition-colors">Lelang Aktif</p>
            <h3 class="text-3xl font-bold text-text-main transition-colors">{{ $stats['active_auctions'] ?? 0 }}</h3>
        </div>
        <div class="absolute right-0 top-0 h-full w-20 bg-gradient-to-l from-green-50 dark:from-green-900/20 to-transparent opacity-50 group-hover:w-24 transition-all"></div>
        <div class="absolute bottom-4 right-4 text-green-600 dark:text-green-400 bg-green-100 dark:bg-green-900/30 p-2 rounded-lg transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
        </div>
    </div>

    <!-- Pending Verifications -->
    <div class="bg-surface p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 relative overflow-hidden group hover:shadow-lg transition-all duration-300">
        <div class="relative z-10">
            <p class="text-sm font-medium text-text-muted mb-1 transition-colors">Perlu Verifikasi</p>
            <h3 class="text-3xl font-bold text-text-main transition-colors">{{ $stats['pending_auctions'] ?? 0 }}</h3>
        </div>
        <div class="absolute right-0 top-0 h-full w-20 bg-gradient-to-l from-yellow-50 dark:from-yellow-900/20 to-transparent opacity-50 group-hover:w-24 transition-all"></div>
        <div class="absolute bottom-4 right-4 text-accent bg-orange-100 dark:bg-orange-900/30 p-2 rounded-lg transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        </div>
    </div>

    <!-- Total Revenue -->
    <div class="bg-surface p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 relative overflow-hidden group hover:shadow-lg transition-all duration-300">
        <div class="relative z-10">
            <p class="text-sm font-medium text-text-muted mb-1 transition-colors">Total Pendapatan</p>
            <h3 class="text-3xl font-bold text-text-main transition-colors">Rp {{ number_format($stats['total_revenue'] ?? 0, 0, ',', '.') }}</h3>
        </div>
        <div class="absolute right-0 top-0 h-full w-20 bg-gradient-to-l from-purple-50 dark:from-purple-900/20 to-transparent opacity-50 group-hover:w-24 transition-all"></div>
        <div class="absolute bottom-4 right-4 text-purple-600 dark:text-purple-400 bg-purple-100 dark:bg-purple-900/30 p-2 rounded-lg transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Recent Users -->
    <div class="bg-surface rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 transition-colors duration-300">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-bold text-text-main transition-colors">Pengguna Terbaru</h3>
            <a href="{{ route('admin.users.index') }}" class="text-sm text-primary hover:text-blue-700 font-medium">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b border-gray-100 dark:border-gray-700 transition-colors">
                        <th class="text-left text-xs font-semibold text-text-muted uppercase tracking-wider pb-3 transition-colors">Nama</th>
                        <th class="text-left text-xs font-semibold text-text-muted uppercase tracking-wider pb-3 transition-colors">Email</th>
                        <th class="text-left text-xs font-semibold text-text-muted uppercase tracking-wider pb-3 transition-colors">Role</th>
                        <th class="text-right text-xs font-semibold text-text-muted uppercase tracking-wider pb-3 transition-colors">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-gray-700 transition-colors">
                    @forelse($recentUsers ?? [] as $user)
                    <tr>
                        <td class="py-3 text-sm text-text-main font-medium transition-colors">{{ $user->name }}</td>
                        <td class="py-3 text-sm text-text-muted transition-colors">{{ $user->email }}</td>
                        <td class="py-3 text-sm">
                            <span class="px-2 py-1 rounded text-xs font-semibold {{ $user->role === 'admin' ? 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400' : ($user->role === 'seller' ? 'bg-blue-100 text-primary dark:bg-blue-900/30' : 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400') }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="py-3 text-sm text-gray-400 text-right">{{ $user->created_at->format('d M') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-4 text-center text-sm text-text-muted transition-colors">Belum ada data pengguna.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recent Auctions -->
    <div class="bg-surface rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 transition-colors duration-300">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-bold text-text-main transition-colors">Lelang Terbaru</h3>
            <a href="{{ route('auctions.index') }}" class="text-sm text-primary hover:text-blue-700 font-medium">Lihat Semua</a>
        </div>
        <div class="space-y-4">
            @forelse($recentAuctions ?? [] as $auction)
            <div class="flex items-center p-3 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition-colors border border-transparent hover:border-gray-100 dark:hover:border-gray-700">
                <div class="h-12 w-12 rounded-lg bg-gray-200 dark:bg-gray-700 flex-shrink-0 overflow-hidden transition-colors">
                    @if($auction->images->first())
                        <img src="{{ asset('storage/' . $auction->images->first()->image_path) }}" class="h-full w-full object-cover">
                    @endif
                </div>
                <div class="ml-4 flex-1">
                    <h4 class="text-sm font-bold text-text-main transition-colors">{{ $auction->title }}</h4>
                    <p class="text-xs text-text-muted transition-colors">Oleh <span class="font-medium text-secondary">{{ $auction->seller->name }}</span></p>
                </div>
                <div class="text-right">
                    <p class="text-sm font-bold text-primary">Rp {{ number_format($auction->current_price, 0, ',', '.') }}</p>
                    <p class="text-xs text-gray-400">{{ $auction->status }}</p>
                </div>
            </div>
            @empty
            <p class="text-center text-sm text-text-muted py-4 transition-colors">Belum ada lelang terbaru.</p>
            @endforelse
        </div>
    </div>
</div>

<!-- Pending Auctions for Verification -->
<div class="bg-surface rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 transition-colors duration-300 mt-8">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-bold text-text-main transition-colors">Lelang Menunggu Verifikasi</h3>
        <a href="{{ route('admin.verifications.index') }}" class="text-sm text-primary hover:text-blue-700 font-medium">Lihat Semua</a>
    </div>
    <div class="space-y-4">
        @forelse($recentPendingAuctions ?? [] as $auction)
        <div class="flex items-center p-3 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition-colors border border-transparent hover:border-gray-100 dark:hover:border-gray-700">
            <div class="h-12 w-12 rounded-lg bg-gray-200 dark:bg-gray-700 flex-shrink-0 overflow-hidden transition-colors">
                @if($auction->images->first())
                    <img src="{{ asset('storage/' . $auction->images->first()->image_path) }}" class="h-full w-full object-cover">
                @endif
            </div>
            <div class="ml-4 flex-1">
                <h4 class="text-sm font-bold text-text-main transition-colors">{{ $auction->title }}</h4>
                <p class="text-xs text-text-muted transition-colors">Oleh <span class="font-medium text-secondary">{{ $auction->seller->name }}</span></p>
            </div>
            <div class="text-right">
                <p class="text-sm font-bold text-primary">Rp {{ number_format($auction->starting_price, 0, ',', '.') }}</p>
                <span class="inline-block px-2 py-1 text-xs font-semibold text-yellow-700 bg-yellow-100 dark:bg-yellow-900/30 dark:text-yellow-400 rounded">Pending</span>
            </div>
        </div>
        @empty
        <p class="text-center text-sm text-text-muted py-4 transition-colors">Tidak ada lelang menunggu verifikasi.</p>
        @endforelse
    </div>
</div>
@endsection