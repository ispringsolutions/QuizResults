<?php

class QuizDetails
{
    const FINISH_TIMESTAMP_ATTRIBUTE = 'finishTimestamp';
    const IS_TEST_PASSED_ATTRIBUTE = 'passed';
    const PASSING_PERCENT_TAG = 'passingPercent';
    const STUDENT_PERCENT_ATTRIBUTE = 'percent';


    /** @var string|null */
    public $finishedAt;

    /** @var Question[] */
    public $questions;

    /** @var bool|null */
    public $isTestPassed = null;

    /** @var float|null */
    public $studentPercent = null;

    /** @var float|null  */
    public $passingPercent = null;

    /**
     * init from xml
     * @param string $xml
     * @param string $xsdSchemeFileName
     * @param string $version
     * @return bool true, if xml was validate with xsd scheme, else - false
     */
    public function loadFromXml($xml, $xsdSchemeFileName, $version)
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

        $summaryNode = $doc->getElementsByTagName('summary')->item(0);
        if ($summaryNode)
        {
            if ($summaryNode->hasAttribute(self::FINISH_TIMESTAMP_ATTRIBUTE))
            {
                $this->finishedAt = $summaryNode->getAttribute(self::FINISH_TIMESTAMP_ATTRIBUTE);
            }
            $this->isTestPassed = XmlUtils::getElementBooleanAttribute($summaryNode, self::IS_TEST_PASSED_ATTRIBUTE);
            if ($summaryNode->hasAttribute(self::STUDENT_PERCENT_ATTRIBUTE))
            {
                $this->studentPercent = $summaryNode->getAttribute(self::STUDENT_PERCENT_ATTRIBUTE);
            }
        }

        $passingPercentNode = $doc->getElementsByTagName(self::PASSING_PERCENT_TAG)->item(0);
        if ($passingPercentNode)
        {
            $this->passingPercent = $passingPercentNode->textContent;
        }

        $questionsNode = $doc->getElementsByTagName('questions')->item(0);
        $this->exportQuestions($questionsNode, $version);

        return true;
    }

    /**
     * @param DOMElement $questionsNode
     * @param string $version
     */
    private function exportQuestions(DOMElement $questionsNode, $version)
    {
        foreach ($questionsNode->childNodes as $questionNode)
        {
            if (!$questionNode instanceof DOMElement)
            {
                continue;
            }

            $question = QuestionFactory::CreateFromXmlNode($questionNode, $version);
            if ($question)
            {
                $this->questions[] = $question;
            }
        }
    }
}