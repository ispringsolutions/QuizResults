<?php

class Version
{
    /**
     * @param string $version1
     * @param string $version2
     * @return bool
     */
    public static function IsVersionOlderThan($version1, $version2)
    {
        if (!$version1)
        {
            // empty version is considered to be older (they don't send version parameter)
            return true;
        }

        $comparisonResult = strnatcmp($version1, $version2);
        return $comparisonResult < 0;
    }

    /**
     * @param $version1
     * @param $version2
     * @return bool
     */
    public static function IsVersionNewerOrSameAs($version1, $version2)
    {
        return !self::IsVersionOlderThan($version1, $version2);
    }
}