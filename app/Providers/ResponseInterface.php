<?php

namespace App\Providers;

use App\HttpClient\HttpClientResponseInterface;

interface ResponseInterface
{
    /**
     * @param HttpClientResponseInterface $response
     *
     * @return \App\Providers\ResponseInterface
     */
    public function setResponse(HttpClientResponseInterface $response): ResponseInterface;
}