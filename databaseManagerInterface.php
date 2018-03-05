<?php
    /**
     * Define an Interface about database's functions
     */
    interface DatabaseManagerInterface
    {
        public function isConnected();
        public function closeConnection();
        public function startTransaction();
        public function commitTransaction();
        public function rollbackTransaction();
        public function storeCacheFile($sqlCacheName, $data);
        public function isCached($cacheFile, $cacheTimeSeconds);
        public function initCacheArray($sql);
        public function openConnection();
        public function selectData($table, $conditions = array());
        public function insertData($table,$data);
        public function updateData($table, $data, $conditions);
        public function deleteData($table, $conditions);
        public function __construct($dbDriver, $host, $port, $username, $password, $dbName, $unixSocket, $charset);
    }
?>