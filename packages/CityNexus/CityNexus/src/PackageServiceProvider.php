<?php

namespace CityNexus\CityNexus;

use Illuminate\Support\ServiceProvider;

class PackageServiceProvider extends ServiceProvider
{

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {

        $this->loadViewsFrom(__DIR__.'/views', 'citynexus');

        if (! $this->app->routesAreCached()) {
            require __DIR__ . '/routes.php';
        }

        $this->publishes([
            __DIR__ . '/config.php' => config_path('CityNexus.php'),
        ]);

        // Load migrations
        $this->loadMigrationsFrom(__DIR__ . '/migrations/');

    }


    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {


        $this->publishes([
            __DIR__.'/Public' => public_path('vendor/CityNexus'),
        ], 'public');

    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
        ];
    }
}
