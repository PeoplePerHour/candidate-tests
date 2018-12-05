<?php

declare(strict_types=1);

namespace Models\DBAL\Exceptions;

use Exception;

final class StatementException extends Exception
{
    public static function executeException(): self
    {
        return new self("Execution of query failed!");
    }

    public static function fetchException(): self
    {
        return new self("Fetch of results failed!");
    }
}
