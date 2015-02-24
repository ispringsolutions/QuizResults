<?php

class FillInTheBlankDetails extends FillInTheBlankSurveyDetails
{
    protected function createBlank()
    {
        return new FillInTheBlankDetailsBlank();
    }
}