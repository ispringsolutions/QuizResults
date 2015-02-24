<?php

class MultipleChoiceSurveyAnswers
{
    public $answers;
    public $userAnswerIndex;

    public function initFromXmlNode(DOMElement $node)
    {
        if ($node->hasAttribute('userAnswerIndex'))
        {
            $this->userAnswerIndex = $node->getAttribute('userAnswerIndex');
        }

        $answersNodeList = $node->getElementsByTagName('answer');
        for ($i = 0; $i < $answersNodeList->length; ++$i)
        {
            $answerNode = $answersNodeList->item($i);
            $answer = $this->createAnswer();
            $answer->initFromXmlNode($answerNode);
            $this->answers[] = $answer;
        }
    }

    protected function createAnswer()
    {
        return new MultipleChoiceSurveyAnswer();
    }
}