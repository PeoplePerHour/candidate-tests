<?php

namespace App\Handlers;

use App\Services\WeatherService;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class TemperatureHandler
{
    /**
     * @var \App\Services\WeatherService
     */
    protected WeatherService $weatherService;

    private ContainerInterface $container;

    // constructor receives container instance
    public function __construct(ContainerInterface $container, WeatherService $weatherService)
    {
        $this->container = $container;
        $this->weatherService = $weatherService;
    }

    public function getNextDay(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $responseMessage = sprintf('Location: %s, Unit: %s, Provider: %s',
            $args['location'], $args['unit'], $args['provider'] ?? 'default');

        $unit = $args['unit'];

        if ($unit == 'k' || $unit == 'K' || $unit == 'kelvin')
        {
            $unit = 'kelvin';
        }
        elseif ($unit == 'f' || $unit == 'F' || $unit == 'fahrenheit')
        {
            $unit = 'imperial';
        }
        elseif ($unit == 'c' || $unit == 'C' || $unit == 'celsius')
        {
            $unit = 'metric';
        }
        else
        {
            $unit = 'metric';
        }
        $model = $this->weatherService->get24HForecastFor($args['location'], $unit);

        $responseMessage = sprintf('Location: %s, Unit: %s, Provider: %s --- Temperature : %.2f , details: %s' ,
            $args['location'], $args['unit'], $args['provider'] ?? 'default', $model->getValue(), $model->getDetails());
        $response->getBody()->write($responseMessage);
        return $response;
    }
}