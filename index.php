<?php

/**
 * File to perform testing on the Connection Manager class
 */

use johnchristofis\dbcmanager\ConnectionManager;

require_once 'config.php';


#$db = ConnectionManager::connect('mysql','localhost','root','root','dummydb',3306);

#$db->delete('user',[]);


/*try {
    $db->beginTransaction();

    // Insert records
    $db->insert('user',['firstname'=>'nikos','lastname'=>'korompos','username'=>'nkorompos','password'=>'pass7788']);
    $db->insert('user',['firstname'=>'nikos','lastname'=>'koukos','username'=>'nkoukos','password'=>'pass8899']);
    $db->insert('user',['firstname'=>'john','lastname'=>'doe','username'=>'nkoukos','password'=>'pass123']);
    $db->insert('user',['firstname'=>'jane','lastname'=>'doe','username'=>'janedoe','password'=>'pass345']);
    $db->delete('user',['usernames'=>'johndoe']);
    $db->delete('user',['username'=>'janedoe']);

    // Assuming the both inserts work, we get to the following line.
    $db->commitTransaction();

} catch(PDOException $e) {
    $db->rollBackTransaction();
}*/


#$db->close();

