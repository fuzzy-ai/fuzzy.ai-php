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

 $fuzzy_io_php_version = "0.1.0";

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
    $ch = curl_init();
    curl_setopt_array($ch, array(
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_URL => $this->root.$rel,
      CURLOPT_POSTFIELDS => json_encode($payload),
      CURLOPT_HTTPHEADER => array("Authorization: Bearer $this->key",
                                  "Content-Type: application/json"),
      CURLOPT_RETURNTRANSFER => TRUE));
    $body = curl_exec($ch);
    $results = NULL;
    if ($body) {
      $results = json_decode($body);
    }
    curl_close($ch);
    return $results;
  }
}
