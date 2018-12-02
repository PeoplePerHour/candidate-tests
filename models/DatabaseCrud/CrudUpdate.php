<?php

declare(strict_types = 1);

namespace Models\DatabaseCrud;

use Doctrine\DBAL\Query\QueryBuilder;
use Webmozart\Assert\Assert;

final class CrudUpdate
{
    public function update(
        QueryBuilder $queryBuilder,
        string $tableName,
        array $values,
        array $where
    ): bool {
        Assert::stringNotEmpty($tableName);
        Assert::notEmpty($values);

        $queryBuilder
            ->update($tableName);

        $counter = 0;
        foreach ($values as $key => $value) {
            $queryBuilder->set($key, '?');
            $queryBuilder->setParameter($counter, $value);
            $counter++;
        }

        foreach ($where as $key => $value) {
            $queryBuilder->where($key . " = ?");
            $queryBuilder->setParameter($counter, $value);
            $counter++;
        }

        $queryBuilder->execute();

        return true;
    }
}
