<?php

class QuizReportFactory
{
    const DEFAULT_LANGUAGE     = 'en';
    const I18N_FILENAME_FORMAT = 'i18n/%s.xml';

    /**
     * @param QuizResults    $quizResults
     * @param array          $requestParams
     *
     * @return QuizReportGenerator
     */
    public static function CreateGenerator(QuizResults $quizResults, $requestParams)
    {
        $takerInfo = QuizTakerInfoFactory::CreateFromRequest($requestParams);
        if ($takerInfo)
        {
            $takerInfo->initUserInResults($quizResults);
        }

        $generator = new QuizReportGenerator($quizResults, $requestParams);
        $generator->setTakerInfo($takerInfo);
        return $generator;
    }
}