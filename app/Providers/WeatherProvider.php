<?php
declare(strict_types=1);

namespace App\Providers;

use App\Services\WeatherService\Providers\OpenWeatherProvider;
use App\Services\WeatherService\Providers\WeatherBitProvider;
use App\Services\WeatherService\WeatherService;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class WeatherProvider extends ServiceProvider
{
    /**
     * Create a single instance of WeatherService App.
     *
     * @return void
     */
    public function register() : void
    {
        $this->app->singleton(WeatherService::class, function ($app) {
            return new WeatherService();
        });
    }


    /**
     * Boot the Weather Providers for the application.
     *
     * @return void
     */
    public function boot() : void
    {
        $this->app->make(WeatherService::class)->register(
            'OpenWeatherProvider',
            new OpenWeatherProvider(Config('provider.openWeather.appId'), new Client())
        );

        $this->app->make(WeatherService::class)->register(
            'WeatherBitProvider',
            new WeatherBitProvider(Config('provider.weatherBit.key'), new Client())
        );
    }

}
