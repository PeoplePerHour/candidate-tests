<?php

namespace CT\DBConnectionManager;

/**
 * Interface CRUDInterface
 * @package CT\DBConnectionManager
 */
interface CRUDInterface {

    public function select(string $table, array $params, array $options);
    public function insert(string $table, array $params): bool;
    public function update(string $table, array $params, array $options): bool;
    public function delete(string $table, array $options): bool;

}