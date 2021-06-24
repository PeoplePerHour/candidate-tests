<?php

namespace App\HttpClient\Curl;

use App\HttpClient\HttpClientResponseInterface;

class CurlClientResponse implements HttpClientResponseInterface
{
    /**
     * @var string
     */
    protected $contentType;

    /**
     * @var int
     */
    private $responseCode;

    /**
     * @var string
     */
    private $error;

    /**
     * @var int
     */
    private $erno;

    /**
     * @var array
     */
    private $options;

    /**
     * @var string
     */
    private $response;

    /**
     * Response constructor.
     */
    public function __construct(
        string $response,
        string $contentType,
        int $responseCode,
        string $error,
        int $erno,
        array $options = []
    ) {
        $this->response = $response;
        $this->responseCode = $responseCode;
        $this->error = $error;
        $this->erno = $erno;
        $this->options = $options;
        $this->contentType = $contentType;
    }

    public function getBodyRaw()
    {
        return $this->response;
    }

    public function isEmptyResponse(): bool
    {
        return trim($this->response) == '';
    }

    public function getBodyFormatted()
    {
        if ($this->contentType == 'application/json')
        {
            return $this->isEmptyResponse()
                ? new \stdClass()
                : json_decode($this->response);
        }
        return $this->response;
    }

    public function getErrors(): array
    {
        return ($this->hasErrors()) ? [$this->error] : [];
    }

    public function hasErrors(): bool
    {
        return (! ($this->responseCode >= 200 && $this->responseCode < 300) || $this->erno > 0);
    }
}