<?php

namespace PeoplePerHour\Dbal;

use PeoplePerHour\Dbal\Connection\ConnectionConfiguration;
use PeoplePerHour\Dbal\Driver\AbstractDriver;
use PHPUnit\Framework\TestCase;

class ConnectionTest extends TestCase {
  /**
   * @var ConnectionManager
   */
  private $db;

  /**
   * @var AbstractDriver
   */
  private $mockDriver;

  protected function setUp() {
    /** @var AbstractDriver $mockDriver */
    $this->mockDriver = $this->getMockBuilder(AbstractDriver::class)
                             ->disableOriginalConstructor()
                             ->setMockClassName('MockDriver')
                             ->setMethods(['getConfig'])
                             ->getMockForAbstractClass();

    $config = new ConnectionConfiguration('localhost', 'testDb', 'dev', 'dev');
    $this->mockDriver->method('getConfig')
                     ->willReturnReference($config);

    $this->db = new ConnectionManager($this->mockDriver, $config);
  }

  public function testCorrectDriverName(): void {
    $this->assertEquals('MockDriver', $this->db->getDriverName());
  }

  public function testCorrectDatabaseName(): void {
    $this->assertEquals('testDb', $this->db->getDatabaseName());
  }

  public function testCorrectDriverReference(): void {
    $this->assertSame($this->mockDriver, $this->db->getDriver());
  }

  public function testCorrectDatabaseHost(): void {
    $this->assertEquals('localhost', $this->db->getDriver()->getDatabaseHost());
  }
}