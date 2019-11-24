<?php

declare(strict_types=1);


use App\Services\WeatherService\Providers\OpenWeatherProvider;
use App\Services\WeatherService\WeatherService;

class WeatherServiceTest extends TestCase
{

    /** @var WeatherService|\Mockery\LegacyMockInterface|\Mockery\MockInterface */
    private $mockWeatherService;

    /** @var OpenWeatherProvider|\Mockery\LegacyMockInterface|\Mockery\MockInterface */
    private $mockOpenWeatherProvider;

    public function setUp() : void
    {
        parent::setUp();

        $this->mockWeatherService = Mockery::mock(WeatherService::class);
        $this->mockOpenWeatherProvider = Mockery::mock(OpenWeatherProvider::class);

        $this->app->instance(WeatherService::class, $this->mockWeatherService);
        $this->app->instance(OpenWeatherProvider::class, $this->mockOpenWeatherProvider);
    }

    public function testRegister()
    {
        $this->assertTrue(true);
    }

    public function testGet()
    {
        $this->assertTrue(true);
    }



}
