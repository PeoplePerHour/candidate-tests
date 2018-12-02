<?php

namespace Manager\Model;

use PDO;

class Model {

    private $conn;
    private $statement;
    private $selectables = array();
    private $table;
    private $whereClause;
    private $limit;
    private $offset;
    private $orderField;
    private $orderType;

    public function __construct($connection)
    {
        $this->conn = $connection;
    }

    /**
     * Insert Data To Table
     * @param $table
     * @param array $data
     */
    public function insert($table, array $data)
    {
        $colNames = implode(',', array_keys($data));
        $colValues = ':' . implode(', :', array_keys($data));

        $sql = "INSERT INTO $table ($colNames) VALUES ($colValues)";

        $this->prepare($sql);

        foreach ($data as $key => $value) {
            $this->bind(":$key", $value);
        }

        return $this->execute();
    }

    /**
     * Select
     * @return $this
     */
    public function select() {
        $this->selectables = func_get_args();
        return $this;
    }

    /**
     * @param $table
     * @return $this
     */
    public function from($table) {
        $this->table = $table;
        return $this;
    }

    /**
     * @param $where
     * @return $this
     */
    public function where($where) {
        $this->whereClause = $where;
        return $this;
    }

    /**
     * @param $limit
     * @return $this
     */
    public function limit($limit) {
        $this->limit = $limit;
        return $this;
    }

    /**
     * @param int $skip
     * @param int $take
     * @return $this
     */
    public function paginate($skip = 0, $take = 10) {
        $this->limit = $take;
        $this->offset = $skip;
        return $this;
    }

    public function orderBy($field, $type = 'desc')
    {
        $this->orderField = $field;
        $this->orderType = $type;
        return $this;
    }

    /**
     * Fetch Results
     * @return mixed
     */
    public function results()
    {
        $query = $this->generateQuery();

        $this->validateChain();

        $this->prepare($query);

        $this->execute();

        $results = $this->getAll();

        return $results;
    }

    /**
     * @throws \Exception
     */
    private function validateChain()
    {
        if(empty($this->table)){
            throw new \Exception('Provide a DB table to fetch data from with from() method');
        }
    }


        /**
     * Update Table
     * @param $table
     * @param array $data
     * @param string $where
     */
    public function update($table, array $data, $where = '')
    {
        $updateFields = null;

        foreach ($data as $key => $value) {
            $updateFields .="$key = :$key,";
        }

        $updateFields = rtrim($updateFields, ',');

        $sql = "UPDATE $table SET $updateFields " . ($where ? 'WHERE ' . $where : '');

        $this->prepare($sql);

        foreach ($data as $key => $value){
            $this->bind(":$key", $value);
        }

        return $this->execute();
    }

    /**
     * Delete Specific Row(s)
     * @param $table
     * @param $where
     * @return mixed
     * @throws \Exception
     */
    public function delete($table, $where){
        if(empty($where) || $where == '')
        {
           throw new \Exception('Provide where clause or use deleteAll() method to delete all rows from table.');
        }
        $sql = "DELETE FROM $table WHERE $where";
        $this->prepare($sql);
        return $this->execute();
    }

    /**
     * Delete Entire Table Rows
     * @param $table
     * @return mixed
     */
    public function deleteAll($table)
    {
        $sql = "DELETE FROM $table";
        $this->prepare($sql);
        return $this->execute();
    }

    /**
     * Start Transaction
     */
    public function startTRX()
    {
        $this->conn->beginTransaction();
    }

    /**
     * Commit Transaction
     */
    public function commitTRX()
    {
        $this->conn->commit();
    }

    /**
     * Rollback Transaction
     */
    public function rollBackTRX()
    {
        $this->conn->rollBack();
    }

    /**
     * Fetch All Records
     * @param bool $returnAssoc
     * @return mixed
     */
    private function getAll($returnAssoc = true)
    {
        $results = ($returnAssoc) ? $this->statement->fetchAll(PDO::FETCH_ASSOC) : $this->statement->fetchAll(PDO::FETCH_OBJ);
        return $results;
    }

    /**
     * Execute Statement
     */
    private function execute()
    {
        return $this->statement->execute();
    }

    /**
     * Compile Statement
     * @param $sql
     */
    private function prepare($sql)
    {
        $this->statement = $this->conn->prepare($sql);
    }

    /**
     * Bind Values
     * @param $param
     * @param $value
     * @param null $type
     */
    public function bind($param, $value, $type=null)
    {
        if(is_null($type)){
            switch(true){
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }

        $this->statement->bindValue($param, $value, $type);
    }

    /**
     * Generate Query
     * @return string
     */
    private function generateQuery()
    {
        $sql[] = "select";

        if (empty($this->selectables)) {
            $sql[] = "*";
        }
        else {
            $sql[] = join(', ', $this->selectables);
        }

        $sql[] = "from";
        $sql[] = $this->table;

        if (!empty($this->whereClause)) {
            $sql[] = "where";
            $sql[] = $this->whereClause;
        }

        if (!empty($this->orderField) && !empty($this->orderType)) {
            $sql[] = "order by";
            $sql[] = $this->orderField;
            $sql[] = $this->orderType;
        }

        if (!empty($this->limit) && empty($this->offset)) {
            $sql[] = "limit";
            $sql[] = $this->limit;
        }

        if (!empty($this->limit) && !empty($this->offset)) {
            $sql[] = "offset";
            $sql[] = $this->offset;
            $sql[] = "limit";
            $sql[] = $this->limit;
        }

        $sql = join(' ', $sql);

        return $sql;
    }

}