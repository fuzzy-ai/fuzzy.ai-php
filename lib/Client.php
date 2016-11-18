<?php
/**
 * Client
 */

namespace FuzzyAi;

/**
 * Client class
 *
 * @category Class
 * @package FuzzyAi
 */
class Client
{
    /**
     * @const string SDK version number
     */
    const VERSION = '0.2.0';

    /**
     * @var key
     */
    protected $key;

    /**
     * @var root
     */
    protected $root;

    /**
     * @var httpClient
     */
    protected $httpClient;

    /**
     * Class constructor
     * @param $key API key for fuzzy.ai
     * @param $root API root URL
     */
    public function __construct($key = null, $root = 'https://api.fuzzy.ai')
    {
        $this->key = $key;
        $this->root = $root;
    }

    public function setHttpClient($client)
    {
        $this->httpClient = $client;
    }

    public function httpClient()
    {
        if (!$this->httpClient) {
            $this->httpClient = new HttpClientCurl();
        }

        return $this->httpClient;
    }

    public function getUrl($path)
    {
        return $this->root . $path;
    }
    /**
     * Evaluate
     */
    public function evaluate($agentId, array $inputs)
    {
        $path = '/agent/' . $agentId;
        list($response, $code, $headers) = $this->request('POST', $path, $inputs);
        return array($response, $headers['X-Evaluation-ID']);
    }

    /**
     * Feedback
     */
    public function feedback($evaluationId, array $performance)
    {
        $path = '/evaluation/' . $evaluationId . '/feedback';
        list($response, $code, $headers) = $this->request('POST', $path, $performance);

        return $response;
    }

    protected function request($method, $path, $params)
    {
        $headers = array(
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->key,
            'User-Agent' => 'fuzzy.ai-php/' . Client::VERSION
        );

        return $this->httpClient()->request($method, $this->getUrl($path), $headers, $params);
    }
}
