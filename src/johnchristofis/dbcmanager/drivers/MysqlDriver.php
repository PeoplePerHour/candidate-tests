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


    public function insert($table, $data)
    {

        $this->tableExists($table);
        $this->columnsExists($table, array_keys($data));

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

        $statement = $this->pdo->prepare($sql);
        foreach ($data as $column => $value) {
            $statement->bindValue(":$column", $value);
        }

        return $statement->execute();
    }

    public function update()
    {
        // TODO: Implement update() method.
        echo  'update data';
    }

    public function delete()
    {
        // TODO: Implement delete() method.
        echo  'delete data';

    }

    /**
     * Forces pdo to close the db connection (optional as PDO gets terminated after php script execution. Problem exists with PDO persistent connection)
     */
    public function close()
    {
        $this->pdo = null;
    }


    public function tableExists($table)
    {
        try{
            $statement = $this->pdo->query('DESCRIBE ' . $table);
            $result = $statement->execute();

        }catch (PDOException $e){
            echo "Database table $table doesn't exist";
        }
    }

    public function columnsExists($table, $columns)
    {

        $statement = $this->pdo->prepare("DESCRIBE $table");
        $statement->execute();
        $tableColumns = $statement->fetchAll(PDO::FETCH_COLUMN);

        try{
            if (count(array_intersect($tableColumns,$columns)) < count($columns)){
                throw new PDOException('Specified columns are not valid');
            }
        }catch (PDOException $e){
            echo $e->getMessage();
        }

    }

    public function beginTransaction()
    {
        $this->pdo->beginTransaction();
    }

    public function commitTransaction()
    {
        return $this->pdo->commit();
    }

    public function rollBackTransaction()
    {
        return $this->pdo->rollBack();
    }

    public function getDriverName()
    {
        return $this->driverName;
    }

}