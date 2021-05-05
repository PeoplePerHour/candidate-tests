<?php

declare(strict_types=1);

namespace App\Weather;

use GuzzleHttp\Client as HttpClient;
use RuntimeException;

use function floatval;
use function json_decode;

/*
Adapter for OpenWeatherMap Provider
*/
class OpenWeatherMapProvider extends Provider
{
    private $endpoint = 'https://api.openweathermap.org/data/2.5/onecall';

    public function __construct(array $conf = [])
    {
        parent::__construct($conf);
    }

    public function getProviderName() : string
    {
        return 'OpenWeatherMap';
    }

    public function makeRequest(array $params) : array
    {
        $query = [
            'appid' => $this->conf['key'],
            'units' => 'metric', // Metric, Celsius
            //'mode'  => 'json',
            'lang'    => 'en',
            'exclude' => 'current,minutely,hourly,alerts',
        ];
        if (isset($params['lon']) && isset($params['lat'])) {
            // OpenWeatherMap OneCall API supports only lon/lat specification
            $query['lon'] = $params['lon'];
            $query['lat'] = $params['lat'];
        } else {
            // no point in making request
            throw new RuntimeException('numeric lon/lat parameters are missing', 1);
            //return [];
        }

        $httpClient = new HttpClient();
        $response   = $httpClient->get($this->endpoint, ['query' => $query, 'http_errors' => false]);
        $code       = $response->getStatusCode();
        $body       = (string) $response->getBody();
        $data       = 200 === $code ? json_decode($body, true) : [];
        //tico()->get('logger')->info($this->getProviderName(), ['query' => $query, 'code' => $code, 'body' => $body]);

        $output = [];

        if (isset($data['daily']) && isset($data['daily'][0])) {
            $output['name']        = $data['city']['name'] ?? '';
            $output['longitude']   = floatval($data['lon']);
            $output['latitude']    = floatval($data['lat']);
            $output['temperature'] = floatval($data['daily'][0]['temp']['day']);
            $output['units']       = 'Celsius';
            $output['description'] = $data['daily'][0]['weather'][0]['description'] ?? '';
        }

        return $output;
    }
}
