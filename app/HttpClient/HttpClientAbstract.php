<?php

namespace App\HttpClient;

abstract class HttpClientAbstract implements HttpClientInterface
{
    const VERB_DELETE = 'DELETE';
    const VERB_GET = 'GET';
    const VERB_PATCH = 'PATCH';
    const VERB_POST = 'POST';
    const VERB_PUT = 'PUT';

    /**
     * @var string
     */
    private $contentType;

    /**
     * @var string
     */
    private $responseContentType;

    /**
     * HttpClientAbstract constructor.
     */
    public function __construct(string $contentType = null, string $responseContentType = null)
    {
        $this->contentType = $contentType;
        $this->responseContentType = $responseContentType ?? $contentType;
    }

    /**
     * Prepare data and header data for client request
     *
     * @param \stdClass $data
     * @param \stdClass $headers
     */
    public function dataPrepare(\stdClass $data, \stdClass $headers): void
    {
        $headers->{'Content-Type'} = ! property_exists($headers, 'Content-Type')
            ? $this->contentType
            : $headers->{'Content-Type'};
    }

    /**
     * @param string $verb
     * @param string $endpoint
     * @param \stdClass $headers
     * @param \stdClass|null $data
     * @param array $options
     *
     * @return \App\HttpClient\HttpClientResponseInterface
     */
    public function execute(
        string $verb,
        string $endpoint,
        \stdClass $headers,
        \stdClass $data = null,
        array $options = []
    ): HttpClientResponseInterface {
        $acceptableVerbs = [
            self::VERB_DELETE,
            self::VERB_GET,
            self::VERB_PATCH,
            self::VERB_POST,
            self::VERB_PUT,
        ];
        if (! in_array($verb, $acceptableVerbs))
        {
            throw new \Exception('Unsupported verb value');
        }
        return $this->triggerRequest($verb, $endpoint, $headers, $data, $options);
    }

    protected abstract function triggerRequest(
        string $verb,
        string $endpoint,
        \stdClass $headers,
        \stdClass $data = null,
        array $options = []
    ): HttpClientResponseInterface;

    public function setContentType(string $contentType): HttpClientInterface
    {
        $this->contentType = $contentType;
        return ($this->getContentType() == '') ? $this->setResponseContentType($contentType) : $this;
    }

    public function setResponseContentType(string $contentType): HttpClientInterface
    {
        $this->responseContentType = $contentType;
        return $this;
    }

    public function getContentType(): string
    {
        return $this->contentType ?? '';
    }

    public function getResponseContentType(): string
    {
        return $this->responseContentType ?? '';
    }
}