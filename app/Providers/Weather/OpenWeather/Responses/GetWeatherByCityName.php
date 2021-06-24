<?php

namespace App\Providers\Weather\OpenWeather\Responses;

use App\Providers\ResponseAbstract;

class GetWeatherByCityName extends ResponseAbstract
{
    /**
     * GetWeatherByCityName constructor.
     */
    public function __construct()
    {
        $this->response = new \stdClass();
    }

    public function getTemperature(): float
    {
        $response = ! is_object($this->response) ? (object) $this->response : $this->response;
        if(property_exists($response, 'main') && property_exists($response->main, 'temp')){
            return floatval($response->main->temp);
        }
        throw new \Exception('No temperature value found');
    }

    public function getTemperatureFeelsLike(): float
    {
        $response = ! is_object($this->response) ? (object) $this->response : $this->response;
        if(property_exists($response, 'main') && property_exists($response->main, 'feels_like')){
            return floatval($response->main->feels_like);
        }
        throw new \Exception('No `feels like` value found');
    }
}