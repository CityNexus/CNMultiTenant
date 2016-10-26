<?php

namespace CityNexus\DataStore;

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

        $this->publishes([
            __DIR__ . '/config.php' => config_path('CityNexus.php'),
        ]);

        // Load migrations
        $this->loadMigrationsFrom(__DIR__ . '/migrations/');

        // load front end
        require_once __DIR__ . '/DataStore.php';

        // load helpers
        require_once __DIR__ . '/helpers/AWS.php';

    }


    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

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
