<?php
namespace FuzzyAi;

interface HttpClientInterface
{
    /**
     * @param string $method The HTTP method being used
     * @param string $absUrl The URL being requested, including domain and protocol
     * @param array $headers Headers to be used in the request (full strings, not KV pairs)
     * @param array $params KV pairs for parameters. Can be nested for arrays and hashes
     * @return array($rawBody, $httpStatusCode, $httpHeader)
     */
    public function request($method, $url, $headers, $params);
}
