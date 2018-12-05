<?php

declare(strict_types = 1);

namespace Models\DBAL\DriverConnection;

use Models\DBAL\Exceptions\DriverConnectionException;
use Webmozart\Assert\Assert;

abstract class DriverConnection
{
    /**
     * @param array $connectionParams
     * @return Connection
     * @throws DriverConnectionException
     */
    public function connect(array $connectionParams): Connection
    {
        $this->validateConnectionParams($connectionParams);

        return $this->completeConnection($connectionParams);
    }

    /**
     * @param array $connectionParams
     * @return bool
     */
    private function validateConnectionParams(array $connectionParams): bool
    {
        Assert::notEmpty($connectionParams);
        Assert::notEmpty($connectionParams['dbhost']);
        Assert::stringNotEmpty($connectionParams['dbname']);
        Assert::stringNotEmpty($connectionParams['username']);
        Assert::stringNotEmpty($connectionParams['password']);
        Assert::stringNotEmpty($connectionParams['driver']);

        return true;
    }

    /**
     * @param $connectionParams
     * @return Connection
     * @throws DriverConnectionException
     */
    abstract public function completeConnection($connectionParams): Connection;
}
