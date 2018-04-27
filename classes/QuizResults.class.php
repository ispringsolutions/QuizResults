<?php

class QuizResults
{
    const XSD_CURRENT = "QuizReport.xsd";
    const XSD_OLDER_THAN_9 = "QuizReport_8.xsd";

    public $quizType;
    public $quizTitle;
    public $passingScore;
    public $studentName;
    public $studentEmail;
    public $studentPoints;
    public $quizTakingTimeInSeconds;
    public $formattedQuizTakingTime;
    public $version;

    /**
     * @var QuizDetails
     */
    public $detailResult;

    public function InitFromRequest($requestParams)
    {
        $this->ReadFromRequestParams($requestParams);
        $this->CheckInvalidVariables();
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
        $this->quizTakingTimeInSeconds = $requestParams["ut"];
        $this->formattedQuizTakingTime = $requestParams["fut"] ?: $this->FormatQuizTakingTime($this->quizTakingTimeInSeconds);
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

        $detailResultXml = $requestParams["dr"];
        if ($detailResultXml)
        {
            $quizDetails = new QuizDetails();
            $xsdFileName = $this->GetSchemaByVersion($this->version);
            $validateSuccessfully = $quizDetails->loadFromXml($detailResultXml, $xsdFileName, $this->version);
            if ($validateSuccessfully)
            {
                $this->detailResult = $quizDetails;
            }
        }
    }

    private function CheckInvalidVariables()
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

    private function FormatQuizTakingTime($quizTakingTimeInSeconds)
    {
        $format = new TimeIntervalFormat();
        return $format->ApplyToSeconds($quizTakingTimeInSeconds);
    }

    /**
     * @param string $version
     * @return string
     */
    private function GetSchemaByVersion($version)
    {
        $validationSchema = self::XSD_OLDER_THAN_9;
        if (Version::IsVersionNewerOrSameAs($version, '9.0'))
        {
            $validationSchema = self::XSD_CURRENT;
        }
        return $validationSchema;
    }
}