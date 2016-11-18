<?php

namespace FuzzyAi;

class TestCase extends \PHPUnit_Framework_TestCase
{
    private $mock;
    private $call;

    protected function mockRequest($method, $path, $params = array(), $return = array(), $return_code = 200, $return_headers = array())
    {
        $url = $this->client->getUrl($path);

        $mock = $this->setUpMockClient();
        $mock->expects($this->any())
             ->method('request')
             ->with($method, $url, $this->anything(), $params)
             ->willReturn(array($return, $return_code, $return_headers));
    }
    protected function setUpMockClient()
    {
        if (!$this->mock) {
            $this->mock = $this->getMock('\FuzzyAi\HttpClientInterface');
        }

        return $this->mock;
    }

    public function setUp()
    {
        $this->client = new Client();
        $this->client->setHttpClient($this->setUpMockClient());
    }
}
