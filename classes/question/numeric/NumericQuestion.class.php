<?php

class NumericQuestion extends NumericSurveyQuestion
{
    public function isGradedByDefault()
    {
        return true;
    }

    public function initFromXmlNode(DOMElement $node)
    {
        parent::initFromXmlNode($node);

        $answersNode = $node->getElementsByTagName('answers')->item(0);
        $answers = $this->exportAnswers($answersNode);
        $this->correctAnswer = join(', ', $answers);
    }

    private function exportAnswers(DOMElement $node = null)
    {
        if (!$node)
        {
            return null;
        }

        $answers = array();
        $answersList = $node->childNodes;
        for ($i = 0; $i < $answersList->length; ++$i)
        {
            $answerNode = $answersList->item($i);
            switch ($answerNode->nodeName)
            {
                case 'between':
                    $leftOperand = $answerNode->getElementsByTagName('leftOperand')->item(0)->textContent;
                    $rightOperand = $answerNode->getElementsByTagName('rightOperand')->item(0)->textContent;
                    $answers[] = new NumericAnswer(NumericAnswerType::BETWEEN, $leftOperand, $rightOperand);
                    break;
                case 'equal';
                    $value = $answerNode->textContent;
                    $answers[] = new NumericAnswer(NumericAnswerType::EQUAL, $value);
                    break;
                case 'greather':
                case 'greater':
                    $value = $answerNode->textContent;
                    $answers[] = new NumericAnswer(NumericAnswerType::GREATHER, $value);
                    break;
                case 'greatherOrEqual':
                case 'greaterOrEqual':
                    $value = $answerNode->textContent;
                    $answers[] = new NumericAnswer(NumericAnswerType::GREATHER_OR_EQUAL, $value);
                    break;
                case 'less':
                    $value = $answerNode->textContent;
                    $answers[] = new NumericAnswer(NumericAnswerType::LESS, $value);
                    break;
                case 'lessOrEqual':
                    $value = $answerNode->textContent;
                    $answers[] = new NumericAnswer(NumericAnswerType::LESS_OR_EQUAL, $value);
                    break;
                case 'notEqual':
                    $value = $answerNode->textContent;
                    $answers[] = new NumericAnswer(NumericAnswerType::NOT_EQUAL, $value);
                    break;
            }

            return $answers;
        }
    }
}