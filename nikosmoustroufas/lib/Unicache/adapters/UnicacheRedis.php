<?php

require_once(dirname(__FILE__).'/drivers/redis.php');

class UNICACHE_RedisCache extends UNICACHE_Cache
{
    public static function isSupported( )
    {
        //return extension_loaded('redis');
        return true;
    }

    // Lightweight Redis client
    private $redis;

    public function __construct()
    {
    }

    public function __destruct()
    {
        $this->redis = null;
    }

    public function put( $key, $data, $ttl )
    {
        $data = serialize(array(time()+(int)$ttl, $data));
        return $this->redis->cmd('SET', $this->prefix.$key, $data)->cmd('EXPIRE', $this->prefix.$key, (int)$ttl)->set();
    }

    public function get( $key )
    {
        $data = $this->redis->cmd('GET', $this->prefix.$key)->get();
        if ( !$data ) return false;
        $data = @unserialize($data);
        if ( !$data || time() > $data[0] )
        {
            //$this->redis->cmd('UNLINK', $this->prefix.$key)->set();
            return false;
        }
        return $data[1];
    }

    public function remove( $key )
    {
        return $this->redis->cmd('UNLINK', $this->prefix.$key)->set();
    }

    public function clear( )
    {
        // consider using SCAN command to retrieve keys by prefix for `clear` method
        $keys = $this->redis->cmd('KEYS', $this->prefix.'*')->get();
        if ( !$keys ) return true;
        foreach($keys as $key)
        {
            $this->redis->cmd('UNLINK', $key);
        }
        $this->redis->set();
        return true;
    }

    public function gc( $maxlifetime )
    {
        // handled automatically
        return true;
    }

    public function server( $host, $port=6379 )
    {
        $this->redis = new redis_cli( $host, $port );
        return $this;
    }
}
