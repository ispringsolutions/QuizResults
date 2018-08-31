<?php

class QuizTakerInfoFactory
{
    const PARAM_FIELDS = 'vt';
    const PARAM_QUIZ_PAGE_ARGS = 'pv';

    private static $standardFieldTitles = array(
        'USER_NAME' => 'Name',
        'USER_EMAIL' => 'Email',
        'COMPANY' => 'Company',
        'DEPARTMENT' => 'Department',
        'JOBTITLE' => 'Job Title',
        'PHONE' => 'Phone',
        'ADDRESS' => 'Address',
    );

    public static function CreateFromRequest($requestParameters)
    {
        $shouldSkipAbsentFields = false;
        $fieldTitles = self::getCustomizedFieldTitles($requestParameters);
        if (!$fieldTitles)
        {
            // When a standard field is not present in parameters it should not show in result
            $shouldSkipAbsentFields = true;
            $fieldTitles = self::$standardFieldTitles;
        }

        $parametersOfPageQuizHasBeenLoadedOn = self::getJsonEncodedParam($requestParameters, self::PARAM_QUIZ_PAGE_ARGS);

        unset(
            $requestParameters[self::PARAM_FIELDS],
            $requestParameters[self::PARAM_QUIZ_PAGE_ARGS]
        );

        $requestParameters = array_merge($parametersOfPageQuizHasBeenLoadedOn, $requestParameters);
        $result = new QuizTakerInfo($fieldTitles, $requestParameters);
        $result->shouldSkipAbsentFields($shouldSkipAbsentFields);
        return $result;
    }

    /**
     * @param array $requestParameters
     * @return array|null
     */
    private static function getCustomizedFieldTitles($requestParameters)
    {
        if (!self::hasValidFieldTitlesParameter($requestParameters))
        {
            return null;
        };

        $result = array();
        $fields = $requestParameters[self::PARAM_FIELDS];
        ksort($fields);

        foreach ($fields as $fieldInfo)
        {
            if (!self::isValidFieldInfo($fieldInfo))
            {
                continue;
            }

            $id = $fieldInfo['id'];
            $title = isset($fieldInfo['title']) ? $fieldInfo['title'] : '';
            $result[$id] = $title;
        }
        return $result;
    }

    /**
     * @param $requestParameters
     * @return bool
     */
    private static function hasValidFieldTitlesParameter($requestParameters)
    {
        return !empty($requestParameters[self::PARAM_FIELDS])
            && is_array($requestParameters[self::PARAM_FIELDS]);
    }

    private static function isValidFieldInfo($fieldInfo)
    {
        return isset($fieldInfo['id']);
    }

    /**
     * @param array $requestParameters
     * @param string $name
     * @return array
     */
    private static function getJsonEncodedParam($requestParameters, $paramName)
    {
        $result = array();
        if (empty($requestParameters[$paramName]))
        {
            return $result;
        }

        $encodedParam = $requestParameters[$paramName];
        $decodedParam = json_decode($encodedParam);
        if (is_array($decodedParam))
        {
            $result = $decodedParam;
        }

        return $result;
    }
}