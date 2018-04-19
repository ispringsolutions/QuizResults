<?php

class DndMatch
{
    public $objectIndex;
    public $destinationIndex;

    public function initFromXmlNode(DOMElement $node)
    {
        $this->reset();

        $this->objectIndex = $node->getAttribute('objectIndex');
        $this->destinationIndex = $node->getAttribute('destinationIndex');
    }

    private function reset()
    {
        $this->objectIndex = null;
        $this->destinationIndex = null;
    }
}