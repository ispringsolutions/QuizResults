<?php

class WordBankSurveyQuestion extends Question
{
    /** @var WordBankDetails */
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
            /** @var WordBankDetailsSurveyWord $item */
            if ($this->userAnswer != '')
            {
                $this->userAnswer .= '; ';
            }
            $this->userAnswer .= ($item->userAnswer) ? $item->userAnswer : '______';
        }
    }

    protected function createDetails()
    {
        return new WordBankSurveyDetails();
    }
}