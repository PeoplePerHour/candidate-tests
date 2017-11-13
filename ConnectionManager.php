<?php
include_once("iDatabase.php");


class ConnectionManager
{

    private $db;

    public function __construct( iDataBase $db)
    {
        $this->db = $db;
    }

    public function select($tableName,$selectColumns, $conditions)
    {
        $parsedColumns =implode(',',$selectColumns);
        $query="SELECT {$parsedColumns}  FROM {$tableName} WHERE ";
        $conditionsParsed = [];
        $bindings=[];

        foreach ($conditions as $condition)
        {
            $placeHolderName= uniqid ();
            $conditionsParsed[] = " {$condition['column']} {$condition['operator']} :{$placeHolderName}";
            $bindings[$placeHolderName] = $condition['value'];
        }
        $query.=  implode(' AND ', $conditionsParsed);

        return $this->db->execute($query,$bindings);
    }


    /**
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
                $placeHolderName= uniqid ();
                $placeHolders[] = ":{$placeHolderName}";
                $bindings[$placeHolderName] = $value;
            }
            $placeHolders = implode(',', $placeHolders);
            $query .= "({$placeHolders})";

        }
       return $this->db->execute($query,$bindings);
    }

    public function update($tableName, $data, $conditions)
    {
        $query="UPDATE {$tableName} SET ";
        $conditionsParsed = [];
        $bindings=[];

        foreach ($data as $column=>$value)
        {
            $placeHolderName= uniqid ();
            $query.="{$column} = : {$placeHolderName} ";
            $bindings[$placeHolderName]=$value;

        }
        foreach ($conditions as $condition)
        {
            $placeHolderName= uniqid ();


            $conditionsParsed[] = " {$condition['column']} {$condition['operator']} :{$placeHolderName}";
            $bindings[$placeHolderName] = $condition['value'];
        }
        $query.= "WHERE ". implode(' AND ', $conditionsParsed);

        return $this->db->execute($query,$bindings);
    }

    public function delete($tableName, $conditions)
    {

        $query="DELETE   FROM {$tableName} WHERE ";
        $conditionsParsed = [];
        $bindings=[];

        foreach ($conditions as $condition)
        {
            $placeHolderName= uniqid ();
            $conditionsParsed[] = " {$condition['column']} {$condition['operator']} :{$placeHolderName}";
            $bindings[$placeHolderName] = $condition['value'];
        }
        $query.=  implode(' AND ', $conditionsParsed);

        return $this->db->execute($query,$bindings);
    }

}