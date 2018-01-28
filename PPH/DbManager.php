<?php

namespace PPH;

use PPH\entities;

/**
 * Class DbManager
 *
 * @package PPH
 * @author  Kostas Rentzikas <kostas.rentzikas@gmail.com>
 */
class DbManager
{
    /** @var DbConnector */
    private $db;

    /** @var CacheManager */
    private $cache;

    /** @var entities\SelectEntity */
    private $selectEntity;

    /** @var entities\InsertEntity */
    private $insertEntity;

    /** @var entities\DeleteEntity */
    private $deleteEntity;

    /** @var entities\UpdateEntity */
    private $updateEntity;

    /**
     * DbManager constructor.
     */
    public function __construct()
    {
        $this->db    = (new DbConnector())->getPdoConnection();
        $this->cache = new CacheManager();
    }

    /**
     * @param string|array|null $columns
     *
     * @return entities\SelectEntity
     */
    public function select($columns = '*'): entities\SelectEntity
    {
        $this->selectEntity = new entities\SelectEntity($this->db, $this->cache);
        $this->selectEntity->columns($columns);

        return $this->selectEntity;
    }

    /**
     * @param string|int $primaryKeyValue
     * @param string     $tableName
     * @param bool       $asArray
     *
     * @return array|bool|null|\stdClass
     *
     */
    public function findOne($primaryKeyValue, string $tableName, bool $asArray = false)
    {
        if (\is_string($primaryKeyValue) || \is_int($primaryKeyValue)) {
            $primaryKey = (new entities\SelectEntity($this->db, $this->cache))->from($tableName)->getPrimaryKey();
            if ($primaryKey !== false) {
                $result = (new entities\SelectEntity($this->db, $this->cache))
                    ->columns()
                    ->from($tableName)
                    ->where([
                        [$primaryKey, '=', $primaryKeyValue],
                    ])
                    ->one($asArray);

                return $result;
            }
        }

        return null;
    }

    /**
     * @param array  $whereConditions
     * @param string $tableName
     * @param bool   $asArray
     *
     * @return array|bool|null
     */
    public function findAll(array $whereConditions, string $tableName, bool $asArray = false)
    {
        return (new entities\SelectEntity($this->db, $this->cache))
            ->columns()
            ->from($tableName)
            ->where($whereConditions)
            ->all($asArray);
    }

    /**
     * @param array $columnsWithValues
     *
     * @return entities\InsertEntity
     */
    public function insert(array $columnsWithValues): entities\InsertEntity
    {
        $this->insertEntity = new entities\InsertEntity($this->db);
        $this->insertEntity->insert($columnsWithValues);

        return $this->insertEntity;
    }

    /**
     * @return entities\DeleteEntity
     */
    public function delete()
    {
        $this->deleteEntity = new entities\DeleteEntity($this->db);

        return $this->deleteEntity;
    }

    /**
     * @param array $columnsWithValues
     *
     * @return entities\UpdateEntity
     */
    public function update(array $columnsWithValues)
    {
        $this->updateEntity = new entities\UpdateEntity($this->db);
        $this->updateEntity->set($columnsWithValues);

        return $this->updateEntity;
    }
}