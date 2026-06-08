<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema; 
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
        Schema::defaultStringLength(191); 

        // Forcer Laravel à rester confiné dans le sous-dossier et en HTTPS sur le serveur
        if (request()->server('HTTP_HOST') === 'ya-consulting.com') {
            URL::forceScheme('https');
            URL::forceRootUrl(config('app.url'));
        }
    }
}