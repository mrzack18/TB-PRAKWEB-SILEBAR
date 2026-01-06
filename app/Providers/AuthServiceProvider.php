<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        //
    ];

    public function boot()
    {
        $this->registerPolicies();

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