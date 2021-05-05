<?php

declare(strict_types=1);

namespace App\Test;

use GuzzleHttp\Client as HttpClient;
use PHPUnit\Framework\TestCase;

class BasicTest extends TestCase
{
    private $endpoint = 'http://127.0.0.1:8000/api';
    private $jsonapi  = 'application/vnd.api+json';
    private $http;

    protected function setUp() : void
    {
        $this->http = new HttpClient();
    }

    protected function tearDown() : void
    {
        $this->http = null;
    }

    public function testFailure1() : void
    {
        $response = $this->http->get($this->endpoint, ['http_errors' => false]);

        $this->assertEquals(400, $response->getStatusCode());

        $this->assertEquals($this->jsonapi, $response->getHeaders()["Content-Type"][0]);

        $data = json_decode((string) $response->getBody(), true);

        $this->assertArrayHasKey('errors', $data);
        $this->assertEquals('location or numeric lon/lat params shoud be given', $data['errors'][0]['title']);
    }

    public function testFailure2() : void
    {
        $response = $this->http->get($this->endpoint, [
            'query' => [
                'provider' => 'openweathermap',
                'location' => 'London',
                'country'  => 'UK',
                'units'    => 'C',
            ],
            'http_errors' => false
        ]);

        $this->assertEquals(500, $response->getStatusCode());

        $this->assertEquals($this->jsonapi, $response->getHeaders()["Content-Type"][0]);

        $data = json_decode((string) $response->getBody(), true);

        $this->assertArrayHasKey('errors', $data);
        $this->assertEquals('numeric lon/lat parameters are missing', $data['errors'][0]['title']);
    }

    public function testFailure3() : void
    {
        $response = $this->http->get($this->endpoint, [
            'query' => [
                'provider' => 'foo',
                'lon'      => -93.25296,
                'lat'      => 35.32897,
                'units'    => 'F',
            ],
            'http_errors' => false
        ]);

        $this->assertEquals(400, $response->getStatusCode());

        $this->assertEquals($this->jsonapi, $response->getHeaders()["Content-Type"][0]);

        $data = json_decode((string) $response->getBody(), true);

        $this->assertArrayHasKey('errors', $data);
        $this->assertEquals('provider param must be one of {weatherbit,openweathermap}', $data['errors'][0]['title']);
    }

    public function testSuccess1() : void
    {
        $response = $this->http->get($this->endpoint, [
            'query' => [
                //'provider' => 'weatherbit',
                'lon'      => -93.25296,
                'lat'      => 35.32897,
                'units'    => 'C',
            ],
            'http_errors' => false
        ]);

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertEquals($this->jsonapi, $response->getHeaders()["Content-Type"][0]);

        $data = json_decode((string) $response->getBody(), true);

        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('type', $data['data']);
        $this->assertEquals('WeatherBit', $data['data']['type']);
        $this->assertArrayHasKey('attributes', $data['data']);
        $this->assertArrayHasKey('temperature', $data['data']['attributes']);
        $this->assertEquals('Celsius', $data['data']['attributes']['units']);
        $this->assertArrayHasKey('description', $data['data']['attributes']);
    }

    public function testSuccess2() : void
    {
        $response = $this->http->get($this->endpoint, [
            'query' => [
                'provider' => 'openweathermap',
                'lon'      => -93.25296,
                'lat'      => 35.32897,
                'units'    => 'C',
            ],
            'http_errors' => false
        ]);

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertEquals($this->jsonapi, $response->getHeaders()["Content-Type"][0]);

        $data = json_decode((string) $response->getBody(), true);

        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('type', $data['data']);
        $this->assertEquals('OpenWeatherMap', $data['data']['type']);
        $this->assertArrayHasKey('attributes', $data['data']);
        $this->assertArrayHasKey('temperature', $data['data']['attributes']);
        $this->assertEquals('Celsius', $data['data']['attributes']['units']);
        $this->assertArrayHasKey('description', $data['data']['attributes']);
    }

    public function testSuccess3() : void
    {
        $response = $this->http->get($this->endpoint, [
            'query' => [
                'provider' => 'weatherbit',
                'location' => 'London',
                'country'  => 'UK',
                'units'    => 'F',
            ],
            'http_errors' => false
        ]);

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertEquals($this->jsonapi, $response->getHeaders()["Content-Type"][0]);

        $data = json_decode((string) $response->getBody(), true);

        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('type', $data['data']);
        $this->assertEquals('WeatherBit', $data['data']['type']);
        $this->assertArrayHasKey('attributes', $data['data']);
        $this->assertArrayHasKey('temperature', $data['data']['attributes']);
        $this->assertEquals('Fahrenheit', $data['data']['attributes']['units']);
        $this->assertArrayHasKey('description', $data['data']['attributes']);
        $this->assertEquals('London', $data['data']['attributes']['name']);
    }

    public function testInvalidEndpoint() : void
    {
        $response = $this->http->get('http://127.0.0.1:8000/foo', ['http_errors' => false]);

        $this->assertEquals(404, $response->getStatusCode());

        $this->assertEquals($this->jsonapi, $response->getHeaders()["Content-Type"][0]);

        $data = json_decode((string) $response->getBody(), true);

        $this->assertArrayHasKey('errors', $data);
        $this->assertEquals('Invalid Route', $data['errors'][0]['title']);
    }
}
