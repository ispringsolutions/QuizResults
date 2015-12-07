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

        $answer = !empty($this->answers->answers[$this->answers->correctAnswerIndex])
                  ? $this->answers->answers[$this->answers->correctAnswerIndex]
                  : null;
        /** @var MultipleChoiceAnswer $answer */
        $this->correctAnswer = $answer ? $answer->getValue() : null;
    }

    protected function createAnswers()
    {
        return new MultipleChoiceAnswers();
    }
}