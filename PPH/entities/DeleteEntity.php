<?php

namespace PPH\entities;

use PPH\entities\traits;

/**
 * Class DeleteEntity
 *
 * @package PPH\entities
 * @author  Kostas Rentzikas <kostas.rentzikas@gmail.com>
 */
class DeleteEntity
{

    use traits\WhereTrait {
        where as traitWhere;
    }

    /** @var string */
    private $from;

    /** @var \PDO */
    private $db;

    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    /**
     * @param string $tableName
     *
     * @return DeleteEntity
     */
    public function from(string $tableName): DeleteEntity
    {
        $this->from = " FROM {$tableName}";

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function where(array $conditions)
    {
        $this->traitWhere($conditions);

        return $this->delete();
    }


    /**
     * @return bool
     */
    private function delete(): bool
    {
        if (empty($this->andWhereConditions) || empty($this->from)) {
            return false;
        }
        $statement      = "DELETE{$this->from}{$this->andWhereConditions}";
        $preparedDelete = $this->db->prepare($statement);

        return $preparedDelete->execute($this->andWhereBindValues);
    }
}