<?php

namespace App\Providers;

/**
 * Interface RequestInterface
 * Each Request class must has at least the following methods.
 *
 * @package Providers
 */
interface RequestInterface
{
    /**
     * Get the provider request endpoint
     *
     * @param \stdClass $data
     *
     * @return string
     */
    public function getEndpoint(\stdClass $data): string;

    /**
     * Get the Request verb
     * eg. POST, GET, etc
     *
     * @return string
     */
    public function getVerb(): string;

    /**
     * @return \App\Providers\ResponseInterface
     */
    public function getResponseObject(): ResponseInterface;

    /**
     * process the data before the request
     * Return an array which will used on request method
     *
     * @param \stdClass $data
     *
     * @return array
     */
    public function prepareData(\stdClass $data): \stdClass;

    /**
     * Process the data before the request and build the required headers
     * Return an array which will used on request method as header parameters
     *
     * @param \stdClass $data
     *
     * @return array
     */
    public function getHeaders(\stdClass $data): \stdClass;

    /**
     * @param \stdClass $data
     *
     * @return bool
     * @throws \InvalidArgumentException if is not valid
     */
    public function validate(\stdClass $data): bool;
}