<?php

class QuizTakerInfo
{
    private $fields;
    private $fieldTitles;
    private $fieldValues;
    private $isFieldPresentInValues;
    private $replacer;
    private $shouldSkipAbsentFields;

    const FIELD_USER_NAME = 'USER_NAME';
    const FIELD_USER_EMAIL = 'USER_EMAIL';

    public function __construct($fieldTitles, $fieldValues)
    {
        $this->fieldTitles = $fieldTitles;
        $this->fieldValues = $this->collectKnownFieldValues($fieldValues);
        $this->isFieldPresentInValues = $this->collectFieldStates($fieldValues);
    }

    public function initUserInResults(QuizResults $quizResults)
    {
        if (!$this->doesContainUserEmail())
        {
            return;
        }

        $quizResults->studentName = !empty($this->fieldValues[self::FIELD_USER_NAME])
            ? $this->fieldValues[self::FIELD_USER_NAME] : null;
        $quizResults->studentEmail = !empty($this->fieldValues[self::FIELD_USER_EMAIL])
            ? $this->fieldValues[self::FIELD_USER_EMAIL] : null;
    }

    /**
     * @param bool $shouldSkipAbsentFields
     */
    public function shouldSkipAbsentFields($shouldSkipAbsentFields)
    {
        $this->shouldSkipAbsentFields = $shouldSkipAbsentFields;
    }

    /**
     * @return bool
     */
    public function doesContainUserEmail()
    {
        return !empty($this->fieldValues[self::FIELD_USER_NAME])
            || !empty($this->fieldValues[self::FIELD_USER_EMAIL]);
    }

    /**
     * @param array $arrayContainingFieldValues
     * @return array
     */
    private function collectKnownFieldValues($arrayContainingFieldValues)
    {
        $result = array();
        foreach ($this->fieldTitles as $fieldId => $fieldTitle)
        {
            $result[$fieldId] = !empty($arrayContainingFieldValues[$fieldId])
                ? $arrayContainingFieldValues[$fieldId]
                : '';
        }
        return $result;
    }

    /**
     * @param array $arrayContainingFieldValues
     * @return bool[]
     */
    private function collectFieldStates($arrayContainingFieldValues)
    {
        $result = array();
        foreach ($this->fieldTitles as $fieldId => $fieldTitle)
        {
            $result[$fieldId] = array_key_exists($fieldId, $arrayContainingFieldValues);
        }
        return $result;
    }

    public function getReplacer()
    {
        if (!isset($this->replacer))
        {
            $this->replacer = new VariableReplacer($this->fieldValues);
        }
        return $this->replacer;
    }

    /**
     * @return QuizTakerInfoField[]
     */
    public function getFields()
    {
        if (!isset($this->fields))
        {
            $this->fields = $this->createFields();
        }
        return $this->optionallyHideNotProvidedFields($this->fields);
    }

    private function createFields()
    {
        $result = array();
        foreach ($this->fieldTitles as $fieldId => $fieldTitle)
        {
            $result[$fieldId] = new QuizTakerInfoField(
                $fieldTitle,
                $this->fieldValues[$fieldId]
            );
        }
        return $result;
    }

    /**
     * @param QuizTakerInfoField[] $fields
     * @return QuizTakerInfoField[]
     */
    private function optionallyHideNotProvidedFields(array $fields)
    {
        if (!$this->shouldSkipAbsentFields)
        {
            return $fields;
        }

        $result = array();
        foreach ($fields as $fieldId => $field)
        {
            if (!empty($this->isFieldPresentInValues[$fieldId]))
            {
                $result[$fieldId] = $field;
            }
        }
        return $result;
    }
}