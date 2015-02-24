<?php

class SequenceAnswer extends SequenceSurveyAnswer
{
    public $index;

    public function initFromXmlNode(DOMElement $node)
    {
        parent::initFromXmlNode($node);

        $this->userDefinedPosition = $node->getAttribute('userDefinedPosition');
    }
}