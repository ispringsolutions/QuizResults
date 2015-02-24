<?php

class Hotspot
{
    public $marked;
    public $label;

    public function initFromXmlNode(DOMElement $node)
    {
        $this->marked = $node->getAttribute('marked') == 'true';
        $this->label = $node->getAttribute('label');
    }
}