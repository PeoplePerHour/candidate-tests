<?php

namespace CT\DBConnectionManager;

use CT\DBConnectionManager\Config\DBConfiguration;
use PDO;

/**
 * Class DBFactory
 * @package CT\DBConnectionManager
 */
class DBFactory implements DBFactoryInterface {

    public static function createDBConnection(DBConfiguration $configuration): PDO {

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_PERSISTENT => $configuration->isPersistent()
        ];

        $dbConnection = new PDO($configuration->getDsn(), $configuration->getUsername(),
            $configuration->getPassword(), $options);

        return $dbConnection;
    }
}