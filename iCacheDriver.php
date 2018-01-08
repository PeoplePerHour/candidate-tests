<?php
/**
 * AQBstact cache driver that must be implemented by an cahc implementation
 * Created by PhpStorm.
 * User: gkalligeros
 * Date: 11/18/2017
 * Time: 3:14 PM
 */

interface iCacheDriver
{

    /**
     * get the given key from
     * if it was created after now + @param $expiration
     * @param string $key
     * @param $expiration
     * @return string $value
     */
    public function get($key, $expiration);

    /**
     * Store the given value in cache value db with this key
     * @param string $key
     * @param string $value
     * @return mixed
     */
    public function store($key, $value);


    /**
     * Delete the given key from cache
     * @param $key
     * @return mixed
     */
    public function delete($key);

}