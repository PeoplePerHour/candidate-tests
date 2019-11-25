<?php

namespace app\Components\Files\Sources;

use Illuminate\Support\ServiceProvider;

abstract class Source extends ServiceProvider
{
    protected $configBasePath = "sources";
    protected $source;
    protected $sourceApiCall;

    public function doTheCall()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->s . $method_request);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $output = curl_exec($ch);
        curl_close($ch);


        $this->response['response'] = json_decode($output);
    }
}
