<?php

class UNICACHE_APCUCache extends UNICACHE_Cache
{
    public static function isSupported( )
    {
        return extension_loaded('apcu');
        //return (function_exists('apcu_fetch') && function_exists('apcu_store') && function_exists('apcu_delete'));
    }

    public function __construct()
    {
    }

    public function __destruct()
    {
    }

    public function get( $key )
    {
        $data = apcu_fetch( $this->prefix.$key, $success );
        return $success ? $data : false
    }

    public function put( $key, $data, $ttl )
    {
        return apcu_store( $this->prefix.$key, $data, (int)$ttl );
    }

    public function remove( $key )
    {
        return apcu_delete( $this->prefix.$key );
    }

    public function clear( )
    {
        if (class_exists('APCuIterator', false))
        {
            // http://php.net/manual/en/apcuiterator.construct.php
            apcu_delete(new APCuIterator(strlen($this->prefix)?'/'.preg_quote($this->prefix).'.+/':null, APC_ITER_NONE));
            return true;
        }

        $cache = @apcu_cache_info(); // Raises warning by itself already
        foreach ($cache['cache_list'] as $key)
        {
            if ( !strlen($this->prefix) || 0===strpos($key['info'], $this->prefix) )
                apcu_delete($key['info']);
        }
        return true;
    }

    public function gc( $maxlifetime )
    {
        // handled automatically
        return true;
    }
}
