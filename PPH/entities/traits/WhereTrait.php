<?php

namespace PPH\entities\traits;

/**
 * Trait WhereTrait
 *
 * @package PPH\entities
 * @author  Kostas Rentzikas <kostas.rentzikas@gmail.com>
 */
trait WhereTrait
{
    /** @var string|null */
    private $andWhereConditions = null;

    /** @var array|null */
    private $andWhereBindValues = null;

    /** @var array */
    private static $validOperators = [
        '=',
        '>',
        '<',
        '>=',
        '<=',
        '<>',
        '!=',
        '<=>',
        'LIKE',
        'NOT LIKE',
    ];

    /**
     * @param array $conditions
     *
     * @return $this
     */
    public function where(array $conditions)
    {
        try {
            $preparedConditions = [];
            foreach ($conditions as $condition) {
                if (\count($condition) < 3) {
                    throw new \Error("Condition must consist of ['column_name', 'operator', 'value']");
                } elseif ( ! $this->checkValidOperator($condition[1])) {
                    throw new \Error('Invalid condition operator');
                } else {
                    $preparedConditions[] = "{$condition[0]} {$condition[1]}:{$condition[0]}";
                    if ($condition[1] == 'LIKE' || $condition[1] == 'NOT LIKE') {
                        if ( ! $this->checkValidLike($condition[2])) {
                            throw new \Error("Invalid '{$condition[1]}' Operator.");
                        }
                    }
                    $this->andWhereBindValues[$condition[0]] = $condition[2];
                }
            }
            $this->andWhereConditions = ' WHERE ';
            $this->andWhereConditions .= \implode(' AND ', $preparedConditions);

            return $this;
        } catch (\Throwable $throwable) {
            die($throwable->getMessage());
        }
    }

    /**
     * @param $value
     *
     * @return bool
     */
    private function checkValidLike($value): bool
    {
        $length = \strlen($value);
        if (\substr($value, 0, $length) === '%') {
            return true;
        } elseif (\substr($value, -$length) === '%') {
            return false;
        } else {
            return false;
        }
    }

    /**
     * @param string $operator
     *
     * @return bool
     */
    private function checkValidOperator(string $operator): bool
    {
        return (\in_array($operator, self::$validOperators));
    }
}