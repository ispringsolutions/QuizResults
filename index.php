<?php

    header('Access-Control-Allow-Origin: *');

    if ($_SERVER['REQUEST_METHOD'] != 'POST')
    {
        echo "POST request expected";
        return;
    }

    error_reporting(E_ALL && E_WARNING && E_NOTICE);
    ini_set('display_errors', 1);
    ini_set('log_errors', 1);

    require_once 'includes/common.inc.php';

    $requestParameters = RequestParametersParser::getRequestParameters($_POST, !empty($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : null);

    try
    {
        $quizResults = new QuizResults();
        $quizResults->InitFromRequest($requestParameters);
        $generator = QuizReportFactory::CreateGenerator($quizResults, $requestParameters);
        $report = $generator->createReport();

        $dateTime = date('Y-m-d_H-i-s');
        $resultFilename = dirname(__FILE__) . "/result/quiz_result_{$dateTime}.txt";
        
        // some debugging
        // $is_writable = is_writable('/var/www/html/result');
        // echo $resultFilename . "is writable:" . $is_writable . "\n";
        echo $report;
        
        // @file_put_contents($resultFilename, $report); the @ surpresses any error - use this in prod-env only
        file_put_contents($resultFilename, $report);

    }
    catch (Exception $e)
    {
        error_log($e);

        echo "Error: " . $e->getMessage();
    }

    function _log($requestParameters)
    {
        $logFilename = dirname(__FILE__) . '/log/quiz_results.log';
        $event       = array('ts' => date('Y-m-d H:i:s'), 'request_parameters' => $requestParameters, 'ts_' => time());
        $logMessage  = json_encode($event);
        $logMessage .= ',' . PHP_EOL;
        // echo $logMessage; #for debugging purpose
        file_put_contents($logFilename, $logMessage, FILE_APPEND);
    }