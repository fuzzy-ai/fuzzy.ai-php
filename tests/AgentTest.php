<?php

namespace FuzzyAi;

class AgentTest extends TestCase
{
    public function testEvaluate()
    {
        $this->mockRequest('POST', '/agent/testId', array(), array(), 200, array('X-Evaluation-ID' => 'test-eval-id'));

        $agent = new Agent($this->client);
        $agent->id = 'testId';
        $eval = $agent->evaluate(array());
        $this->assertEquals($eval->id, 'test-eval-id');
        $this->assertEquals($eval->outputs, array());
    }

    public function testCreate()
    {
        $this->mockRequest('POST', '/agent', array(), $this->agentResponse(), 200, array());
        $agent = new Agent($this->client);
        $response = $agent->create(array());
        $this->assertEquals($agent->id, 'testId');
        $this->assertEquals($agent->inputs, array());
    }

    public function testRead()
    {
        $this->mockRequest('GET', '/agent/testId', array(), $this->agentResponse(), 200, array());
        $agent = new Agent($this->client);
        $agent->read('testId');
        $this->assertEquals($agent->id, 'testId');
        $this->assertEquals($agent->inputs, array());
    }

    public function testUpdate()
    {
        $this->mockRequest('PUT', '/agent/testId', array(), $this->agentResponse(), 200, array());
        $agent = new Agent($this->client);
        $agent->id = 'testId';
        $response = $agent->update(array());
        $this->assertEquals($agent->id, 'testId');
        $this->assertEquals($agent->inputs, array());
    }

    public function testDelete()
    {
        $this->mockRequest('DELETE', '/agent/testId', array(), $this->agentResponse(), 200, array());
        $agent = new Agent($this->client);
        $agent->id = 'testId';
        $response = $agent->delete();
    }
}
