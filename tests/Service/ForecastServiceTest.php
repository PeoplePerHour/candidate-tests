<?php

namespace App\Tests\Service;

use App\Service\ForecastService;
use App\Kernel;
use Symfony\Component\HttpClient\CurlHttpClient;
use PHPUnit\Framework\TestCase;

/**
 * ForecastServiceTest
 *
 * @author Ilya Panovskiy <panovskiy1980@gmail.com>
 */
class ForecastServiceTest extends TestCase
{
    private array $params;
    private string $provider;
    private string $tempUnit;
    private string $location;


    protected function setUp(): void
    {
        $kernel = new Kernel($_SERVER['APP_ENV'], false);
        $kernel->boot();
        $container = $kernel->getContainer();
        
        $this->params = $container->getParameter('wheatherApi');
        $this->provider = 'weatherbit';
        $this->tempUnit = 'cel';
        $this->location = 'London,GB';
    }
    
    public function testPrepareCall(): void
    {
        $forecast = new ForecastService($this->params, new CurlHttpClient());
        $forecast->prepareCall([
            'location' => $this->location, 
            'tempUnit' => $this->tempUnit, 
            'provider' => $this->provider
        ]);
        
        $expectedLocation = $this->location;
        $expectedTempUnit = $this->params[ForecastService::PROVIDERS]
                [$this->provider][ForecastService::ALL_TEMP_UNITS][$this->tempUnit];
        $expectedUri = $this->params[ForecastService::PROVIDERS]
                [$this->provider][ForecastService::URI];
        $expectedQuery = [
            'days' => 2, //part of original query
            'key' => $this->params[ForecastService::PROVIDERS]
                [$this->provider][ForecastService::QUERY]['key'], //part of original query
            'city' => $this->location,
            'units' => $this->params[ForecastService::PROVIDERS]
                [$this->provider][ForecastService::ALL_TEMP_UNITS][$this->tempUnit],
        ];
        $expectedUrl = 'https://api.weatherbit.io/v2.0/forecast/daily?days=2&key=a742c8e824274bb0a2dcc2abb39a1797&city=London%2CGB&units=M';
        
        $refObject = new \ReflectionClass($forecast);
        
        $reflection = $refObject->getProperty('location');
	$reflection->setAccessible(true);
        
        $this->assertEquals($expectedLocation, $reflection->getValue($forecast));
        
        $reflection = $refObject->getProperty('tempUnit');
	$reflection->setAccessible(true);
        
        $this->assertEquals($expectedTempUnit, $reflection->getValue($forecast));
        
        $reflection = $refObject->getProperty('uri');
	$reflection->setAccessible(true);
        
        $this->assertEquals($expectedUri, $reflection->getValue($forecast));
        
        $reflection = $refObject->getProperty('query');
	$reflection->setAccessible(true);
        
        $this->assertEquals($expectedQuery, $reflection->getValue($forecast));
        
	$reflection = $refObject->getProperty('url');
	$reflection->setAccessible(true);
        
        $this->assertEquals($expectedUrl, $reflection->getValue($forecast));
    }
}
