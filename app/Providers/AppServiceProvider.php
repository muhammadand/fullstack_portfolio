<?php

namespace App\Providers;

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
        // Push notification ke HP admin untuk kejadian penting (lihat app/Support/AdminActivityHooks.php).
        \App\Support\AdminActivityHooks::register();
    }
}
