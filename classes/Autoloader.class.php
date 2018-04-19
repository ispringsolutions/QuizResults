<?php

class Autoloader
{
    const PHP_STATEMENT_THAT_RETURNS_VALUE = "<?php return ";
    const PHP_STATEMENT_END = ';';

    const PHP_FILE_PATTERN  = '/\.php$/';
    const CLASS_NAME_PATTERN = '/^(?P<class_name>[a-z_][a-z_0-9]*)\./i';

    /** @var string[]|null */
    private static $pathsByClassNames;

    const CACHE_DIR = 'cache';

    public static function LoadClassByName($className)
    {
        self::EnsureClassPathsAreLoaded();
        $lowerCaseClassName = mb_strtolower($className);
        if (!empty(self::$pathsByClassNames[$lowerCaseClassName]))
        {
            include_once(self::$pathsByClassNames[$lowerCaseClassName]);
        }
    }

    private static function EnsureClassPathsAreLoaded()
    {
        if (is_null(self::$pathsByClassNames))
        {
            self::EnsureClassPathsCacheIsCreated();
            self::$pathsByClassNames = self::LoadFromCache() ?: self::ReadClassPathsFromFileSystem();
        }
    }

    private static function EnsureClassPathsCacheIsCreated()
    {
        $filePath = self::GetCacheFilePath();
        if (!file_exists($filePath))
        {
            $classPathsByNames = self::ReadClassPathsFromFileSystem();
            $data = self::PHP_STATEMENT_THAT_RETURNS_VALUE . var_export($classPathsByNames, true) . self::PHP_STATEMENT_END;
            @file_put_contents($filePath, $data);
        }
    }

    /**
     * @return string[]
     */
    private static function LoadFromCache()
    {
        $cacheFilePath = self::GetCacheFilePath();
        return is_readable($cacheFilePath) ? include_once($cacheFilePath) : [];
    }

    /**
     * @return string
     */
    private static function GetCacheFilePath()
    {
        return dirname(__FILE__) . '/../' . self::CACHE_DIR . '/__autoload_cache.php';
    }

    /**
     * @return string[]
     */
    private static function ReadClassPathsFromFileSystem()
    {
        $result = [];

        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(dirname(__FILE__), RecursiveDirectoryIterator::SKIP_DOTS | RecursiveDirectoryIterator::KEY_AS_FILENAME),
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        /** @var SplFileInfo[] $phpFiles */
        $phpFiles = new RegexIterator($files, self::PHP_FILE_PATTERN, RegexIterator::MATCH, RegexIterator::USE_KEY);
        foreach ($phpFiles as $file)
        {
            $className = self::GetClassNameFromFileName($file->getFilename());
            $className = mb_strtolower($className);
            if ($className)
            {
                $result[$className] = $file->getPathname();
            }
        }

        return $result;
    }

    /**
     * @param string $fileName
     * @return string
     */
    private static function GetClassNameFromFileName($fileName)
    {
        $result = null;
        if (preg_match(self::CLASS_NAME_PATTERN, $fileName, $matches))
        {
            $result = $matches['class_name'];
        }
        return $result;
    }
}