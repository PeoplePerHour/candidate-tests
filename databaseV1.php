<?php

class Database extends PDO
{

	private $opt = [
	    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
	    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
	    PDO::ATTR_EMULATE_PREPARES   => false //sql injection flag
	];

	private $action = '';
	private $params = [];
  	private $cachedQueries = [];

	public function __construct($driver, $charset, $host, $db, $user, $pass) {
		parent::__construct("$driver:host=$host;dbname=$db;charset=$charset", $user, $pass, $this->opt);
		return $this;
	}

	/**
	 * Insert one or more rows
	 *
	 * @param string   	the table in which rows will be inserted
	 * @param array 	the data to insert
	 */ 
	public function insert($table = '', $params = []) {
		
		if (!empty($params)) {
			$this->params = $params;
		}

		// if no table or data to insert is given don't proceed
		if ($this->missingArguments($table) || $this->missingArguments($params)) {
			echo 'Missing insert arguments' . PHP_EOL;
			die;
		}

		try {
			//open transaction
			$this->beginTransaction();

			//build the query, bind values with placeholders and execute
			foreach ($this->params as $pair) {
				if (is_array($pair)) {
					$theValues = str_repeat('?,', count(array_values($pair)) - 1) . '?';
					$this->queryString = "INSERT INTO {$table} (" . implode(', ', array_keys($pair)) . ") VALUES ({$theValues})";
		
					$prepared = $this->prepare($this->queryString);
					$prepared->execute(array_values($pair));
				}
			}

			//commit transaction
			$this->commit();

			echo "Rows inserted successfully" . PHP_EOL;

		} catch (PDOException $e) {
			//rollback changes if something goes wrong
			$this->rollback();
			echo 'Insert failed: ' . $e->getMessage() . PHP_EOL;
		}
	}

	/**
	 * Update a row
	 *
	 * @param string   	the table in which rows will be updated
	 * @param array 	new data
	 * @param array 	where clause data
	 */ 
	public function update($table = '', $updateTo = [], $params = []) {

		if (!empty($params)) {
			$this->params = $params;
		}

		// if no table or data are given don't proceed
		if ($this->missingArguments($table) || $this->missingArguments($updateTo)) {
			echo 'Missing update arguments' . PHP_EOL;
			die;
		}

		try {
			//open transaction
			$this->beginTransaction();

			$this->queryString = "UPDATE {$table} SET ";
			
			//prepare query and set values to bind
			$this->whereValues(false, $updateTo);

			//execute query binding the values
			$this->prepared->execute($this->whereValues);

			//commit transaction
			$this->commit();

			//show what happened
			$this->action = 'update';
			echo $this->affectedRows();

		} catch (PDOException  $e) {
			//rollback changes if something goes wrong
			$this->rollback();
			echo 'Update failed: ' . $e->getMessage();
		}
	}


	/**
	 * Delete rows
	 *
	 * @param string   	the table in which rows will be updated
	 * @param array 	where clause data
	 */ 
	public function delete($table = '', $params = []) {
		
		if (!empty($params)) {
			$this->params = $params;
		}

		// if no table or data are given don't proceed
		if ($this->missingArguments($table)) {
			echo 'Missing delete arguments' . PHP_EOL;
			die;
		}

		try {
			//open transaction
			$this->beginTransaction();

			$this->queryString = "DELETE FROM {$table}";

			//prepare query and set values to bind
			$this->whereValues();

			//execute query binding the values
			$this->prepared->execute($this->whereValues);

			//commit transaction
			$this->commit();

			//show what happened
			$this->action = 'delete';
			echo $this->affectedRows();

		} catch (PDOException $e) {
			//rollback changes if something goes wrong
			$this->rollback();
			echo 'Delete failed: ' . $e->getMessage() . PHP_EOL;
		}
	}

	/**
	 * Select rows
	 *
	 * @param array   	array of selected columns
	 * @param string   	the table in which rows will be updated
	 * @param array 	where clause data
	 */ 
	public function select($select = [], $table = '', $params = []) {

		if (!empty($params)) {
			$this->params = $params;
		}

		// if no table or data are given don't proceed
		if ($this->missingArguments($table)) {
			echo 'Missing select arguments' . PHP_EOL;
			die;
		}

		try {
			//build the select part
			$select = array_filter($select);
			if (!empty($select)) {
				$this->queryString = 'SELECT ' . implode(', ', $select);
			}
			else {
				$this->queryString = 'SELECT * ';
			}

			$this->queryString .= " FROM {$table}";
		
			//prepare query and set values to bind
			$this->whereValues(true);

			//execute query binding the values and fetching the dataset
			$this->prepared->execute($this->whereValues);
			$results = $this->prepared->fetchAll(PDO::FETCH_ASSOC);

			if (!empty($results)) {
				print_r($results);
			} else {
				echo 'No matching rows' . PHP_EOL;
			}

		} catch (PDOException $e) {
			echo 'Select failed: ' . $e->getMessage() . PHP_EOL;
		}
	}

	/**
	 * Query caching
	 *
	 * @param string   	the query
	 * @param bool 		flag to show if caching is enabled
	 */ 
  	public function prepare($query, $cached = false) {

  		//if nothing is cached before then prepare query
  		if (!$cached) {
  			return parent::prepare($query);
  		}
    
    	//else if query is already cached get this one
      	if (!isset($this->cachedQueries[$query])) {    
            $this->cachedQueries[$query] = parent::prepare($query);
		}

    	return $this->cachedQueries[$query];
	}

	/**
	 * Build the SET of the update 
	 *
	 * @param string   	the query
	 * @param array   	data of the where condition
	 * @param array   	new values for the update
	 * @param bool 		flag to show if caching is enabled
	 *
	 * @return array
	 */ 
	private function whereValues($cache = false, $updateTo = []) {

		$temp = [];
		$query = '';
		//only for the update build the SET part
		if (!empty($updateTo)) {
			foreach ($updateTo as $key => $value) {
				$query .= "{$key} = ?, ";
				$temp [] = $value;
			}
			$query = rtrim($query, ', ');
		}

		//build the where clause
		$whereValues = [];
		if (!empty($this->params)) {
			list($where, $whereValues) = $this->where();
			$query .= " WHERE {$where}";
		}

		$this->queryString .= $query;
		$this->whereValues = array_merge($temp,$whereValues);
		$this->prepared = $this->prepare($this->queryString, $cache);	
		
		return $this;
	}
	
	/**
	 * Create the where clause
	 *
	 * @param array   	data of the where condition
	 *
	 * @return array
	 */ 
	private function where() {
		
		$where = '';
		$lastCondition = '';
		$whereValues = [];
		foreach ($this->params as $clause) {
			if ($clause[0] && $clause[1]) {

				//get the condition type
				$comparison = $this->getWhereComparison($clause[1]);

				$where .= "{$clause[0]} " . $comparison;
				
				//don't create placeholders for null and notnull conditions
				if (stripos($clause[1], 'null') !== false) continue;

				//check if there is a value to compare to
				if (isset($clause[2])) {
					//special handling for the in() and not in() conditions if array 
					if ($clause[1] == 'in' || $clause[1] == 'nin' ) {
						if (is_array($clause[2])) {
							$whereValues = array_merge($whereValues,$clause[2]);

							$in = str_repeat('?,', count($clause[2]) - 1) . '?';
							$where .= " ($in) ";
						} 
						else {
							//special handling for the in() and not in() conditions if single value
							$whereValues[] = $clause[2];
							$where .= " (?) ";
						}
					} 
					else {
						//handling of other conditions
						$whereValues[] = "{$clause[2]}";
						$where .= " ? ";
					}
				}
			}

			//connnect the conditions with OR or AND operators
			if (isset($clause[3])) {
				$where .= " {$clause[3]} ";
				$lastCondition = $clause[3];
			}
		}

		//in case an operator shows in the end ofthe query without a condition remove it
		if ($lastCondition) {
			$where = rtrim($where, $lastCondition . ' ');
		}

		//just fix double spaces
		$where = str_replace('  ', ' ', $where);

		return [$where, $whereValues];
	}

	/**
	 * Get the condition type
	 *
	 * @param string   	comparison type
	 */ 
	private function getWhereComparison($compare) {

		if ($compare == 'eq')			$comparison = '=';
		elseif ($compare == 'neq')		$comparison = '!=';
		elseif ($compare == 'like')		$comparison = 'like';
		elseif ($compare == 'nlike')	$comparison = 'not like';
		elseif ($compare == 'in')		$comparison = 'in';
		elseif ($compare == 'nin')		$comparison = 'not in';
		elseif ($compare == 'null')		$comparison = 'is null';
		elseif ($compare == 'notnull')	$comparison = 'is not null';
		elseif ($compare == 'gt')		$comparison = '>';
		elseif ($compare == 'lt')		$comparison = '<';
		elseif ($compare == 'gteq')		$comparison = '>=';
		elseif ($compare == 'lteq')		$comparison = '<=';

		return $comparison;
	}

	private function affectedRows() {
		if ($this->action == 'update') {
			return "Updated {$this->prepared->rowCount()} rows" . PHP_EOL;
		}
		if ($this->action == 'delete') {
			return "Deleted {$this->prepared->rowCount()} rows" . PHP_EOL;
		}
	}

	private function missingArguments($arguments) {
		if (is_array($arguments)) {
			if (empty($arguments)) {
				return true;
			}
		}
		else {
			if (!strlen($arguments)) {
				return true;
			}
		}

		return false;
	}

}