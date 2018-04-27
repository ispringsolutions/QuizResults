<?php

class FillInTheBlankQuestion extends FillInTheBlankSurveyQuestion
{
    public function isGradedByDefault()
    {
        return true;
    }

    protected function createDetails()
    {
        return new FillInTheBlankDetails();
    }

    public function initFromXmlNode(DOMElement $node)
    {
        parent::initFromXmlNode($node);

        $detailsNode = $node->getElementsByTagName('details')->item(0);
        $this->details = $this->createDetails();
        if ($detailsNode)
        {
            $this->details->initFromXmlNode($detailsNode);
        }

        foreach ($this->details->items as $item)
        {
            $correctAnswer = '';
            foreach ($item->answers as $answer)
            {
                if ($correctAnswer != '')
                {
                    $correctAnswer .= ', ';
                }
                $correctAnswer .= $answer;
            }
            if ($this->correctAnswer != '')
            {
                $this->correctAnswer .= '; ';
            }
            $this->correctAnswer .= $correctAnswer;
        }
    }
}