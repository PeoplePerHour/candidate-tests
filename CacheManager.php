<?php


class CacheManager
{
    const CACHE_EXPIRATION_TIME = 1000;

    function __construct(iCacheDriver $driver)
    {
        $this->driver = $driver;
    }

    function remember($tableName, $selectColumns, $conditions, $result)
    {
        $this->driver->store($this->generateCacheKey($tableName, $selectColumns,$conditions), $result);
    }


    public function generateCacheKey($tableName, $selectColumns, $conditions)
    {
        echo $tableName . serialize($tableName).serialize($conditions)."</br>";
        return md5($tableName . serialize($selectColumns).serialize($conditions));
    }

    public function clear($key)
    {
        $this->driver->delete($key);
    }

    public function get($query, $bindings,$conditions)
    {
        $key = $this->generateCacheKey($query,$bindings,$conditions);
        return $this->driver->get($key, static::CACHE_EXPIRATION_TIME);

    }
}