<?php

namespace App\HttpClient\Curl;

use App\HttpClient\HttpClientAbstract;
use App\HttpClient\HttpClientResponseInterface;

class CurlClient extends HttpClientAbstract
{
    /**
     * @param string $verb
     * @param string $endpoint
     * @param \stdClass $headers
     * @param \stdClass|null $data
     * @param array $options
     *
     * @return \App\HttpClient\HttpClientResponseInterface
     */
    public function triggerRequest(
        string $verb,
        string $endpoint,
        \stdClass $headers,
        \stdClass $data = null,
        array $options = []
    ): HttpClientResponseInterface {
        $data = $data ?? new \stdClass();
        $this->dataPrepare($data, $headers);

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => (array)$headers,
            CURLOPT_ENCODING => '',
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => $verb,
        ]);
        if ($verb == 'POST' || $verb == 'PUT' || $verb == 'PATCH')
        {
            if ($this->getContentType() == 'application/json')
            {
                curl_setopt($curl, CURLOPT_POSTFIELDS, count((array) $data) ? json_encode($data) : '');
            }
        }

        $rawResponse = curl_exec($curl);
        $responseCode = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
        $error = curl_error($curl);
        $errno = curl_errno($curl);
        curl_close($curl);

        return new CurlClientResponse(
            $rawResponse,
            $this->getResponseContentType(),
            (int) $responseCode,
            $error,
            $errno,
            $options
        );
    }
}