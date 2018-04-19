<?php

class DragAndDropQuestion extends Question
{
    /** @var DndMatch[] */
    public $placementsByUser;

    /** @var DndMatch[] */
    public $correctPlacements;

    public $objects;

    public $destinations;

    public function isGradedByDefault()
    {
        return true;
    }

    public function initFromXmlNode(DOMElement $node)
    {
        parent::initFromXmlNode($node);

        $objectsNode = $node->getElementsByTagName('objects')->item(0);
        $objectsList = $objectsNode->getElementsByTagName('object');
        for ($i = 0; $i < $objectsList->length; ++$i)
        {
            $this->objects[] = trim($objectsList->item($i)->textContent);
        }

        $destinationsNode = $node->getElementsByTagName('destinations')->item(0);
        $destinationsList = $destinationsNode->getElementsByTagName('destination');
        for ($i = 0; $i < $destinationsList->length; ++$i)
        {
            $this->destinations[] = trim($destinationsList->item($i)->textContent);
        }

        if ($node->getElementsByTagName('userAnswer')->length != 0)
        {
            $userAnswerNode = $node->getElementsByTagName('userAnswer')->item(0);
            $this->placementsByUser = $this->exportMatchCollection($userAnswerNode);
        }

        if ($node->getElementsByTagName('matches')->length != 0)
        {
            $matchesNode = $node->getElementsByTagName('matches')->item(0);
            $this->correctPlacements = $this->exportMatchCollection($matchesNode);
        }

        $this->userAnswer = $this->generateUserAnswer();
        $this->correctAnswer = $this->generateCorrectAnswer();
    }

    /**
     * @param DOMElement $node
     * @return DndMatch[]
     */
    private function exportMatchCollection(DOMElement $node)
    {
        $result = [];

        $matchesList = $node->getElementsByTagName('match');
        for ($i = 0; $i < $matchesList->length; ++$i)
        {
            $match = new DndMatch();
            $match->initFromXmlNode($matchesList->item($i));
            $result[] = $match;
        }

        return $result;
    }

    /**
     * @return string
     */
    private function generateUserAnswer()
    {
        return $this->buildPlacementString($this->placementsByUser);
    }

    /**
     * @return string
     */
    private function generateCorrectAnswer()
    {
        return $this->buildPlacementString($this->correctPlacements);
    }

    /**
     * @param DndMatch $match
     * @return string|null
     */
    private function getObjectName(DndMatch $match)
    {
        return !is_null($match->objectIndex) && !empty($this->objects[$match->objectIndex])
            ? $this->objects[$match->objectIndex]
            : '';
    }

    /**
     * @param DndMatch $match
     * @return string|null
     */
    private function getDestinationName(DndMatch $match)
    {
        return !is_null($match->destinationIndex) && !empty($this->destinations[$match->destinationIndex])
            ? $this->destinations[$match->destinationIndex]
            : '';
    }

    /**
     * @param DndMatch[] $matches
     * @return string
     */
    private function buildPlacementString($matches)
    {
        $parts = [];
        foreach ($matches as $match)
        {
            $object = $this->getObjectName($match);
            $destination = $this->getDestinationName($match);
            $parts[] = "$object - $destination";
        }
        return implode('; ', $parts);
    }
}