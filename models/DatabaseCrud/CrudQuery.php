<?php

declare(strict_types = 1);

namespace Models\DatabaseCrud;

use Doctrine\DBAL\Connection;
use Webmozart\Assert\Assert;

final class CrudQuery
{
    public function query(
        Connection $connection,
        string $query,
        array $replaceValues
    ): array {
        Assert::stringNotEmpty($query);

        $stmt = $connection->prepare($query);

        foreach ($replaceValues as $key => $value) {
            $stmt->bindValue(++$key, $value);
        }

        $stmt->execute();

        return $stmt->fetchAll();
    }
}
