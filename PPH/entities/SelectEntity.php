<?php

namespace PPH\entities;

use PPH\CacheManager;

/**
 * Class SelectEntity
 *
 * @package PPH\entities
 * @author  Kostas Rentzikas <kostas.rentzikas@gmail.com>
 */
class SelectEntity
{

    use traits\WhereTrait;

    /** @var array|string|null */
    private $columns;

    /** @var bool|null */
    private $count = false;

    /** @var string */
    private $from;

    /** @var null|static */
    private $orderBy = null;

    /** @var null|int */
    private $limit = null;

    /** @var null|int */
    private $offset = null;

    /** @var \PDO */
    private $db;

    /** @var CacheManager */
    private $cache;

    /**
     * SelectEntity constructor.
     *
     * @param \PDO         $db
     * @param CacheManager $cache
     */
    public function __construct(\PDO $db, CacheManager $cache)
    {
        $this->db    = $db;
        $this->cache = $cache;
    }

    /**
     * @param array|string|null $columns
     *
     * @return SelectEntity
     */
    public function columns($columns = null)
    {
        if (empty($columns)) {
            $columns = '*';
        }
        $this->columns = $columns;

        return $this;
    }

    /**
     * @param bool|null $count
     *
     * @return SelectEntity
     */
    public function count(?bool $count): SelectEntity
    {
        $this->count = $count;

        return $this;
    }

    /**
     * @param string $tableName
     *
     * @return SelectEntity
     */
    public function from(string $tableName): SelectEntity
    {
        $this->from = " FROM {$tableName}";

        return $this;
    }

    /**
     * @param string|array $orderColumns
     * @param string       $sortOrder 'ASC'|'DESC'|SORT_ASC|SORT_DESC
     *
     * @return SelectEntity
     */
    public function orderBy($orderColumns, $sortOrder = 'ASC'): SelectEntity
    {
        /**
         * Change constants to strings
         * and set default to ASC if we have entered something else
         */
        if ($sortOrder === \SORT_ASC) {
            $sortOrder = 'ASC';
        } elseif ($sortOrder === \SORT_DESC) {
            $sortOrder = 'DESC';
        }

        if ($sortOrder != 'DESC' || $sortOrder != 'ASC') {
            $sortOrder = 'ASC';
        }
        if (\is_array($orderColumns)) {
            $orderColumns = \implode(', ', $orderColumns);
        }
        $this->orderBy = " ORDER BY {$orderColumns} {$sortOrder}";

        return $this;
    }

    /**
     * @param string|array $orderColumns
     *
     * @return SelectEntity
     */
    public function orderByAsc($orderColumns): SelectEntity
    {
        if (\is_array($orderColumns)) {
            $orderColumns = \implode(', ', $orderColumns);
        }

        return $this->orderBy($orderColumns, 'ASC');
    }

    /**
     * @param string|array $orderColumns
     *
     * @return SelectEntity
     */
    public function orderByDesc($orderColumns): SelectEntity
    {
        if (\is_array($orderColumns)) {
            $orderColumns = \implode(', ', $orderColumns);
        }

        return $this->orderBy($orderColumns, 'DESC');
    }

    /**
     * @param int $limit
     *
     * @return SelectEntity
     */
    public function limit(int $limit): SelectEntity
    {
        $this->limit = (int)\abs($limit);

        return $this;
    }

    /**
     * @param int $offset
     *
     * @return SelectEntity
     */
    public function offset(int $offset): SelectEntity
    {
        $this->offset = (int)\abs($offset);

        return $this;
    }

    /**
     * @return string
     */
    private function getStatement(): string
    {
        if (\is_array($this->columns)) {
            $this->columns = \implode(', ', $this->columns);
        }

        return ($this->count && ! $this->limit) ? "SELECT COUNT({$this->columns}) " : "SELECT {$this->columns} ";
    }


    /**
     * @param bool $asArray
     *
     * @return array|bool|null If $asArray it's true, then it will return the rows as an array of arrays
     *               Otherwise it will return an array of objects (instance of \stdClass)
     */
    public function all(bool $asArray = false): ?array
    {
        if ( ! $this->from) {
            return null;
        }
        $fetchStyle = $asArray ? \PDO::FETCH_ASSOC : \PDO::FETCH_OBJ;
        $statement  = "{$this->getStatement()}{$this->from}{$this->andWhereConditions}{$this->orderBy}";
        if ($this->limit && ! $this->count) {
            $statement .= " LIMIT {$this->limit}";
            if ($this->offset) {
                $statement .= " OFFSET {$this->offset}";
            }
        }

        if ($this->cache->enabled()) {
            $result = $this->cache->load($statement);
            if ($result) {
                return \json_decode($result, $asArray);
            }
        }

        $prepared = $this->db->prepare($statement);
        $prepared->execute($this->andWhereBindValues);
        $result = $prepared->fetchAll($fetchStyle);
        ! $this->cache->enabled() ?: $this->cache->store($statement, $result);

        return ($result != null) ? $result : null;
    }

    /**
     * @param bool $asArray
     *
     * @return array|\stdClass|bool|null
     */
    public function one(bool $asArray = false)
    {
        if ( ! $this->from) {
            return null;
        }
        $fetchStyle = $asArray ? \PDO::FETCH_ASSOC : \PDO::FETCH_OBJ;
        $statement  = "{$this->getStatement()}{$this->from}{$this->andWhereConditions}{$this->orderBy}";

        if ($this->cache->enabled()) {
            $result = $this->cache->load($statement);
            if ($result) {
                return \json_decode($result, $asArray);
            }
        }

        $prepared = $this->db->prepare($statement);
        $prepared->execute($this->andWhereBindValues);
        $result = $prepared->fetch($fetchStyle);
        ! $this->cache->enabled() ?: $this->cache->store($statement, $result);

        return ($result != null) ? $result : null;
    }

    /**
     * @return string|null null if query fails or the name of the column
     */
    public function getPrimaryKey(): ?string
    {
        try {
            $query  = $this->db->query("SHOW KEYS{$this->from} WHERE Key_name = 'PRIMARY'");
            $result = $query->fetch(\PDO::FETCH_OBJ);

            return $result->Column_name;
        } catch (\Exception $exception) {
            return null;
        }
    }

}