<?php

namespace FuzzyAi;

class ClientTest extends TestCase
{
    public function testEvaluate()
    {
        $this->mockRequest('POST', '/agent/testId', array(), array(), 200, array('X-Evaluation-ID' => 'test-eval-id'));
        list($response, $evalId) = $this->client->evaluate('testId', array());
        $this->assertEquals($response, array());
        $this->assertEquals($evalId, 'test-eval-id');
    }

    public function testFeedback()
    {
        $this->mockRequest('POST', '/evaluation/testEval/feedback', array());
        $response = $this->client->feedback('testEval', array());

        $this->assertEquals($response, array());
    }
}
