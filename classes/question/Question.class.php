<?php

abstract class Question
{
    public $awardedPoints;
    public $direction;
    public $userAnswer;
    public $correctAnswer;

    public function initFromXmlNode(DOMElement $node)
    {
        $this->reset();

        if ($this->isGraded())
        {
            $this->awardedPoints = $node->getAttribute('awardedPoints');
        }

        $directionSource = trim($node->getElementsByTagName('direction')->item(0)->textContent);
        $this->direction = str_replace("\n", PHP_EOL, $directionSource);
    }

    abstract public function isGraded();

    protected function reset()
    {
        $this->awardedPoints = null;
        $this->direction = null;
        $this->userAnswer = null;
        $this->correctAnswer = null;
    }
}