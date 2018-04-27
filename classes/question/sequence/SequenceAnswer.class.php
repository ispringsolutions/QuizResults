<?php

class SequenceAnswer extends SequenceSurveyAnswer
{
    public $originalIndex;

    public function initFromXmlNode(DOMElement $node)
    {
        parent::initFromXmlNode($node);

        $this->userDefinedPosition = $node->hasAttribute('userDefinedPosition')
            ? intval($node->getAttribute('userDefinedPosition'))
            : null;
        $this->originalIndex = $node->hasAttribute('originalIndex')
            ? intval($node->getAttribute('originalIndex'))
            : null;
    }
}