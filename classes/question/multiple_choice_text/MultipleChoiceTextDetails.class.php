<?php

class MultipleChoiceTextDetails extends MultipleChoiceTextSurveyDetails
{
    protected function createBlank()
    {
        return new MultipleChoiceTextDetailsBlank();
    }
}