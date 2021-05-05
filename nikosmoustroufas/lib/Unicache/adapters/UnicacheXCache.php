<?php

class UNICACHE_XCache extends UNICACHE_Cache
{
    public static function isSupported( )
    {
        return extension_loaded('xcache');
        //return (function_exists('xcache_get') && function_exists('xcache_set') && function_exists('xcache_unset'));
    }

    public function __construct()
    {
    }

    public function __destruct()
    {
    }

    public function get( $key )
    {
        $data = xcache_get( $this->prefix.$key );
        return null !== $data ? $data : false
    }

    public function put( $key, $data, $ttl )
    {
        return xcache_set( $this->prefix.$key, $data, (int)$ttl );
    }

    public function remove( $key )
    {
        return xcache_unset( $this->prefix.$key );
    }

    public function clear( )
    {
        /*$max = xcache_count(XC_TYPE_VAR);
        for ($i=0; $i<$max; $i++)
        {
            xcache_clear_cache(XC_TYPE_VAR, $i);
        }*/
        xcache_unset_by_prefix( $this->prefix );
        return true;
    }

    public function gc( $maxlifetime )
    {
        // handled automatically
        return true;
    }
}
