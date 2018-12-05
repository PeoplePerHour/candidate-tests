<?php

declare(strict_types=1);

namespace Models\DBAL\Exceptions;

use Exception;

final class ConnectionException extends Exception
{
    public static function prepareException(string $queryString): self
    {
        return new self("Error on prepare query for query \"{$queryString}\"!");
    }

    public static function beginTransactionException(): self
    {
        return new self(
            "Cannot begin transaction or transactions are not supported!"
        );
    }

    public static function commitException(): self
    {
        return new self("There is no transaction to commit!");
    }

    public static function rollbackException(): self
    {
        return new self("There is no transaction to rollback!");
    }

    public static function endTransactionException(): self
    {
        return new self("There is no transaction to end!");
    }

    public static function insertException(
        string $tableName,
        array $values
    ): self {
        return new self(
            "Insert on columns " .
            implode(",", array_keys($values)) .
            " and values " . implode(",", $values) .
            " for table {$tableName} did not completed successfully!"
        );
    }

    public static function updateException(
        string $tableName,
        array $values
    ): self {
        return new self(
            "Update on columns " .
            implode(",", array_keys($values)) .
            " and values " . implode(",", $values) .
            " for table {$tableName} did not completed successfully!"
        );
    }

    public static function deleteExpeption(
        string $tableName,
        string $where
    ): self {
        return new self(
            "Delete of data on {$tableName}" .
            " with where statement {$where} did not completed successfully!"
        );
    }

    public static function selectExpeption(
        string $tableName,
        string $selectFields
    ): self {
        return new self(
            "Select of data from {$tableName} cannot completed successfully!"
        );
    }
}
