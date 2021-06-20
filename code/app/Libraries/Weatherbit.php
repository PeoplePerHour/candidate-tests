<?php

namespace App\Libraries;

use Log;
use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;

/** Weatherbit
 * 
 * This is a custom small library (class) that will be used in order to talk with WeatherBit rest api.
 * It is a small implementation just for the sake of the test.
 */
class Weatherbit
{
    protected $service_url;
    public $params = [];

    public function __construct()
    {
        $this->service_url = env('WEATHERBIT_BASEURL', '');
    }

    public function call($service, $params)
    {
        $client = new GuzzleHttpClient();
        $params['key'] = env('WEATHERBIT_APIKEY', '');
        $data = ['cache' => false, 'data' => []]; //initialize data,
        $request = null;
        try {
            $request = $client->request('GET', $this->service_url . $service, ['query' => $params]);
        } catch(RequestException $e) {
            $data['data']['status_message'] = 'Weatherbit request was unsuccessful. Please contact our administrators.';
            $data['data']['status_code'] = $e->getCode();
            Log::error("[WEATHERBIT][REQUEST EXCEPTION]: " . $e->getCode() . $e->getMessage());
            return $data;
        } catch(ClientException $e) {
            $data['data']['status_message'] = 'Weatherbit request was unsuccessful. Please contact our administrators.';
            $data['data']['status_code'] = $e->getCode();
            Log::error("[WEATHERBIT][CLIENT EXCEPTION]: " . $e->getCode() . $e->getMessage());
            return $data;
        } catch(\Exception $e) {
            $data['data']['status_message'] = 'There was an issue talking with weatherbit. Please contact our administrators.';
            $data['data']['status_code'] = $e->getCode();
            Log::error("[WEATHERBIT][EXCEPTION]: " . $e->getCode() . $e->getMessage());
            return $data;
        }
        // request present, we may continue.
        $statusCode = $request->getStatusCode();
        if ($statusCode !== 200) {
            $data['data']['status_message'] = 'Unsuccessful operation';
            $data['data']['status_code'] = $statusCode;
            Log::error("[WEATHERBIT][UNSUCCESSFUL RESPONSE]: " . $statusCode);
        }
        $response = json_decode($request->getBody(), true);
        if ($response && array_key_exists('count', $response) && $response['count'] === 1) {
            $obj = $response['data'][0];
            $data['cache'] = true; // enable caching
            $data['data'] = [
                'conditions' => $obj['weather']['description'],
                'temperature' => $obj['temp'],
            ];
            Log::info("[WEATHERBIT][REQUEST]: " . $this->service_url . $service . http_build_query($params));
        }
        return $data;
    }
}