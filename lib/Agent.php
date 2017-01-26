<?php
/**
 * Client
 */

namespace FuzzyAi;

use FuzzyAi\Exceptions\ApiException;

/**
 * Agent class
 *
 * @category Class
 * @package FuzzyAi
 */
class Agent
{

    /**
     * @var id
     */
    public $id;

    /**
     * @var inputs
     */
    public $inputs;

    /**
     * @var outputs
     */
    public $outputs;

    /**
     * @var rules
     */
    public $rules;

    /**
     * @var client
     */
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function evaluate($inputs)
    {
        $path = '/agent/' . $this->id;
        list($response, $code, $headers) = $this->client->request('POST', $path, $inputs);
        if ($code != 200) {
            throw new ApiException($response->message, $code);
        }

        $eval = new Evaluation($this->client);
        $eval->id = $headers['X-Evaluation-ID'];
        $eval->inputs = $inputs;
        $eval->outputs = $response;

        return $eval;
    }

    public function create($props)
    {
        $path = '/agent';
        list($response, $code, $headers) = $this->client->request('POST', $path, $props);
        if ($code != 200) {
            throw new ApiException($response->message, $code);
        }

        $this->mapResponse($response);
    }

    public function read($id)
    {
        $path = '/agent/' . $id;
        list($response, $code, $headers) = $this->client->request('GET', $path, array());
        if ($code != 200) {
            throw new ApiException($response->message, $code);
        }

        $this->mapResponse($response);
    }

    public function update($props)
    {
        $path = '/agent/' . $this->id;
        list($response, $code, $headers) = $this->client->request('PUT', $path, array());
        if ($code != 200) {
            throw new ApiException($response->message, $code, $props);
        }

        $this->mapResponse($response);
    }

    public function delete()
    {
        $path = '/agent/' . $this->id;
        list($response, $code, $headers) = $this->client->request('DELETE', $path, array());
        if ($code != 200) {
            throw new ApiException($response->message, $code, $props);
        }
    }

    protected function mapResponse($response)
    {
        $this->id = $response->id;
        $this->inputs = $response->inputs;
        $this->outputs = $response->outputs;
        $this->rules = $response->rules;
    }
}
