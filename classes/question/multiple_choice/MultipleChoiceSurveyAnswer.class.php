<?php

class MultipleChoiceSurveyAnswer extends Text
{
    private $customAnswer;

    public function __construct($value = '', $customAnswer = '')
    {
        parent::__construct($value);

        $this->customAnswer = $customAnswer;
    }

    public function getValue()
    {
        return parent::getValue() . ' ' . $this->customAnswer;
    }

    public function initFromXmlNode(DOMElement $node)
    {
        parent::initFromXmlNode($node);

        if ($node->hasAttribute('customAnswer'))
        {
            $this->customAnswer = trim($node->getAttribute('customAnswer'));
        }
    }
}