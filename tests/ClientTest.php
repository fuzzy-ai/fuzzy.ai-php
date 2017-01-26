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

    /**
     * @expectedException FuzzyAi\Exceptions\ApiException
     */
    public function testEvaluateApiError()
    {
        $response = new \stdClass();
        $response->message = "error";
        $this->mockRequest('POST', '/agent/testId', array(), $response, 500, array());
        $this->client->evaluate('testId', array());
    }

    public function testFeedback()
    {
        $this->mockRequest('POST', '/evaluation/testEval/feedback', array(), $this->feedbackResponse());
        $feedback = $this->client->feedback('testEval', array());

        $this->assertEquals($feedback->id, 'testFeedbackId');
        $this->assertEquals($feedback->data, array());
    }

    public function testNewAgent()
    {
        $props = (array) $this->agentResponse();

        $this->mockRequest('POST', '/agent', $props, $this->agentResponse(), 200, array());
        $agent = $this->client->newAgent($props);

        $this->assertEquals($agent->id, 'testId');
        $this->assertEquals($agent->inputs, array());
    }

    public function testGetAgent()
    {
        $this->mockRequest('GET', '/agent/testId', array(), $this->agentResponse(), 200, array());
        $agent = $this->client->getAgent('testId');
        $this->assertEquals($agent->id, 'testId');
        $this->assertEquals($agent->inputs, array());
    }
}
