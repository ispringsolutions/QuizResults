<?php

class TypeInSurveyQuestion extends Question
{
    public function isGraded()
    {
        return false;
    }

    public function initFromXmlNode(DOMElement $node)
    {
        parent::initFromXmlNode($node);

        if ($node->hasAttribute('userAnswer'))
        {
            $this->userAnswer = trim($node->getAttribute('userAnswer'));
        }
    }
}