<?php

class MultipleChoiceAnswers extends MultipleChoiceSurveyAnswers
{
    public $correctAnswerIndex;

    public function initFromXmlNode(DOMElement $node)
    {
        parent::initFromXmlNode($node);

        if ($node->hasAttribute('correctAnswerIndex'))
        {
            $this->correctAnswerIndex = $node->getAttribute('correctAnswerIndex');
        }
    }

    protected function createAnswer()
    {
        return new MultipleChoiceAnswer();
    }
}