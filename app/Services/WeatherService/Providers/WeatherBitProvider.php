<?php

declare(strict_types=1);

namespace App\Services\WeatherService\Providers;

use App\Services\WeatherService\WeatherInterface;
use GuzzleHttp\Client;
use Illuminate\Http\Response;

class WeatherBitProvider implements WeatherInterface
{
    private $key;

    /**
     * @var Client Client
     */
    private $client;

    /**
     * WeatherBitProvider constructor.
     *
     * @param string $key
     * @param Client $client
     */
    public function __construct(string $key, Client $client)
    {
        $this->key = $key;
        $this->client = $client;
    }

    /**
     * Get forecast for the provided city
     *
     * @param string $cityName
     * @param string $unit
     * @return array
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getWeatherByCity(string $cityName, string $unit) : array
    {
        $params = [
            'query' => [
                'city' => $cityName,
                'units' => ($unit === 'Celsius') ? 'M' : 'I',
                'key' => $this->key
            ]
        ];

        try {
            $res = $this->client->request(
                'GET',
                'http://api.weatherbit.io/v2.0/forecast/daily',
                $params
            );

            $status = $res->getStatusCode();
            $contents = json_decode($res->getBody()->getContents(), true);

            /**
             * Handle Guzzle 6.* issue: https://github.com/guzzle/guzzle/issues/1432
             *
             * When a city is not found the API returns 204 with no body and Guzzle does not handle
             * that so this is a patch until the issue is fixed.
             */
            if (empty($contents) && $status == Response::HTTP_NO_CONTENT) {
                $error = [
                    'errors' => [
                        'status' => (string) Response::HTTP_NOT_FOUND,
                        'detail' => 'city not found',
                    ]
                ];

                throw new \Exception(json_encode($error), Response::HTTP_NOT_FOUND);
            }


        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            $error = [
                'errors' => [
                    'status' => (string) $e->getCode(),
                    'source' => $e->getFile(),
                    'detail' => $contents['message'],
                ]
            ];

            throw new \Exception(json_encode($error), $e->getCode());
        }

        $result = [
            'data' => [
                //This ID represents the record ID from WeatherBit API response.
                'id' => 2,
                'type' => 'forecast',
                'attributes' => [
                    'unit' => $unit,
                    'temp' => $contents['data'][2]['temp'],
                    'description' => $contents['data'][2]['weather']['description'],
                ]
            ]
        ];

        return $result;
    }
}
