<?php

namespace App\Providers\Weather;

use App\Models\TemperatureModel;

interface WeatherProviderInterface
{
    /**
     * Execute a request and return the actual temperature for the given city
     *
     * @param string $city
     *
     * @return float
     * On Success return a float with the current temperature of given city,
     * On Errors like error city name or no response return 0
     * @throws \Exception  if request failed
     * @throws \Exception if response structure is not the accepted
     */
    public function getTemperatureByCityName(string $city): float;

    /**
     * Execute a request and return the temperature 1 day forecast for the given city
     *
     * @param string $city
     * @param string $unit
     *
     * @return TemperatureModel
     * On Success return an instance of TemperatureModel
     * On Errors throw errors
     * @throws \Exception if request failed
     * @throws \Exception if response structure is not the accepted
     */
    public function getNextDayForecastByCityName(string $city, string $unit= 'metric'): TemperatureModel;
}