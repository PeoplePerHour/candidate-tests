<?php
/**
 * Dummy database implementation for testing
 * this class is just a stub
 * Created by PhpStorm.
 * User: gkalligeros
 * Date: 11/13/2017
 * Time: 9:48 PM
 */

class DummyDataBase implements iDataBase
{

    public function execute($query, $bindings)
    {
        return [
            "cll" => "values"
        ];
    }

    public function connect()
    {
    }

    public function beginTransaction()
    {
    }

    public function endTransaction()
    {

    }

    public function supportsTransactions(): bool
    {
        return true;
    }
}