<?php
/**
 * Created by PhpStorm.
 * User: gkalligeros
 * Date: 11/13/2017
 * Time: 9:48 PM
 */

class DummyDataBase implements iDataBase
{

    public function execute($query, $bindings)
    {
        // TODO: Implement execute() method.
        return $query;
    }

    public function connect($query)
    {
        // TODO: Implement connect() method.
    }

    public function beginTransaction()
    {
        // TODO: Implement beginTransaction() method.
    }

    public function endTransaction()
    {
        // TODO: Implement endTransaction() method.
    }

    public function supportsTransactions():bool
    {
       return true;
    }
}