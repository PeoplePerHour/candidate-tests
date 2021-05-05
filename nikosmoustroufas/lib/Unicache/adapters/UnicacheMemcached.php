<?php

class UNICACHE_MemcachedCache extends UNICACHE_Cache
{
    public static function isSupported( )
    {
        return (extension_loaded('memcached') || extension_loaded('memcache'));
        //return class_exists('Memcached', false) || class_exists('Memcache', false);
    }

    // Memcache object
    private $connection;

    public function __construct()
    {
        $this->connection = null;
        if (class_exists('Memcached', false))
        {
            $this->connection = new \Memcached();
        }
        elseif (class_exists('Memcache', false))
        {
            $this->connection = new \Memcache();
        }
    }

    public function __destruct()
    {
        if ($this->connection instanceof \Memcache)
        {
            $this->connection->close();
        }
        elseif ($this->connection instanceof \Memcached && method_exists($this->connection, 'quit'))
        {
            $this->connection->quit();
        }
        $this->connection = null;
    }

    public function put( $key, $data, $ttl )
    {
        if (get_class($this->connection) === 'Memcached')
        {
            return $this->connection->set($this->prefix.$key, $value, (int)$ttl);
        }
        elseif (get_class($this->connection) === 'Memcache')
        {
            return $this->connection->set($this->prefix.$key, $value, 0, (int)$ttl);
        }
        return false;
    }

    public function get( $key )
    {
        return $this->connection->get( $this->prefix.$key );
    }

    public function remove( $key )
    {
        return $this->connection->delete( $this->prefix.$key );
    }

    public function clear( )
    {
        if ( strlen($this->prefix) )
        {
            // Memcache
            if ( get_class($this->connection) === 'Memcache' )
            {
                $slabs = $this->connection->getExtendedStats('slabs');
                foreach($slabs as $serverSlabs)
                {
                    if ( !$serverSlabs ) continue;
                    foreach($serverSlabs as $slabId => $slabMeta)
                    {
                        if ( !is_int($slabId) ) continue;

                        try
                        {
                            $cacheDump = $this->connection->getExtendedStats('cachedump', (int)$slabId, 1000);
                        }
                        catch (\Exception $e)
                        {
                            continue;
                        }

                        if ( !is_array($cacheDump) ) continue;
                        foreach($cacheDump as $dump)
                        {
                            if ( !is_array($dump) ) continue;
                            foreach($dump as $key => $value)
                            {
                                if ( 0 === strpos($key, $this->prefix) )
                                    $this->connection->delete($key);
                            }
                        }
                    }
                }
                return true;
            }

            // Memcached
            elseif ( get_class($this->connection) === 'Memcached' )
            {
                $keys = $this->connection->getAllKeys();
                foreach($keys as $index => $key)
                {
                    if ( 0 === strpos($key, $this->prefix) )
                    {
                        $this->connection->delete($key);
                    }
                }
                return true;
            }
        }

        return $this->connection->flush( );
    }

    public function gc( $maxlifetime )
    {
        // handled automatically
        return true;
    }

    public function addServer( $host, $port=11211, $weight=10 )
    {
        if (get_class($this->connection) === 'Memcache')
        {
            $this->connection->addServer( $host, $port, true, $weight );
        }
        else
        {
            $this->connection->addServer( $host, $port, $weight );
        }
        return $this;
    }
}
