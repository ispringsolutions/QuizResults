<?php

class QuizDetails
{
    public $questions;

    /**
     * init from xml
     * @param $xml - string
     * @param $xsdSchemeFileName - string
     * @return true, if xml was validate with xsd scheme, else - false
     */
    public function loadFromXml($xml, $xsdSchemeFileName)
    {
        libxml_use_internal_errors(true);

        $doc = new DOMDocument('1.0', 'utf8');

        $doc->loadXML($xml);

        // validate xml
        if (!$doc->schemaValidate($xsdSchemeFileName))
        {
            _log(var_export(libxml_get_errors(), true));
            return false;
        }

        $questionsNode = $doc->getElementsByTagName('questions')->item(0);
        $this->exportQuestions($questionsNode);

        return true;
    }

    private function exportQuestions(DOMElement $questionsNode)
    {
        foreach ($questionsNode->childNodes as $questionNode)
        {
            $question = QuestionFactory::CreateFromXmlNode($questionNode);
            if ($question)
            {
                $this->questions[] = $question;
            }
        }
    }
}