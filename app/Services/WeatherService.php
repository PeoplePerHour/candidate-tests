<?php

namespace App\Services;

use App\Models\TemperatureModel;
use App\Providers\Weather\WeatherProviderInterface;

class WeatherService
{
    /**
     * @var \App\Providers\Weather\WeatherProviderInterface
     */
    protected WeatherProviderInterface $provider;

    /**
     * WeatherService constructor.
     */
    public function __construct(WeatherProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    /**
     * @param string $city
     *
     * @throws \Exception
     */
    public function getTemperatureFor(string $city)
    {
        $temperature = $this->provider->getTemperatureByCityName($city);
    }

    /**
     * @param string $city
     * @param string $unit
     *
     * @return \App\Models\TemperatureModel
     * @throws \Exception
     */
    public function get24HForecastFor(string $city, string $unit = "metric"): TemperatureModel
    {
        return $this->provider->getNextDayForecastByCityName($city, $unit);
    }
}