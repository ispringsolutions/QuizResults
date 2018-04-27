<?php

class HotspotQuestion extends Question
{
    public function initFromXmlNode(DOMElement $node)
    {
        parent::initFromXmlNode($node);

        $hotspotsNodeList = $node->getElementsByTagName('hotspots');
        $hotspotsNode = $hotspotsNodeList->item(0);
        $hotspots = $this->getHotspotsFromXmlNode($hotspotsNode);

        $this->userAnswer = $this->getHotspotsMarkedByUser($hotspots);
        $this->correctAnswer = $this->getCorrectHotspots($hotspots);
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
     * @param Hotspot[] $hotspots
     * @return string
     */
    private function getHotspotsMarkedByUser($hotspots)
    {
        $hotspots = array_filter(
            $hotspots,
            function (Hotspot $hotspot) { return $hotspot->marked; }
        );
        return $this->getHotspotsString($hotspots);
    }

    /**
     * @param Hotspot[] $hotspots
     * @return string
     */
    private function getCorrectHotspots($hotspots)
    {
        $hotspots = array_filter(
            $hotspots,
            function (Hotspot $hotspot) { return $hotspot->correct; }
        );
        return $this->getHotspotsString($hotspots);
    }

    /**
     * @param Hotspot[] $hotspots
     * @return string
     */
    private function getHotspotsString($hotspots)
    {
        $labels = array_map(
            function (Hotspot $hotspot) { return $hotspot->label; },
            $hotspots
        );
        $notEmptyLabels = array_filter($labels);
        return implode('; ', $notEmptyLabels);
    }
}