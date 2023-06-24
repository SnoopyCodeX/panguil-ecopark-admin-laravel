<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;
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
        Paginator::useBootstrapFive();

        // If app is not in debug mode and not in local environment, force url scheme to 'https'
        // echo "Debug: " . (env('APP_DEBUG') ? 'true' : 'false') . "<br>Env: " . env('APP_ENV');
        if(!env('APP_DEBUG', true) && env('APP_ENV') != 'local')
            URL::forceScheme('https');
    }
}
