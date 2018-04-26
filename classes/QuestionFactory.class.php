<?php

class QuestionFactory
{
    const TYPE_IN_RENAMED_IN_VERSION = '9.0';

    /**
     * @param DOMElement $questionNode
     * @param string $version
     * @return IQuestion|null
     */
    public static function CreateFromXmlNode(DOMElement $questionNode, $version)
    {
        $question = null;

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
            case QuestionType::LEGACY_TYPE_IN_OR_NEW_FILL_IN_THE_BLANK:
                if (Version::IsVersionOlderThan($version, self::TYPE_IN_RENAMED_IN_VERSION))
                {
                    $question = new TypeInQuestion();
                }
                else
                {
                    $question = new FillInTheBlankQuestion();
                }
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
                $question = new WordBankSurveyQuestion();
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
            case QuestionType::DRAG_AND_DROP_QUESTION:
                $question = new DragAndDropQuestion();
                break;
        }

        if ($question != null)
        {
            $question->initFromXmlNode($questionNode);
        }

        return $question;
    }
}