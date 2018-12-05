<?php

declare(strict_types=1);


namespace Models\DBAL\Exceptions;

use Exception;

final class CacheException extends Exception
{
    public static function fetchException(): self
    {
        return new self('Cannot fetch cached data!');
    }

    public static function saveException(): self
    {
        return new self('Data save to cache failed!');
    }

    public static function deleteException(): self
    {
        return new self('Delete of cache key failed!');
    }
}
