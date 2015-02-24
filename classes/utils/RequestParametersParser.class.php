<?php

class RequestParametersParser
{
    public static function getRequestParameters($postParameters, $rawRequest)
    {
        $result = $postParameters;
        if (!$result)
        {
            $result = array();
            if ($rawRequest)
            {
                parse_str($rawRequest, $result);
            }
        }
        return $result;
    }
}