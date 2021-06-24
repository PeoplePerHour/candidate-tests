<?php

namespace App\Providers\Weather\OpenWeather;

use App\HttpClient\Curl\CurlClient;
use App\Models\TemperatureModel;
use App\Providers\ProviderAbstract;
use App\Providers\Weather\WeatherProviderInterface;

class OpenWeatherProvider extends ProviderAbstract implements WeatherProviderInterface
{
    /**
     * @var \App\Providers\Weather\OpenWeather\OpenWeatherConfig
     */
    protected OpenWeatherConfig $config;

    /**
     * @var \App\HttpClient\HttpClientInterface
     */
    protected \App\HttpClient\HttpClientInterface $httpClient;

    /**
     * OpenWeatherProvider constructor.
     */
    public function __construct(OpenWeatherConfig $config = null)
    {
        $config = $config ?? new OpenWeatherConfig();
        parent::__construct($config, new CurlClient('application\json'));
    }

    /**
     * @inheritDoc
     */
    public function getTemperatureByCityName(string $city): float
    {
        $data = new \stdClass();
        $data->city_name = $city;
        $data->appid = $this->config->getKey();

        /** @var \App\Providers\Weather\OpenWeather\Responses\GetWeatherByCityName $response */
        $response = $this->sendRequest(new Requests\GetWeatherByCityName($this->config->getHost()), $data);
        return $response->getTemperature();
    }

    /**
     * @inheritDoc
     */
    public function getNextDayForecastByCityName(string $city, string $unit = 'metric'): TemperatureModel
    {
        $data = new \stdClass();
        $data->city_name = $city;
        $data->appid = $this->config->getKey();
        if ($unit == 'imperial')
        {
            $data->useImperial = true;
        }
        elseif ($unit == 'kelvin')
        {
            $data->useKelvin = true;
        }
        elseif ($unit == 'metric')
        {
            $data->useMetric = true;
        }

        /** @var \App\Providers\Weather\OpenWeather\Responses\GetNextDayForecastByCityName $response */
        $response = $this->sendRequest(new Requests\GetNextDayForecastByCityName($this->config->getHost()), $data);
        return $response->getTemperature();
    }
}