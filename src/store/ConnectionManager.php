<?php

namespace Manager\Store;

use Manager\Driver\Config;
use Manager\Driver\Credentials;
use PDO;
use PDOException;

class ConnectionManager {

    private $dsn;
    private $dbUser;
    private $dbPass;
    private $connection;
    private $adapter;
    private $activeConnections = [];
    private $validOptions = [
        'dbuser', 'dbpass', 'dbname', 'port', 'host', 'driver'
    ];


    /**
     * ConnectionManager constructor.
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->adapter = $config->getAdapter();
        $this->validateAdapterOptions();
        $this->setDNS($this->adapter);
        $this->setDBUser($this->adapter["dbuser"]);
        $this->setDBPassword($this->adapter["dbpass"]);
    }

    /**
     * Connect to the database and return a PDO connection.
     * @return PDO
     */
    public function connect()
    {
        if(in_array($this->adapter['driver'], $this->activeConnections)){
            return $this->connection;
        }
        try {
            $this->connection = new PDO($this->dsn, $this->dbUser, $this->dbPass, [
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
            array_push($this->activeConnections, $this->adapter['driver']);
        } catch (PDOException $e) {
            die($e->getMessage());
        }

        return $this->connection;
    }

    /**
     * @throws \Exception
     */
    private function validateAdapterOptions()
    {
        foreach ($this->adapter as $key => $value) {
            if(!in_array($key, $this->validOptions) || is_null($value) || $value == '')
            {
                throw new \Exception("Wrong Adapter Configuration Found." . $key);
            }
        }
    }

    /**
     * Compile the DSN, username and password connection specs.
     * @param array $adapter
     */
    private function setDNS(array $adapter)
    {
        $this->dsn = $adapter["driver"] . ":";

        foreach ($adapter as $key => $value) {
            if($key == 'dbname' || $key == 'host' || $key == 'port'){
                $this->dsn .= $key . '=' . $value . ';';
            }
        }
    }

    /**
     * @param string $dbUser
     */
    private function setDBUser(string $dbUser)
    {
        $this->dbUser = $dbUser;
    }

    /**
     * @param string $dbPassword
     */
    private function setDBPassword(string $dbPassword)
    {
        $this->dbPass = $dbPassword;
    }


}

