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
        // Eliminado el binding innecesario
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
