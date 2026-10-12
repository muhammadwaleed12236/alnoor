<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        // Force HTTPS URL generation on live production / SSL servers to prevent Mixed Content blocking
        if (config('app.env') === 'production' || 
            request()->server('HTTP_X_FORWARDED_PROTO') === 'https' || 
            request()->isSecure() ||
            str_starts_with(config('app.url'), 'https://')) {
            URL::forceScheme('https');
        }
    }
}
