<?php

class WordBankQuestion extends WordBankSurveyQuestion
{
    public function getType()
    {
        return QuestionType::WORD_BANK;
    }

    public function isGradedByDefault()
    {
        return true;
    }

    public function initFromXmlNode(DOMElement $node)
    {
        parent::initFromXmlNode($node);

        foreach ($this->details->items as $item)
        {
            /** @var WordBankDetailsWord $item */
            if ($this->correctAnswer != '')
            {
                $this->correctAnswer .= '; ';
            }
            $this->correctAnswer .= $item->getValue();
        }
    }

    protected function createDetails()
    {
        return new WordBankDetails();
    }
}