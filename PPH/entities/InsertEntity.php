<?php

namespace PPH\entities;

/**
 * Class InsertEntity
 *
 * @package PPH\entities
 * @author  Kostas Rentzikas <kostas.rentzikas@gmail.com>
 */
class InsertEntity
{
    /** @var \PDO */
    private $db;

    /** @var string */
    private $into;

    /** @var string|null */
    private $insertColumns = null;

    /** @var array|null */
    private $insertBindValues = null;

    /** @var string */
    private $statementString;

    /**
     * InsertEntity constructor.
     *
     * @param \PDO $db
     */
    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    /**
     * @param string $tableName
     *
     * @return InsertEntity
     */
    public function into(string $tableName): InsertEntity
    {
        $this->into = " INTO {$tableName}";

        return $this;
    }

    /**
     * @param array $columnsWithValues An array with column names as keys where their values, it's the value of the
     *                                 column we want to set (if that makes any sense)
     *
     * @return InsertEntity
     */
    public function insert(array $columnsWithValues): InsertEntity
    {
        if (empty($columnsWithValues)) {
            return null;
        }
        $this->insertColumns = \implode(', ', \array_keys($columnsWithValues));
        $insertValues        = [];
        foreach ($columnsWithValues as $columnName => $columnValue) {
            $insertBindUID                          = \uniqid();
            $insertValues[]                         = ":{$insertBindUID}";
            $this->insertBindValues[$insertBindUID] = $columnValue;
        }

        $insertValuesString    = \implode(', ', $insertValues);
        $this->statementString = "({$this->insertColumns}) VALUES({$insertValuesString})";

        return $this;
    }


    /**
     * Checks if there's a table set first, if we have a table, we try for transactional insert, if the DB accepts it
     * if not, we try for the normal one.
     *
     * @return bool true if we have a successful insert (transactional or not)
     */
    public function save(): bool
    {
        if (empty($this->into)) {
            return false;
        }
        $isTransactional = $this->db->beginTransaction();

        if ($isTransactional === true) {
            $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            try {
                $prepared = $this->db->prepare("INSERT{$this->into}{$this->statementString}");
                $prepared->execute($this->insertBindValues);

                return $this->db->commit();
            } catch (\PDOException $exception) {
                $this->db->rollBack();

                return false;
            }
        } else {
            $prepared = $this->db->prepare("{$this->statementString}");

            return $prepared->execute($this->insertBindValues);
        }
    }
}