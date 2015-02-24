<?php

class MultipleChoiceQuestion extends MultipleChoiceSurveyQuestion
{
    public function isGraded()
    {
        return true;
    }

    public function initFromXmlNode(DOMElement $node)
    {
        parent::initFromXmlNode($node);

        $answer = $this->answers->answers[$this->answers->correctAnswerIndex];
        /** @var MultipleChoiceAnswer $answer */
        $this->correctAnswer = $answer->getValue();
    }

    protected function createAnswers()
    {
        return new MultipleChoiceAnswers();
    }
}