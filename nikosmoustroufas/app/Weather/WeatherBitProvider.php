<?php

declare(strict_types=1);

namespace App\Weather;

use GuzzleHttp\Client as HttpClient;
use RuntimeException;

use function floatval;
use function json_decode;

/*
Adapter for WeatherBit Provider
*/
class WeatherBitProvider extends Provider
{
    private $endpoint = 'https://api.weatherbit.io/v2.0/forecast/daily';

    public function __construct(array $conf = [])
    {
        parent::__construct($conf);
    }

    public function getProviderName() : string
    {
        return 'WeatherBit';
    }

    public function makeRequest(array $params) : array
    {
        $query = [
            'key'   => $this->conf['key'],
            'units' => 'M', // Metric, Celsius
            'days'  => 1, // next day forecast
            'lang'  => 'en',
        ];
        if (isset($params['lon']) && isset($params['lat'])) {
            $query['lon'] = $params['lon'];
            $query['lat'] = $params['lat'];
        } elseif (isset($params['location'])) {
            $query['city'] = $params['location'];
            if (isset($params['country'])) {
                $query['country'] = $params['country'];
            }
        } else {
            // no point in making request
            throw new RuntimeException('location or numeric lon/lat parameters are missing', 1);
            //return [];
        }

        $httpClient = new HttpClient();
        $response   = $httpClient->get($this->endpoint, ['query' => $query, 'http_errors' => false]);
        $code       = $response->getStatusCode();
        $body       = (string) $response->getBody();
        $data       = 200 === $code ? json_decode($body, true) : [];
        //tico()->get('logger')->info($this->getProviderName(), ['query' => $query, 'code' => $code, 'body' => $body]);

        $output = [];

        if (isset($data['data']) && isset($data['data'][0])) {
            $output['name']        = $data['city_name'] ?? '';
            $output['longitude']   = floatval($data['lon']);
            $output['latitude']    = floatval($data['lat']);
            $output['temperature'] = floatval($data['data'][0]['temp']);
            $output['units']       = 'Celsius';
            $output['description'] = $data['data'][0]['weather']['description'] ?? '';
        }

        return $output;
    }
}
