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
interface AbstractDatabase
{

    public function select($table, $fields, $conditions, $options);
    public function insert($table, $data);
    public function update();
    public function delete();
    public function close();
    public function tableExist($table);
    public function columnsExist($table, $columns);
    public function beginTransaction();
    public function commitTransaction();
    public function rollBackTransaction();

}