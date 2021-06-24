<?php

namespace App\Providers;

use App\HttpClient\HttpClientInterface;

class ProviderAbstract implements ProviderInterface
{
    /**
     * @var \App\Providers\ProviderAbstractConfig
     */
    protected Weather\OpenWeather\OpenWeatherConfig $config;

    /**
     * @var \App\HttpClient\HttpClientInterface
     */
    protected HttpClientInterface $httpClient;

    /**
     * OpenWeatherProvider constructor.
     */
    public function __construct(ProviderAbstractConfig $config, HttpClientInterface $client)
    {
        $this->config = $config;
        $this->httpClient = $client;
    }

    public function getHttpClient(): HttpClientInterface
    {
        return $this->httpClient;
    }

    /**
     * @param \App\Providers\RequestInterface $request
     * @param \stdClass $data
     *
     * @return \App\Providers\ResponseInterface
     * @throws \Exception
     */
    public function sendRequest(RequestInterface $request, \stdClass $data): ResponseInterface
    {
        $endpoint = $request->getEndpoint($data);
        $sendData = $request->prepareData($data);
        $request->validate($sendData);

        $response = $this->getHttpClient()->execute($request->getVerb(), $endpoint, $request->getHeaders($data), $sendData);
        if ($response->hasErrors())
        {
            $errorMessage = sprintf('Request to `%s` Failed', $endpoint);
            throw new \Exception($errorMessage);
        }
        return $request->getResponseObject()->setResponse($response);
    }
}