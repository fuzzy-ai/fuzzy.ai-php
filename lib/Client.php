<?php
/**
 * Client
 */

namespace FuzzyAi;

use FuzzyAi\Exceptions\ApiException;
use FuzzyAi\Agent;

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
    const VERSION = '0.3.1';

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

    public function setHttpClient(HttpClientInterface $client)
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
        $agent = new Agent($this);
        $agent->id = $agentId;
        $evaluation = $agent->evaluate($inputs);
        return array($evaluation->outputs, $evaluation->id);
    }

    /**
     * Feedback
     */
    public function feedback($evaluationId, array $performance)
    {
        $eval = new Evaluation($this);
        $eval->id = $evaluationId;
        return $eval->feedback($performance);
    }

    /**
     * getAgent
     *
     * @param $agentId ID of the agent to retrieve.
     */
    public function getAgent($agentId)
    {
        $agent = new Agent($this);
        $agent->read($agentId);

        return $agent;
    }

    /**
     * newAgent
     */
    public function newAgent($props)
    {
        $agent = new Agent($this);
        $agent->create($props);

        return $agent;
    }

    public function request($method, $path, $params = array())
    {
        $headers = array(
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->key,
            'User-Agent' => 'fuzzy.ai-php/' . Client::VERSION
        );

        return $this->httpClient()->request($method, $this->getUrl($path), $headers, $params);
    }
}
