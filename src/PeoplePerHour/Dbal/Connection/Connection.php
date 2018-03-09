<?php

namespace PeoplePerHour\Dbal\Connection;

use PeoplePerHour\Dbal\Exception\DatabaseException;
use PeoplePerHour\Dbal\Exception\JoinNotSupportedOnUpdateException;
use PeoplePerHour\Dbal\Exception\JoinsNotSupportedOnDeleteException;
use PeoplePerHour\Dbal\Exception\NoPendingTransactionException;
use PeoplePerHour\Dbal\Exception\TransactionsNotSupportedException;
use PeoplePerHour\Dbal\Expression\Expression;
use PeoplePerHour\Dbal\Expression\Join;
use PeoplePerHour\Dbal\Expression\Order;

interface Connection {

  /**
   * @param string $query The query string to prepare. This must take care
   * of sanitizing the string according to specific platform requirements.
   *
   * @return PreparedStatement
   */
  function prepareStatement(string $query): PreparedStatement;

  /**
   * Execute a prepared statement
   *
   * @param PreparedStatement $statement The statement to execute
   * @param array $params Parameters to bind to the statement
   *
   * @return mixed Depends on operation
   */
  function executeStatement(PreparedStatement $statement, array $params): mixed;

  /**
   * @return bool True if this database platform/version supports transactions, false otherwise
   */
  function supportsTransactions(): bool;

  /**
   * Starts a database transaction
   *
   * @throws TransactionsNotSupportedException If database does not support transactions
   *
   * @see: Connection::supportsTransactions()
   */
  function beginTransaction(): void;

  /**
   * Commits the current transaction (if any)
   *
   * @return bool TRUE on success, FALSE on failure
   *
   * @throws NoPendingTransactionException If there is no pending transaction in this connection to commit
   */
  function commit(): bool;

  /**
   * Rollback the current transaction (if any)
   *
   * @return bool TRUE on success, FALSE on failure
   *
   * @throws NoPendingTransactionException If there is no pending transaction in this connection to rollback
   */
  function rollback(): bool;

  /**
   * Execute an insert operation
   *
   * @param string $table The table name to insert values into
   * @param array $values Array of values to insert into table
   * @param array|null $columns The ordered column names to insert values into
   *
   * @return int The number of rows inserted
   */
  function insert(string $table, array $values, array $columns = null): int;

  /**
   * Execute an update operation
   *
   * @param string $table The table name to update
   * @param array $values Array of values to update columns with
   * @param array $columns the column names to update
   * @param Expression|null $where Expression to use as WHERE predicate
   * @param Join[]|null $joins Array of Join objects
   *
   * @return int The number of rows updated
   *
   * @see Expression
   * @see Join
   *
   * @throws DatabaseException
   * @throws JoinNotSupportedOnUpdateException If the database does not support joins in update operations
   */
  function update(string $table, array $values, array $columns, Expression $where = null, array $joins = null): int;

  /**
   * Execute a delete operation
   *
   * @param string $table The table name to update
   * @param Expression|null $criteria Expression to use as WHERE predicate
   * @param Join[]|null $joins Array of Join objects
   *
   * @see Expression
   * @see Join
   *
   * @return int The number of rows deleted
   *
   * @throws DatabaseException
   * @throws JoinsNotSupportedOnDeleteException
   */
  function delete(string $table, Expression $criteria = null, array $joins = null): int;

  /**
   * Fetch rows from database
   *
   * @param array $selections The fields to select
   * @param string|string[] $from The table(s) from which data will be selected (Some dbs support multiple FROM tables)
   * @param Expression|null $criteria
   * @param Join[]|null $joins
   * @param Order[]|null $orders
   *
   * @return array
   *
   */
  function select(array $selections, $from, Expression $criteria = null, array $joins = null, array $orders = null): array;

  /**
   * @param string $table The table name
   * @return bool TRUE if table exists, FALSE otherwise
   */
  function tableExists(string $table): bool;

  /**
   * @param string $table The table name
   * @param string $column The column name
   * @return bool
   */
  function columnExists(string $table, string $column): bool;
}