<?php

use PHPUnit\Framework\TestCase;
use Manager\Store\ConnectionManager;
use Manager\Driver\Config;
use Manager\Model\Model;

class PDOTest extends TestCase {


    public function test_connection_manager()
    {
        $manager = new ConnectionManager(new Config('postgres'));
        $this->assertEquals($manager, new ConnectionManager(new Config('postgres')));
    }

    public function test_connection()
    {
        $manager = new ConnectionManager(new Config('postgres'));
        $connection = $manager->connect();
        $mock = $this->createPartialMock(ConnectionManager::class, ['connect']);
        $mock->method('connect')->willReturn($connection);
        $this->assertEquals($connection, $mock->connect());
    }

}