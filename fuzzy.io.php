<?php

/*
 * fuzzy.io.php
 * PHP interface for fuzzy.io
 * Copyright 2014 fuzzy.io
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *  http://www.apache.org/licenses/LICENSE-2.0
 */

/**
 * FuzzyAgent -- an agent that can make decisions
 */

class FuzzyAgent {
  public function __construct($id, $server) {
    $this->id = $id;
    $this->server = $server;
  }
  public function evaluate($inputs) {
    return $this->server->post("/agent/$this->id", $inputs);
  }
}

class FuzzyServer {
  const DEFAULT_ROOT = 'https://api.fuzzy.io';

  public function __construct($key, $root = self::DEFAULT_ROOT) {
    $this->key = $key;
    $this->root = $root;
  }
  public function getAgent($id) {
    return new FuzzyAgent($id, $this);
  }
  public function post($rel, $payload) {
    $req = new HttpRequest($this->root.$rel, HTTP_METH_POST);
    $req->addHeaders(array("Authorization" => "Bearer $this->key",
                           "Content-Type" => "application/json"));
    $req->setBody(json_encode($payload));
    $msg = $req->send();
    if ($msg->getResponseCode() == 200) {
      return json_decode($msg->getBody());
    } else {
      return null;
    }
  }
}
