<?php

class QuestionType
{
    const TRUE_FALSE = 'trueFalseQuestion';
    const MULTIPLE_CHOICE = 'multipleChoiceQuestion';
    const MULTIPLE_RESPOSE = 'multipleResponseQuestion';
    const SEQUENCE = 'sequenceQuestion';
    const NUMERIC = 'numericQuestion';
    const FILL_IN_THE_BLANK = 'fillInTheBlankQuestionEx';
    const LEGACY_TYPE_IN_OR_NEW_FILL_IN_THE_BLANK = 'fillInTheBlankQuestion';
    const TYPE_IN = 'typeInQuestion';
    const MATCHING = 'matchingQuestion';
    const MULTIPLE_CHOICE_TEXT = 'multipleChoiceTextQuestion';
    const WORD_BANK = 'wordBankQuestion';
    const ESSAY = 'essayQuestion';
    const HOTSPOT = 'hotspotQuestion';
    const DRAG_AND_DROP_QUESTION = 'dndQuestion';

    const YES_NO = 'yesNoQuestion';
    const PICK_ONE = 'pickOneQuestion';
    const PICK_MANY = 'pickManyQuestion';
    const SHORT_ANSWER = 'shortAnswerQuestion';
    const RANKING = 'rankingQuestion';
    const NUMERIC_SURVEY = 'numericSurveyQuestion';
    const MATCHING_SURVEY = 'matchingSurveyQuestion';
    const WHICH_WORD = 'whichWordQuestion';
    const LIKERT_SCALE = 'likertScaleQuestion';
    const MULTIPLE_CHOICE_TEXT_SURVEY = 'multipleChoiceTextSurveyQuestion';
    const FILL_IN_THE_BLANK_SURVEY = 'fillInTheBlankSurveyQuestion';

    public static $gradedQuestions = array(
        self::TRUE_FALSE,
        self::MULTIPLE_CHOICE,
        self::MULTIPLE_RESPOSE,
        self::SEQUENCE,
        self::NUMERIC,
        self::FILL_IN_THE_BLANK,
        self::LEGACY_TYPE_IN_OR_NEW_FILL_IN_THE_BLANK,
        self::MATCHING,
        self::MULTIPLE_CHOICE_TEXT,
        self::WORD_BANK,
        self::ESSAY,
        self::HOTSPOT,
    );

    public static $surveyQuestions = array(
        self::YES_NO,
        self::PICK_ONE,
        self::PICK_MANY,
        self::SHORT_ANSWER,
        self::RANKING,
        self::NUMERIC_SURVEY,
        self::MATCHING_SURVEY,
        self::WHICH_WORD,
        self::LIKERT_SCALE,
        self::MULTIPLE_CHOICE_TEXT_SURVEY,
        self::FILL_IN_THE_BLANK_SURVEY,
    );
}