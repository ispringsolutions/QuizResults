<?php

class MultipleChoiceSurveyQuestion extends Question
{
    /**
     * @var MultipleChoiceAnswers
     */
    public $answers;

    public function isGraded()
    {
        return false;
    }

    public function initFromXmlNode(DOMElement $node)
    {
        parent::initFromXmlNode($node);

        $answersNode = $node->getElementsByTagName('answers')->item(0);
        $this->answers = $this->createAnswers();
        $this->answers->initFromXmlNode($answersNode);

        $answer = !empty($this->answers->answers[$this->answers->userAnswerIndex])
                  ? $this->answers->answers[$this->answers->correctAnswerIndex]
                  : null;
        /** @var MultipleChoiceSurveyAnswer $answer */
        $this->userAnswer = $answer ? $answer->getValue() : null;
    }

    protected function createAnswers()
    {
        return new MultipleChoiceSurveyAnswers();
    }
}
