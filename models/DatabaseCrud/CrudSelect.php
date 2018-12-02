<?php

declare(strict_types = 1);

namespace Models\DatabaseCrud;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\Query\QueryBuilder;
use Webmozart\Assert\Assert;

final class CrudSelect
{

    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var array
     */
    private $selectFields;

    /**
     * @var string
     */
    private $joins;

    /**
     * @var array
     */
    private $whereValues;

    /**
     * @var string
     */
    private $orderBy;

    /**
     * @var string
     */
    private $groupBy;

    /**
     * @var string
     */
    private $having;

    /**
     * @var int
     */
    private $offset;

    /**
     * @var int
     */
    private $limit;

    /**
     * @var array
     */
    private $bindValues;

    /**
     * @var string
     */
    private $tableName;

    public static function fromParams(
        Connection $connection,
        string $tableName,
        array $selectFields,
        string $joins,
        array $whereValues,
        string $orderBy,
        string $groupBy,
        string $having,
        int $offset,
        int $limit
    ): self {
        Assert::allStringNotEmpty($selectFields);
        Assert::stringNotEmpty($tableName);

        return new self(
            $connection,
            $tableName,
            $selectFields,
            $joins,
            $whereValues,
            $orderBy,
            $groupBy,
            $having,
            $offset,
            $limit
        );
    }
    public function select(): array
    {
        $query = $this->buildQuery();

        $stmt = $this->connection->prepare($query);

        if (!empty($this->bindValues)) {
            foreach ($this->bindValues as $key => $value) {
                if (is_int($value)) {
                    $stmt->bindValue(
                        ++$key,
                        $value,
                        ParameterType::INTEGER
                    );
                    continue;
                }

                $stmt->bindValue(++$key, $value);
            }
        }

        $stmt->execute();

        return $stmt->fetchAll();
    }

    private function __construct(
        Connection $connection,
        string $tableName,
        array $selectFields,
        string $joins,
        array $whereValues,
        string $orderBy,
        string $groupBy,
        string $having,
        int $offset,
        int $limit
    ) {
        $this->connection = $connection;
        $this->tableName = $tableName;
        $this->selectFields = $selectFields;
        $this->joins = $joins;
        $this->whereValues = $whereValues;
        $this->orderBy = $orderBy;
        $this->groupBy = $groupBy;
        $this->having = $having;
        $this->offset = $offset;
        $this->limit = $limit;
        $this->setBindValues();
    }

    private function setBindValues()
    {
        if (!empty($this->whereValues)) {
            foreach ($this->whereValues as $value) {
                $this->bindValues[] = $value;
            }
        }

        if (!empty($this->groupBy)) {
            $this->bindValues[] = $this->groupBy;
        }

        if (!empty($this->having)) {
            $this->bindValues[] = $this->having;
        }

        if (!empty($this->orderBy)) {
            $this->bindValues[] = $this->orderBy;
        }

        if (!empty($this->limit)) {
            $this->bindValues[] = intval($this->limit);

            if (!empty($this->offset)) {
                $this->bindValues[] = intval($this->offset);
            }
        }
    }

    private function replaceValuesWithQuestionMark(array $values): string
    {
        if (empty($values)) {
            return '';
        }

        array_walk($values, function (&$item, $key) {
            return $item = "{$key} = ?";
        });

        return implode(",", $values);
    }

    private function buildQuery(): string
    {
        $query = 'SELECT ' . implode(',', $this->selectFields);

        if (!empty($joins)) {
            $query .= " {$joins}";
        }

        $query .= " FROM {$this->tableName}";

        if (!empty($this->whereValues)) {
            $query .=
                " WHERE {$this->replaceValuesWithQuestionMark($this->whereValues)}";
        }

        if (!empty($this->groupBy)) {
            $query .= " GROUP BY ?";
        }

        if (!empty($this->having)) {
            $query .= " HAVING ?";
        }

        if (!empty($this->orderBy)) {
            $query .= " ORDER BY ?";
        }

        if (!empty($this->limit)) {
            $query .= " LIMIT ?";

            if (!empty($this->offset)) {
                $query .= " OFFSET ?";
            }
        }

        return $query;
    }
}
