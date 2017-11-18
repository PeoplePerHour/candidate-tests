<?php
/**
 * Simple cache driver that uses files created for testing
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
     * Retrieve the value with $key
     * @param string $key
     * @param int $expiration
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

    /**
     * Store the  given $value in file with name $key
     * @param string $key
     * @param string $value
     * @return void
     */
    public function store($key, $value)
    {
        $serializedData = serialize($value);
        $cacheFilename = $key;

        file_put_contents($this->cacheDir.DIRECTORY_SEPARATOR.$cacheFilename, $serializedData);

    }

    /**
     * Delete the file with name $key if exists
     * @param $key
     * @return mixed|void
     */
    public function delete($key)
    {

        if (file_exists(  $this->getCacheLocation($key))) {
            unlink($this->getCacheLocation($key));

        }


    }

    /**
     * Returns tru if this key is in cached and is not expired
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