<?php

namespace app\Components\Files\Sources;

use Illuminate\Support\ServiceProvider;

abstract class Source extends ServiceProvider
{
    protected $configBasePath = "sources";
    protected $source;
    protected $sourceApiCall;
    protected $headers;
    protected $response;

    public function doTheCall()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->sourceApiCall);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->postfields);
        $output = curl_exec($ch);
        curl_close($ch);
        $this->response = json_decode($output);
    }
}
