<?php

declare(strict_types=1);

namespace App\Weather;

use InvalidArgumentException;

use function array_merge;
use function number_format;
use function strtolower;
use function strtoupper;

class Provider
{
    public const CACHETTL = 2 * 60 * 60; /* up to 2 hours cache time */

    public static function getSupportedProviders() : array
    {
        return ['weatherbit', 'openweathermap'];
    }

    public static function getProvider(string $providerId, array $conf = []) : ?self
    {
        // Factory Method Pattern
        // Each Provider Subclass is an Adapter for a 3rd-party Provider

        $conf = array_merge([
            'openweathermap' => [],
            'weatherbit'     => [],
        ], $conf);

        switch (strtolower($providerId)) {
            case 'openweathermap':
                return new OpenWeatherMapProvider($conf['openweathermap']);
            case 'weatherbit':
                return new WeatherBitProvider($conf['weatherbit']);
            default:
                throw new InvalidArgumentException('unknown weather provider', 1);
        }
    }

    public $conf = null;

    public function __construct(array $conf = [])
    {
        $this->conf = $conf;
    }

    public function getProviderName() : string
    {
        return '';
    }

    public function c2F(float $t) : float
    {
        // Celsius to Fahrenheit
        return ($t * 9 / 5) + 32;
    }

    public function f2C(float $t) : float
    {
        // Fahrenheit to Celsius
        return ($t - 32) * 5 / 9;
    }

    public function computeCacheKey(array $params) : string
    {
        if (isset($params['lon']) && isset($params['lat'])) {
            $key = 'c_' . $params['lon'] . '_' . $params['lat'];
        } elseif (isset($params['location'])) {
            $key = 'a_' . strtolower($params['location']) . '_' . strtolower($params['country'] ?? '');
        } else {
            $key = '';
        }
        return strtolower($this->getProviderName()) . '_' . $key;
    }

    public function makeRequest(array $params) : array
    {
        return [];
    }

    public function getPrediction(array $params) : array
    {
        // Template Method Pattern
        // Each Subclass implements the sub-methods as needed

        $cache    = tico()->get('cache');
        $cacheKey = $cache ? $this->computeCacheKey($params) : '';

        $data = false;

        if ($cache) {
            $data = $cache->get($cacheKey);
        }

        if (! $data) {
            $data = $this->makeRequest($params);

            if ($cache && ! empty($data)) {
                $cache->put($cacheKey, $data, static::CACHETTL);
            }
        }

        if (! empty($data)) {
            $units = strtoupper($params['units'] ?? 'C');
            if ('F' === $units && 'Celsius' === $data['units']) {
                // Celsius to Fahrenheit conversion
                $data['temperature'] = $this->c2F($data['temperature']);
                $data['units']       = 'Fahrenheit';
            } elseif ('C' === $units && 'Fahrenheit' === $data['units']) {
                // Fahrenheit to Celsius conversion
                $data['temperature'] = $this->f2C($data['temperature']);
                $data['units']       = 'Celsius';
            }

            // round up to 3 decimal places
            $data['temperature'] = (float) number_format((float) $data['temperature'], 3, '.', '');
        }

        return $data;
    }
}
