<?php

namespace PeoplPerHour\Dbal\PeoplePerHour\Dbal\Exception;

use PeoplePerHour\Dbal\Exception\DatabaseException;

class TableNotExistsException extends DatabaseException {
  /**
   * @param string $tableName The table name
   */
  public function __construct(string $tableName) {
    parent::__construct('Table ' . $tableName . ' does not exist');
  }
}