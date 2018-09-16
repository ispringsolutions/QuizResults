<?php

class LikertScaleQuestion extends Question
{
    private $areLabelsIndexedFromZero = false;

    public function getType()
    {
        return QuestionType::LIKERT_SCALE;
    }

    public function isGradedByDefault()
    {
        return false;
    }

    public function initFromXmlNode(DOMElement $node)
    {
        parent::initFromXmlNode($node);

        $statementsNode = $node->getElementsByTagName('statements')->item(0);
        $statementsCollection = TextCollection::fromXmlNode($statementsNode, 'statement');
        $statements = $statementsCollection->toArray();

        $labelsNode = $node->getElementsByTagName('scaleLabels')->item(0);
        $this->areLabelsIndexedFromZero = XmlUtils::getElementBooleanAttribute($labelsNode, 'numberFromZero');
        $labelsCollection = TextCollection::fromXmlNode($labelsNode, 'label');
        $labels = $labelsCollection->toArray();

        $userAnswers = array();

        if ($node->getElementsByTagName('userAnswer')->length != 0)
        {
            $userAnswerNode = $node->getElementsByTagName('userAnswer')->item(0);
            $userAnswers = $this->exportUserAnswer($userAnswerNode);
        }

        $index = 0;
        foreach ($statements as $statement)
        {
            $label = '';
            $userAnswer = $this->getUserAnswerByStatementIndex($userAnswers, $index);
            $hasAnswerBeenGiven = $userAnswer && !is_null($userAnswer->labelIndex) && $userAnswer->labelIndex >= 0;
            if ($hasAnswerBeenGiven)
            {
                $label = $labels[$userAnswer->labelIndex];
            }

            if ($this->userAnswer != '')
            {
                $this->userAnswer .= '; ';
            }
            $this->userAnswer .= $statement . ' - ' .
                                 ($hasAnswerBeenGiven ? ($label . $this->getLabelIndexText($userAnswer)) : '');
            ++$index;
        }
    }

    /**
     * @param $userAnswers
     * @param $index
     * @return LikertScaleMatch
     */
    public function getUserAnswerByStatementIndex($userAnswers, $index)
    {
        if (!$userAnswers)
        {
            return null;
        }

        foreach ($userAnswers as $match)
        {
            if ($match->statementIndex == $index)
            {
                return $match;
            }
        }

        return null;
    }

    private function exportUserAnswer(DOMElement $node)
    {
        $out = Array();

        $matchesList = $node->getElementsByTagName('match');
        for ($i = 0; $i < $matchesList->length; ++$i)
        {
            $matchNode = $matchesList->item($i);

            $match = new LikertScaleMatch();
            $match->initFromXmlNode($matchNode);
            $out[] = $match;
        }

        return $out;
    }

    /**
     * @param LikertScaleMatch|null $userAnswer
     */
    private function getLabelIndexText(LikertScaleMatch $userAnswer = null)
    {
        if (!$userAnswer)
        {
            return '';
        }

        $index = $userAnswer->labelIndex;
        if (!$this->areLabelsIndexedFromZero)
        {
            ++$index;
        }
        return " ($index)";
    }
}