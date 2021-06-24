<?php

namespace App\Providers;

use App\HttpClient\HttpClientInterface;

interface ProviderInterface
{
    public function getHttpClient(): HttpClientInterface;
}