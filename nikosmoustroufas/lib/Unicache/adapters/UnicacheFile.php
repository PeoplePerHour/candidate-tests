<?php

class UNICACHE_FileCache extends UNICACHE_Cache
{
    public static function isSupported( )
    {
        return true;
    }

    private $cachedir = '';

    public function __construct()
    {
    }

    public function __destruct()
    {
    }

    public function put( $key, $data, $ttl )
    {
        // Opening the file in read/write mode
        $ch = fopen($this->getFileName($key),'a+');
        if (!$ch)
            throw new \Exception('UNICACHE: Could not save to cache');

        flock($ch,LOCK_EX); // exclusive lock, will get released when the file is closed
        fseek($ch,0); // go to the start of the file
        // truncate the file
        ftruncate($ch,0);

        // Serializing along with the TTL
        $data = serialize(array(time()+(int)$ttl,$data));
        if (false === fwrite($ch,$data))
            throw new \Exception('UNICACHE: Could not save to cache');
        fclose($ch);
    }

    public function get( $key )
    {
        $filename = $this->getFileName($key);
        if (!file_exists($filename)) return false;
        $ch = fopen($filename,'r');

        if (!$ch) return false;

        // Getting a shared lock
        flock($ch,LOCK_SH);

        $data = (string)fread($ch, filesize($filename));
        fclose($ch);

        $data = @unserialize($data);

        if (!$data || time() > $data[0])
        {
            // Unlinking when the file was expired
            @unlink($filename);
            return false;
        }
        return $data[1];
    }

    public function remove( $key )
    {
        $filename = $this->getFileName($key);
        if (file_exists($filename))
            return @unlink($filename);
        else
            return false;
    }

    public function clear( )
    {
        /*if ($handle = opendir($this->cachedir))
        {
            while (false !== ($file=readdir($handle)))
            {
                if( is_file($file) )
                    @unlink($file);
            }
            closedir($handle);
            return true;
        }
        return false;*/
        $files = glob($this->cachedir . DIRECTORY_SEPARATOR . $this->prefix . '*');
        if ( !empty($files) )
        {
            foreach((array)$files as $file)
            {
                if( is_file($file) )
                    @unlink($file);
            }
        }
        return true;
    }

    public function gc( $maxlifetime )
    {
        $files = glob($this->cachedir . DIRECTORY_SEPARATOR . $this->prefix . '*');
        if ( !empty($files) )
        {
            $currenttime = time();
            $maxlifetime = (int)$maxlifetime;
            foreach((array)$files as $file)
            {
                if( is_file($file) )
                {
                    $mtime = filemtime($file);
                    if ( false===$mtime ) continue;
                    if ($mtime < $currenttime-$maxlifetime )
                    {
                        // expired, delete
                        @unlink($file);
                    }
                }
            }
        }
        return true;
    }

    public function setCacheDir( $dir )
    {
        $this->cachedir = rtrim((string)$dir, '/\\');
        if ( !(file_exists($this->cachedir) && is_dir($this->cachedir)) )
            @mkdir($this->cachedir, 0755, true); // recursive
        return $this;
    }

    protected function getFileName( $key )
    {
        return $this->cachedir . DIRECTORY_SEPARATOR . $this->prefix . md5($key);
    }
}
