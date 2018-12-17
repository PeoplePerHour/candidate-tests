<?php

namespace CT\DBConnectionManager\Cache;
use Redis;

/**
 * Class RedisCache
 * @package CT\DBConnectionManager\Cache
 */
class RedisCache implements CacheInterface {

    protected $cacheObj;

    public function __construct() {
        $this->cacheObj = new Redis();
    }

    public function connect($host, $port, $persistent = false) {
        if ($persistent) {
            $this->cacheObj->pconnect($host, intval($port));
            return $this;
        }
        $this->cacheObj->connect($host, intval($port));
        return $this;
    }

    public function set($key, $value, $time = 0) {
        return $this->cacheObj->set($key, $value, intval($time));
    }

    public function update($key, $value, $time = 0) {
        return $this->set($key, $value, $time);
    }

    public function get($key) {
        return $this->cacheObj->get($key);
    }

    public function delete($key) {
        return (bool)$this->cacheObj->delete($key);
    }

    public function clearCache() {
        return (bool)$this->cacheObj->flushAll();
    }
}