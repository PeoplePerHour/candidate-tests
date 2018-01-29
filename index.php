<?php

require_once 'autoloader.php';

/** @noinspection PhpUnhandledExceptionInspection */
$db     = new \PPH\DbManager();

$all    = $db->select()->from('authors')->where([['first_name', '=', 'Hiram']])->all();

$all2   = $db->select()->from('authors')->limit(5)->offset(10)->all();

$one    = $db->select(['first_name', 'last_name'])->from('authors')->one();

$insert = $db->insert([
    'first_name' => 'Kostas',
    'last_name'  => 'Rentzikas',
    'email'      => 'kostas.rentzikas@gmail.com',
    'birthdate'  => '1985-08-25',
    'added'      => '2018-01-30 06:17:56',
])->into('authors')->save();

/**
 * Update
 */
$update = $db->update(['email' => 'kostas.rentzikas@gmail.com'])
             ->table('authors')
             ->where([
                 ['last_name', '=', 'Rentzikas'],
             ])
             ->update();

/**
 * Delete Statement
 */
$delete = $db->delete()
             ->from('authors')
             ->where([
                 ['first_name', '=', 'Kostas'],
                 ['last_name', '=', 'Rentzikas',],
             ]);


$findOne = $db->findOne(1, 'authors');

$findAll = $db->findAll([['first_name', '=', 'Hiram']], 'authors');
