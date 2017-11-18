<?php
/**
 * Created by PhpStorm.
 * User: gkalligeros
 * Date: 11/18/2017
 * Time: 3:14 PM
 */

interface iCacheDriver
{

    public function get($key,$expiration);
    public function store($key,$value);
    public function delete($key);

}