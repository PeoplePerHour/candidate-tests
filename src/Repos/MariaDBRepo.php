<?php


    namespace App\Repos;

    use App\Interfaces\DBInterface;
    use App\Models\Model;
    use App\Traits\Helper;

    class MariaDBRepo extends Model implements DBInterface
    {
        private $__db;
        private $__host     = '';
        private $__dbName   = '';
        private $__charset  = 'utf8mb4';
        private $__username = '';
        private $__password = '';

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
                $this->__db = new \PDO('mysql:host='.$this->__host.';dbname='.$this->__dbName.';charset='.$this->__charset.';connect_timeout=15', $this->__username, $this->__password);
                $this->__db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                $this->__db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
            }
            catch (\PDOException $e)
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

        public function select(bool $isList, array $columns, string $table, array $joins, array $conditions, string $orderBy, string $limitStart, string $limitEnd) :array
        {
            try
            {
                $results = array();

				if($isList == true)
					$sql = 'SELECT SQL_CALC_FOUND_ROWS ';
				else
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
					$query = $this->__db->query("SELECT FOUND_ROWS()");
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

				$sql = 'INSERT INTO '.$table.' ( ';

				foreach ($columns as $column)
					if($column == end($columns))
						$sql .= $column['column'].' ) ';
					else
						$sql .= $column['column'].', ';

				$sql.= 'VALUES ( ';

				foreach ($columns as $column)
					if($column == end($columns))
						$sql .= ':'.$column['column'].' ) ';
					else
						$sql .= ':'.$column['column'].', ';

				$stmt  = $this->__db->prepare($sql);

				foreach ($columns as $column)
					$stmt->bindValue(':'.$column['column'], $column['value'], is_int($column['value']) ? \PDO::PARAM_INT : \PDO::PARAM_STR);

				$stmt->execute();

                $this->commit();

				return $response = array(
					'success' => true,
					'type' => 'success',
					'message' => 'User added'
				);
            }
            catch (\PDOException $e)
            {
                $this->rollback();

				return $response = array(
					'success' => false,
					'type' => 'danger',
					'message' => $e->getMessage()
				);
            }
        }

        public function update(string $table, array $values, array $conditions)  :array
        {
            try
            {
                $this->startTransaction();

				$sql = 'UPDATE '.$table.' SET ';

				foreach ($values as $value)
					if($value == end($values))
						$sql .= $value['column'].' = :'.$value['column'].' ';
					else
						$sql .= $value['column'].' = :'.$value['column'].', ';


				if(!empty($conditions))
					foreach ($conditions as $condition)
						$sql .= $condition['clause'].' '.$condition['column'].' '.$condition['operator'].' :'.$condition['column'].' ';

				$stmt  = $this->__db->prepare($sql);

				foreach ($values as $value)
					$stmt->bindValue(':'.$value['column'], $value['value'], is_int($value['value']) ? \PDO::PARAM_INT : \PDO::PARAM_STR);

				if(!empty($conditions))
					foreach ($conditions as $condition)
						$stmt->bindValue(':'.$condition['column'], $condition['value'], is_int($condition['value']) ? \PDO::PARAM_INT : \PDO::PARAM_STR);

				$stmt->execute();

                $this->commit();

				return $response = array(
					'success' => true,
					'type' => 'success',
					'message' => 'User updated'
				);
            }
            catch (\PDOException $e)
            {
                $this->rollback();

				return $response = array(
					'success' => false,
					'type' => 'danger',
					'message' => $e->getMessage()
				);
            }
        }

        public function delete(string $table, array $conditions)
        {
            try
            {
                $this->startTransaction();

                $sql = 'DELETE FROM '.$table.' ';

				foreach ($conditions as $condition)
					$sql .= $condition['clause'].' '.$condition['column'].' '.$condition['operator'].' :'.$condition['column'].' ';

				$stmt  = $this->__db->prepare($sql);

				foreach ($conditions as $condition)
					$stmt->bindValue(':'.$condition['column'], $condition['value'], is_int($condition['value']) ? \PDO::PARAM_INT : \PDO::PARAM_STR);

				$stmt->execute();

                $this->commit();

				return $response = array(
					'success' => true,
					'type' => 'success',
					'message' => 'User(s) deleted'
				);
            }
            catch (\PDOException $e)
            {
				$this->rollback();

				return $response = array(
					'success' => false,
					'type' => 'danger',
					'message' => $e->getMessage()
				);
			}
        }
    }