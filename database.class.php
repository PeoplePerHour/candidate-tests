<?php 
require_once("./paginator.class.php");
/*
 * Database Class
 * This class is used for database related (connect, insert, update, and delete) operations
 * with PHP Data Objects (PDO)
 */

class Database{

    /* 
     * The variables have been declared as private. This
     * means that they will only be available with the 
     * Database class
     */

    private $db_driver;
    private $db_host;
    private $db_user;
    private $db_pass;
    private $db_name;
    private $conn; // Hold the connection if it is active

    public function __construct($db_driver, $db_name, $db_host = "localhost", $db_user = "root", $db_pass = "") {
        // Setting values to local variables
        $this->db_driver = $db_driver;
        $this->db_host = $db_host;
        $this->db_user = $db_user;
        $this->db_pass = $db_pass;
        $this->db_name = $db_name;

        // Connect to the database
        try {
            $this->conn = new PDO($this->db_driver.":host=".$this->db_host.";dbname=".$this->db_name,$this->db_user,$this->db_pass);
            $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die($e->getMessage());
        }

    }

    /*
     * Function to validate data
     * @param string the data to validate
     */
    private function dataVal($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    /*
     * Function to bind values to prepared sql queries. This implementation helps with SQL Injection
     * @param array the table with the data to bind in the statment
     * @param string prepared sql query statement
     */
    protected function bind($table,$sql){
       try {
            $query = $this->conn->prepare($sql);
            foreach($table as $key=>$val){
                // Call dataVal function in order to validate data for SQL Injection
                $query->bindValue(':'.$key,$this->dataVal($val));
            }
            // Return the prepared statment
            return $query;
        } catch (Exception $e) {
            print_r($e->getMessage());
            throw new Exception($e->getMessage());
        }
        
    }

    /*
     * Function that executes and commits SQL queries with error handling.
     * @param string prepared sql query statement with nameholders filled with values.
     */
    protected function execTransaction($query){
        try {                
                $this->conn->beginTransaction();
                $transaction_exec = $query->execute();
                $this->conn->commit();
                return $transaction_exec;
            } catch (Exception $e) {
                $this->conn->rollBack();
                print_r($e->getMessage());
                return false;
            }
        
    }


    /*
     * Function that closes the connection with the Database.
     */
    public function disconnect(){
        // If there is a connection to the database
        if($this->conn){
            // Close it
            $this->conn = null;
            return true;
        }
        return false;
    }


    /*
     * Function to insert item into the database
     * @param string name of the table
     * @param array the data for inserting into the table
     */
    public function create($table,$data){
        if(!empty($data) && is_array($data)){
            // Parsing array data in order to create the prepared statment with nameholders for each field
            $columns = '';
            $values  = '';

            $columns = implode(',', array_keys($data));
            $values = ":".implode(',:', array_keys($data));
            
            // Complete SQL query
            $sql = "INSERT INTO ".$table." (".$columns.") VALUES (".$values.")";
            
            // Call bind function in order to create the prepared statment and bind values to it
            $query = $this->bind($data,$sql);
            // Call execTransaction function in order to execute the prepared statment and commit the changes
            $insert = $this->execTransaction($query);

            return $insert?$this->conn->lastInsertId():false;
        }
        else{
            return false;
        }
    }

    /*
     * Function to SELECT from the database
     * @param string name of the table
     * @param array select, where, order_by, limit and return_type conditions
     */
    public function read($table,$conditions = array(),$page = 1){

        $sql = 'SELECT ';
        $sql .= array_key_exists("select",$conditions)?$conditions['select']:'*';
        $sql .= ' FROM '.$table;

        if(array_key_exists("join",$conditions)){
            $sql .= ' JOIN ';
            $i = 0;
            foreach($conditions['join'] as $key => $value){
                $preStr = ($i > 0)?' JOIN ':'';
                $sql .= $preStr.$key." ON ".$value;
                $i++;
            }
        }

        if(array_key_exists("where",$conditions)){
            $sql .= ' WHERE ';
            $i = 0;
            foreach($conditions['where'] as $key => $value){
                $preStr = ($i > 0)?' AND ':'';
                $sql .= $preStr."`".$key."` = :".$key;
                $i++;
            }
        }
        
        if(array_key_exists("order_by",$conditions)){
            $sql .= ' ORDER BY '.$conditions['order_by']; 
        }    

        if (array_key_exists("pagination",$conditions)) {
            $sql .= ' LIMIT :min,:max';
            // Call bind function in order to create the prepared statment and bind values to it
            $query = $this->bind($conditions['where'],$sql);
            $pg = new Paginator($query);
        
            $query=$pg->paginatedQuery($conditions['pagination'],$page);
        }
        else{
            if(array_key_exists("start",$conditions) && array_key_exists("limit",$conditions)){
                $sql .= ' LIMIT '.$conditions['start'].','.$conditions['limit']; 
            }
            elseif(!array_key_exists("start",$conditions) && array_key_exists("limit",$conditions)){
                $sql .= ' LIMIT '.$conditions['limit']; 
            }
            $query = $this->bind($conditions['where'],$sql);
        }

        // Call execTransaction function in order to execute the prepared statment and commit the changes
        $select = $this->execTransaction($query);

        if(array_key_exists("return_type",$conditions) && $conditions['return_type'] != 'all'){
            switch($conditions['return_type']){
                case 'count':
                    $data = $query->rowCount();
                    break;
                case 'single':
                    $data = $query->fetch(PDO::FETCH_ASSOC);
                    break;
                default:
                    $data = '';
            }
        }
        else{
            if($query->rowCount() > 0){
                $data = $query->fetchAll();
            }
        }

        return !empty($data)?$data:false;
    }

    /*
     * Update data into the database
     * @param string name of the table
     * @param array the data for updating into the table
     * @param array where condition on updating data
     */
    public function update($table,$data,$conditions = array()){
        if(!empty($data) && is_array($data)){
            $colSet = '';
            $where = '';
            $i = 0;

            foreach($data as $key=>$val){
                $preStr = ($i > 0)?', ':'';
                $colSet .= $preStr."`".$key."` = :".$key;
                $i++;
            }
            if(!empty($conditions)&& is_array($conditions)){
                $where .= ' WHERE ';
                $i = 0;
                foreach($conditions as $key => $value){
                    $preStr = ($i > 0)?' AND ':'';
                    $where .= $preStr."`".$key."` = :".$key;
                    $i++;
                }
            }

            // Complete SQL query
            $sql = "UPDATE ".$table." SET ".$colSet.$where;

            // Call bind function in order to create the prepared statment and bind values to it
            $query=$this->bind(array_merge($data, $conditions),$sql);
            // Call execTransaction function in order to execute the prepared statment and commit the changes
            $update=$this->execTransaction($query);

            return $update?$query->rowCount():false;
        }
        else{
            return false;
        }
    }

    /*
     * Delete data from the database
     * @param string name of the table
     * @param array where condition on deleting data
     */
    public function delete($table,$conditions = array()){
        $where = '';
        if(!empty($conditions) && is_array($conditions)){
            $where .= ' WHERE ';
            $i = 0;
            foreach($conditions as $key => $value){
                $preStr = ($i > 0)?' AND ':'';
                $where .= $preStr."`".$key."` = :".$key;
                $i++;
            }
        }

        // Complete SQL query
        $sql = "DELETE FROM ".$table.$where;
        
        // Call bind function in order to create the prepared statment and bind values to it
        $query=$this->bind($conditions,$sql);
        // Call execTransaction function in order to execute the prepared statment and commit the changes
        $delete=$this->execTransaction($query);

        return $delete?$delete:false;
    }

}
    

?>