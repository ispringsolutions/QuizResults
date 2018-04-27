<?php

class WordBankSurveyDetails
{
    private static $wordTagNames = array(
        'word',
        'blank'
    );

    public $items;

    public function initFromXmlNode(DOMElement $node)
    {
        foreach ($node->childNodes as $childNode)
        {
            if (in_array($childNode->tagName, self::$wordTagNames))
            {
                $word = $this->createWord();
                $word->initFromXmlNode($childNode);
                $this->items[] = $word;
            }
        }
    }

    protected function createWord()
    {
        return new WordBankDetailsSurveyWord();
    }
}