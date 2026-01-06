<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // Register custom blade directives
        Blade::if('role', function ($role) {
            return auth()->check() && auth()->user()->role === $role;
        });

        // Define gates for authorization
        Gate::define('admin-only', function ($user) {
            return $user->role === 'admin';
        });

        Gate::define('seller-only', function ($user) {
            return $user->role === 'seller';
        });

        Gate::define('buyer-only', function ($user) {
            return $user->role === 'buyer';
        });
    }
}