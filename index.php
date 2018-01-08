<?php
/**
 * testing file
 * Created by PhpStorm.
 * User: gkalligeros
 * Date: 11/13/2017
 * Time: 9:43 PM
 */
include_once("ConnectionManager.php");
include_once("DummyDataBase.php");
include_once("CacheManager.php");
include_once("FileCacheDriver.php");
include_once("iCacheDriver.php");

$db = new DummyDataBase();
$fileCache= new FileCacheDriver();
$cacheManager = new CacheManager($fileCache);
$cm = new ConnectionManager($db,$cacheManager);
echo json_encode($cm->select('test',["12"],

    [["column" => "namee", "operator" => "=", "value" => "jimiu"]]
)
);