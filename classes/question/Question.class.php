<?php

abstract class Question
{
    public $awardedPoints;
    public $direction;
    public $userAnswer;
    public $correctAnswer;

    /** @var bool */
    private $evaluationEnabled = null;

    public function initFromXmlNode(DOMElement $node)
    {
        $this->reset();

        if ($node->hasAttribute('evaluationEnabled'))
        {
            $this->evaluationEnabled = $node->getAttribute('evaluationEnabled') === 'true';
        }
        else
        {
            $this->evaluationEnabled = null;
        }

        if ($this->isGraded())
        {
            $this->awardedPoints = $node->getAttribute('awardedPoints');
        }

        $directionNode = $node->getElementsByTagName('direction')->item(0);
        $directionSource = XmlUtils::getElementText($directionNode);
        $this->direction = str_replace("\n", PHP_EOL, $directionSource);
    }

    public function isGraded()
    {
        return !is_null($this->evaluationEnabled) ? $this->evaluationEnabled : $this->isGradedByDefault();
    }
    
    abstract public function isGradedByDefault();

    protected function reset()
    {
        $this->awardedPoints = null;
        $this->direction = null;
        $this->userAnswer = null;
        $this->correctAnswer = null;
    }
}