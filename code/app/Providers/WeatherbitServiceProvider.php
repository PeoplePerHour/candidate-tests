<?php

namespace App\Providers;

use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;
use App\Libraries\Weatherbit;

class WeatherbitServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Weatherbit::class, function ($app) {
            return new Weatherbit();
        });
    }
}