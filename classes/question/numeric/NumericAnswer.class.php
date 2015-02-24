<?php

class NumericAnswer
{
    public $type;
    public $leftOperand;
    public $rightOperand;

    public function __construct($type, $leftOperand, $rightOperand = null)
    {
        $this->type = $type;
        $this->leftOperand = $leftOperand;
        $this->rightOperand = $rightOperand;
    }

    public function __toString()
    {
        switch($this->type)
        {
            case NumericAnswerType::BETWEEN:
                return '< ' . $this->leftOperand . ' & > ' . $this->rightOperand;
                break;
            case NumericAnswerType::EQUAL:
                return '= ' . $this->leftOperand;
                break;
            case NumericAnswerType::GREATHER:
                return '> ' . $this->leftOperand;
                break;
            case NumericAnswerType::GREATHER_OR_EQUAL:
                return '>= ' . $this->leftOperand;
                break;
            case NumericAnswerType::LESS:
                return '< ' . $this->leftOperand;
                break;
            case NumericAnswerType::LESS_OR_EQUAL:
                return '<= ' . $this->leftOperand;
                break;
            case NumericAnswerType::NOT_EQUAL:
                return '!= ' . $this->leftOperand;
                break;
        }

        return '';
    }

    public function getType()
    {
        return $this->type;
    }
}