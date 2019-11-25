<?php

/**
 * I will use this class as a singleton pattern
 */

namespace app\Components\Files;

class FilesOperationProvider
{

    private static $theOnlyInstance = null;
    protected $data;
    protected $controller;
    const FILE_OPERATION = "fileOperation";

    private function __construct($data)
    {
        
        (new $data[self::FILE_OPERATION])->applyOperation($data);
    }

    public static function initialize($data)
    {
        if (self::$theOnlyInstance == null) {
            self::$theOnlyInstance = new FilesOperationProvider($data);
        }

        return self::$theOnlyInstance;
    }
}
