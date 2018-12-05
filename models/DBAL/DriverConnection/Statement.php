<?php

namespace Models\DBAL\DriverConnection;

use Models\DBAL\Exceptions\StatementException;
use Models\DBAL\ParameterType\ParameterType;

interface Statement
{
    /**
     * @param $param
     * @param $value
     * @param int|null $type
     * @return bool
     */
    public function bindValue($param, $value, ?int $type = ParameterType::STRING): bool;

    /**
     * @param $column
     * @param $variable
     * @param int|null $type
     * @param int|null $length
     * @return mixed
     */
    public function bindParam($column, &$variable, ?int $type = ParameterType::STRING, ?int $length = null);

    /**
     * @param array|null $input_parameters
     * @return Statement
     * @throws StatementException
     */
    public function execute(?array $input_parameters = null): Statement;

    /**
     * @return int
     */
    public function rowCount(): int;

    /**
     * @return array
     * @throws StatementException
     */
    public function fetch(): array;
}
