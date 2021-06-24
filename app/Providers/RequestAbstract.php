<?php

namespace App\Providers;

abstract class RequestAbstract implements RequestInterface
{
    /**
     * @var string
     */
    protected $host;

    /**
     * RequestAbstract constructor.
     */
    public function __construct(string $host)
    {
        $this->host = $host;
    }

    /**
     * In order to build the endpoint for each request we combine the host and all the required query parameters,
     * which may differs for each request
     *
     * @param \stdClass $data
     *
     * @return string
     */
    public function getEndpoint(\stdClass $data): string
    {
        $host = rtrim($this->host, '/');
        $query = ltrim($this->getEndpointQuery($data), '/');
        return $host . '/' . $query;
    }

    /**
     * Helper method to build endpoint query parameters as string based on given data
     *
     * @param \stdClass $data
     *
     * @return string
     */
    abstract protected function getEndpointQuery(\stdClass $data): string;

    /**
     * @param \stdClass $data
     *
     * @return \stdClass
     */
    public function prepareData(\stdClass $data): \stdClass
    {
        return new \stdClass();
    }

    /**
     * @param \stdClass $data
     *
     * @return \stdClass
     */
    public function getHeaders(\stdClass $data): \stdClass
    {
        return new \stdClass();
    }

    /**
     * @inheritDoc
     */
    public function validate(\stdClass $data):bool
    {
        return true;
    }
}