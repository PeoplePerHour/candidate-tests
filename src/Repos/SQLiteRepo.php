<?php


    namespace App\Repos;

    use App\Interfaces\DBInterface;
    use App\Models\Model;
    use App\Traits\Helper;

    class SQLiteRepo extends Model implements DBInterface
    {
        private $__db;
        private $__dbName = DIR.'/demo.db';

        public function __construct()
        {
            try
            {
                $this->connect();
            }
            catch (\Exception $e)
            {
                throw $e;
            }
        }

		public function connect()
        {
            try
            {
                $this->__db = new \PDO('sqlite:'.$this->__dbName);
                $this->__db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                $this->__db->exec('PRAGMA foreign_keys = ON');
            }
            catch (\Exception $e)
            {
                throw $e;
            }
        }

        public function startTransaction() :bool
        {
            try
            {
                return $this->__db->beginTransaction();
            }
            catch (\PDOException $e)
            {
                throw $e;
            }
        }

        public function commit() :bool
        {
            try
            {
                return $this->__db->commit();
            }
            catch (\PDOException $e)
            {
                throw $e;
            }
        }

        public function rollback() :bool
        {
            try
            {
                return $this->__db->rollBack();
            }
            catch (\PDOException $e)
            {
                throw $e;
            }
        }

        public function select(bool $isList, array $columns, string $table, array $joins, array $conditions, string $orderBy, string $limitStart, string $limitEnd)
        {
            try
            {
                // SQLite does not support SQL_CALC_FOUND_ROWS and FOUND_ROWS

                $results = array();

                $sql = 'SELECT ';

                // columns
                $sql .= implode(', ', $columns);

                // table
                $sql .= ' FROM '. $table. ' ';

                // joins
                if(!empty($joins))
                    foreach ($joins as $join)
                        $sql .= $join['clause'].' '.$join['table'].' '.$join['columns'].' ';

                // conditions
                if(!empty($conditions))
                    foreach ($conditions as $condition)
                        $sql .= $condition['clause'].' '.$condition['column'].' '.$condition['operator'].' :'.$condition['column'].' ';

                // order by
                if(!empty($orderBy))
                    $sql .= ' '.$orderBy;

                // limits
                if(!empty($limitStart))
                    $sql .= ' '.$limitStart;

                if(!empty($limitEnd))
                    $sql .= ' '.$limitEnd;

                $stmt  = $this->__db->prepare($sql);

                foreach ($conditions as $condition)
                    $stmt->bindValue(':'.$condition['column'], $condition['value'], is_int($condition['value']) ? \PDO::PARAM_INT : \PDO::PARAM_STR);

                if(!empty($limitStart))
                    $stmt->bindValue(':nav_start', $_SESSION[$table]['nav']['start'], \PDO::PARAM_INT);

                if(!empty($limitEnd))
                    $stmt->bindValue(':nav_limit', $_SESSION[$table]['nav']['limit'], \PDO::PARAM_INT);

                $stmt->execute();

                while ($row = $stmt->fetch())
                    $results['list'][] = $row;


                if($isList == true)
                {
                    $query = $this->__db->query("SELECT COUNT(id) FROM users");
                    $results['total_rows'] = (int)$query->fetchColumn();
                    $results['paginate'] = Helper::paginate($_SESSION[$table]['nav']['targetpage'], $_SESSION[$table]['nav']['page'], $_SESSION[$table]['nav']['limit'], $results['total_rows']);
                }

                return $results;
            }
            catch (\PDOException $e)
            {
                throw $e;
            }
        }

        public function insert(string $table, array $columns)
        {
            try
            {
                $this->startTransaction();

                /*
                 * Queries
                 * */

                $this->commit();
            }
            catch (\PDOException $e)
            {
                $this->rollback();

                throw $e;
            }
        }

        public function update(string $table, array $values, array $conditions)
        {
            try
            {
                $this->startTransaction();

                /*
                 * Queries
                 * */

                $this->commit();
            }
            catch (\PDOException $e)
            {
                $this->rollback();

                throw $e;
            }
        }

        public function delete(string $table, array $conditions)
        {
            try
            {
                $this->startTransaction();

                /*
                 * Queries
                 * */

                $this->commit();
            }
            catch (\PDOException $e)
            {
                $this->rollback();

                throw $e;
            }
        }
    }