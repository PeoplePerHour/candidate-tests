<?php

namespace PeoplePerHour\Dbal\Driver;

use PeoplePerHour\Dbal\Connection\Connection;
use PeoplePerHour\Dbal\Connection\ConnectionConfiguration;

/**
 * Class AbstractDriver
 *
 * Base class that should be extended by platform specific driver classes
 *
 * @package PeoplePerHour\Dbal\Driver
 */
abstract class AbstractDriver implements Driver {

  /** @var ConnectionConfiguration */
  private $config;

  public function connect(ConnectionConfiguration $config): Connection {
    $this->config = $config;
    return $this->doConnect();
  }

  public function getName() {
    return get_class($this);
  }

  public function getDatabase(Connection $conn) {
    return $this->config->getDatabase();
  }

  public function getDatabaseHost(): string {
    return $this->config->getHost();
  }

  public abstract function doConnect(): Connection;

  /**
   * @return ConnectionConfiguration
   */
  public function getConfig(): ConnectionConfiguration {
    return $this->config;
  }
}