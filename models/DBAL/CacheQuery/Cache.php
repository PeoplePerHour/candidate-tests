<?php

namespace Models\DBAL\CacheQuery;

use Models\DBAL\Exceptions\CacheException;

interface Cache
{
    /**
     * @param string $cacheKey
     * @return array
     * @throws CacheException
     */
    public function fetch(string $cacheKey): array;

    /**
     * @param string $cacheKey
     * @param array $data
     * @param int $lifetime
     * @return bool
     * @throws CacheException
     */
    public function save(string $cacheKey, array $data, int $lifetime): bool;

    /**
     * @param string $cacheKey
     * @return bool
     */
    public function contains(string $cacheKey): bool;

    /**
     * @param string $cacheKey
     * @return bool
     * @throws CacheException
     */
    public function delete(string $cacheKey): bool;
}
