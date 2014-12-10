fuzzy.io.php
============

0.1.0

PHP library for accessing the fuzzy.io API.

Copyright 2014 fuzzy.io

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

 http://www.apache.org/licenses/LICENSE-2.0

Usage
=====

  require_once '../fuzzy.io.php';

  $server = new FuzzyServer('YourAPIKey');

  $agent = $server->getAgent('YourAgentID');

  $outputs = $agent->evaluate(array('input1' => 10, 'input2' => 8.7));

  echo "Output1 is $outputs->output1.\n";

Overview
========

fuzzy.io is a service for doing lightweight artificial intelligence. It lets you
set up *agents* that can make decisions based on input from your code. The
*output* of these agents can be used in your software.

Account
-------

You'll need an account with fuzzy.io to use this library. Accounts are free for
moderate use, with a scaled pay structure for higher use. You can sign up here:

  https://beta.fuzzy.io/

API key
-------

You need your API key to connect to fuzzy.io. It's available on your "dashboard"
or your "account" page.

Setting up an agent
-------------------

You set up a new agent through the Web interface on fuzzy.io. You need the agent
ID (visible on every page) to call it remotely.

Classes
=======

The fuzzy.io.php library defines two classes.

FuzzyServer
-----------

This class represents the server you're connecting to.

* constructor($key): This is the constructor for the class. Pass your API key
  (see above) to set up the server.
* getAgent($id): gets a FuzzyAgent (see below) with the given ID.

FuzzyAgent
----------

This class is an agent that can make a decision.

* constructor($id, $server): This constructs a new agent. You can also use
  FuzzyServer's getAgent($id).
* evaluate($inputs): Evaluate the inputs. Inputs are structured as an associative
  array mapping input names to numerical values, like
  array('input1' => 10, 'input2' => 8.7). Results are an associative array
  mapping output names to output numeric values, like array('output1' => 6).

Examples
========

The examples/ directory has some examples of using the library.
