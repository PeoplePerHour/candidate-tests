<?php
declare(strict_types = 1);

namespace Models\DatabaseConnection;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

final class DatabaseConnection
{
    const DB_HOST = 'localhost';
    const DB_NAME = 'dbName';
    const DB_USERNAME = 'dbUsername';
    const DB_PASSWORD = 'dbPassword';
    const DB_PORT = '3306';
    const DB_DRIVER = 'pdo_mysql';

    public function connect(): Connection
    {
        $connectionParams = array(
            'dbname' => self::DB_NAME,
            'user' => self::DB_USERNAME,
            'password' => self::DB_PASSWORD,
            'host' => self::DB_HOST,
            'driver' => self::DB_DRIVER,
        );

        return DriverManager::getConnection($connectionParams);
    }
}
