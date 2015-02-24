<?php

class SequenceSurveyAnswer
{
    public $text;
    public $userDefinedPosition;

    public function initFromXmlNode(DOMElement $node)
    {
        $this->text = trim($node->textContent);
    }
}