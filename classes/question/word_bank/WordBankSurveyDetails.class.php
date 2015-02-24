<?php

class WordBankSurveyDetails
{
    public $items;

    public function initFromXmlNode(DOMElement $node)
    {
        $childNodes = $node->getElementsByTagName($this->getWordTagName());
        foreach ($childNodes as $childNode)
        {
            $word = $this->createWord();
            $word->initFromXmlNode($childNode);
            $this->items[] = $word;
        }
    }

    protected function getWordTagName()
    {
        return 'blank';
    }

    protected function createWord()
    {
        return new WordBankDetailsSurveyWord();
    }
}