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
        $questionsList = $questionsNode->childNodes;
        for ($i = 0; $i < $questionsList->length; ++$i)
        {
            $question = null;

            $questionNode = $questionsList->item($i);
            switch ($questionNode->nodeName)
            {
            case QuestionType::TRUE_FALSE:
                $question = new TrueFalseQuestion();
                break;
            case QuestionType::MULTIPLE_CHOICE:
                $question = new MultipleChoiceQuestion();
                break;
            case QuestionType::MULTIPLE_RESPOSE:
                $question = new MultipleResponseQuestion();
                break;
            case QuestionType::SEQUENCE:
                $question = new SequenceQuestion();
                break;
            case QuestionType::FILL_IN_THE_BLANK:
                $question = new FillInTheBlankQuestion();
                break;
            case QuestionType::TYPE_IN:
                $question = new TypeInQuestion();
                break;
            case QuestionType::MATCHING:
                $question = new MatchingQuestion();
                break;
            case QuestionType::NUMERIC:
                $question = new NumericQuestion();
                break;
            case QuestionType::MULTIPLE_CHOICE_TEXT:
                $question = new MultipleChoiceTextQuestion();
                break;
            case QuestionType::WORD_BANK:
                $question = new WordBankQuestion();
                break;
            case QuestionType::ESSAY:
                $question = new EssayQuestion();
                break;
            case QuestionType::HOTSPOT:
                $question = new HotspotQuestion();
                break;
            case QuestionType::YES_NO:
                $question = new TrueFalseSurveyQuestion();
                break;
            case QuestionType::PICK_ONE:
                $question = new MultipleChoiceSurveyQuestion();
                break;
            case QuestionType::PICK_MANY:
                $question = new MultipleResponseSurveyQuestion();
                break;
            case QuestionType::SHORT_ANSWER:
                $question = new TypeInSurveyQuestion();
                break;
            case QuestionType::RANKING:
                $question = new SequenceSurveyQuestion();
                break;
            case QuestionType::NUMERIC_SURVEY:
                $question = new NumericSurveyQuestion();
                break;
            case QuestionType::MATCHING_SURVEY:
                $question = new MatchingSurveyQuestion();
                break;
            case QuestionType::WHICH_WORD:
                $question = new WorkBankSurveyQuestion();
                break;
            case QuestionType::LIKERT_SCALE:
                $question = new LikertScaleQuestion();
                break;
            case QuestionType::MULTIPLE_CHOICE_TEXT_SURVEY:
                $question = new MultipleChoiceTextSurveyQuestion();
                break;
            case QuestionType::FILL_IN_THE_BLANK_SURVEY:
                $question = new FillInTheBlankSurveyQuestion();
                break;
            }

            if ($question != null)
            {
                $question->initFromXmlNode($questionNode);
                $this->questions[] = $question;
            }
        }
    }
}