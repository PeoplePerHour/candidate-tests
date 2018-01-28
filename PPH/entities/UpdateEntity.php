<?php

namespace PPH\entities;

/**
 * Class UpdateEntity
 *
 * @package PPH\entities
 * @author  Kostas Rentzikas <kostas.rentzikas@gmail.com>
 */
class UpdateEntity
{

    use traits\WhereTrait;

    /** @var \PDO */
    private $db;

    /** @var string */
    private $tableName;

    /** @var string|null */
    private $updateColumns = null;

    /** @var array|null */
    private $updateBindValues = null;

    /** @var string */
    private $statementString;

    /**
     * UpdateEntity constructor.
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
     * @return UpdateEntity
     */
    public function table(string $tableName): UpdateEntity
    {
        $this->tableName = $tableName;

        return $this;
    }

    /**
     * @param array $columnsWithValues An array with column names as keys where their values, it's the value of the
     *                                 column we want to set (if that makes any sense)
     *
     * @return UpdateEntity
     */
    public function set(array $columnsWithValues): UpdateEntity
    {
        if (empty($columnsWithValues)) {
            return null;
        }
        $this->updateColumns = \implode(', ', \array_keys($columnsWithValues));
        $insertValues        = [];
        foreach ($columnsWithValues as $columnName => $columnValue) {
            $insertBindUID                          = \uniqid();
            $insertValues[]                         = ":{$insertBindUID}";
            $this->updateBindValues[$insertBindUID] = $columnValue;
        }

        $insertValuesString    = \implode(', ', $insertValues);
        $this->statementString = " SET {$this->updateColumns} ={$insertValuesString}";

        return $this;
    }

    /**
     * Checks if there's a table set first, if we have a table, we try for transactional update, if the DB accepts it
     * if not, we try for the normal one.
     *
     * @return bool true if we have a successful update (transactional or not)
     */
    public function update(): bool
    {
        if (empty($this->tableName) || empty($this->andWhereConditions)) {
            return false;
        }

        // Check if data exists first or fail.
        $existingData = $this->db->prepare("SELECT * FROM {$this->tableName}{$this->andWhereConditions}");
        $existingData->execute($this->andWhereBindValues);
        $existingData = $existingData->fetch(\PDO::FETCH_OBJ);
        if ($existingData === false) {
            return false;
        }

        $mergedBinds = \array_merge($this->updateBindValues, $this->andWhereBindValues);

        $isTransactional = $this->db->beginTransaction();

        if ($isTransactional === true) {
            $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            try {
                $prepared = $this->db->prepare("UPDATE {$this->tableName}{$this->statementString}{$this->andWhereConditions}");
                $prepared->execute($mergedBinds);

                return $this->db->commit();
            } catch (\PDOException $exception) {
                $this->db->rollBack();

                return false;
            }
        } else {
            $prepared = $this->db->prepare("UPDATE {$this->tableName}{$this->statementString}{$this->andWhereConditions}");

            return $prepared->execute($mergedBinds);
        }
    }
}