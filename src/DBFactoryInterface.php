<?php

namespace CT\DBConnectionManager;

use CT\DBConnectionManager\Config\DBConfiguration;
use PDO;

/**
 * Interface DBFactoryInterface
 * @package CT\DBConnectionManager
 */
interface DBFactoryInterface {

    public static function createDBConnection(DBConfiguration $configuration): PDO;
}