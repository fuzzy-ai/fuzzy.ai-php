<?php
/**
 * Client
 */

namespace FuzzyAi;

use FuzzyAi\Exceptions\ApiException;

/**
 * Feedback class
 *
 * @category Class
 * @package FuzzyAi
 */
class Feedback
{
    protected $client;

    public $id;

    public $data;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }
}
