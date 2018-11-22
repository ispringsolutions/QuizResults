<?php

class MatchingSurveyQuestion extends Question
{
    /**
     * premises
     * @var array of string
     */
    public $premises;

    /**
     * resposes
     * @var array of string
     */
    public $responses;

    public function isGradedByDefault()
    {
        return false;
    }

    public function initFromXmlNode(DOMElement $node)
    {
        parent::initFromXmlNode($node);

        $premisesNode = $node->getElementsByTagName('premises')->item(0);
        $premisesList = $premisesNode->getElementsByTagName('premise');
        for ($i = 0; $i < $premisesList->length; ++$i)
        {
            $this->premises[] = XmlUtils::getElementText($premisesList->item($i));
        }

        $responsesNode = $node->getElementsByTagName('responses')->item(0);
        $responsesList = $responsesNode->getElementsByTagName('response');
        for ($i = 0; $i < $responsesList->length; ++$i)
        {
            $this->responses[] = XmlUtils::getElementText($responsesList->item($i));
        }

        $userAnswerMatches = array();
        if ($node->getElementsByTagName('userAnswer')->length != 0)
        {
            $userAnswerNode = $node->getElementsByTagName('userAnswer')->item(0);
            $userAnswerMatches = $this->exportMatchesCollection($userAnswerNode);
        }

        if (empty($userAnswerMatches))
        {
            return;
        }

        $userAnswers = array();
        foreach ($userAnswerMatches as $answer)
        {
            $userAnswers[$answer->premiseIndex] = $answer;
        }

        ksort($userAnswers);

        foreach ($userAnswers as $i => $answer)
        {
            $premiseIndex = $i;
            $responseIndex = $answer->responseIndex;

            if ($this->userAnswer != '')
            {
                $this->userAnswer .= '; ';
            }
            $this->userAnswer .= $this->premises[$premiseIndex] . ' - ' . $this->responses[$responseIndex];
        }
    }

    /**
     * export matches collection from xml node
     * @param $node DOMElement xml node
     * @return array of Match
     */
    protected function exportMatchesCollection(DOMElement $node)
    {
        $out = Array();

        $matchesList = $node->getElementsByTagName('match');
        for ($i = 0; $i < $matchesList->length; ++$i)
        {
            $matchNode = $matchesList->item($i);

            $match = new Match();
            $match->initFromXmlNode($matchNode);
            $out[] = $match;
        }

        return $out;
    }
}