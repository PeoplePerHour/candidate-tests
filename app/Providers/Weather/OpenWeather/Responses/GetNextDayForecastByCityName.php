<?php

namespace App\Providers\Weather\OpenWeather\Responses;

use App\HttpClient\HttpClientResponseInterface;
use App\Models\TemperatureModel;
use App\Providers\ResponseAbstract;
use App\Providers\ResponseInterface;

class GetNextDayForecastByCityName extends ResponseAbstract
{
    /**
     * GetWeatherByCityName constructor.
     */
    public function __construct()
    {
        $this->response = new \stdClass();
    }

    public function setResponse(HttpClientResponseInterface $response): ResponseInterface
    {
        parent::setResponse($response);
        $this->response = json_decode($response->getBodyRaw());
        return $this;
    }
    /**
     * @throws \Exception
     */
    public function getTemperature(): TemperatureModel
    {
        $response = ! is_object($this->response) ? (object) $this->response : $this->response;
        if (property_exists($response, 'list') && is_array($response->list))
        {
            //Get 1st
            $current = $response->list[0];
            $tomorrow = false;
            //search all the results until we find the element that keep the temperature for 24h after.
            foreach ($response->list as $item)
            {
                if ($item->dt == $current->dt + 86400)
                {
                    $tomorrow = $item;
                    break;
                }
            }
            if (! $tomorrow)
            {
                throw new \Exception('No temperature value found');
            }

            if (! (property_exists($tomorrow, 'main') && property_exists($tomorrow->main, 'temp')
                && property_exists($tomorrow, 'weather') && is_array($tomorrow->weather)
                && property_exists($tomorrow->weather[0], 'description')))
            {
                throw new \Exception('invalid structure');
            }
            return new TemperatureModel($tomorrow->main->temp, $tomorrow->weather[0]->description);
        }
        throw new \Exception('No temperature value found');
    }
}