<?php

namespace App\Providers;

use App\Models\User;
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
     *
     * The "admin" ability for the super admin pages (route: middleware('can:admin')).
     */
    public function boot(): void
    {
        Gate::define('admin', fn (User $user) => $user->isAdmin());
    }
}
