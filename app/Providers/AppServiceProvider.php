<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Product;
use App\Policies\ProductPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('export-product', function (User $user) {
            return $user->role === 'admin';
        });

        Gate::policy(Product::class, ProductPolicy::class);
    }
}
