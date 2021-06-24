<?php

namespace App\HttpClient;

/**
 * Generic Request adapter with basic request methods
 *
 * Interface HttpClientInterface
 */
interface HttpClientInterface
{
    /**
     * @param \stdClass $data
     * @param \stdClass $headers
     *
     * @return mixed
     */
    public function dataPrepare(\stdClass $data, \stdClass $headers);

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
    ): HttpClientResponseInterface;

    /**
     * @param string $contentType
     *
     * @return self
     */
    public function setContentType(string $contentType): self;

    /**
     * @param string $contentType
     *
     * @return $this
     */
    public function setResponseContentType(string $contentType): self;

    /**
     * @return string
     */
    public function getContentType(): string;

    /**
     * @return string
     */
    public function getResponseContentType(): string;
}
