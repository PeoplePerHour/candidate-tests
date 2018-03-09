<?php

namespace PeoplePerHour\Dbal;

use PeoplePerHour\Dbal\Cache\AbstractCache;
use PeoplePerHour\Dbal\Connection\Connection;
use PeoplePerHour\Dbal\Connection\ConnectionConfiguration;
use PeoplePerHour\Dbal\Driver\Driver;
use PeoplePerHour\Dbal\Exception\DatabaseException;
use PeoplePerHour\Dbal\Exception\JoinNotSupportedOnUpdateException;
use PeoplePerHour\Dbal\Exception\JoinsNotSupportedOnDeleteException;
use PeoplePerHour\Dbal\Expression\Expression;
use PeoplePerHour\Dbal\Expression\Join;
use PeoplePerHour\Dbal\Expression\Order;
use PeoplPerHour\Dbal\Exception\ColumnNotExistsException;
use PeoplPerHour\Dbal\Exception\TableNotExistsException;

class ConnectionManager {
  /**
   * @var Driver $driver
   */
  private $driver;

  /**
   * @var Connection $connection
   */
  private $connection;

  /**
   * @var AbstractCache
   */
  private $cache;

  /**
   * @var bool
   */
  private $cacheEnabled = false;

  public function __construct(Driver $driver, ConnectionConfiguration $config, AbstractCache $cache = null, $cacheExpires = 3600) {
    $this->driver = $driver;
    $this->connection = $this->driver->connect($config);
    if (!is_null($cache)) {
      $this->cache = $cache;
      $this->cache->setExpires($cacheExpires);
    }
  }

  /**
   * @param string $table The table name to insert values into
   * @param array $values Array values to insert into table
   * @param array $columns Optional: Specify the columns in the order of insertion
   *
   * @return int The number of rows inserted into the table
   *
   * @throws TableNotExistsException
   * @throws ColumnNotExistsException
   * @throws \InvalidArgumentException
   */
  public function insert(string $table, array $values, array $columns = null): int {
    $this->checkTablesExist([$table]);
    $this->checkColumnsExist($table, $columns);
    if ($columns != null) {
      if (($colCount = count($columns)) != ($valCount = count($values))) {
        throw new \InvalidArgumentException("You have provided $valCount number of values but specified $colCount number of columns");
      }
    }
    foreach ($values as $value) {
      $this->sanitizeInput($value);
    }

    return $this->connection->insert($table, $values, $columns)->execute();
  }

  /**
   * @param string $table The table name to update
   * @param array $values Array of values to update columns with
   * @param array $columns the column names to update
   * @param Expression|null $where Expression to use as WHERE predicate
   * @param Join[]|null $joins Array of Join objects
   *
   * @return int The number of rows updated
   *
   * @throws JoinNotSupportedOnUpdateException If the database does not support joins in update operations
   * @throws TableNotExistsException
   * @throws ColumnNotExistsException
   * @throws \InvalidArgumentException
   * @throws DatabaseException
   */
  public function update(string $table, array $values, array $columns, Expression $where = null, array $joins = null): int {
    $this->checkTablesExist([$table]);
    $this->checkColumnsExist($table, $columns);
    if ($columns != null) {
      if (($colCount = count($columns)) != ($valCount = count($values))) {
        throw new \InvalidArgumentException("You have provided $valCount number of values but specified $colCount number of columns");
      }
    }
    foreach ($values as $value) {
      $this->sanitizeInput($value);
    }
    if ($joins) {
      $this->checkJoins($joins);
    }
    return $this->connection->update($table, $values, $columns, $where, $joins)->execute();
  }

  /**
   * @param string $table The table name to update
   * @param Expression|null $where Expression to use as WHERE predicate
   * @param Join[]|null $joins Array of Join objects (if needed)
   *
   * @return int The number of rows deleted
   *
   * @throws DatabaseException Thrown by the Connection object
   * @throws JoinsNotSupportedOnDeleteException If the database does not support joins in delete operations
   */
  public function delete(string $table, Expression $where = null, array $joins = null): int {
    $this->checkTablesExist([$table]);
    if ($joins) {
      $this->checkJoins($joins);
    }
    return $this->connection->delete($table, $where, $joins)->execute();
  }

  /**
   * @param string[] $selections The fields to select
   * @param string|string[] $from The table(s) from which data will be selected or aggregated
   * @param Expression|null $where Expression to use as WHERE predicate
   * @param Join[]|null $joins Array of Join objects (if needed)
   * @param Order[]|null $orders Array of Order objects (if needed)
   * @param int|null $firstResult Pagination offset
   * @param int|null $maxResults Pagination limit
   *
   * @return array The rows returned
   *
   * @throws TableNotExistsException
   */
  public function select(
    array $selections,
    $from,
    Expression $where = null,
    array $joins = null,
    array $orders = null,
    int $firstResult = null,
    int $maxResults = null
  ): array {
    $this->checkTablesExist(is_array($from) ? $from : [$from]);
    $this->checkFrom($from);
    $this->checkJoins($joins);
    $this->checkOrders($orders);

    $query = $this->connection->select($selections, $from, $where, $joins, $orders, $firstResult, $maxResults);
    $hash = $query->getQueryHash();
    if ($this->cacheEnabled && !is_null($this->cache)) {
      if ($this->cache->has($hash) && !$this->cache->hasExpired($hash)) {
        $result = $this->cache->get($hash);
      } else {
        $result = $query->execute();
        $this->cache->set($hash, $result);
      }
    } else {
      $result = $query->execute();
    }

    return $result;
  }

  /**
   * @return Driver
   */
  public function getDriver(): Driver {
    return $this->driver;
  }

  /**
   * @param Driver $driver
   */
  public function setDriver(Driver $driver): void {
    $this->driver = $driver;
  }

  /**
   * @return AbstractCache
   */
  public function getCache(): AbstractCache {
    return $this->cache;
  }

  /**
   * @param AbstractCache $cache
   */
  public function setCache(AbstractCache $cache): void {
    $this->cache = $cache;
  }

  /**
   * @return bool
   */
  public function isCacheEnabled(): bool {
    return $this->cacheEnabled;
  }

  /**
   * @param bool $cacheEnabled
   */
  public function setCacheEnabled(bool $cacheEnabled): void {
    $this->cacheEnabled = $cacheEnabled;
  }

  public function getDriverName(): string {
    return $this->driver->getName();
  }

  public function getDatabaseName(): string {
    return $this->driver->getDatabase($this->connection);
  }

  /**
   * @param array $tables Array of table names
   *
   * @return bool
   *
   * @throws TableNotExistsException
   */
  private function checkTablesExist(array $tables): bool {
    foreach ($tables as $table) {
      if (!is_string($table)) {
        throw new \InvalidArgumentException('`tables` parameter must be an array of strings');
      }
      if (!$this->connection->tableExists($table)) {
        throw new TableNotExistsException($table);
      }
    }

    return true;
  }

  /**
   * @param string $table The table name
   * @param array $columns Array of column names
   *
   * @return bool
   *
   * @throws ColumnNotExistsException
   */
  private function checkColumnsExist(string $table, array $columns): bool {
    foreach ($columns as $column) {
      if (!is_string($column)) {
        throw new \InvalidArgumentException('`columns` parameter must be an array of strings');
      }
      if (!$this->connection->columnExists($table, $column)) {
        throw new ColumnNotExistsException($table, $column);
      }
    }

    return true;
  }

  private function checkFrom($from): bool {
    if (is_null($from) || !is_string($from) && !is_array($from)) {
      throw new \InvalidArgumentException("Parameter `from` is required and must be a string or an array of strings");
    }
    foreach ($from as $fromItem) {
      if (!is_string($fromItem)) {
        throw new \InvalidArgumentException("Parameter `from` must be a string or an array of strings");
      }
    }

    return true;
  }

  private function checkJoins($joins): bool {
    if (is_null($joins)) {
      return true;
    }

    $msg = "The `joins` parameter must be an array of Join objects";

    if (!is_array($joins)) {
      throw new \InvalidArgumentException($msg);
    }

    foreach ($joins as $join) {
      if (!($join instanceof Join)) {
        throw new \InvalidArgumentException($msg);
      }
    }

    return true;
  }

  private function checkOrders($orders): bool {
    if (is_null($orders)) {
      return true;
    }

    $msg = "The `orders` parameter must be an array of Order objects";

    if (!is_array($orders)) {
      throw new \InvalidArgumentException($msg);
    }

    foreach ($orders as $order) {
      if (!($order instanceof Order)) {
        throw new \InvalidArgumentException($msg);
      }
    }

    return true;
  }

  private function sanitizeInput(mixed $value): mixed {
    return $this->driver->sanitizeInput($value);
  }
}