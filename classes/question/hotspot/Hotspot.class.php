<?php

class Hotspot
{
    public $marked;
    public $label;
    public $correct = null;

    public function initFromXmlNode(DOMElement $node)
    {
        $this->marked = $node->getAttribute('marked') == 'true';
        if ($node->hasAttribute('correct'))
        {
            $this->correct = $node->getAttribute('correct') == 'true';
        }
        $this->label = $node->getAttribute('label');
    }
}