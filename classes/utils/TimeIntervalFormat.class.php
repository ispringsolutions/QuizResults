<?php

class TimeIntervalFormat
{
    /**
     * @param int|float $seconds
     * @return string
     */
    public function ApplyToSeconds($seconds)
    {
        $seconds = round($seconds);
        $hours = floor($seconds / 3600);
        $seconds %= 3600;
        $minutes = floor($seconds / 60);
        $seconds %= 60;
        return sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);
    }
}