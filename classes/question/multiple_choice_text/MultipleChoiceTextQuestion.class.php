<?php

class MultipleChoiceTextQuestion extends MultipleChoiceTextSurveyQuestion
{
    public function isGradedByDefault()
    {
        return true;
    }

    public function initFromXmlNode(DOMElement $node)
    {
        parent::initFromXmlNode($node);

        foreach ($this->details->items as $item)
        {
            if ($this->correctAnswer != '')
            {
                $this->correctAnswer .= '; ';
            }
            $this->correctAnswer .= $item->answers[$item->correctAnswerIndex];
        }
    }

    protected function createDetails()
    {
        return new MultipleChoiceTextDetails();
    }
}