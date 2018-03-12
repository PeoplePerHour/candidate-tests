<?php
/**
 * Created by PhpStorm.
 * User: JC
 * Date: 06-Mar-18
 * Time: 00:16
 */

namespace johnchristofis\dbcmanager\drivers;

use johnchristofis\dbcmanager\DatabaseAbstractionLayer;
use Exception;
use PDO;
use PDOException;
use Throwable;

/**
 * Class MysqlDriver
 * @package johnchristofis\dbcmanager
 * Mysql specific driver that implements AbstractDatabase
 */
class MysqlDriver implements DatabaseAbstractionLayer
{

    private $driverName = "MySQL Driver";
    private $pdo;

    public function __construct($host,$user, $password, $database, $port,$persistent = true)
    {
        try {
            $this->pdo = new PDO("mysql:host=$host:$port;dbname=$database", $user, $password/*,array(
                PDO::ATTR_PERSISTENT => $persistent)*/);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();;
        }
    }


    public function select($table, array $fields = [], array $conditions = [],array $options = ['orderBy'=>'id','order'=>'desc'] )
    {

        $this->tableExists($table);
        $this->columnsExists($table, $fields);

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

        $statement = $this->pdo->prepare($sql);
        foreach ($conditions as $condition => $value) {
            $statement->bindValue(":$condition", $value);
        }
        // TODO implement getColumnMeta(0); to add strict data_type in bindValue()

        $statement->execute();
        $result = $statement->fetchAll();
        return $result;
    }

    /**
     * Insert record on database table
     * @param $table
     * @param $data
     * @return bool
     * @throws Exception
     */
    public function insert($table, $data)
    {

        $this->tableExists($table);
        $this->columnsExists($table, array_keys($data));

        $insert = "INSERT INTO $table ";
        if (empty($data)){
            throw new Exception('Data can not be empty.');
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

        $statement = $this->pdo->prepare($sql);
        foreach ($data as $column => $value) {
            $statement->bindValue(":$column", $value);
        }

        return $statement->execute();
    }

    /**
     * Update record in a database table
     * @param $table
     * @param array $data
     * @param array $conditions
     * @return bool
     */
    public function update($table, array $data, array $conditions = [])
    {
        $this->tableExists($table);
        $this->columnsExists($table, array_keys($data));

        $update = "UPDATE $table";
        $set = ' SET ';

        foreach ($data as $column => $value) {
            $set .= "$column = :$column";
            if(next( $data )){
                $set .= ' , ';
            }
        }

        if (!empty($conditions) && $this->columnsExists($table, array_keys($conditions))){

            $where = ' WHERE ';
            foreach ($conditions as $condition => $value) {

                $where .= $condition." = :condition_$condition";

                if(next( $conditions )){
                    $where .= ' AND ';
                }
            }

        }else{
            $where = ' ';
        }

        $sql = $update.$set.$where;

        $statement = $this->pdo->prepare($sql);

        foreach ($data as $column => $value) {
            $statement->bindValue(":$column", $value);
        }

        foreach ($conditions as $column => $value) {
            $statement->bindValue(":condition_$column", $value);
        }

        return $statement->execute();
    }

    /**
     * Delete record from database table
     * @param $table
     * @param array $conditions
     * @return bool
     */
    public function delete($table, array $conditions)
    {
        $this->tableExists($table);
        $this->columnsExists($table, array_keys($conditions));

        $delete = "DELETE FROM $table ";

        if (!empty($conditions) && $this->columnsExists($table, array_keys($conditions))){

            $where = ' WHERE ';
            foreach ($conditions as $condition => $value) {

                $where .= $condition." = :$condition";

                if(next( $conditions )){
                    $where .= ' AND ';
                }
            }

        }else{
            $where = ' ';
        }

        $sql = $delete.$where;

        $statement = $this->pdo->prepare($sql);
        foreach ($conditions as $column => $value) {
            $statement->bindValue(":$column", $value);
        }

        return $statement->execute();
    }

    /**
     * Forces pdo to close the db connection (optional as PDO gets terminated after php script execution. Problem exists with PDO persistent connection)
     */
    public function close()
    {
        $this->pdo = null;
    }


    /**
     * Check if database table is valid and exists
     * @param $table
     * @return bool
     */
    public function tableExists($table)
    {
        try{
            $statement = $this->pdo->query('DESCRIBE ' . $table);
            $result = $statement->execute();

        }catch (PDOException $e){
            echo "Database table $table doesn't exist";
        }

        return true;
    }

    /**
     * Check if database column is valid and exists
     * @param $table
     * @param $columns
     * @return bool
     */
    public function columnsExists($table, $columns)
    {
        $statement = $this->pdo->prepare("DESCRIBE $table");
        $statement->execute();
        $tableColumns = $statement->fetchAll(PDO::FETCH_COLUMN);

        try{
            if (count(array_intersect($tableColumns,$columns)) < count($columns)){
                throw new PDOException("Specified columns are not valid");
            }
        }catch (PDOException $e){
            echo $e->getMessage()."<br>";
        }
        return true;
    }

    /**
     * Begin the transaction
     */
    public function beginTransaction()
    {
        $this->pdo->beginTransaction();
    }

    /**
     * Commit the transaction the performed queries don't fail
     * @return bool
     */
    public function commitTransaction()
    {
        return $this->pdo->commit();
    }

    /**
     * Roll the transaction back
     * @return bool
     */
    public function rollBackTransaction()
    {
        return $this->pdo->rollBack();
    }

    /**
     * Get current driver name
     * @return string
     */
    public function getDriverName()
    {
        return $this->driverName;
    }

}