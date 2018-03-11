<?php
/**
 * Created by PhpStorm.
 * User: JC
 * Date: 06-Mar-18
 * Time: 00:01
 */

namespace johnchristofis\dbcmanager;

/**
 * Interface AbstractDatabase
 * @package johnchristofis\dbcmanager
 * AbstractDatabase interface that stands as the Database Abstraction Layer and can be implemented by any RDBMS driver
 */
interface DatabaseAbstractionLayer
{

    public function select($table, array $fields, array $conditions, array $options);
    public function insert($table, $data);
    public function update();
    public function delete();

    public function tableExists($table);
    public function columnsExists($table, $columns);

    public function beginTransaction();
    public function commitTransaction();
    public function rollBackTransaction();

    public function getDriverName();
    public function close();

}