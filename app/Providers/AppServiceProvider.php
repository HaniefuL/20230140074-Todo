<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Policies\ProductPolicy;
use App\Policies\CategoryPolicy;
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

        // Category Gates - Only Admin can manage categories
        Gate::define('view-category', function (User $user) {
            return true; // All authenticated users can view categories
        });

        Gate::define('create-category', function (User $user) {
            return $user->role === 'admin';
        });

        Gate::define('edit-category', function (User $user) {
            return $user->role === 'admin';
        });

        Gate::define('delete-category', function (User $user) {
            return $user->role === 'admin';
        });

        // Policies
        Gate::policy(Product::class, ProductPolicy::class);
        Gate::policy(Category::class, CategoryPolicy::class);
    }
}
