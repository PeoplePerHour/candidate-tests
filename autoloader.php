<?php

/**
 * Class Autoloader
 */
class Autoloader
{
    /**
     * @param string $className
     *
     * @return bool
     */
    public static function loader(string $className)
    {
        $fileName = str_replace("\\", '/', $className) . '.php';
        if (file_exists($fileName)) {
            /** @noinspection PhpIncludeInspection */
            include $fileName;
            if (class_exists($className)) {
                return true;
            }
        }

        return false;
    }
}

spl_autoload_register('Autoloader::loader');