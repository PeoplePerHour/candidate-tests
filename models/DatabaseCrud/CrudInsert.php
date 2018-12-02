<?php
declare(strict_types = 1);
namespace Models\DatabaseCrud;

use Doctrine\DBAL\Query\QueryBuilder;
use Webmozart\Assert\Assert;

final class CrudInsert
{
    public function insert(
        QueryBuilder $queryBuilder,
        string $tableName,
        array $values
    ): bool {
        Assert::stringNotEmpty($tableName);
        Assert::notEmpty($values);

        $queryBuilder
            ->insert($tableName)
            ->values($this->getValues($values));

        $counter = 0;
        foreach ($values as $key => $value) {
            $queryBuilder->setParameter($counter, $value);
            $counter++;
        }

        $queryBuilder->execute();

        return true;
    }

    private function getValues(array $values): array
    {
        array_walk($values, function (&$item) {
            return $item = '?';
        });

        return $values;
    }
}
