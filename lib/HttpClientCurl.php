<?php

namespace FuzzyAi;

class HttpClientCurl implements HttpClientInterface
{
    public function request($method, $url, $headers, $params)
    {
        $requestHeaders = $this->encodeHeaders($headers);

        $responseHeaders = array();
        $headerCallback = function ($curl, $header_line) use (&$responseHeaders) {
            // Ignore the HTTP request line (HTTP/1.1 200 OK)
            if (strpos($header_line, ":") === false) {
                return strlen($header_line);
            }
            list($key, $value) = explode(":", trim($header_line), 2);
            $responseHeaders[trim($key)] = trim($value);
            return strlen($header_line);
        };

        $ch = curl_init();
        curl_setopt_array($ch, array(
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_URL => $url,
          CURLOPT_POSTFIELDS => json_encode($params),
          CURLOPT_HTTPHEADER => $requestHeaders,
          CURLOPT_HEADERFUNCTION => $headerCallback,
          CURLOPT_RETURNTRANSFER => true));
        $body = curl_exec($ch);
        $results = null;
        if ($body) {
            $results = json_decode($body);
        }
        $returnCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);
        return array($results, $returnCode, $responseHeaders);
    }

    public function encodeHeaders($headers)
    {
        $result = array();
        foreach ($headers as $key => $value) {
            $result[] = $key .': '. $value;
        }
        return $result;
    }
}
