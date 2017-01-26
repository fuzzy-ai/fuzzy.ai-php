<?php
/**
 * Client
 */

namespace FuzzyAi;

use FuzzyAi\Exceptions\ApiException;

/**
 * Evaluation class
 *
 * @category Class
 * @package FuzzyAi
 */
class Evaluation
{
    protected $client;

    public $id;

    public $inputs;

    public $outputs;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function read($id)
    {
        $path = '/evaluation/' . $id;
        list($response, $code, $headers) = $this->client->request('GET', $path);
        if ($code != 200) {
            throw new ApiException($response->message, $code);
        }

        $this->id = $response->reqID;
        $this->inputs = $response->input;
        $this->outputs = $response->crisp;
    }

    public function feedback($values)
    {
        $feedback = new Feedback($this->client);

        $path = '/evaluation/' . $this->id . '/feedback';
        list($response, $code, $headers) = $this->client->request('POST', $path, $values);
        if ($code != 200) {
            throw new ApiException($response->message, $code);
        }

        $feedback->id = $response->id;
        $feedback->data = $response->data;
        return $feedback;
    }
}
