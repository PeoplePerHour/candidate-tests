<?php

namespace PeoplPerHour\Dbal\Exception;

use PeoplePerHour\Dbal\Exception\DatabaseException;

class ColumnNotExistsException extends DatabaseException {
  /**
   * @param string $tableName The table name
   * @param string $columnName The column name
   */
  public function __construct(string $tableName, string $columnName) {
    parent::__construct('Column ' . $columnName . ' does not exist in table ' . $tableName);
  }
}