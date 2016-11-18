# Fuzzy.ai PHP SDK

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

## Examples

The `examples/` directory has some examples of using the library.

## Development

Install dependencies:

    composer install

Run the tests:

    ./vendor/bin/phpunit
