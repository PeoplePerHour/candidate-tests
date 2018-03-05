<?php

    include_once 'databaseManagerInterface.php';

    /**
     * Define an Abstract class for all databases
     * connections to extend
     */
    abstract class DatabaseManager implements DatabaseManagerInterface
    {
        protected $dbDriver;
        protected $host;
        protected $port;
        protected $username;
        protected $password;
        protected $dbName;
        protected $unixSocket;
        protected $charset;
        protected $connection;

        /**
         * Connect database
         */
        abstract public function openConnection();

        /**
         * Returns rows from the database based on the conditions
         * @param string name of the table
         * @param array select, where, order_by, limit and return_type conditions
         */
        abstract public function selectData($table, $conditions = array());

        /**
         * Insert data into the database
         * @param string name of the table
         * @param array the data for inserting into the table
         */
        abstract public function insertData($table,$data);
        
        /**
         * Update data into the database
         * @param string name of the table
         * @param array the data for updating into the table
         * @param array where condition on updating data
         */
        abstract public function updateData($table, $data, $conditions);

        /**
         * Delete data from the database
         * @param string name of the table
         * @param array where condition on deleting data
         */
        abstract public function deleteData($table, $conditions);

        /**
         * Constructor
         */
        abstract public function __construct($dbDriver, $host, $port, $username, $password, $dbName, $unixSocket, $charset);

        /**
         * @return bool
         */
        public function isConnected()
        {
            return ($this->connection instanceof PDO);
        }

        /**
         * Kill connection
         */
        public function closeConnection()
        {
            $this->connection = null;
        }

        /**
         * Start transaction
         */
        public function startTransaction()
        {
            $this->connection->beginTransaction();
        }

        /**
         * Commit the changes
         */
        public function commitTransaction()
        {
            $this->connection->commit();
        }

        /**
         * Rollback the changes
         */
        public function rollbackTransaction()
        {
            $this->connection->rollBack();
        }

        /**
         * Store cache file in cache folder
         * @param string name of cache file
         * @param array data from select query
         */
        public function storeCacheFile($sqlCacheName, $data)
        {
            /* Write data to file */
            $filew = fopen("cache/" . $sqlCacheName, 'w');
            fwrite($filew, print_r($data, true));
            fclose($filew);
        }

        /**
         * Checks if cache file exists and is modified less than one hour
         * @param string cache file
         * @param int total minutes before expiration
         * @return bool
         */
        public function isCached($cacheFile, $cacheTimeSeconds)
        {
            return (file_exists($cacheFile) && (filemtime($cacheFile) > (time() - ($cacheTimeSeconds))));
        }

        /**
         * Execute functionality for query caching
         * @param string select query
         * @return array
         */
        public function initCacheArray($sql)
        {
            /*Generate an MD5 hash from the SQL query above.*/
            $cacheArray['sqlCacheName'] = md5($sql) . ".cache";
  
            /* The name of our cache folder. */
            $cacheArray['cache'] = 'cache';
                       
            /* Full path to cache file. */
            $cacheArray['cacheFile'] = $cacheArray['cache'] . "/" . $cacheArray['sqlCacheName'];
            
            /* Cache time in seconds. 60 * 60 = one hour. */
            $cacheArray['cacheTimeSeconds'] = (60 * 60);

            return $cacheArray;
        }
        
    }
?>