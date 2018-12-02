<!-- Avoid Request For Favicon (Request Twice)-->
<html>
<head>
<link href="data:image/x-icon;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQEAYAAABPYyMiAAAABmJLR0T///////8JWPfcAAAACXBIWXMAAABIAAAASABGyWs+AAAAF0lEQVRIx2NgGAWjYBSMglEwCkbBSAcACBAAAeaR9cIAAAAASUVORK5CYII=" rel="icon" type="image/x-icon" />
</head>
</html>

<?php

require_once '../src/boot/boot.php';

use Manager\Store\ConnectionManager;
use Manager\Driver\Config;
use Manager\Model\Model;

// Create Connection Manager
$postgres = new ConnectionManager(new Config('postgres'));

// Connect To Manager
$connection = $postgres->connect();

// Initialize New Model
$model = new Model($connection);

// Basic CRUD - More On Tests
$users_select = $model->select()->from('users')->results();
$user_insert = $model->insert('users', ['firstname' => 'Hello', 'lastname' => 'World', 'email' => 'hello@world.com']);
$user_update = $model->update('users', ['firstname' => 'Goddbye'], 'user_id = 120');
$user_dlt = $model->delete('users', 'user_id = 120');

echo '================== SELECT DATA ================== <br>';
dnd($users_select);
echo '================== INSERT DATA ================== <br>';
dnd($user_insert);
echo '================== UPDATE DATA ================== <br>';
dnd($user_update);
echo '================== DELETE DATA ================== <br>';
dnd($user_dlt);
echo '================== CREATED BY NAVISOT ==================';

