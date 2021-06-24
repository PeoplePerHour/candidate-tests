<?php

namespace App\Providers\Weather\OpenWeather;

use App\Providers\ProviderAbstractConfig;

/**
 * Class OpenWeatherConfig
 *
 * Configuration class about open-weather provider
 *
 * @package Providers\Weather\OpenWeather
 */
class OpenWeatherConfig extends ProviderAbstractConfig
{
    public function getKey(): string
    {
        return $this->getConfigValue('key') ?? '';
    }

    protected function getConfigFilePath(): string
    {
        return (dirname(__FILE__));
    }
}