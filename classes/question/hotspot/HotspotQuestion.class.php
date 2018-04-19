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
            $this->userAnswer .= $hotspot->label . ' - ' . (($hotspot->marked) ? 'Marked' : 'Unmarked') . $this->getHotspotStatus($hotspot);
        }
    }

    public function isGradedByDefault()
    {
        return true;
    }

    /**
     * @param DOMElement $node
     * @return Hotspot[]
     */
    private function getHotspotsFromXmlNode(DOMElement $node = null)
    {
        if (!$node)
        {
            return [];
        }

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

    /**
     * @param Hotspot $hotspot
     * @return string
     */
    private function getHotspotStatus(Hotspot $hotspot)
    {
        if (!$this->isGraded() || is_null($hotspot->correct))
        {
            return '';
        }
        return ' - ' . ($hotspot->correct ? 'Correct' : 'Incorrect');
    }
}