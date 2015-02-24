<?php

class MultipleResponseSurveyAnswer
{
    public $selected;
    public $text;
    public $customAnswer = '';

    public function initFromXmlNode(DOMElement $node)
    {
        $this->selected = $node->getAttribute('selected') == 'true';
        $this->text = trim($node->textContent);

        if ($node->hasAttribute('customAnswer'))
        {
            $this->customAnswer = trim($node->getAttribute('customAnswer'));
        }
    }
}
