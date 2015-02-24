<?php

class WordBankQuestion extends WorkBankSurveyQuestion
{
    public function getType()
    {
        return QuestionType::WORD_BANK;
    }

    public function isGraded()
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