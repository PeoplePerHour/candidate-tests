<?php
/**
 * Created by PhpStorm.
 * User: JC
 * Date: 11-Mar-18
 * Time: 14:57
 */

namespace johnchristofis\dbcmanager;

use Exception;
use johnchristofis\dbcmanager;
use johnchristofis\dbcmanager\drivers;
use Throwable;

/**
 * Class ConnectionManager
 * @package johnchristofis\dbcmanager
 * Connection Manager Class that handles database connection
 */
class ConnectionManager implements DatabaseAbstractionLayer
{

    private static $instance;
    private $driver;
    private $host;
    private $user;
    private $password;
    private $database;
    private $port;

    /**
     * Use of Singleton pattern to prevent the instantiation of multiple ConnectionManager objects.
     * @param $driver
     * @param $host
     * @param $user
     * @param $password
     * @param $database
     * @param $port
     * @return ConnectionManager
     */
    public static function connect($driver,$host, $user, $password, $database, $port){
        if (!isset(self::$instance)){
            self::$instance = new self($driver,$host, $user, $password, $database, $port);
        }

        return self::$instance;
    }

    /**
     * ConnectionManager constructor.
     * @param $driver
     * @param $host
     * @param $user
     * @param $password
     * @param $database
     * @param $port
     */
    private function __construct($driver,$host, $user, $password, $database, $port)
    {
        $this->host = $host;
        $this->database = $database;
        $this->user = $user;
        $this->password = $password;
        $this->port = $port;

        $driver = __NAMESPACE__.'\drivers\\'.ucfirst($driver).'Driver';
        try{
            $this->driver = new $driver($host,$user, $password, $database, $port);
        }catch (Throwable $throwable){
            echo $throwable->getMessage();
        }
    }

    /**
     * Returns the current connection driver name
     * @return string
     */
    public function getDriverName()
    {
        return $this->driver->getDriverName();
    }

    /**
     * Returns the current connection host name
     * @return string
     */
    public function getDatabaseHost(){
        return $this->host;
    }

    /**
     * Returns current database name
     * @return string
     */
    public function getDatabaseName(){
        return $this->database;
    }

    /**
     * Returns current database port
     * @return string
     */
    public function getDatabasePort(){
        return $this->port;
    }

    /**
     * Returns current database user name
     * @return string
     */
    public function getDatabaseUser(){
        return $this->user;
    }

    /**
     *
     * Performs a select query in a database table with the specified fields and conditions
     * @param $table
     * @param $fields
     * @param array $conditions
     * @param array $options
     * @return mixed
     */
    public function select($table, array $fields = [], array $conditions = [], array $options = []){
        return $this->driver->select($table, $fields, $conditions, $options);
    }

    public function insert($table, $data)
    {
        return $this->driver->insert($table, $data);
    }

    public function update($table, array $data, array $conditions){
        return $this->driver->update($table, $data, $conditions);
    }

    public function delete(){
        return $this->driver->delete();
    }

    public function tableExists($table)
    {
        return $this->driver->tableExists($table);
    }

    public function columnsExists($table, $columns)
    {
        return $this->driver->columnsExists($table, $columns);
    }

    public function beginTransaction()
    {
        return $this->driver->beginTransaction();
    }

    public function commitTransaction()
    {
        return $this->driver->commitTransaction();
    }

    public function rollBackTransaction()
    {
        return $this->driver->rollBackTransaction();
    }

    public function close()
    {
        return $this->driver->close();
    }

}