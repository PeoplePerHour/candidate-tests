<?php

use johnchristofis\dbcmanager\ConnectionManager;

require_once 'config.php';


$db = ConnectionManager::connect('mysql','localhost','root','root','dummydb',3306);

/*

try {
    $db->beginTransaction();

    // Insert records
    $db->insert('user',['firstname'=>'nikos','lastname'=>'korompos','username'=>'nkorompos','password'=>'pass7788']);
    $db->insert('user',['firstname'=>'nikos','lastname'=>'koukos','username'=>'nkoukos','password'=>'pass8899']);

    // Assuming the both inserts work, we get to the following line.
    $db->commitTransaction();

} catch(PDOException $e) {
    $db->rollBackTransaction();
}


$db->close();

*/