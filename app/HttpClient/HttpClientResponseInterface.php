<?php

namespace App\HttpClient;

interface HttpClientResponseInterface
{
    /**
     * @return mixed
     */
    public function getBodyRaw();

    /**
     * @return bool
     */
    public function isEmptyResponse(): bool;

    /**
     * @return mixed
     * @uses $this->getReturnType
     */
    public function getBodyFormatted();

    /**
     * @return array
     */
    public function getErrors(): array;

    /**
     * @return false
     * @throws \RuntimeException
     */
    public function hasErrors(): bool;
}
