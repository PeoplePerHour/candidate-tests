<?php

declare(strict_types = 1);

namespace Models\DatabaseCrud;

use Doctrine\DBAL\Query\QueryBuilder;
use Webmozart\Assert\Assert;

final class CrudDelete
{
    public function delete(
        QueryBuilder $queryBuilder,
        string $tableName,
        int $id
    ): int {
        Assert::stringNotEmpty($tableName);
        Assert::notEmpty($id);

        $queryBuilder
            ->delete($tableName)
            ->where('id = ?')
            ->setParameter(0, $id);

        return $queryBuilder->execute();
    }
}
