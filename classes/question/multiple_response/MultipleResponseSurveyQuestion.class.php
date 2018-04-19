<?php

class MultipleResponseSurveyQuestion extends Question
{
    /**
     *@var array of MultipleResponseSurveyAnswer
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
        $answersList = $answersNode->getElementsByTagName('answer');
        for ($i = 0; $i < $answersList->length; ++$i)
        {
            $answerNode = $answersList->item($i);

            $answer = $this->createAnswer();
            $answer->initFromXmlNode($answerNode);
            $this->answers[] = $answer;
        }

        foreach ($this->answers as $answer)
        {
            /** @var MultipleResponseSurveyAnswer $answer */
            if (!$answer->selected)
            {
                continue;
            }
            if ($this->userAnswer != '')
            {
                $this->userAnswer .= '; ';
            }
            $this->userAnswer .= $answer->text;
            if (!empty($answer->customAnswer))
            {
                $this->userAnswer .= " " . $answer->customAnswer;
            }
        }
    }

    protected function createAnswer()
    {
        return new MultipleResponseSurveyAnswer();
    }
}