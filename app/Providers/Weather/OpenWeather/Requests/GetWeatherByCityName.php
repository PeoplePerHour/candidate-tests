<?php

namespace App\Providers\Weather\OpenWeather\Requests;

use App\Providers\RequestAbstract;
use App\Providers\ResponseInterface;

/**
 * Class GetWeatherByCityName
 *
 * Cover the request get temperature based on city name
 *
 * @package Providers\Weather\OpenWeather\Requests
 */
class GetWeatherByCityName extends RequestAbstract
{
    /**
     * Build the required parameters.
     *
     * @param \stdClass $data
     *
     * @return string
     */
    protected function getEndpointQuery(\stdClass $data): string
    {
        $unit = 'metric';
        $unit = (property_exists($data, 'useImperial') && $data->useImperial
            ? 'imperial' : property_exists($data, 'useKelvin') && $data->useKelvin)
            ? 'standard' : $unit;

        return 'weather?' . http_build_query([
                'q' => property_exists($data, 'city_name') ? $data->city_name : '',
                'appid' => property_exists($data, 'appid') ? $data->appid : '',
                'units' => $unit,
            ]);
    }

    public function getVerb(): string
    {
        return 'GET';
    }

    public function getResponseObject(): ResponseInterface
    {
        return new \App\Providers\Weather\OpenWeather\Responses\GetWeatherByCityName();
    }
}