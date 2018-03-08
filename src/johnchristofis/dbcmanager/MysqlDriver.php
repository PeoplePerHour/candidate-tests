<?php
/**
 * Created by PhpStorm.
 * User: JC
 * Date: 06-Mar-18
 * Time: 00:16
 */

namespace johnchristofis\dbcmanager;

use Exception;
use mysqli;
use PDO;
use PDOException;

/**
 * Class MysqlDriver
 * @package johnchristofis\dbcmanager
 * Mysql specific driver that implements AbstractDatabase
 */
class MysqlDriver extends PDO implements AbstractDatabase
{

    public function __construct($host,$user, $password, $database, $port,$persistent = true)
    {

        try {
            parent::__construct("mysql:host=$host:$port;dbname=$database", $user, $password,array(
                PDO::ATTR_PERSISTENT => $persistent
            ));
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();;
        }
    }


    public function select($table, $fields=[], $conditions = [],$options = ['order by'=>'id','order'=>'desc'] )
    {

        $this->tableExist($table);
        $this->columnsExist($table, $fields);

        $select = "SELECT ";
        $from = " FROM $table ";
        $fields = !empty($fields) ? implode(",",$fields) : '*';
        $where = '';

        if (!empty($conditions)){

            $where = ' WHERE ';
            foreach ($conditions as $condition => $value) {

                $where .= $condition." = :$condition";

                if(next( $conditions )){
                    $where .= ' AND ';
                }
            }

        }else{
            $where = '';
        }

        $orderBy = array_key_exists('orderBy',$options) ? ' ORDER BY '.$options['orderBy'] : '';
        $order = array_key_exists('order',$options) ? ' '.$options['order'] : '';
        $limit = array_key_exists('limit',$options) ? ' LIMIT '.$options['limit'] : '';
        $offset = array_key_exists('offset',$options) ? ' OFFSET '.$options['offset'] : '';

        $sql = $select.$fields.$from.$where.$orderBy.$order.$limit.$offset;

        $statement = $this->prepare($sql);
        foreach ($conditions as $condition => $value) {
            $statement->bindValue(":$condition", $value);
        }
        // TODO implement getColumnMeta(0); to add strict data_type in bindValue()

        $statement->execute();
        $result = $statement->fetchAll();
        return $result;
    }


    public function insert($table, $data)
    {

        $this->tableExist($table);
        $this->columnsExist($table, array_keys($data));

        $insert = "INSERT INTO $table ";
        if (empty($data)){
            throw new Exception('Conditions can not be empty.');
        }

        $columns = ' ( ';
        $columns .= implode(",",array_keys($data));
        $columns .= ' ) ';

        $values = ' VALUES ( ';
        foreach ($data as $column => $value) {
            $values .= ":$column";
            if(next( $data )){
                $values .= ' , ';
            }
        }
        $values .= ' ) ';

        $sql = $insert.$columns.$values;

        $statement = $this->prepare($sql);
        foreach ($data as $column => $value) {
            $statement->bindValue(":$column", $value);
        }

        return $statement->execute();
    }

    public function update()
    {
        // TODO: Implement update() method.
    }

    public function delete()
    {
        // TODO: Implement delete() method.
    }


    public function close()
    {
        // TODO: Implement close() method.
    }


    public function tableExist($table)
    {
        try{
            $statement = $this->query('DESCRIBE ' . $table);
            $result = $statement->execute();

        }catch (PDOException $e){
            echo "Database table $table doesn't exist";
        }
    }

    public function columnsExist($table, $columns)
    {

        $statement = $this->prepare("DESCRIBE $table");
        $statement->execute();
        $tableColumns = $statement->fetchAll(PDO::FETCH_COLUMN);

        try{
            if (count(array_intersect($tableColumns,$columns)) < count($columns)){
                throw new Exception('Specified columns are not valid');
            }
        }catch (Exception $e){
            echo $e->getMessage();
        }

    }

    public function commitTransaction()
    {
        // TODO: Implement commitTransaction() method.
    }

    public function rollBackTransaction()
    {
        // TODO: Implement rollBackTransaction() method.
    }


}