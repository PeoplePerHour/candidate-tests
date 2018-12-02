<?php
declare(strict_types = 1);

namespace Models\MakeTransaction;

use Doctrine\DBAL\Connection;
use Exception;

final class MakeTransaction
{
    public function beginTransaction(Connection $connection): bool
    {
        try {
            $connection->beginTransaction();
            return true;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    public function commit(Connection $connection): bool
    {
        try {
            $connection->commit();
            return true;
        } catch (Exception $exception) {
            $connection->rollBack();
            throw $exception;
        }
    }
}
