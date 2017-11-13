<?php
/**
 * Created by PhpStorm.
 * User: gkalligeros
 * Date: 11/13/2017
 * Time: 9:43 PM
 */
include_once("ConnectionManager.php");
include_once("DummyDataBase.php");

$db = new DummyDataBase();
$cm = new ConnectionManager($db);
echo json_encode($cm->delete('test',

    [["column" => "name", "operator" => "=", "value" => "jimi"]]
)
);