<?php

namespace App\Providers;

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
        // Derrière le proxy TLS de Render, forcer les URL générées en https
        // (sinon @vite sort des liens http:// bloqués en "mixed content").
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
