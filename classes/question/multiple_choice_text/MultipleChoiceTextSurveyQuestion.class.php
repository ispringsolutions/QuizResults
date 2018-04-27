<?php

class MultipleChoiceTextSurveyQuestion extends Question
{
    /**
     * @var MultipleChoiceTextDetails
     */
    public $details;

    public function isGradedByDefault()
    {
        return false;
    }

    public function initFromXmlNode(DOMElement $node)
    {
        parent::initFromXmlNode($node);

        $detailsNode = $node->getElementsByTagName('details')->item(0);
        $this->details = $this->createDetails();
        $this->details->initFromXmlNode($detailsNode);

        foreach ($this->details->items as $item)
        {
            if ($this->userAnswer != '')
            {
                $this->userAnswer .= '; ';
            }
            $this->userAnswer .= ($item->userAnswerIndex == -1) ? '______' : $item->answers[$item->userAnswerIndex];
        }
    }

    protected function createDetails()
    {
        return new MultipleChoiceTextSurveyDetails();
    }
}