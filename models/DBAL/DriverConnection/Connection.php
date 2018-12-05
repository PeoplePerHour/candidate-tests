<?php

namespace Models\DBAL\DriverConnection;

use Models\DBAL\Exceptions\ConnectionException;
use Models\DBAL\ParameterType\ParameterType;
use phpDocumentor\Reflection\Types\Mixed_;

interface Connection
{

    /**
     * Prepares a statement for execution
     *
     * @param string $queryString
     * @return Statement
     *
     * @throws ConnectionException
     */
    public function prepare(string $queryString): Statement;

    /**
     * Begin a transaction
     *
     * @return Statement
     * @throws ConnectionException
     */
    public function beginTransaction(): Statement;

    /**
     * Commits a database transaction
     *
     * @return Statement
     * @throws ConnectionException
     */
    public function commit(): Statement;

    /**
     * Rollback a database transaction
     *
     * @return Statement
     * @throws ConnectionException
     */
    public function rollback(): Statement;

    /**
     * Ends a database transaction
     *
     * @return Statement
     */
    public function endTransaction(): Statement;

    /**
     * Inserts a table row with specific data
     *
     * @param string $tableName The name of the table
     * @param array $values Key is the column and value is the value that will be used
     * @return Statement
     * @throws ConnectionException
     */
    public function insert(string $tableName, array $values): Statement;

    /**
     * Updates table rows
     *
     * @param string $tableName
     * @param array $values
     * @param string $where
     * @param string $joins
     * @return Statement
     * @throws ConnectionException
     */
    public function update(
        string $tableName,
        array $values,
        ?string $where,
        ?string $joins
    ): Statement;

    /**
     * Deletes table rows
     *
     * @param string $tableName
     * @param string $where
     * @param string $joins
     * @return Statement
     * @throws ConnectionException
     */
    public function delete(
        string $tableName,
        ?string $where,
        ?string $joins
    );

    /**
     *
     * @param string $tableName
     * @param array $selectFields
     * @param string $joins
     * @param array $whereValues
     * @param string $orderBy
     * @param string $groupBy
     * @param string $having
     * @param int $offset
     * @param int $limit
     * @return Statement
     * @throws ConnectionException
     */
    public function select(
        string $tableName,
        array $selectFields,
        ?string $joins,
        ?array $whereValues,
        ?string $orderBy,
        ?string $groupBy,
        ?string $having,
        ?int $offset,
        ?int $limit
    ): Statement;

    /**
     * Secure value from sql injections
     *
     * @param mixed $value
     * @param int $type
     * @return mixed
     */
    public function secureValue($value, int $type);

    /**
     * Get or generate Cache Key
     *
     * @return string
     */
    public function getOrGenerateCacheKey(): string;
}
