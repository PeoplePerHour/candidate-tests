<?php

namespace CT\DBConnectionManager;

use CT\DBConnectionManager\Cache\CacheInterface;
use PDO;
use PDOStatement;

/**
 * Class Database
 * @package CT\DBConnectionManager
 */
class Database extends AbstractDatabase implements CRUDInterface {

    protected $cache;

    public function select(string $table, array $params, array $options) {



        $column = array_keys($options)[0];

        $query = 'SELECT '.  implode(',', $params) .' FROM '. $table . ' WHERE ' . $column . '=?';

        // Prepare statement
        $pdoStatement = $this->getPdo()->prepare($query);
        // Execute
        $pdoStatement->execute($options[$column]);
        return $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert(string $table, array $params): bool {

        $placeholders = implode(',', array_fill(0, count($params), '?'));

        $query = 'INSERT INTO ' . $table . '(' . implode(',', array_keys($params)) . ') ';
        $query .= 'VALUES(' . $placeholders . ')';

        // Prepare and execute query
        $pdoStatement = $this->execute($query, array_values($params));
        return $pdoStatement->rowCount() > 0;
    }

    public function update(string $table, array $params, array $options): bool {

        $sets = [];
        foreach ($params as $key => $value) {
            array_push($sets, $key . '=?');
        }

        $column = array_keys($options)[0];
        $values = array_values($params);
        array_push($values, $options[$column]);

        $query = 'UPDATE ' . $table . ' SET ' . implode(',', $sets) . ' WHERE ' . $column . '=?';

        // Prepare and execute query
        $pdoStatement = $this->execute($query, $values);
        return $pdoStatement->rowCount() > 0;
    }

    public function delete(string $table, array $options): bool {

        $column = array_keys($options)[0];

        $query = 'DELETE FROM ' . $table . ' WHERE ' . $column . '=?';

        // Prepare and execute query
        $pdoStatement = $this->execute($query, $options[$column]);
        return $pdoStatement->rowCount() > 0;
    }

    public function isConnected(): bool {
        return is_object($this->pdo)? true: false;
    }

    public function executeQuery($query) {

        // Prepare statement
        $pdoStatement = $this->getPdo()->prepare($query);
        // Execute
        $pdoStatement->execute();
        return $pdoStatement;
    }

    public function commit() {
        $this->pdo->commit();
    }

    public function rollback() {
        $this->pdo->rollBack();
    }

    public function setCacheProvider(CacheInterface $cache) {
        $this->cache = $cache;
    }

    public function getCacheProvider(): CacheInterface {
        return $this->cache;
    }

    protected function isCacheEnabled(): bool {
        return is_object($this->cache)? true: false;
    }

    protected function saveQueryToCache($params, $options, $value) {

        if ($this->isCacheEnabled()) {
            $key = md5(json_decode($params).json_encode($options));
            $this->getCacheProvider()->set($key, $value);
        }

    }

    protected function getCachedResult($params, $options) {

        if ($this->isCacheEnabled()) {
            $key = md5(json_decode($params).json_encode($options));
            return $this->getCacheProvider()->get($key);
        }
    }

    /**
     * @param $query
     * @param $values
     * @return \PDOStatement
     */
    protected function execute($query, $values) {

        // Prepare statement
        $pdoStatement = $this->getPdo()->prepare($query);
        // Execute
        $pdoStatement->execute($values);
        return $pdoStatement;
    }
}