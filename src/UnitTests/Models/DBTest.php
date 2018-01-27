<?php
    declare(strict_types=1);

    namespace App\UnitTests\Models;

    use PHPUnit\Framework\TestCase;

    class DBTest extends TestCase
    {
        protected $_db;

        public function __construct($name = null, array $data = [], $dataName = '')
        {
            parent::__construct($name, $data, $dataName);

            $pdo = new \PDO('mysql:host=localhost;dbname=PPHDemo;charset=utf8mb4;connect_timeout=15', 'root', 'AnteGeiaReMounia');
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);

            $this->_db = $pdo;

            defined('ENABLE_CACHE')  || define('ENABLE_CACHE', false);
        }
    }