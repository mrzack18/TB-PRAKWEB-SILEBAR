<!DOCTYPE html>
<html lang="en" class="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="user-id" content="<?php echo e(auth()->id()); ?>">
    <meta name="user-name" content="<?php echo e(auth()->user()->name); ?>">
    <title><?php echo $__env->yieldContent('title', 'Dashboard - SILEBAR'); ?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Tailwind CSS & Config -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        primary: 'var(--color-primary)',
                        'primary-light': 'var(--color-primary-light)',
                        'primary-dark': 'var(--color-primary-dark)',

                        secondary: 'var(--color-secondary)',
                        'secondary-light': 'var(--color-secondary-light)',
                        'secondary-dark': 'var(--color-secondary-dark)',

                        accent: 'var(--color-accent)',
                        success: 'var(--color-success)',
                        error: 'var(--color-error)',

                        background: 'var(--color-background)',
                        surface: 'var(--color-surface)',
                        'surface-card': 'var(--color-surface-card)',

                        text: {
                            main: 'var(--color-text-main)',
                            muted: 'var(--color-text-muted)',
                        }
                    }
                }
            }
        }
    </script>

    <!-- Custom CSS -->
    <style>
        [x-cloak] {
            display: none !important;
        }

        :root {
            /* Light Mode Palette */
            --color-primary: #0066FF;
            --color-primary-light: #3385FF;
            --color-primary-dark: #0052CC;

            --color-secondary: #00B4D8;
            --color-secondary-light: #48CAE4;
            --color-secondary-dark: #0096C7;

            --color-accent: #F59E0B;
            --color-success: #10B981;
            --color-error: #EF4444;

            --color-background: #F8FAFC;
            --color-surface: #FFFFFF;
            --color-surface-card: #FFFFFF;

            --color-text-main: #1E293B;
            --color-text-muted: #64748B;
        }

        .dark {
            /* Dark Mode Palette */
            --color-primary: #3385FF;
            --color-primary-light: #5BA3FF;
            --color-primary-dark: #0066FF;

            --color-secondary: #48CAE4;
            --color-secondary-light: #90E0EF;
            --color-secondary-dark: #00B4D8;

            --color-accent: #FBBF24;
            --color-success: #34D399;
            --color-error: #F87171;

            --color-background: #0F172A;
            --color-surface: #1E293B;
            --color-surface-card: #334155;

            --color-text-main: #F8FAFC;
            --color-text-muted: #94A3B8;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--color-background);
            color: var(--color-text-main);
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .sidebar-active {
            background-color: var(--color-primary);
            color: white;
        }

        .sidebar-active svg {
            color: white;
        }
    </style>
</head>

<body class="min-h-screen" x-data="{
    sidebarOpen: false,
    darkMode: localStorage.getItem('theme') === 'dark',
    toggleTheme() {
        this.darkMode = !this.darkMode;
        localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
        if (this.darkMode) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    },
    init() {
        if (this.darkMode) {
            document.documentElement.classList.add('dark');
        }
    }
}" x-init="init()">

    <div class="flex h-screen overflow-hidden bg-background">

        <!-- Sidebar -->
        <aside
            class="fixed inset-y-0 left-0 z-50 w-64 bg-surface shadow-xl transform transition-transform duration-300 ease-in-out md:translate-x-0 md:static md:inset-0 border-r border-gray-100 dark:border-gray-800"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

            <!-- Logo -->
            <div class="flex items-center justify-center h-20 border-b border-gray-100 dark:border-gray-800">
                <a href="<?php echo e(route('home')); ?>" class="text-3xl font-bold text-primary tracking-tighter">SILEBAR</a>
            </div>

            <!-- Navigation -->
            <nav class="p-4 space-y-1 overflow-y-auto h-[calc(100vh-5rem)]">

                <p class="px-4 text-xs font-semibold text-text-muted uppercase tracking-wider mb-2 mt-2">Menu</p>

                <?php if(auth()->user()->role === 'admin'): ?>
                    <a href="<?php echo e(route('admin.dashboard')); ?>"
                        class="flex items-center px-4 py-3 rounded-xl transition-all <?php echo e(request()->routeIs('admin.dashboard') ? 'sidebar-active shadow-lg shadow-blue-500/30' : 'text-text-muted hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-primary'); ?>">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                            </path>
                        </svg>
                        Dashboard
                    </a>
                    <a href="<?php echo e(route('admin.users.index')); ?>"
                        class="flex items-center px-4 py-3 rounded-xl transition-all <?php echo e(request()->routeIs('admin.users.*') ? 'sidebar-active shadow-lg shadow-blue-500/30' : 'text-text-muted hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-primary'); ?>">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                        Pengguna
                    </a>
                    <a href="<?php echo e(route('admin.categories.index')); ?>"
                        class="flex items-center px-4 py-3 rounded-xl transition-all <?php echo e(request()->routeIs('admin.categories.*') ? 'sidebar-active shadow-lg shadow-blue-500/30' : 'text-text-muted hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-primary'); ?>">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                            </path>
                        </svg>
                        Kategori
                    </a>
                    <a href="<?php echo e(route('admin.verifications.index')); ?>"
                        class="flex items-center px-4 py-3 rounded-xl transition-all <?php echo e(request()->routeIs('admin.verifications.*') ? 'sidebar-active shadow-lg shadow-blue-500/30' : 'text-text-muted hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-primary'); ?>">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>

                        Verifikasi
                    </a>
                    <a href="<?php echo e(route('admin.payments.index')); ?>"
                        class="flex items-center px-4 py-3 rounded-xl transition-all <?php echo e(request()->routeIs('admin.payments.*') ? 'sidebar-active shadow-lg shadow-blue-500/30' : 'text-text-muted hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-primary'); ?>">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Pembayaran
                    </a>
                    <a href="<?php echo e(route('admin.reports.index')); ?>"
                        class="flex items-center px-4 py-3 rounded-xl transition-all <?php echo e(request()->routeIs('admin.reports.*') ? 'sidebar-active shadow-lg shadow-blue-500/30' : 'text-text-muted hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-primary'); ?>">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        Laporan
                    </a>
                <?php elseif(auth()->user()->role === 'seller'): ?>
                    <a href="<?php echo e(route('seller.dashboard')); ?>"
                        class="flex items-center px-4 py-3 rounded-xl transition-all <?php echo e(request()->routeIs('seller.dashboard') ? 'sidebar-active shadow-lg shadow-blue-500/30' : 'text-text-muted hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-primary'); ?>">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                            </path>
                        </svg>
                        Dashboard
                    </a>
                    <a href="<?php echo e(route('seller.auctions.index')); ?>"
                        class="flex items-center px-4 py-3 rounded-xl transition-all <?php echo e(request()->routeIs('seller.auctions.*') ? 'sidebar-active shadow-lg shadow-blue-500/30' : 'text-text-muted hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-primary'); ?>">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>
                        Lelang Saya
                    </a>
                    <a href="<?php echo e(route('seller.auctions.create')); ?>"
                        class="flex items-center px-4 py-3 rounded-xl transition-all <?php echo e(request()->routeIs('seller.auctions.create') ? 'sidebar-active shadow-lg shadow-blue-500/30' : 'text-text-muted hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-primary'); ?>">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                        Buat Lelang
                    </a>
                    <a href="<?php echo e(route('seller.shipping.index')); ?>"
                        class="flex items-center px-4 py-3 rounded-xl transition-all <?php echo e(request()->routeIs('seller.shipping.*') ? 'sidebar-active shadow-lg shadow-blue-500/30' : 'text-text-muted hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-primary'); ?>">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        Pengiriman
                    </a>
                    <a href="<?php echo e(route('seller.transactions.index')); ?>"
                        class="flex items-center px-4 py-3 rounded-xl transition-all <?php echo e(request()->routeIs('seller.transactions.*') ? 'sidebar-active shadow-lg shadow-blue-500/30' : 'text-text-muted hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-primary'); ?>">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                        Transaksi
                    </a>
                <?php elseif(auth()->user()->role === 'buyer'): ?>
                    <a href="<?php echo e(route('buyer.dashboard')); ?>"
                        class="flex items-center px-4 py-3 rounded-xl transition-all <?php echo e(request()->routeIs('buyer.dashboard') ? 'sidebar-active shadow-lg shadow-blue-500/30' : 'text-text-muted hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-primary'); ?>">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                            </path>
                        </svg>
                        Dashboard
                    </a>
                    <a href="<?php echo e(route('auctions.index')); ?>"
                        class="flex items-center px-4 py-3 rounded-xl transition-all text-text-muted hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-primary">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Cari Lelang
                    </a>
                    <a href="<?php echo e(route('buyer.auctions.followed')); ?>"
                        class="flex items-center px-4 py-3 rounded-xl transition-all <?php echo e(request()->routeIs('buyer.auctions.followed') ? 'sidebar-active shadow-lg shadow-blue-500/30' : 'text-text-muted hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-primary'); ?>">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                            </path>
                        </svg>
                        Lelang Diikuti
                    </a>
                    <a href="<?php echo e(route('buyer.transactions.index')); ?>"
                        class="flex items-center px-4 py-3 rounded-xl transition-all <?php echo e(request()->routeIs('buyer.transactions.*') ? 'sidebar-active shadow-lg shadow-blue-500/30' : 'text-text-muted hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-primary'); ?>">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                            </path>
                        </svg>
                        Riwayat Transaksi
                    </a>
                <?php endif; ?>

                <div class="border-t border-gray-100 dark:border-gray-800 my-4"></div>

                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit"
                        class="w-full flex items-center px-4 py-3 text-error hover:bg-red-50 dark:hover:bg-red-900/20 rounded-xl transition-all group">
                        <svg class="w-5 h-5 mr-3 group-hover:text-red-700" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                            </path>
                        </svg>
                        Logout
                    </button>
                </form>
            </nav>
        </aside>

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col overflow-hidden bg-background">

            <!-- Header -->
            <header
                class="flex items-center justify-between h-20 px-6 py-4 bg-surface/80 backdrop-blur-sm border-b border-gray-100 dark:border-gray-800 sticky top-0 z-40 transition-colors duration-300">
                <div class="flex items-center">
                    <button @click="sidebarOpen = !sidebarOpen" class="text-text-muted focus:outline-none md:hidden">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    <h2 class="text-xl font-bold text-text-main ml-4"><?php echo $__env->yieldContent('title'); ?></h2>
                </div>

                <div class="flex items-center space-x-4">
                    <!-- Theme Toggle -->
                    <button @click="toggleTheme()"
                        class="p-2 rounded-full text-text-muted hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none transition-colors">
                        <template x-if="!darkMode">
                            <!-- Sun Icon -->
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z">
                                </path>
                            </svg>
                        </template>
                        <template x-if="darkMode">
                            <!-- Moon Icon -->
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z">
                                </path>
                            </svg>
                        </template>
                    </button>

                    <!-- Notifications -->
                    <!-- Notifications Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                            class="relative p-2 text-text-muted hover:text-primary transition-colors focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                                </path>
                            </svg>
                            <!-- Unread Indicator -->
                            <?php if(auth()->user()->unreadNotifications->count() > 0): ?>
                                <span
                                    class="absolute -top-0.5 -right-0.5 h-4 w-4 flex items-center justify-center bg-error text-white text-xs rounded-full border border-surface"
                                    data-notification-badge>
                                    <?php echo e(min(auth()->user()->unreadNotifications->count(), 99)); ?>

                                    <?php if(auth()->user()->unreadNotifications->count() > 99): ?>
                                        +
                                    <?php endif; ?>
                                </span>
                            <?php else: ?>
                                <span
                                    class="absolute -top-0.5 -right-0.5 h-4 w-4 flex items-center justify-center bg-error text-white text-xs rounded-full border border-surface hidden"
                                    data-notification-badge>
                                </span>
                            <?php endif; ?>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" @click.away="open = false"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-80 bg-surface rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 py-1 z-50 overflow-hidden"
                            style="display: none;">

                            <div
                                class="px-4 py-3 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-gray-800/50">
                                <h3 class="text-sm font-semibold text-text-main">Notifikasi</h3>
                                <?php if(auth()->user()->unreadNotifications->count() > 0): ?>
                                    <form action="<?php echo e(route('notifications.markAllAsRead')); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PATCH'); ?>
                                        <button type="submit"
                                            class="text-xs text-primary hover:text-blue-600 transition-colors">Baca
                                            Semua</button>
                                    </form>
                                <?php endif; ?>
                            </div>

                            <div class="max-h-96 overflow-y-auto">
                                <?php $__empty_1 = true; $__currentLoopData = auth()->user()->notifications->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <div
                                        class="px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors border-b border-gray-50 dark:border-gray-800 last:border-0 <?php echo e($notification->read_at ? 'opacity-75' : ''); ?>">
                                        <p class="text-sm text-text-main font-medium">
                                            <?php echo e($notification->message ?? 'Notifikasi Baru'); ?></p>
                                        <p class="text-xs text-text-muted mt-1">
                                            <?php echo e($notification->created_at->diffForHumans()); ?></p>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <div class="px-4 py-6 text-center text-text-muted text-sm">
                                        Tidak ada notifikasi baru
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div
                                class="border-t border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50">
                                <a href="<?php echo e(route('notifications.index')); ?>"
                                    class="block px-4 py-3 text-center text-sm font-medium text-primary hover:text-blue-700 transition-colors">
                                    Lihat Semua Notifikasi
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- User Profile -->
                    <div class="flex items-center space-x-3 pl-4 border-l border-gray-100 dark:border-gray-800">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-bold text-text-main"><?php echo e(auth()->user()->name); ?></p>
                            <p class="text-xs text-secondary capitalize"><?php echo e(auth()->user()->role); ?></p>
                        </div>
                        <div
                            class="h-10 w-10 bg-primary/10 rounded-full flex items-center justify-center text-primary font-bold border-2 border-primary/20">
                            <?php echo e(substr(auth()->user()->name, 0, 1)); ?>

                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto flex flex-col">
                <div class="flex-1 p-6">
                    <?php echo $__env->yieldContent('content'); ?>
                </div>

                <!-- Sticky Footer -->
                <div
                    class="py-6 text-center text-sm text-text-muted border-t border-gray-100 dark:border-gray-800 bg-surface/50 backdrop-blur-sm transition-colors duration-300">
                    &copy; 2025 SILEBAR - Sistem Lelang Barang. All rights reserved.
                </div>
            </main>
        </div>

        <!-- Overlay for mobile -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false"
            x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-black bg-opacity-50 z-40 md:hidden"></div>
    </div>

    <!-- Pusher Configuration -->
    <script>
        window.pusherKey = '<?php echo e(env("PUSHER_APP_KEY")); ?>';
        window.pusherCluster = '<?php echo e(env("PUSHER_APP_CLUSTER", "mt1")); ?>';
    </script>

    <!-- Pusher and Echo for real-time notifications -->
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="<?php echo e(asset('js/echo.js')); ?>"></script>

    <?php echo $__env->yieldContent('scripts'); ?>
</body>

</html>
<?php /**PATH C:\Users\LENOVO\Desktop\SILEBAR\resources\views/layouts/dashboard.blade.php ENDPATH**/ ?>