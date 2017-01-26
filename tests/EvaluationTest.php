<?php

namespace FuzzyAi;

class EvaluationTest extends TestCase
{
    public function testFeedback()
    {
        $this->mockRequest('POST', '/evaluation/testEval/feedback', array(), $this->feedbackResponse());

        $evaluation = new Evaluation($this->client);
        $evaluation->id = 'testEval';
        $feedback = $evaluation->feedback(array());

        $this->assertEquals($feedback->id, 'testFeedbackId');
        $this->assertEquals($feedback->data, array());
    }

    public function testRead()
    {
        $this->mockRequest('GET', '/evaluation/testEvalId', array(), $this->evaluationResponse(), 200, array());
        $evaluation = new Evaluation($this->client);
        $evaluation->read('testEvalId');
        $this->assertEquals($evaluation->id, 'testEvalId');
        $this->assertEquals($evaluation->inputs, array());
    }
}
