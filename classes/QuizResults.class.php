<?php

class QuizResults
{
    const XSD_CURRENT = "QuizReport.xsd";
    const XSD_OLDER_THAN_9 = "QuizReport_8.xsd";

    const VERSION_9 = '9.0';

    public $quizType;
    public $quizTitle;
    public $passingScore;
    public $passingScorePercent;
    public $totalScore;
    public $studentName;
    public $studentEmail;
    public $studentPoints;
    public $quizTakingTimeInSeconds;
    public $formattedQuizTakingTime;
    public $version;

    /** @var QuizDetails */
    public $detailResult;

    /** @var QuizStatus */
    private $quizStatus;

    public function InitFromRequest($requestParams)
    {
        $this->ReadFromRequestParams($requestParams);
        $this->CheckInvalidVariables();
        $this->InitDetailResult($requestParams);
        $this->InitUserAttemptData();
    }

    /**
     * .@return string
     */
    public function formatUserScore()
    {
        $totalPoints = $this->quizStatus->getTotalPoints();
        $studentPercent = $this->quizStatus->getStudentPercent();

        /** @var QuizStatus|null */
        if ($totalPoints > 0)
        {
            $result = "{$this->quizStatus->getStudentPoints()} / {$totalPoints} ({$studentPercent}%)";
        }
        elseif (!is_null($studentPercent))
        {
            $result = "{$studentPercent}%";
        }
        else
        {
            $result = "{$this->quizStatus->getStudentPoints()}";
        }

        return $result;
    }

    /**
     * @return string
     */
    public function formatPassingScore()
    {
        $passingPoints = $this->quizStatus->getPassingPoints();
        $passingPercent = $this->quizStatus->getPassingPercent();
        if (!is_null($passingPoints) && !is_null($passingPercent))
        {
            $result = "{$passingPoints} ({$passingPercent}%)";
        }
        elseif (!is_null($passingPoints))
        {
            $result = $passingPoints;
        }
        else
        {
            $result = "{$passingPercent}%";
        }
        return $result;
    }

    /**
     * @return string
     */
    public function formatStatus()
    {
        return $this->quizStatus->isPassed() ? 'Passed' : 'Failed';
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
        $this->passingPercent = $requestParams["psp"];
        $this->totalScore = $requestParams["tp"];

        $this->studentName = $requestParams["sn"];
        $this->studentEmail = $requestParams["se"];
        $this->studentPoints = $requestParams["sp"];
        $this->quizStatus = new QuizStatus($this->quizType);
        $this->version = $requestParams["v"];
        $this->quizTakingTimeInSeconds = $requestParams["ut"];
        $this->formattedQuizTakingTime = $requestParams["fut"] ?: $this->FormatQuizTakingTime($this->quizTakingTimeInSeconds);
    }

    private function InitUserAttemptData()
    {
        $this->studentPoints = floatval($this->studentPoints);
        $this->quizStatus->setPassingPoints($this->passingScore)
                         ->setPassingPercent($this->passingScorePercent)
                         ->setTotalPoints($this->totalScore)
                         ->setStudentPoints($this->studentPoints);

        if (Version::IsVersionNewerOrSameAs($this->version, self::VERSION_9))
        {
            $this->AddAttemptDataFromSummary();
        }
    }

    private function AddAttemptDataFromSummary()
    {
        if (!is_null($this->detailResult->passingPercent))
        {
            $this->quizStatus->setPassingPercent($this->detailResult->passingPercent);
        }

        if (!is_null($this->detailResult->studentPercent))
        {
            $this->quizStatus->setStudentPercent($this->detailResult->studentPercent);
        }

        if (!is_null($this->detailResult->isTestPassed))
        {
            $this->quizStatus->setPassedStatus($this->detailResult->isTestPassed);
        }
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
        if (Version::IsVersionNewerOrSameAs($version, self::VERSION_9))
        {
            $validationSchema = self::XSD_CURRENT;
        }
        return $validationSchema;
    }
}