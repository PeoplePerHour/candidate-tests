<?php
/**
 * Created by PhpStorm.
 * User: gkalligeros
 * Date: 11/18/2017
 * Time: 3:35 PM
 */
include_once("iCacheDriver.php");

class FileCacheDriver implements iCacheDriver
{
    private $cacheDir;
    /**
     * FileCacheDriver constructor.
     * @param string $cacheDir
     */
    public function __construct($cacheDir='cache')
    {
        $this->cacheDir = $cacheDir;
        if(!file_exists($this->cacheDir))
            mkdir($this->cacheDir);
    }

    /**
     * @param $key
     * @param $expiration
     * @return mixed|null
     */
    public function get($key, $expiration)
    {
        if ($this->hasCachedValue($key, $expiration)) {
            return unserialize(file_get_contents($this->getCacheLocation($key)));
        }
        $this->delete($key);
        return null;

    }

    public function store($key, $value)
    {
        $serializedData = serialize($value);
        $cacheFilename = $key;

        file_put_contents($this->cacheDir.DIRECTORY_SEPARATOR.$cacheFilename, $serializedData);
    }

    public function delete($key)
    {

        if (file_exists(  $this->getCacheLocation($key))) {
            unlink($this->getCacheLocation($key));

        }


    }

    /**
     * @param $key
     * @param $expiration
     * @return bool
     */
    public function hasCachedValue($key, $expiration)
    {

        return file_exists($this->getCacheLocation($key)) && ($this->expirationTimeStamp($key, $expiration) > time());
    }

    /**
     * @param $key
     * @return string
     */
    public function getCacheLocation($key)
    {
        return getcwd() . DIRECTORY_SEPARATOR . $this->cacheDir . DIRECTORY_SEPARATOR . $key;
    }

    /**
     * @param $key
     * @param $expiration
     * @return bool|int
     */
    public function expirationTimeStamp($key, $expiration)
    {



        return filemtime($this->getCacheLocation($key)) + (1000 * $expiration);
    }
}