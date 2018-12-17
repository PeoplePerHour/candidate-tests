<?php

namespace CT\DBConnectionManager;

use PDO;
use PDOStatement;

/**
 * Class AbstractDatabase
 * @package CT\DBConnectionManager
 */
abstract class AbstractDatabase {

    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * @return PDO
     */
    public function getPdo(): PDO {
        return $this->pdo;
    }

    /**
     * @param PDO $pdo
     */
    public function setPdo(PDO $pdo): void {
        $this->pdo = $pdo;
    }

    public abstract function isConnected(): bool;
    public abstract function executeQuery($query): PDOStatement;
    public abstract function commit();
    public abstract function rollback();

}