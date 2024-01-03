<?php

namespace App\Providers;

use App\Services\Geolocation\Geolocation;
use App\Services\Map\Map;
use App\Services\Satellite\Satellite;
use Illuminate\Support\ServiceProvider;

class GeolocationServiceProvider extends ServiceProvider
{
    // Important Note! Service Provider should be register in the DI Container thru config\app.php's providers array prop


    /**
     * Register services.
     */
    public function register(): void
    {
        //$this->app->singleton should be used if only one instance would suffice
        //$this->app->bind should be if every new instance will be returned
        $this->app->singleton
        (Geolocation::class, function ($app) {
            $map = new Map();
            $satellite = new Satellite();

            return new Geolocation($map, $satellite);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Note! This is called after this Service Provider is setup
    }
}
