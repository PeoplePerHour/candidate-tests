<?php

class UNICACHE_MemoryCache extends UNICACHE_Cache
{
    public static function isSupported( )
    {
        return true;
    }

    protected $_cache;

    public function __construct()
    {
        $this->_cache = array();
    }

    public function __destruct()
    {
        $this->_cache = null;
    }

    public function put( $key, $data, $ttl )
    {
        $this->_cache[$this->prefix.$key] = array(time()+(int)$ttl,$data);
    }

    public function get( $key )
    {
        if ( !isset($this->_cache[$this->prefix.$key]) ) return false;

        $data = $this->_cache[$this->prefix.$key];

        if ( !$data || time() > $data[0] )
        {
            unset($this->_cache[$this->prefix.$key]);
            return false;
        }
        return $data[1];
    }

    public function remove( $key )
    {
        if ( !isset($this->_cache[$this->prefix.$key]) ) return false;
        unset($this->_cache[$this->prefix.$key]);
        return true;
    }

    public function clear( )
    {
        if ( !strlen($this->prefix) )
        {
            $this->_cache = array();
        }
        else
        {
            foreach($this->_cache as $key=>$data)
            {
                if ( 0===strpos($key, $this->prefix, 0) )
                {
                    unset($this->_cache[$key]);
                }
            }
        }
        return true;
    }

    public function gc( $maxlifetime )
    {
        $maxlifetime = (int)$maxlifetime;
        $currenttime = time();
        $l = strlen($this->prefix);
        foreach($this->_cache as $key=>$data)
        {
            if ( !$l || 0===strpos($key, $this->prefix, 0) )
            {
                if ( $data[0] < $currenttime-$maxlifetime )
                    unset($this->_cache[$key]);
            }
        }
        return true;
    }
}
