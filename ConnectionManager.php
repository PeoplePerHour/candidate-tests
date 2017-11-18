<?php
include_once("iDatabase.php");
/**
 * Created by PhpStorm.
 * User: gkalligeros
 * Date: 11/18/2017
 * Time: 3:14 PM
 * Main class connection manager depends upon an database abstraction and a CacheManager
 *
 */
class ConnectionManager
{


    private $db, $cacheManager;

    /**
     * ConnectionManager constructor.
     * @param iDataBase $db
     * @param CacheManager $cacheManager
     */
    public function __construct(iDataBase $db, CacheManager $cacheManager)
    {
        $this->db = $db;
        $this->db->connect();
        $this->cacheManager = $cacheManager;
    }

    /**
     * Get requested value from cache if it is available or
     * Generate a select statement with bindings and pass it to database for execution  then get the result store it in cache and return it
     * @param string $tableName
     * @param array $selectColumns
     * @param  array $conditions
     * @return bool
     */
    public function select($tableName, $selectColumns, $conditions)
    {
        $parsedColumns = implode(',', $selectColumns);
        $query = "SELECT {$parsedColumns}  FROM {$tableName} WHERE ";
        $conditionsParsed = [];
        $bindings = [];
        $result = $this->getCachedQueryResult($tableName, $selectColumns, $conditions);
        if ($result != null) {
            return $result;
        }
        foreach ($conditions as $condition) {
            $placeHolderName = uniqid();
            $conditionsParsed[] = " {$condition['column']} {$condition['operator']} :{$placeHolderName}";
            $bindings[$placeHolderName] = $condition['value'];
        }
        $query .= implode(' AND ', $conditionsParsed);
        $result = $this->db->execute($query, $bindings);
        $this->cacheManager->remember($tableName, $selectColumns, $conditions, $result);
        return $result;
    }


    /**
     * Generate an insert statement with bindings and pass it to database for execution
     * @param $tableName
     * @param $data
     * @return bool
     */
    public function insert($tableName, $data)
    {
        $columns = implode(array_keys($data[0]), ',');
        $query = "INSERT INTO `{$tableName}` ({$columns}) VALUES ";
        $bindings = [];
        foreach ($data as $row) {
            $placeHolders = [];
            foreach ($row as $columnName => $value) {
                $placeHolderName = uniqid();
                $placeHolders[] = ":{$placeHolderName}";
                $bindings[$placeHolderName] = $value;
            }
            $placeHolders = implode(',', $placeHolders);
            $query .= "({$placeHolders})";

        }
        return $this->db->execute($query, $bindings);
    }

    /**
     * Generate an update statement with bindings and pass it to database for execution
     * @param $tableName
     * @param $data
     * @param $conditions
     * @return mixed
     */
    public function update($tableName, $data, $conditions)
    {
        $query = "UPDATE {$tableName} SET ";
        $conditionsParsed = [];
        $bindings = [];

        foreach ($data as $column => $value) {
            $placeHolderName = uniqid();
            $query .= "{$column} = : {$placeHolderName} ";
            $bindings[$placeHolderName] = $value;

        }
        foreach ($conditions as $condition) {
            $placeHolderName = uniqid();


            $conditionsParsed[] = " {$condition['column']} {$condition['operator']} :{$placeHolderName}";
            $bindings[$placeHolderName] = $condition['value'];
        }
        $query .= "WHERE " . implode(' AND ', $conditionsParsed);

        return $this->db->execute($query, $bindings);
    }

    /**
     * Generate a delete statement with bindings and pass it to database for execution
     * @param $tableName
     * @param $conditions
     * @return mixed
     */
    public function delete($tableName, $conditions)
    {

        $query = "DELETE   FROM {$tableName} WHERE ";
        $conditionsParsed = [];
        $bindings = [];

        foreach ($conditions as $condition) {
            $placeHolderName = uniqid();
            $conditionsParsed[] = " {$condition['column']} {$condition['operator']} :{$placeHolderName}";
            $bindings[$placeHolderName] = $condition['value'];
        }
        $query .= implode(' AND ', $conditionsParsed);

        return $this->db->execute($query, $bindings);
    }


    /**
     * Begins transaction if supported by db or throw exception
     * @throws Exception
     */
    public function beginTransaction()
    {
        if (!$this->db->supportsTransactions()) {
            $this->db->execute("BEGIN TRANSACTION;", []);
        }
        throw new Exception("Transactions not supported by this RDMS ");

    }

    /**
     * commits transaction if supported by db or throw exception
     * @throws Exception
     */
    public function commitTransaction()
    {
        if (!$this->db->supportsTransactions()) {
            $this->db->execute("COMMIT  TRANSACTION;", []);
        }
        throw new Exception("Transactions not supported by this RDMS");

    }

    /**
     *  Rollbacks transaction if supported by db or throw exception
     * @throws Exception
     */
    public function rollbackTransaction()
    {
        if (!$this->db->supportsTransactions()) {
            $this->db->execute("ROLLBACK   ;", []);
        }
        throw new Exception("Transactions not supported by this RDMS");
    }

    /**
     * Returns select query result if is available in cache
     * @param $tableName
     * @param $selectColumns
     * @param $conditions
     * @return mixed
     */
    public function getCachedQueryResult($tableName, $selectColumns, $conditions)
    {
        $cachedResult = $this->cacheManager->get($tableName, $selectColumns, $conditions);

        return $cachedResult;
    }
}