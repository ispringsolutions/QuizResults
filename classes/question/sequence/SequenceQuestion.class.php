<?php

class SequenceQuestion extends SequenceSurveyQuestion
{
    public function isGraded()
    {
        return true;
    }

    public function initFromXmlNode(DOMElement $node)
    {
        parent::initFromXmlNode($node);

        $correctAnswer = array();
        foreach ($this->answers as $answer)
        {
            $correctAnswer[$answer->index] = $answer;
        }

        $answersCount = count($correctAnswer);
        for ($i = 0; $i < $answersCount; ++$i)
        {
            if ($this->correctAnswer != '')
            {
                $this->correctAnswer .= '; ';
            }
            $this->correctAnswer .= $i + 1 . '. ' . $correctAnswer[$i]->text;
        }
    }

    protected function createAnswer($index)
    {
        $answer = new SequenceAnswer();
        $answer->index = $index;
        return $answer;
    }
}
