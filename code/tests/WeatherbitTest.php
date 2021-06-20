<?php

class WeatherbitTest extends TestCase
{
    /**
     * @return void
     */
    public function testInitialEndpointStatusCode()
    {
        $this->get('/weather');
        $this->assertEquals(400, $this->response->getStatusCode(), 'Entry point should respond with 400.');
    }
    /**
     * @return void
     */
    public function testValidCaseLatLon()
    {
        $lat = '37.983810';
        $lon = '23.727539';
        $this->get('/weather?' . http_build_query(['lat' => $lat, 'lon' => $lon]));
        $this->assertEquals(200, $this->response->getStatusCode());
        $response_data = json_decode($this->response->getContent(), true);
        $this->assertCount(2, $response_data, 'Response should contain 2 items only: conditions and temperture.');
        $this->assertContains('conditions', array_keys($response_data));
        $this->assertContains('temperature', array_keys($response_data));
    }
    /**
     * @return void
     */
    public function testValidCaseLatLonWithExtraParams()
    {
        $lat = '37.983810';
        $lon = '23.727539';
        $lang = "sv";
        $units = "S";
        $this->get('/weather?' . http_build_query(['lat' => $lat, 'lon' => $lon, 'lang' => $lang, 'units' => $units]));
        $this->assertEquals(200, $this->response->getStatusCode());
        $response_data = json_decode($this->response->getContent(), true);
        $this->assertCount(2, $response_data, 'Response should contain 2 items only: conditions and temperture.');
        $this->assertContains('conditions', array_keys($response_data));
        $this->assertContains('temperature', array_keys($response_data));
    }
    /**
     * @return void
     */
    public function testValidCaseCity()
    {
        $city = "Athens,GR";
        $this->get('/weather?' . http_build_query(['city' => $city]));
        $this->assertEquals(200, $this->response->getStatusCode());
        $response_data = json_decode($this->response->getContent(), true);
        $this->assertCount(2, $response_data, 'Response should contain 2 items only: conditions and temperture.');
        $this->assertContains('conditions', array_keys($response_data));
        $this->assertContains('temperature', array_keys($response_data));
    }
    /**
     * @return void
     */
    public function testValidCaseCityWithExtraParams()
    {
        $city = "Athens,GR";
        $lang = "sv";
        $units = "S";
        $this->get('/weather?' . http_build_query(['city' => $city, 'lang' => $lang, 'units' => $units]));
        $this->assertEquals(200, $this->response->getStatusCode());
        $response_data = json_decode($this->response->getContent(), true);
        $this->assertCount(2, $response_data, 'Response should contain 2 items only: conditions and temperture.');
        $this->assertContains('conditions', array_keys($response_data));
        $this->assertContains('temperature', array_keys($response_data));
    }
    /**
     * @return void
     */
    public function testInvalidCityCase()
    {
        $city = "dsrths35hsrhthsthreth";
        $this->get('/weather?' . http_build_query(['city' => $city]));
        $this->assertEquals(200, $this->response->getStatusCode());
        $response_data = json_decode($this->response->getContent(), true);
        $this->assertContains('status_code', array_keys($response_data));
        $this->assertEquals(204, $response_data['status_code']);
    }
     /**
     * @return void
     */
    public function testInvalidLatLonCase()
    {
        $lat = '055.r346346';
        $lon = '199.73r25837';
        $this->get('/weather?' . http_build_query(['lat' => $lat, 'lon' => $lon]));
        $this->assertEquals(200, $this->response->getStatusCode());
        $response_data = json_decode($this->response->getContent(), true);
        $this->assertContains('status_code', array_keys($response_data));
        $this->assertEquals(400, $response_data['status_code']);
    }
    /**
     * @return void
     */
    public function testInvalidMissingDataCase()
    {
        $this->get('/weather?' . http_build_query(['city' => '']));
        $this->assertEquals(200, $this->response->getStatusCode());
        $response_data = json_decode($this->response->getContent(), true);
        $this->assertContains('status_code', array_keys($response_data));
        $this->assertEquals(400, $response_data['status_code']);
    }
}
