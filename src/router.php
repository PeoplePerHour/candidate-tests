<?php

    $app->get('/', '\App\Controllers\Users:showUsersList');

    $app->get('/add', '\App\Controllers\Users:addUser');

    $app->get('/edit', '\App\Controllers\Users:editUser');

	$app->get('/clear-cache', '\App\Controllers\Users:clearCache');

	$app->post('/update', '\App\Controllers\Users:updateUser');

	$app->post('/insert', '\App\Controllers\Users:insertUser');

	$app->post('/delete', '\App\Controllers\Users:deleteUser');

