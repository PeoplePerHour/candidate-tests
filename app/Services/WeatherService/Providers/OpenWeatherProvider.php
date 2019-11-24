<?php

declare(strict_types=1);

namespace App\Services\WeatherService\Providers;

use App\Services\WeatherService\WeatherInterface;
use GuzzleHttp\Client;

class OpenWeatherProvider implements WeatherInterface
{
    private $key;

    /**
     * @var Client Client
     */
    private $client;

    public function __construct(string $key, Client $client)
    {
        $this->key = $key;
        $this->client = $client;
    }

    public function getWeatherByCity(string $cityName, string $unit) : array
    {
        $params = [
            'query' => [
                'q' => $cityName,
                'units' => ($unit === 'Celsius') ? 'metric' : 'imperial',
                'appid' => $this->key
            ]
        ];

        try {
            $res = $this->client->request(
                'GET',
                'http://api.openweathermap.org/data/2.5/forecast',
                $params
            );

        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            $contents = json_decode($e->getResponse()->getBody()->getContents(), true);

            $res = [
                'errors' => [
                    'status' => (string) $e->getCode(),
                    'source' => $e->getFile(),
                    'detail' => $contents['message'],
                ]
            ];

            throw new \Exception(json_encode($res), $e->getCode());
        }

        $contents = json_decode($res->getBody()->getContents(), true);

        $result = [
            'data' => [
                //This ID represents the record ID from OpenWeather API response.
                'id' => 9,
                'type' => 'forecast',
                'attributes' => [
                    'unit' => $unit,
                    'temp' => $contents['list'][9]['main']['temp'],
                    'description' => $contents['list'][9]['weather'][0]['description'],
                ]
            ]
        ];

        return $result;
    }
}
