<?php

declare(strict_types=1);

use App\Services\WeatherService\Providers\OpenWeatherProvider;
use App\Services\WeatherService\WeatherService;
use Laravel\Lumen\Testing\WithoutMiddleware;

class WeatherControllerTest extends TestCase
{
    use WithoutMiddleware;

    /** @var WeatherService|Mockery\Mock $mockWeatherService */
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

    public function testShowWeather()
    {
        $res = [
            'data' => [
                'id' => 2,
                'type' => 'forecast',
                'attributes' => [
                    'unit' => 'Celsius',
                    'temp' => 16,
                    'description' => 'broken clouds',
                ]
            ]
        ];

        $this->mockWeatherService->shouldReceive('get')
            ->once()
            ->with('OpenWeatherProvider')
            ->andReturn($this->mockOpenWeatherProvider);

        $this->mockOpenWeatherProvider->shouldReceive('getWeatherByCity')
            ->once()
            ->with('London', 'Celsius')
            ->andReturn($res);

        $params = [
                'location' => 'London',
                'unit' => 'Celsius',
                'provider' => 'OpenWeatherProvider'
        ];

        $this->post(
            '/weather',
            $params
        );

        $this->assertEquals(json_encode($res), $this->response->getContent());
    }

    public function testShowWeatherMissingParameter()
    {
        $res = ['errors' => [
            'source' => 'a source file',
            'detail' => 'The location field is required.',
        ]];

        $params = [
            'location' => '',
            'unit' => 'Celsius',
            'provider' => 'OpenWeatherProvider'
        ];

        $this->post(
            '/weather',
            $params
        );

        $actual = json_decode($this->response->getContent(),true);

        $this->assertArrayHasKey('detail', $actual['errors'][0]);
        $this->assertEquals($res['errors']['detail'], $actual['errors'][0]['detail']);
    }

    public function testShowWeatherDefaultProvider()
    {
        $res = [
            'data' => [
                'id' => 2,
                'type' => 'forecast',
                'attributes' => [
                    'unit' => 'Celsius',
                    'temp' => 16,
                    'description' => 'broken clouds',
                ]
            ]
        ];

        $this->mockWeatherService->shouldReceive('get')
            ->with('OpenWeatherProvider')
            ->andReturn($this->mockOpenWeatherProvider);

        $this->mockOpenWeatherProvider->shouldReceive('getWeatherByCity')
            ->with('London', 'Celsius')
            ->andReturn($res);

        $params = [
            'location' => 'London',
            'unit' => 'Celsius',
            'provider' => ''
        ];

        $this->post(
            '/weather',
            $params
        );

        $this->assertEquals(json_encode($res), $this->response->getContent());

        $params = [
            'location' => 'London',
            'unit' => 'Celsius',
        ];

        $this->post(
            '/weather',
            $params
        );

        $this->assertEquals(json_encode($res), $this->response->getContent());
    }
}
