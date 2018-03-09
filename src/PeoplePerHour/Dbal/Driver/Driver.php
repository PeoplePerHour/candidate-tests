<?php

namespace PeoplePerHour\Dbal\Driver;

use PeoplePerHour\Dbal\Connection\Connection;
use PeoplePerHour\Dbal\Connection\ConnectionConfiguration;

interface Driver {
  /**
   * @param ConnectionConfiguration $config The configuration required to establish connection to the database
   *
   * @return Connection The database connection
   */
  public function connect(ConnectionConfiguration $config): Connection;

  /**
   * Gets the name of the driver.
   *
   * @return string The name of the driver.
   */
  public function getName();

  /**
   * Gets the name of the database connected to for this driver.
   *
   * @param Connection $conn
   *
   * @return string The name of the database.
   */
  public function getDatabase(Connection $conn);

  /**
   * @param mixed $value The user input value
   *
   * @return mixed The sanitized value
   */
  function sanitizeInput(mixed $value): mixed;
}