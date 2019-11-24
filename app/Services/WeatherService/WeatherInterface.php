<?php

declare(strict_types=1);

namespace App\Services\WeatherService;

interface WeatherInterface
{
    public function getWeatherByCity(string $cityName, string $unit) : array ;
}
