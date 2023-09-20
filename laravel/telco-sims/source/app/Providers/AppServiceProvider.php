<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
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
        // Set the default string length for migrations to 191 characters to ensure compatibility 
        // with older MySQL versions (< 5.7.7) when using the utf8mb4 character set (which supports emojis).
        Schema::defaultStringLength(191);
    }
}
