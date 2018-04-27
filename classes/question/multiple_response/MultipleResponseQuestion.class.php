<?php

class MultipleResponseQuestion extends MultipleResponseSurveyQuestion
{
    public function isGradedByDefault()
    {
        return true;
    }

    public function initFromXmlNode(DOMElement $node)
    {
        parent::initFromXmlNode($node);

        foreach ($this->answers as $answer)
        {
            /** @var MultipleResponseAnswer $answer */
            if (!$answer->correct)
            {
                continue;
            }
            if ($this->correctAnswer != '')
            {
                $this->correctAnswer .= '; ';
            }
            $this->correctAnswer .= $answer->text;
        }
    }

    protected function createAnswer()
    {
        return new MultipleResponseAnswer();
    }
}