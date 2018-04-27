<?php

class SequenceQuestion extends SequenceSurveyQuestion
{
    public function isGradedByDefault()
    {
        return true;
    }

    public function initFromXmlNode(DOMElement $node)
    {
        parent::initFromXmlNode($node);

        $correctAnswer = array();
        foreach ($this->answers as $answer)
        {
            $correctAnswer[$this->getCorrectAnswerIndex($answer)] = $answer;
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

    /**
     * @param SequenceAnswer $answer
     * @return int
     */
    private function getCorrectAnswerIndex($answer)
    {
        return isset($answer->originalIndex)
            ? $answer->originalIndex
            : $answer->index;
    }
}
