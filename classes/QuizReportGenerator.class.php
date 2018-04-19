<?php

class QuizReportGenerator
{
    const PASSED = "passed";
    const FAILED = "failed";

    private $quizResults;

    public function __construct(QuizResults $quizResults, $requestParams)
    {
        $this->quizResults = $quizResults;
    }

    public function createReport()
    {
        $report = $this->fetchTemplateHeader();

        $details = $this->quizResults->detailResult;
        if ($details)
        {
            $questions = $details->questions; // array of questions
            foreach ($questions as $question)
            {
                $report .= $this->prepareQuestion($question) . PHP_EOL;
            }
        }

        return $report;
    }

    private function fetchTemplateHeader()
    {
        $header = 'Quiz Name: ' . $this->quizResults->quizTitle . PHP_EOL;

        if ($this->quizResults->studentName)
        {
            $header .= 'User Name: ' . $this->quizResults->studentName . PHP_EOL;
        }
        if ($this->quizResults->studentEmail)
        {
            $header .= 'User Email: ' . $this->quizResults->studentEmail . PHP_EOL;
        }

        if ($this->quizResults->quizType == QuizType::GRADED)
        {
            $header .= 'Passing Score: ' . $this->quizResults->passingScore . PHP_EOL;
            $header .= 'User Score: ' . $this->quizResults->studentPoints . PHP_EOL;
        }
        if ($this->quizResults->formattedQuizTakingTime)
        {
            $header .= 'Quiz Taking Time: ' . $this->quizResults->formattedQuizTakingTime . PHP_EOL;
        }

        return $header . PHP_EOL;
    }

    private function prepareQuestion(Question $question)
    {
        $text = $question->direction . PHP_EOL;

        if ($question->isGraded())
        {
            $text .= 'Awarded Points: ' . $question->awardedPoints . PHP_EOL;
            if (!empty($question->correctAnswer))
            {
                $text .= 'Correct Response: ' . $question->correctAnswer . PHP_EOL;
            }
        }

        $text .= 'User Response: ' . $question->userAnswer . PHP_EOL;

        return $text;
    }
}