<?php

class MultipleResponseAnswer extends MultipleResponseSurveyAnswer
{
    public $correct;

    public function initFromXmlNode(DOMElement $node)
    {
        parent::initFromXmlNode($node);

        $this->correct = $node->getAttribute('correct') == 'true';
    }
}