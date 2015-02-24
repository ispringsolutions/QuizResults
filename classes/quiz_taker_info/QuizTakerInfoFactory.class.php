<?php

class QuizTakerInfoFactory
{
    const PARAM_FIELDS = 'vt';

    public static function CreateFromRequest($requestParameters)
    {
        $fieldTitles = self::getFieldTitlesFromParameters($requestParameters);
        if (!$fieldTitles)
        {
            return null;
        }
        unset($requestParameters[self::PARAM_FIELDS]);
        return new QuizTakerInfo($fieldTitles, $requestParameters);
    }

    /**
     * @param array $requestParameters
     * @return array
     */
    private static function getFieldTitlesFromParameters($requestParameters)
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
}