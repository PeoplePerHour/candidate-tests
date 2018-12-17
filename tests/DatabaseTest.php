<?php

namespace CT\DBConnectionManager\Tests;

use CT\DBConnectionManager\Config\DBConfiguration;
use CT\DBConnectionManager\Database;
use CT\DBConnectionManager\DBFactory;
use PHPUnit\Framework\TestCase;

class DatabaseTest extends TestCase {

    public $db;
    private $table;

    protected function setUp() {

        $this->table = "testTable";

        // Make the connection (mysql)
        $dsn = "mysql:dbname=testdb;host=127.0.0.1";
        $configuration = new DBConfiguration($dsn, "dummy", "dummy");

        $pdo = DBFactory::createDBConnection($configuration);
        $this->db = new Database($pdo);

        // Then initialize table: testTable
        $this->prepareTestTable();
    }

    protected function tearDown() {
        parent::tearDown(); // TODO: Change the autogenerated stub
    }

    public function testTable() {
        $this->assertEquals("testTable", $this->table, "Test should be only run against 'testTable'");
    }

    public function testIsConnected() {
        $this->assertTrue($this->db->isConnected(), "Database is not connected");
    }

    protected function prepareTestTable() {

        // Drop table if exists in database
        $dropTableQuery = "DROP TABLE IF EXISTS `{$this->table}`;";
        $this->db->executeQuery($dropTableQuery);

        // Then create the table in database
        $createTableQuery = "CREATE TABLE `{$this->table}` (
          `id` int(10) NOT NULL AUTO_INCREMENT,
          `name` varchar(255) NOT NULL,
          PRIMARY KEY (`id`)
        );";
        $this->db->executeQuery($createTableQuery);
    }

}