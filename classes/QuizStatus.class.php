<?php

class QuizStatus
{
    /** @var string */
    private $quizType;

    /** @var float */
    private $passingPoints;

    /** @var float */
    private $passingPercent;

    /** @var float */
    private $totalPoints;

    /** @var float */
    private $studentPoints;

    /** @var float */
    private $studentPercent;

    /** @var bool|null */
    private $isPassedOverride = null;

    /**
     * @param string $quizType
     */
    public function __construct($quizType)
    {
        $this->quizType = $quizType;
    }

    /**
     * @param float $points
     * @return $this
     */
    public function setPassingPoints($points)
    {
        $this->passingPoints = $points;
        return $this;
    }

    /**
     * @param float $percent
     * @return $this
     */
    public function setPassingPercent($percent)
    {
        $this->passingPercent = $percent;
        return $this;
    }

    /**
     * @param float $points
     * @return $this
     */
    public function setTotalPoints($points)
    {
        $this->totalPoints = $points;
        return $this;
    }

    /**
     * @param float $points
     * @return $this
     */
    public function setStudentPoints($points)
    {
        $this->studentPoints = $points;
        return $this;
    }

    /**
     * @param float $percent
     * @return $this
     */
    public function setStudentPercent($percent)
    {
        $this->studentPercent = $percent;
        return $this;
    }

    /**
     * @param bool $isPassed
     * @return $this
     */
    public function setPassedStatus($isPassed)
    {
        $this->isPassedOverride = $isPassed;
        return $this;
    }

    /**
     * @return float
     */
    public function getStudentPoints()
    {
        return round($this->studentPoints, 2);
    }

    /**
     * @return float
     */
    public function getTotalPoints()
    {
        return round($this->totalPoints, 2);
    }

    /**
     * @return float
     */
    public function getStudentPercent()
    {
        if (!is_null($this->studentPercent))
        {
            return $this->studentPercent;
        }

        return $this->totalPoints > 0
            ? round(($this->studentPoints / $this->totalPoints) * 100, 2)
            : null;
    }

    /**
     * @return float
     */
    public function getPassingPoints()
    {
        return round($this->passingPoints, 2);
    }

    /**
     * @return float
     */
    public function getPassingPercent()
    {
        if (!is_null($this->passingPercent))
        {
            return $this->passingPercent;
        }

        return $this->totalPoints > 0
            ? round(($this->passingPoints / $this->totalPoints) * 100, 2)
            : null;
    }


    /**
     * @return bool|null
     */
    public function isPassed()
    {
        if (!$this->isApplicable())
        {
            return null;
        }

        if (!is_null($this->isPassedOverride))
        {
            return $this->isPassedOverride;
        }

        return $this->studentPoints >= $this->passingPoints;
    }

    /**
     * @return bool
     */
    public function isApplicable()
    {
        return $this->quizType == QuizType::GRADED;
    }
}