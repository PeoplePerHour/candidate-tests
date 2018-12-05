<?php

declare(strict_types=1);


namespace Models\DBAL\Exceptions;

use Exception;

final class DriverConnectionException extends Exception
{
    public static function connectException($userName): self
    {
        return new self("Access deniew for user {$userName}");
    }
}
