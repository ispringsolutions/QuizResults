<?php

class SequenceSurveyQuestion extends Question
{
    /**
     * @var SequenceAnswer[]
     */
    public $answers;

    public function isGradedByDefault()
    {
        return false;
    }

    public function initFromXmlNode(DOMElement $node)
    {
        parent::initFromXmlNode($node);

        $answersNode = $node->getElementsByTagName('answers')->item(0);
        $answersList = $answersNode ? $answersNode->getElementsByTagName('answer') : [];

        for ($i = 0; $i < $answersList->length; ++$i)
        {
            $answerNode = $answersList->item($i);

            $answer = $this->createAnswer($i);
            $answer->initFromXmlNode($answerNode);
            $this->answers[] = $answer;
        }

        $userAnswer = array();
        foreach ($this->answers as $answer)
        {
            $userAnswer[$this->getUserAnswerIndex($answer)] = $answer;
        }

        $answersCount = count($userAnswer);
        for ($i = 0; $i < $answersCount; ++$i)
        {
            if ($this->userAnswer != '')
            {
                $this->userAnswer .= '; ';
            }
            $this->userAnswer .= $i + 1 . '. ' . $userAnswer[$i]->text;
        }
    }

    protected function createAnswer($index)
    {
        $answer = new SequenceSurveyAnswer();
        $answer->index = $index;
        $answer->userDefinedPosition = $index;
        return $answer;
    }

    /**
     * @param SequenceSurveyAnswer $answer
     * @return int
     */
    private function getUserAnswerIndex($answer)
    {
        return isset($answer->userDefinedPosition)
            ? $answer->userDefinedPosition
            : $answer->index;
    }
}