<?php
/**
 * Created by PhpStorm.
 * User: araksia
 * Date: 10/21/2017
 * Time: 5:53 PM
 */
include 'connection.php';
$db = new Connect();
$pdo = new PDO('mysql:host=localhost;dbname=mydb', 'root', '');

$db->setDb($pdo);

//Select
$rows = $db->from('user')
    ->where('id <', 100)
    ->select(array('id', 'name'))
    ->one();


//Insert
$data = array('id' => 123, 'name' => 'bob');
$insert = $db->from('user')
    ->insert($data)
    ->execute();


//Delete
$db->from('user')
    ->where('id', 2)
    ->delete()
    ->execute();

//Update
$data = array('name' => 'bob', 'email' => 'bob@aol.com');
$where = array('id' => 0);

$update = $db->from('user')
    ->where($where)
    ->update($data)
    ->execute();

//SQL injection
$name = "A'Mal";
$result = $db->sql("SELECT * FROM user WHERE name = %s")->execute();

//print_r( $db->quote($name));

//Caching
$db->setCache('./cache');
$key = 'all_users';
$expire = 600;
$users = $db->from('user')
    ->where('id <', 100)
    ->select(array('id', 'name'))
    ->many($key, $expire);

//Pagination
$db->from('user')
    ->limit(10)
    ->offset(20)
    ->select()
    ->sql();

