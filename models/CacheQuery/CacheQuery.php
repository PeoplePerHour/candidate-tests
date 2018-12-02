<?php

declare(strict_types = 1);

namespace Models\CacheQuery;

use Doctrine\DBAL\Cache\CacheException;
use Doctrine\DBAL\Cache\QueryCacheProfile;
use Doctrine\DBAL\Connection;
use Exception;
use Webmozart\Assert\Assert;

final class CacheQuery
{
    public function executeCacheQuery(
        Connection $connection,
        string $query,
        QueryCacheProfile $cacheProfile,
        array $params,
        array $types
    ): array {
        Assert::stringNotEmpty($query);

        try {
            $stmt = $connection->executeCacheQuery(
                $query,
                $params,
                $types,
                $cacheProfile
            );
        } catch (CacheException $exception) {
            throw $exception;
        }

        $result = $stmt->fetchAll();

        $stmt->closeCursor();

        return $result;
    }
}
