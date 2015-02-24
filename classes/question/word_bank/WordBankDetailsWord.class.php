<?php

class WordBankDetailsWord extends WordBankDetailsSurveyWord
{
    /**
     * @var boolean
     */
    public $correct = false;

    public function WordBankDetailsWord($value = '')
    {
        parent::__construct($value);
    }

    public function initFromXmlNode(DOMElement $node)
    {
        parent::initFromXmlNode($node);

        $this->correct = $node->getAttribute('correct') == 'true';
    }
}

?>