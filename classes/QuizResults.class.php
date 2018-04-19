<?php

class QuizResults
{
    const XSD_HEAD = "QuizReport.xsd";

    public $quizType;
    public $quizTitle;
    public $passingScore;
    public $studentName;
    public $studentEmail;
    public $studentPoints;
    public $version;

    /**
     * @var QuizDetails
     */
    public $detailResult;

    public function InitFromRequest($requestParams)
    {
        $this->ReadFromRequestParams($requestParams);
        $this->checkInvalidVariables();
        $this->InitUserAttemptData();
        $this->InitDetailResult($requestParams);
    }

    private function ReadFromRequestParams($requestParams)
    {
        $requestParams = new RequestParameters($requestParams);

        $this->quizType = $requestParams["t"];
        if (!$this->quizType)
        {
            $this->quizType = QuizType::GRADED;
        }

        $this->quizTitle = $requestParams["qt"];
        $this->passingScore = $requestParams["ps"];

        $this->studentName = $requestParams["sn"];
        $this->studentEmail = $requestParams["se"];
        $this->studentPoints = $requestParams["sp"];
        $this->version = $requestParams["v"];
    }

    private function InitUserAttemptData()
    {
        $this->studentPoints = floatval($this->studentPoints);
    }

    private function InitDetailResult($requestParams)
    {
        if ( !isset( $requestParams["dr"] ) )
        {
            return;
        }

        $detailResultXml = stripslashes($requestParams["dr"]);
        if ($detailResultXml)
        {
            $quizDetails = new QuizDetails();
            $xsdFileName = self::XSD_HEAD;
            $validateSuccessfully = $quizDetails->loadFromXml($detailResultXml, $xsdFileName, $this->version);
            if ($validateSuccessfully)
            {
                $this->detailResult = $quizDetails;
            }
        }
    }

    private function checkInvalidVariables()
    {
        $invalidVariables = array();
        if (empty($this->quizTitle))
        {
            $invalidVariables[] = "qt(Quiz Title)";
        }

        if ($this->quizType == QuizType::GRADED)
        {
            if (!is_numeric($this->studentPoints))
            {
                $invalidVariables[] = "sp(Student Points)";
            }

            if (!is_numeric($this->passingScore))
            {
                $invalidVariables[] = "ps/psp(Passing Score/PassingScorePercent)";
            }
        }

        if (count($invalidVariables) > 0)
        {
            throw new InvalidArgumentException("Incorrect or missing variables: " . join(", ", $invalidVariables));
        }
    }
}