<?php

class MatchingQuestion extends MatchingSurveyQuestion
{
    public function getType()
    {
        return QuestionType::MATCHING;
    }

    public function isGradedByDefault()
    {
        return true;
    }

    public function initFromXmlNode(DOMElement $node)
    {
        parent::initFromXmlNode($node);

        foreach ($this->premises as $i => $premise)
        {
            if ($this->correctAnswer != '')
            {
                $this->correctAnswer .= '; ';
            }
            $this->correctAnswer .= $premise . ' - ' . $this->responses[$i];
        }
    }
}