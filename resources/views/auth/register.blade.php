@extends('layouts.app')

@section('title', 'Register - SILEBAR')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-background py-12 px-4 sm:px-6 lg:px-8 transition-colors duration-300">
    <div class="max-w-md w-full space-y-8 bg-surface p-8 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700 transition-colors duration-300">
        <div>
            <div class="mx-auto h-12 w-auto text-center">
                <span class="text-3xl font-bold text-primary">SILEBAR</span>
            </div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-text-main transition-colors">
                Buat Akun Baru
            </h2>
        </div>
        <form class="mt-8 space-y-6" action="{{ route('register') }}" method="POST">
            @csrf
            <div class="rounded-md shadow-sm -space-y-px">
                <div>
                    <label for="name" class="sr-only">Nama Lengkap</label>
                    <input id="name" name="name" type="text" required class="appearance-none rounded-t-lg relative block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 placeholder-gray-500 dark:placeholder-gray-400 text-text-main bg-white dark:bg-gray-800 focus:outline-none focus:ring-primary focus:border-primary focus:z-10 sm:text-sm transition-colors" placeholder="Nama Lengkap">
                </div>
                <div>
                    <label for="email" class="sr-only">Email address</label>
                    <input id="email" name="email" type="email" autocomplete="email" required class="appearance-none relative block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 placeholder-gray-500 dark:placeholder-gray-400 text-text-main bg-white dark:bg-gray-800 focus:outline-none focus:ring-primary focus:border-primary focus:z-10 sm:text-sm transition-colors" placeholder="Email address">
                </div>
                <div>
                    <label for="password" class="sr-only">Password</label>
                    <input id="password" name="password" type="password" autocomplete="new-password" required class="appearance-none relative block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 placeholder-gray-500 dark:placeholder-gray-400 text-text-main bg-white dark:bg-gray-800 focus:outline-none focus:ring-primary focus:border-primary focus:z-10 sm:text-sm transition-colors" placeholder="Password">
                </div>
                <div>
                    <label for="password_confirmation" class="sr-only">Konfirmasi Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required class="appearance-none rounded-b-lg relative block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 placeholder-gray-500 dark:placeholder-gray-400 text-text-main bg-white dark:bg-gray-800 focus:outline-none focus:ring-primary focus:border-primary focus:z-10 sm:text-sm transition-colors" placeholder="Konfirmasi Password">
                </div>
            </div>

            <div>
                <label for="role" class="block text-sm font-medium text-text-main mb-1 transition-colors">Peran Anda</label>
                <div class="grid grid-cols-2 gap-4">
                    <div class="flex items-center">
                        <input id="seller" name="role" type="radio" value="seller" required class="h-4 w-4 text-primary focus:ring-primary border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                        <label for="seller" class="ml-2 block text-sm text-text-main transition-colors">
                            Penjual
                        </label>
                    </div>
                    <div class="flex items-center">
                        <input id="buyer" name="role" type="radio" value="buyer" required class="h-4 w-4 text-primary focus:ring-primary border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                        <label for="buyer" class="ml-2 block text-sm text-text-main transition-colors">
                            Pembeli
                        </label>
                    </div>
                </div>
            </div>

            <div>
                <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-primary hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors">
                    Daftar
                </button>
            </div>
        </form>
        
        <div class="text-center">
            <p class="text-sm text-text-muted transition-colors">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300">
                    Masuk di sini
                </a>
            </p>
        </div>
    </div>
</div>
@endsection