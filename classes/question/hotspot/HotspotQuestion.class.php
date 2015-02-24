<?php

class HotspotQuestion extends Question
{
    public function initFromXmlNode(DOMElement $node)
    {
        parent::initFromXmlNode($node);

        $hotspotsNodeList = $node->getElementsByTagName('hotspots');
        $hotspotsNode = $hotspotsNodeList->item(0);
        $hotspots = $this->getHotspotsFromXmlNode($hotspotsNode);

        foreach ($hotspots as $hotspot)
        {
            if ($this->userAnswer != '')
            {
                $this->userAnswer .= '; ';
            }
            $this->userAnswer .= $hotspot->label . ' - ' . (($hotspot->marked) ? 'Marked' : 'Unmarked');
        }
    }

    public function isGraded()
    {
        return true;
    }

    /**
     * @param DOMElement $node
     * @return Hotspot
     */
    private function getHotspotsFromXmlNode(DOMElement $node)
    {
        $hotspots = array();
        foreach ($node->childNodes as $hotspotNode)
        {
            $hotspot = $this->createHotspotFromNode($hotspotNode);
            if ($hotspot)
            {
                $hotspots[] = $hotspot;
            }
        }

        return $hotspots;
    }

    /**
     * @param DOMElement|DOMNode $hotspotNode
     * @return Hotspot
     */
    private function createHotspotFromNode($hotspotNode)
    {
        if (!($hotspotNode instanceof DOMElement))
        {
            return null;
        }

        $hotspot = new Hotspot();
        $hotspot->initFromXmlNode($hotspotNode);

        return $hotspot;
    }
}