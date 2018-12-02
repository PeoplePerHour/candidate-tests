<?php


use Models\DatabaseConnection\DatabaseConnection;

try {
    $pdo = (new DatabaseConnection())->connect();


} catch(PDOException $exception) {
    die("Connection to database failed! Message:({$exception->getMessage()}");
}
