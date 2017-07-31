<?php

namespace App\Providers;

use App\CustomFacades\Classes\GoogleApi;
use Illuminate\Support\ServiceProvider;

class CustomFacadesProvider extends ServiceProvider
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
        $this->app->bind('google-api', function () {
            return new GoogleApi();
        });
    }
}
