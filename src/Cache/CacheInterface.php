<?php

namespace CT\DBConnectionManager\Cache;

interface CacheInterface {

    public function connect($host, $port);
    public function set($key, $value, $time = 0);
    public function update($key, $value, $time = 0);
    public function get($key);
    public function delete($key);
    public function clearCache();

}