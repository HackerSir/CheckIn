<?php

namespace App\ExtendThrottle;

use Illuminate\Support\ServiceProvider;

class ExtendThrottleFacadesProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('extend-throttle', function () {
            return new ExtendThrottle();
        });
    }
}
