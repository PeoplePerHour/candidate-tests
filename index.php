<?php

	require('databaseV1.php');

	$dbm = new Database('mysql', 'utf8mb4', '127.0.0.1', 'pph', 'root', '');

	$table = 'users';
	
	// INSERT ex1
	$insert = [
		['name' =>'test', 'status' =>'5'],
		['name' =>'test222', 'status' =>'6'],
		['name' =>'test33333', 'status' =>'2'],
	];

	// INSERT ex2
	// $insert = [
	// 	'name' =>'manolis', 'status' =>'123'
	// ];

	// UPDATE
	$update = [
		'name' => 'aaaa',
		'status' => '1234556',
		// 'status' => [23, 32],
	];

	// WHERE
	$where = [
		['id', 'eq', 44, 'or'],
		['id', 'lt', '47', 'or'],
		// ['name', 'null'],
		// ['name', 'notnull', '', ''],
		// ['name', 'like', '%%', 'or'],
		// ['id', 'in', [26, 27, 28], 'or'],
	];


	// CRUD
	// $dbm->insert($table, $insert);
	// $dbm->update($table, $update, $where);
	$dbm->select([], $table, $where);
	// $dbm->delete($table, $where);