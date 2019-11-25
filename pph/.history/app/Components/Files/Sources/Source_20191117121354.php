<?php

namespace app\Components\Files\Sources;

use Illuminate\Support\ServiceProvider;

abstract class Source extends ServiceProvider{
    protected $configBasePath = "sources";
    protected $source;
    protected $sourceApiCall;

    $endpoint = "http://my.domain.com/test.php";
$client = new \GuzzleHttp\Client();
$id = 5;
$value = "ABC";

$response = $client->request('GET', $endpoint, ['query' => [
    'key1' => '$id', 
    'key2' => 'Test'
]]);

// url will be: http://my.domain.com/test.php?key1=5&key2=ABC;

$statusCode = $response->getStatusCode();
$content = $response->getBody();
}