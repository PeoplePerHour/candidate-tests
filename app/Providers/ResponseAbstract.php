<?php

namespace App\Providers;

use App\HttpClient\HttpClientResponseInterface;

abstract class ResponseAbstract implements ResponseInterface
{
    protected $response;

    public function setResponse(HttpClientResponseInterface $response): ResponseInterface
    {
        $this->response = $response->getBodyFormatted();
        return $this;
    }
}