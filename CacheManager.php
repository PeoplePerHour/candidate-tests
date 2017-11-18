<?php

/**
 * Created by PhpStorm.
 * User: gkalligeros
 * Date: 11/18/2017
 * Time: 3:14 PM
 * Cache manager class tha handles all CRUD operations in cache
 *
 */
class CacheManager
{
    const CACHE_EXPIRATION_TIME = 1000;

    /**
     * CacheManager constructor.
     * @param iCacheDriver $driver
     */
    function __construct(iCacheDriver $driver)
    {
        $this->driver = $driver;
    }

    /**
     * Store the given query into the cache
     * @param string $tableName
     * @param array $selectColumns
     * @param array $conditions
     * @param $result
     */
    function remember($tableName, $selectColumns, $conditions, $result)
    {
        $this->driver->store($this->generateCacheKey($tableName, $selectColumns,$conditions), $result);
    }


    /**
     * Generate cache key from query params
     * @param string $tableName
     * @param array $selectColumns
     * @param array $conditions
     * @return string
     */
    public function generateCacheKey($tableName, $selectColumns, $conditions)
    {
        echo $tableName . serialize($tableName).serialize($conditions)."</br>";
        return md5($tableName . serialize($selectColumns).serialize($conditions));
    }

    /**
     * Remove  from cache
     * @param string $key
     */
    public function delete($key)
    {
        $this->driver->delete($key);
    }

    /**
     * Retrieve value with given key from cache if available and not expired
     * @param string $tableName
     * @param array $bindings
     * @param  array $conditions
     * @return string
     * @internal param $query
     */
    public function get($tableName, $bindings, $conditions)
    {
        $key = $this->generateCacheKey($tableName,$bindings,$conditions);
        return $this->driver->get($key, static::CACHE_EXPIRATION_TIME);

    }
}