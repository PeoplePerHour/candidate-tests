<?php

    include_once 'databaseManager.class.php';

    /**
     * Database connection
     */
    class Database extends DatabaseManager
    {
        /**
         * Constructor
         */
        public function __construct($dbDriver, $host, $port, $username, $password, $dbName, $unixSocket, $charset)
        {
            parent::__construct($dbDriver, $host, $port, $username, $password, $dbName, $unixSocket, $charset);
        }

        /**
         * @return PDO
         */
        public function openConnection()
        {
            if ($this->isConnected() != 1)
            {
                try 
                {                    
                    $this->connection = new PDO($this->dbDriver.":host=".$this->host.";port=".$this->port.";charset=".$this->charset.";unix_socket=".$this->unixSocket.";dbname=".$this->dbName,$this->username,$this->password);
                    echo "Successfull connection to database" . "\n";

                    /* disable emulated prepared statements and use real prepared statements */
                    $this->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                    $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                } catch (PDOException $e) 
                {
                    die($e->getMessage());
                }  
            }
            return $this->connection;    
        }

        /**
         * Returns rows from the database based on the conditions
         * @param string name of the table
         * @param array select, where, order_by, limit and return_type conditions
         */
        public function selectData($table, $conditions = array())
        {
            $sql = 'SELECT ';
            $sql .= array_key_exists("select",$conditions)?$conditions['select']:'*';
            $sql .= ' FROM '.$table;

            if(array_key_exists("where",$conditions))
            {
                $sql .= ' WHERE ';
                $i = 0;

                foreach($conditions['where'] as $key => $value)
                {
                    $pre = ($i > 0)?' AND ':'';
                    $sql .= $pre.$key." = '".$value."'";
                    $i++;
                }
            }

            if(array_key_exists("order_by",$conditions))
            {
                $sql .= ' ORDER BY '.$conditions['order_by']; 
            }

            if(array_key_exists("start",$conditions) && array_key_exists("limit",$conditions))
            {
                $sql .= ' LIMIT '.$conditions['start'].','.$conditions['limit']; 

            } elseif(!array_key_exists("start",$conditions) && array_key_exists("limit",$conditions))
            {
                $sql .= ' LIMIT '.$conditions['limit']; 
            }

            $query = $this->connection->prepare($sql);
            $query->execute();

            /**
             * Initialize cache array with infos that we need for query caching
             */
            $cacheArray = $this->initCacheArray($sql);

            /**
             * Checks if we have cached data in folded "cache"
             */
            if ($this->isCached($cacheArray['cacheFile'], $cacheArray['cacheTimeSeconds'])) {
                echo 'is cashed';

                /* Store date */
                $fileContents = file_get_contents($cacheArray['cacheFile']);

                /* Decode the JSON back into an array. */
                $data = json_decode($fileContents, true);

            } else {
                /* Execute SELECT query */
                if(array_key_exists("return_type",$conditions) && $conditions['return_type'] != 'all')
                {
    
                    switch($conditions['return_type'])
                    {
                        case 'count':
                            $data = $query->rowCount();
                            break;
                        case 'single':
                            $data = $query->fetch(PDO::FETCH_ASSOC);
                            break;
                        default:
                            $data = '';
                    }
                } else
                {
                    if($query->rowCount() > 0)
                    {
                        $data = $query->fetchAll();
                    }
                }

                /* Create cache file */
                $this->storeCacheFile($cacheArray['sqlCacheName'], $data);
                /* Store date */
                $resultsJSON = json_encode($data);
                $data = file_put_contents($cacheArray['cacheFile'], $resultsJSON);
            }

            return !empty($data)?$data:false;
        }

        /**
         * Insert data into the database
         * @param string name of the table
         * @param array the data for inserting into the table
         */
        public function insertData($table,$data)
        {
            if(!empty($data) && is_array($data))
            {
                $columns = '';
                $values  = '';
                $i = 0;

                $columnString = implode(',', array_keys($data));
                $valueString = ":".implode(',:', array_keys($data));
                $sql = "INSERT INTO ".$table." (".$columnString.") VALUES (".$valueString.")";
                $query = $this->connection->prepare($sql);
                
                foreach($data as $key=>$val)
                {
                        $query->bindValue(':'.$key, $val);
                }

                $insert = $query->execute();

                return $insert?$this->connection->lastInsertId():false;

            } else
            {
                return false;
            }
        }

        /**
         * Update data into the database
         * @param string name of the table
         * @param array the data for updating into the table
         * @param array where condition on updating data
         */
        public function updateData($table, $data, $conditions)
        {
            if(!empty($data) && is_array($data))
            {
                $colvalSet = '';
                $whereSql = '';
                $i = 0;

                foreach($data as $key=>$val)
                {
                    $pre = ($i > 0)?', ':'';
                    $colvalSet .= $pre.$key."='".$val."'";
                    $i++;
                }

                if(!empty($conditions)&& is_array($conditions))
                {
                    $whereSql .= ' WHERE ';
                    $i = 0;
                    foreach($conditions as $key => $value)
                    {
                        $pre = ($i > 0)?' AND ':'';
                        $whereSql .= $pre.$key." = '".$value."'";
                        $i++;
                    }
                }

                $sql = "UPDATE ".$table." SET ".$colvalSet.$whereSql;
                $query = $this->connection->prepare($sql);
                $update = $query->execute();

                return $update?$query->rowCount():false;

            } else
            {
                return false;
            }
        }

        /**
         * Delete data from the database
         * @param string name of the table
         * @param array where condition on deleting data
         */
        public function deleteData($table, $conditions)
        {
            $whereSql = '';
            if(!empty($conditions)&& is_array($conditions))
            {
                $whereSql .= ' WHERE ';
                $i = 0;
                foreach($conditions as $key => $value)
                {
                    $pre = ($i > 0)?' AND ':'';
                    $whereSql .= $pre.$key." = '".$value."'";
                    $i++;
                }
            }
            $sql = "DELETE FROM ".$table.$whereSql;
            $delete = $this->connection->exec($sql);
            return $delete?$delete:false;
        }
    }
?>