<?php
/**
 * Created by PhpStorm.
 * User: gkalligeros
 * Date: 11/18/2017
 * Time: 3:14 PM
 * Basic database abstraction that handles connection to database
 *  execution of prepared statements
 */
interface iDataBase

{
    /**
     * Primary execute query method accepts the prepeared query  and the bindings this was done to handle SQL injections
     * @param string $query
     * @param  array $bindings
     * @return mixed
     */
    public function execute($query, $bindings);

    /**
     * Connect to db server
     * @return mixed
     */
    public function connect();

    /**
     * returns true if this db support transactions
     * @return bool
     */
    public  function  supportsTransactions():bool ;
    
    
}