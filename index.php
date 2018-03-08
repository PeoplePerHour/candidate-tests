<?php


use johnchristofis\dbcmanager\MysqlDriver;

require_once 'config.php';

$db = new MysqlDriver('localhost','root','root','dummydb',3306);

//$select = $db->select('user',['username','password'],['lastname'=>'doe'],['orderBy'=>'id','order'=>'asc','limit'=>1,'offset'=>1]);

//$insert = $db->insert('user',['firstname'=>'nikos','lastnames'=>'korompos','username'=>'nkorompos','password'=>'pass888']);

