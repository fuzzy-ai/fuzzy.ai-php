# Fuzzy.ai PHP SDK

[![Build Status](https://travis-ci.org/fuzzy-ai/fuzzy.ai-php.svg?branch=master)](https://travis-ci.org/fuzzy-ai/fuzzy.ai-php)
[![Latest Stable Version](https://poser.pugx.org/fuzzy-ai/sdk/v/stable.svg)](https://packagist.org/packages/fuzzy-ai/sdk)
[![Total Downloads](https://poser.pugx.org/fuzzy-ai/sdk/downloads.svg)](https://packagist.org/packages/fuzzy-ai/sdk)
[![License](https://poser.pugx.org/fuzzy-ai/sdk/license.svg)](https://packagist.org/packages/fuzzy-ai/sdk)

PHP library for accessing the fuzzy.ai API.

## Requirements

PHP 5.3.3 or later with the cURL extension.

## Installation

You can install the library via [Composer](http://getcomposer.org/):

    composer require fuzzy-ai/sdk

To load the library, use Composer's autoload:

```php
require_once('vendor/autoload.php');
```

## Usage

All API calls require an API key from https://fuzzy.ai/

```php
$client = new FuzzyAi\Client('YourAPIKey');

list($result, $evalID) = $client->evaluate('YourAgentID', array('input1' => 42));
```

## Client

This is the main class and serves as an entry point to the API.

  * **FuzzyAi\Client($key, $root)** Constructor that takes the following arguments and returns a new Client object.
    * `key`: Your Fuzzy.ai API key
    * `root` (optional): The API endpoint (defaults to https://api.fuzzy.ai)
  * **evaluate($agentId, $inputs)** The main method to use, it performs a single inference. Returns an array of outputs and an evaluation ID (for training feedback, see below).
    * `agentId`: The ID of the Agent to perform the evaluation against
    * `inputs`: An associative array of input name => values.
  * **feedback($evaluationId, $performance)** This is the method used for training better results. Returns a feedback object.
    * `evaluationId`: Unique identifier returned from an evaluate() call.
    * `performance`: The performance metrics (as an associative array) to provide the learning.



## Examples

The `examples/` directory has some examples of using the library.

## Development

Install dependencies:

    composer install

Run the tests:

    ./vendor/bin/phpunit# Fuzzy.ai PHP SDK

[![Build Status](https://travis-ci.org/fuzzy-ai/fuzzy.ai-php.svg?branch=master)](https://travis-ci.org/fuzzy-ai/fuzzy.ai-php)
[![Latest Stable Version](https://poser.pugx.org/fuzzy-ai/sdk/v/stable.svg)](https://packagist.org/packages/fuzzy-ai/sdk)
[![Total Downloads](https://poser.pugx.org/fuzzy-ai/sdk/downloads.svg)](https://packagist.org/packages/fuzzy-ai/sdk)
[![License](https://poser.pugx.org/fuzzy-ai/sdk/license.svg)](https://packagist.org/packages/fuzzy-ai/sdk)

PHP library for accessing the fuzzy.ai API.

## Requirements

PHP 5.3.3 or later with the cURL extension.

## Installation

You can install the library via [Composer](http://getcomposer.org/):

    composer require fuzzy-ai/sdk

To load the library, use Composer's autoload:

```php
require_once('vendor/autoload.php');
```

## Usage

All API calls require an API key from https://fuzzy.ai/

```php
$client = new FuzzyAi\Client('YourAPIKey');

list($result, $evalID) = $client->evaluate('YourAgentID', array('input1' => 42));
```

## Client

This is the main class and serves as an entry point to the API.

  * **FuzzyAi\Client($key, $root)** Constructor that takes the following arguments and returns a new Client object.
    * `key`: Your Fuzzy.ai API key
    * `root` (optional): The API endpoint (defaults to https://api.fuzzy.ai)
  * **evaluate($agentId, $inputs)** The main method to use, it performs a single inference. Returns an array of outputs and an evaluation ID (for training feedback, see below).
    * `agentId`: The ID of the Agent to perform the evaluation against
    * `inputs`: An associative array of input name => values.
  * **feedback($evaluationId, $performance)** This is the method used for training better results. Returns a feedback object.
    * `evaluationId`: Unique identifier returned from an evaluate() call.
    * `performance`: The performance metrics (as an associative array) to provide the learning.
  * **newAgent($props)** Use this method to create a new Agent. Returns an Agent object.
    * `props`: An associative array representing an agent with at least `inputs`, `outputs`, and `rules`.
  * **getAgent($agentId)** This will fetch an existing agent definition. Returns an Agent object.
    * `agentId` : ID of the agent to retrieve

## Agent

This class represents an Agent and provides full CRUD features.
  * **FuzzyAi\Agent($client)** Constructor - takes an HTTP Client object, but it's easier to use either `newAgent` or `getAgent` from above to create the Agent object.
  * **evaluate($inputs)** Like Client::evaluate, but on an existing Agent instance. ***NOTE*** Returns an Evaluation object.
    * `inputs`: An associative array of input name => values.
  * **create($props)** Creates a new agent (although Client::newAgent is likely easier).
    * `props`: An associative array representing an agent with at least `inputs`, `outputs`, and `rules`.
  * **read($props)** Reads an agent definition from the API. Probably easier to use Client::getAgent().
    * `id` : Agent ID to read.
  * **update($props)** Updates the current agent instance with $props.
    * `props`: New agent properties.
  * **delete()** Deletes current agent from the API.

## Evaluation

This class represents a single evaluation.

  * **read($id)** Load a single evaluation object by ID.
  * **feedback($values)** Provide learning feedback data to a single evaluation . Returns a Feedback object.
    * `values`: the performance metrics to provide for feedback. 

## Examples

The `examples/` directory has some examples of using the library.

## Development

Install dependencies:

    composer install

Run the tests:

    ./vendor/bin/phpunit
