<?php

declare(strict_types = 1);

namespace Models\DBAL\ConnectionManager;

use Models\DBAL\CacheQuery\Cache;
use Models\DBAL\DriverConnection\Connection;
use Models\DBAL\DriverConnection\DriverConnection;
use Models\DBAL\DriverConnection\Statement;
use Models\DBAL\Exceptions\CacheException;
use Models\DBAL\Exceptions\ConnectionException;
use Models\DBAL\Exceptions\DriverConnectionException;
use Models\DBAL\Exceptions\StatementException;
use Webmozart\Assert\Assert;

class ConnectionManager
{

    /**
     * @var DriverConnection
     */
    private $driverConnection;

    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var Cache
     */
    private $cache;

    /**
     * ConnectionManager constructor.
     * @param DriverConnection $driverConnection
     * @param array $connectionParams
     * @param Cache $cache
     * @throws DriverConnectionException
     */
    public function __construct(
        DriverConnection $driverConnection,
        array $connectionParams,
        Cache $cache
    ) {
        $this->driverConnection = $driverConnection;
        $this->connection = $this->driverConnection->connect($connectionParams);
        $this->cache = $cache;
    }

    /**
     * @param string $tableName
     * @param array $values
     * @param array $types
     * @return bool
     * @throws ConnectionException
     * @throws StatementException
     */
    public function insert(
        string $tableName,
        array $values,
        array $types
    ): bool {
        Assert::notEmpty($tableName);
        Assert::notEmpty($values);
        Assert::notEmpty($types);
        Assert::eq(count($types), count($values));


        $this->connection
            ->insert($tableName, $this->securedValues($values, $types))
            ->execute();

        return true;
    }

    /**
     * @param string $tableName
     * @param array $values
     * @param array $types
     * @param string|null $where
     * @param string|null $joins
     * @return bool
     * @throws ConnectionException
     * @throws StatementException
     */
    public function update(
        string $tableName,
        array $values,
        array $types,
        ?string $where,
        ?string $joins
    ):bool {
        Assert::stringNotEmpty($tableName);
        Assert::notEmpty($values);
        Assert::notEmpty($types);
        Assert::length($values, count($values));

        $this->connection
            ->update(
                $tableName,
                $this->securedValues($values, $types),
                $where,
                $joins
            )->execute();

        return true;
    }

    /**
     * @param string $tableName
     * @param string|null $where
     * @param string|null $joins
     * @return Statement
     * @throws ConnectionException
     * @throws StatementException
     */
    public function delete(
        string $tableName,
        ?string $where,
        ?string $joins
    ): Statement {
        Assert::stringNotEmpty($tableName);

        return $this->connection->delete($tableName, $where, $joins)->execute();
    }

    /**
     * @param string $tableName
     * @param array $selectFields
     * @param bool $enableCaching
     * @param int $cacheLifetime
     * @param string|null $joins
     * @param array|null $whereValues
     * @param string|null $orderBy
     * @param string|null $groupBy
     * @param string|null $having
     * @param int|null $offset
     * @param int|null $limit
     * @return array
     * @throws ConnectionException
     * @throws StatementException
     * @throws CacheException
     */
    public function select(
        string $tableName,
        array $selectFields,
        bool $enableCaching,
        int $cacheLifetime,
        ?string $joins,
        ?array $whereValues,
        ?string $orderBy,
        ?string $groupBy,
        ?string $having,
        ?int $offset,
        ?int $limit
    ) {
        Assert::stringNotEmpty($tableName);
        Assert::allStringNotEmpty($selectFields);

        if (!$enableCaching) {
            return $this->connection
                ->select(
                    $tableName,
                    $selectFields,
                    $joins,
                    $whereValues,
                    $orderBy,
                    $groupBy,
                    $having,
                    $offset,
                    $limit
                )->execute()->fetch();
        }

        $cacheKey = $this->connection->getOrGenerateCacheKey();

        if ($this->cache->contains($cacheKey)) {
            return $this->cache->fetch($cacheKey);
        }

        $results = $this->connection
            ->select(
                $tableName,
                $selectFields,
                $joins,
                $whereValues,
                $orderBy,
                $groupBy,
                $having,
                $offset,
                $limit
            )->execute()->fetch();

        $this->cache->save($cacheKey, $results, $cacheLifetime);

        return $results;
    }

    /**
     * @param array $values
     * @param array $types
     * @return array
     */
    private function securedValues(array $values, array $types):array
    {
        $counter = 0;
        foreach ($values as $key => $value) {
            $values[$key] =
                $this->connection->secureValue($value, $types[$counter]);
            $counter++;
        }

        return $values;
    }
}
